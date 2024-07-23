<?php

namespace App\Modules\Shifts\Jobs;

use Illuminate\Support\Arr;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use App\Modules\Shifts\Entities\Shift;
use App\Modules\Shifts\Enums\DaysEnum;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\Shifts\Entities\MemberSchedule;
use Facades\App\Modules\Shifts\Facades\ShiftOverlapFacade;
use App\Modules\Integration\Jobs\HRMS\Bulk\CreateBulkScheduleIntegrationJob;

class BulkShiftSchedulingJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private int $shiftId;

    private array $teamMemberIDs;

    private string $recurringFrom;

    private string $recurringTo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shiftId, $teamMemberIDs, $recurringFrom, $recurringTo)
    {
        $this->shiftId       = $shiftId;
        $this->teamMemberIDs = $teamMemberIDs;
        $this->recurringFrom = $recurringFrom;
        $this->recurringTo   = $recurringTo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $createdScheduleIds  = [];
        $deletedScheduleIds  = [];
        $shift               = Shift::find($this->shiftId);
        $workingShiftDays    = array_values(Arr::only(DaysEnum::DAYSValues, json_decode($shift->days)));

        $toOriginal          = Carbon::parse($this->recurringTo. ' '. $shift->time_to);
        foreach ($this->teamMemberIDs as $teamMemberID) {
            $from = Carbon::parse($this->recurringFrom. ' '. $shift->time_from);
            $to   = Carbon::parse($this->recurringFrom. ' '. $shift->time_to);

            if ($to < $from) {
                $to = $to->addDay();
            }

            while ($to <= $toOriginal) {
                if ($oldShift = ShiftOverlapFacade::getOverlappedShift($teamMemberID, $from->toDateTimeString(), $to->toDateTimeString())) {
                    if (MemberSchedule::where('id', $oldShift->id)->delete()){
                        $deletedScheduleIds[] = $oldShift->id;
                    }
                }
                if (in_array($from->format('l'), $workingShiftDays)) {

                    if (ShiftOverlapFacade::isShiftDoesnotOverlapped($teamMemberID, $from->toDateTimeString(), $to->toDateTimeString())) {
                        $memberSchedule = new MemberSchedule();

                        $memberSchedule->name           = $shift->name;
                        $memberSchedule->time_from      = $from->toTimeString();
                        $memberSchedule->time_to        = $to->toTimeString();
                        $memberSchedule->date_from      = $from->toDateString();
                        $memberSchedule->date_to        = $to->toDateString();
                        $memberSchedule->team_member_id = $teamMemberID;
                        $memberSchedule->save();

                        $createdScheduleIds[] = $memberSchedule->id;
                    }

                }

                $from->addDay();
                $to->addDay();
            }

        }

        if (!empty($createdScheduleIds) or !empty($deletedScheduleIds)) {
            CreateBulkScheduleIntegrationJob::dispatch($createdScheduleIds,$deletedScheduleIds);
        }
    }
}
