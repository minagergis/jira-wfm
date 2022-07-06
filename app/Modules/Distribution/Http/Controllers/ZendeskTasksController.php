<?php

namespace App\Modules\Distribution\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\Teams\Services\TeamService;
use App\Modules\Shifts\Entities\MemberSchedule;
use App\Modules\TeamMembers\Entities\TeamMember;
use App\Modules\ContactTypes\Entities\ContactType;
use App\Modules\Core\Http\Controllers\CoreController;
use App\Modules\Distribution\Entities\TaskDistributionLog;
use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;
use Facades\App\Modules\Distribution\Facades\Integrations\JIRA;
use App\Modules\Distribution\Enums\ZendeskTaskPriorityPointsEnum;
use App\Modules\Distribution\Traits\MemberCapacityCalculationTrait;

class ZendeskTasksController extends CoreController
{
    use MemberCapacityCalculationTrait;

    private $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function newTaskCreated(Request $request)
    {
        $zendeskTask =  $request->toArray();

        $team = $this->teamService->getTeamByJiraProjectCode($zendeskTask['issue']['fields']['project']['key']);

        $mina = $this->getOrderedAvailableTeamMembersForNextShift($team);

        dd($mina);
        $availableTeamMembersForNow = $this->getOrderedAvailableTeamMembersForNow($team);

        if (count($availableTeamMembersForNow) > 0) {
            foreach ($availableTeamMembersForNow as $member) {
                $memberAvailableCapacity = $this->getCurrentCapacityForATeamMemberToday(
                    $member['id'],
                    $member['schedule']['id'],
                    TaskDistributionRatiosEnum::ZENDESK
                );

                $jiraIssueWeight   = $this->getJiraTaskWeight($zendeskTask);

                if ($memberAvailableCapacity >= $jiraIssueWeight) {
                    JIRA::assignIssue($zendeskTask['issue']['key'], $member['jira_integration_id']);

                    $loggedTask = TaskDistributionLog::create([
                        'team_id'                => $team->id,
                        'team_member_id'         => $member['id'],
                        'schedule_id'            => $member['schedule']['id'],
                        'task_type'              => TaskDistributionRatiosEnum::ZENDESK,
                        'jira_issue_key'         => $zendeskTask['issue']['key'],
                        'before_member_capacity' => $memberAvailableCapacity,
                        'after_member_capacity'  => $memberAvailableCapacity - $jiraIssueWeight,
                    ]);

                    break;
                }
            }

            // X - So another business
        } else {
        }

        // X - Do another business
    }

    private function getJiraTaskWeight(array $jiraTask): int
    {
        if (config('distribution.distribution_depends_on_priority')) {
            $taskPriority = $jiraTask['issue']['fields']['priority']['name'];

            return ZendeskTaskPriorityPointsEnum::PRIORITY_POINTS[$taskPriority];
        }

        $contactType = ContactType::where('name', $jiraTask['issue']['fields']['issuetype']['name'])
            ->first();

        return (int) isset($contactType) ? $contactType->sla : 10;
    }

    private function getOrderedAvailableTeamMembersForNow($team)
    {
        $lastMemberWhoTakeTaskThisShift = TaskDistributionLog::query()
            ->whereHas('team', function (Builder $query) use ($team) {
                $query->where('teams.id', $team->id);
            })
            ->whereHas('schedule', function (Builder $query) {
                $query
                    ->where(
                        DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                        '<=',
                        now('Africa/Cairo')->toDateTimeString()
                    )
                    ->where(
                        DB::raw("CONCAT(`date_to`, ' ', `time_to`)"),
                        '>=',
                        now('Africa/Cairo')->toDateTimeString()
                    );
            })
            ->taskType(TaskDistributionRatiosEnum::ZENDESK)
            ->orderBy('id', 'DESC')
            ->first();

        $availableTeamMembersForNow = TeamMember::query()
            ->whereHas('teams', function (Builder $query) use ($team) {
                $query->where('teams.id', $team->id);
            })
            ->whereHas('schedules', function (Builder $query) {
                $query
                    ->where(
                        DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                        '<=',
                        now('Africa/Cairo')->toDateTimeString()
                    )
                    ->where(
                        DB::raw("CONCAT(`date_to`, ' ', `time_to`)"),
                        '>=',
                        now('Africa/Cairo')->toDateTimeString()
                    );
            })
            ->get();

        $currentTeamMembersSchedules =  MemberSchedule::query()
            ->where(
                DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                '<=',
                now('Africa/Cairo')->toDateTimeString()
            )
            ->where(
                DB::raw("CONCAT(`date_to`, ' ', `time_to`)"),
                '>=',
                now('Africa/Cairo')->toDateTimeString()
            )
            ->whereIn(
                'team_member_id',
                $availableTeamMembersForNow->pluck('id')->toArray()
            )
            ->get();

        return $availableTeamMembersForNow->when($lastMemberWhoTakeTaskThisShift !== null, function ($members) use ($lastMemberWhoTakeTaskThisShift) {
            return $members->filter(
                function ($member) use ($lastMemberWhoTakeTaskThisShift) {
                    return $member->id !== $lastMemberWhoTakeTaskThisShift->team_member_id;
                }
            );
        })
            ->shuffle()
            ->when($lastMemberWhoTakeTaskThisShift !== null, function ($orderedMembers) use ($availableTeamMembersForNow, $lastMemberWhoTakeTaskThisShift) {
                return $orderedMembers->push(
                    $availableTeamMembersForNow->find($lastMemberWhoTakeTaskThisShift->team_member_id)
                );
            })
            ->map(function ($teamMember) use ($currentTeamMembersSchedules) {
                return collect($teamMember)->put('schedule', $currentTeamMembersSchedules->where('team_member_id', $teamMember->id)->first());
            })->toArray();
    }

    private function getOrderedAvailableTeamMembersForNextShift($team)
    {
        $shiftsLimitation      = 2;

        $teamMembersForTheTeam = TeamMember::query()
            ->whereHas('teams', function (Builder $builder) use ($team) {
                $builder->where('teams.id', $team->id);
            })->pluck('id')->toArray();


        $nextShiftsForThisTeam = MemberSchedule::query()
            ->whereIn('team_member_id', $teamMembersForTheTeam)
            ->where(
                DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                '>',
                now('Africa/Cairo')->toDateTimeString()
            )
            ->orderBy(
                DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                'ASC'
            )
            ->take($shiftsLimitation)
            ->get();


        $lastMemberWhoTakeTaskNextShift = TaskDistributionLog::query()
            ->whereHas('team', function (Builder $query) use ($team) {
                $query->where('teams.id', $team->id);
            })
            ->whereHas('schedule', function (Builder $query) use ($nextShiftsForThisTeam) {
                $query->whereIn(
                    'member_schedules.id',
                    $nextShiftsForThisTeam->pluck('id')->toArray()
                );
            })
            ->taskType(TaskDistributionRatiosEnum::ZENDESK)
            ->orderBy('id', 'DESC')
            ->first();



        $availableTeamMembersForNextShift = TeamMember::query()
            ->whereHas('teams', function (Builder $query) use ($team) {
                $query->where('teams.id', $team->id);
            })
            ->whereHas('schedules', function (Builder $query) use ($nextShiftsForThisTeam) {
                $query->whereIn(
                    'member_schedules.id',
                    $nextShiftsForThisTeam->pluck('id')->toArray()
                );
            })
            ->get();

        return $availableTeamMembersForNextShift->when($lastMemberWhoTakeTaskNextShift !== null, function ($members) use ($lastMemberWhoTakeTaskNextShift) {
            return $members->filter(
                function ($member) use ($lastMemberWhoTakeTaskNextShift) {
                    return $member->id !== $lastMemberWhoTakeTaskNextShift->team_member_id;
                }
            );
        })
            ->shuffle()
            ->when($lastMemberWhoTakeTaskNextShift !== null, function ($orderedMembers) use ($availableTeamMembersForNextShift, $lastMemberWhoTakeTaskNextShift) {
                return $orderedMembers->push(
                    $availableTeamMembersForNextShift->find($lastMemberWhoTakeTaskNextShift->team_member_id)
                );
            })
            ->map(function ($teamMember) use ($nextShiftsForThisTeam) {
                return collect($teamMember)->put('schedule', $nextShiftsForThisTeam->where('team_member_id', $teamMember->id)->first());
            })->toArray();
    }
}
