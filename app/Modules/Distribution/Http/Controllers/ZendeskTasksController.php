<?php

namespace App\Modules\Distribution\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Teams\Services\TeamService;
use App\Modules\ContactTypes\Entities\ContactType;
use App\Modules\Core\Http\Controllers\CoreController;
use App\Modules\Distribution\Enums\ZendeskTaskPriorityPointsEnum;
use App\Modules\Distribution\Traits\ZendeskTaskDistributionTrait;
use App\Modules\Distribution\Traits\MemberCapacityCalculationTrait;
use Illuminate\Support\Facades\Log;

class ZendeskTasksController extends CoreController
{
    use MemberCapacityCalculationTrait;
    use ZendeskTaskDistributionTrait;

    private $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function newTaskCreated(Request $request)
    {
        $zendeskTask =  $request->toArray();

        $team = $this->teamService->getTeamByJiraProjectCode($zendeskTask['issue']['fields']['project']['key']);


        // If it can't distribute to the current team
        if (! $this->distributeTasksForShift($team, $zendeskTask, false)) {
            // It will distribute to the next shift
            $this->distributeTasksForShift($team, $zendeskTask, true);
        }
    }


}
