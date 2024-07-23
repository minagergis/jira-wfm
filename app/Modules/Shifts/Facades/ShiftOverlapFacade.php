<?php

namespace App\Modules\Shifts\Facades;

use Illuminate\Support\Facades\DB;
use App\Modules\Shifts\Entities\MemberSchedule;

class ShiftOverlapFacade
{
    public function isShiftDoesnotOverlapped($teamMemberId, $startDate, $endDate, $scheduleId = null): bool
    {
        $overlappingQuery =  MemberSchedule::query();

        if ($scheduleId != null) {
            $overlappingQuery = $overlappingQuery->where('id', '<>', $scheduleId);
        }


        return $overlappingQuery
            ->where('team_member_id', $teamMemberId)
            ->where(function ($queryBuilder) use ($startDate, $endDate) {
                $queryBuilder->where(function ($query) use ($startDate, $endDate) {
                    return $query->where(
                        DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                        '<=',
                        $endDate
                    )->where(
                        DB::raw("CONCAT(`date_to`, ' ', `time_to`)"),
                        '>=',
                        $startDate
                    );
                })
                    ->orWhere(function ($query2) use ($startDate, $endDate) {
                        return $query2->where(
                            DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                            '<=',
                            $endDate
                        )->where(
                            DB::raw("CONCAT(`date_to`, ' ', `time_to`)"),
                            '>=',
                            $startDate
                        );
                    });
            })

            ->doesntExist();
    }
    public function getOverlappedShift($teamMemberId, $startDate, $endDate, $scheduleId = null)
    {
        $overlappingQuery =  MemberSchedule::query();

        if ($scheduleId != null) {
            $overlappingQuery = $overlappingQuery->where('id', '<>', $scheduleId);
        }


        return $overlappingQuery
            ->where('team_member_id', $teamMemberId)
            ->where(function ($queryBuilder) use ($startDate, $endDate) {
                $queryBuilder->where(function ($query) use ($startDate, $endDate) {
                    return $query->where(
                        DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                        '<=',
                        $endDate
                    )->where(
                        DB::raw("CONCAT(`date_to`, ' ', `time_to`)"),
                        '>=',
                        $startDate
                    );
                })
                    ->orWhere(function ($query2) use ($startDate, $endDate) {
                        return $query2->where(
                            DB::raw("CONCAT(`date_from`, ' ', `time_from`)"),
                            '<=',
                            $endDate
                        )->where(
                            DB::raw("CONCAT(`date_to`, ' ', `time_to`)"),
                            '>=',
                            $startDate
                        );
                    });
            })
            ->first();
    }
}
