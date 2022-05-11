<?php

namespace App\Modules\Distribution\Http\Controllers;

use App\Modules\Distribution\Entities\TaskDistributionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Modules\Teams\Services\TeamService;
use App\Modules\Core\Http\Controllers\CoreController;
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

        $team           = $this->teamService->getTeamByJiraProjectCode($zendeskTask['issue']['fields']['project']['key']);

        $availableShift = $team->shifts
            ->where('time_from', '<', now('Africa/Cairo')->toTimeString())
            ->where('time_to', '>', now('Africa/Cairo')->toTimeString())
            ->first();

        $shiftMembers = $availableShift->teamMembersForCertainTeam($team->id, $availableShift->id)->get()->toArray();

        foreach ($shiftMembers as $member) {
            $memberAvailableCapacity = $this->getCurrentCapacityForATeamMemberToday(
                $member['id'],
                $availableShift->id,
                TaskDistributionRatiosEnum::ZENDESK
            );

            $jiraIssuePriority = $zendeskTask['issue']['fields']['priority']['name'];

            if ($memberAvailableCapacity >= ZendeskTaskPriorityPointsEnum::PRIORITY_POINTS[$jiraIssuePriority]) {
                JIRA::assignIssue($zendeskTask['issue']['key'], $member['jira_integration_id']);

                $loggedTask = TaskDistributionLog::create([
                    'team_id'                => $team->id,
                    'team_member_id'         => $member['id'],
                    'shift_id'               => $availableShift->id,
                    'task_type'              => TaskDistributionRatiosEnum::ZENDESK,
                    'jira_issue_key'         => $zendeskTask['issue']['key'],
                    'before_member_capacity' => $memberAvailableCapacity,
                    'after_member_capacity'  => $memberAvailableCapacity - ZendeskTaskPriorityPointsEnum::PRIORITY_POINTS[$jiraIssuePriority],
                ]);
                break;
            }
        }
    }
}
