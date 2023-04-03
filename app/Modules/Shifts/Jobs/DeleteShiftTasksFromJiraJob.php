<?php

namespace App\Modules\Shifts\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\TeamMembers\Entities\TeamMember;
use Facades\App\Modules\Distribution\Facades\Integrations\JIRA;

class DeleteShiftTasksFromJiraJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private TeamMember $assignedDeletedShiftMember;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TeamMember $assignedDeletedShiftMember)
    {
        $this->assignedDeletedShiftMember = $assignedDeletedShiftMember;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $allTasksAssignedToOldMemberToday = JIRA::getAllIssuesAssignedToMemberBetweenTwoDates(
            $this->assignedDeletedShiftMember->teams->first()->jira_project_key,
            $this->assignedDeletedShiftMember->jira_integration_id,
            Carbon::now()->format('Y-m-d'),
            Carbon::now()->addDay()->format('Y-m-d')
        );

        foreach ($allTasksAssignedToOldMemberToday as $jiraTask) {
            JIRA::deleteIssue($jiraTask->key);
        }
    }
}
