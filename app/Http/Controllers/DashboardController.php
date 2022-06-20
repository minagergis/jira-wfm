<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Modules\Teams\Services\TeamService;
use App\Modules\Shifts\Services\MemberScheduleService;
use App\Modules\TeamMembers\Services\TeamMemberService;
use App\Modules\Distribution\Services\TaskDistributionLogService;

class DashboardController extends Controller
{
    private $teamMemberService;

    private $teamService;

    private $memberScheduleService;

    private $distributionLogService;

    public function __construct(
        TeamMemberService $teamMemberService,
        TeamService $teamService,
        MemberScheduleService $memberScheduleService,
        TaskDistributionLogService $distributionLogService
    ) {
        $this->middleware('auth');

        $this->teamMemberService      = $teamMemberService;
        $this->teamService            = $teamService;
        $this->memberScheduleService  = $memberScheduleService;
        $this->distributionLogService = $distributionLogService;
    }

    public function getDashboard()
    {
        $teamsCount               = $this->teamService->index()->count();
        $teamsLastDaysCount       = $this->teamService->withScope('withInDays', 7)->count();

        $teamMembersCount         = $this->teamMemberService->index()->count();
        $teamMembersLastDaysCount = $this->teamMemberService->withScope('withInDays', 7)->count();

        $tasksCount               = $this->distributionLogService->index()->count();
        $tasksLastDays            = $this->distributionLogService->withScope('withInDays', 7);
        $tasksLastDaysCount       = $tasksLastDays->count();

        $schedulesCount           = $this->memberScheduleService->index()->count();
        $schedulesLastDaysCount   = $this->memberScheduleService->withScope('withInDays', 7)->count();


        $taskCountsForThisWeek = $this->getTaskCountsForThisWeek($tasksLastDays);

        $lineChartData = json_encode([
            'labels' => [
                now()->subDays(6)->dayName,
                now()->subDays(5)->dayName,
                now()->subDays(4)->dayName,
                now()->subDays(3)->dayName,
                now()->subDays(2)->dayName,
                now()->subDay()->dayName,
                now()->dayName,
            ],
            'datasets' => [[
                'label' => 'task count',
                'data'  => $taskCountsForThisWeek,
            ]],
        ]);

        return view('dashboard', compact(
            'teamMembersCount',
            'teamMembersLastDaysCount',
            'tasksCount',
            'tasksLastDaysCount',
            'teamsCount',
            'teamsLastDaysCount',
            'schedulesCount',
            'schedulesLastDaysCount',
            'lineChartData'
        ));
    }

    /**
     * @param $tasksLastDays
     *
     * @return array
     */
    private function getTaskCountsForThisWeek($tasksLastDays): array
    {
        $tasksPerDay = $tasksLastDays->groupBy(function ($log) {
            return Carbon::parse($log->created_at)->format('Y-m-d');
        })->map(function ($tasks) {
            return count($tasks);
        })->toArray();

        $last7Days = [
            now()->subDays(6),
            now()->subDays(5),
            now()->subDays(4),
            now()->subDays(3),
            now()->subDays(2),
            now()->subDay(),
            now(),
        ];

        foreach ($last7Days as $day) {
            if (!isset($tasksPerDay[$day->toDateString()])) {
                $tasksPerDay[$day->toDateString()] = 0;
            }
        }

        return array_values($tasksPerDay);
    }
}
