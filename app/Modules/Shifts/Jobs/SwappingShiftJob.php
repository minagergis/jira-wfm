<?php

namespace App\Modules\Shifts\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\Shifts\Entities\MemberSchedule;
use App\Modules\TeamMembers\Entities\TeamMember;
use App\Modules\Distribution\Entities\TaskDistributionLog;
use Facades\App\Modules\Distribution\Facades\Integrations\JIRA;

class SwappingShiftJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private TeamMember $oldMember;

    private TeamMember $newMember;

    private MemberSchedule $memberSchedule;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MemberSchedule $memberSchedule, TeamMember $oldMember, TeamMember $newMember)
    {
        $this->oldMember      = $oldMember;
        $this->newMember      = $newMember;
        $this->memberSchedule = $memberSchedule;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $allTasksAssignedToOldMemberToday = JIRA::getAllIssuesAssignedToMemberBetweenTwoDates(
            $this->oldMember->teams->first()->jira_project_key,
            $this->oldMember->jira_integration_id,
            Carbon::now()->format('Y-m-d'),
            Carbon::now()->addDay()->format('Y-m-d')
        );

        foreach ($allTasksAssignedToOldMemberToday as $jiraTask) {
            JIRA::assignIssue($jiraTask->key, $this->newMember->jira_integration_id);
        }

        TaskDistributionLog::where([
            'schedule_id'    => $this->memberSchedule->id,
            'team_member_id' => $this->oldMember->id,
        ])->update(
            [ 'team_member_id' => $this->newMember->id]
        );


    }
}
