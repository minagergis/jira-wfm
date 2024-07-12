<?php

namespace App\Modules\Integration\Jobs\HRMS\Bulk;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Modules\Shifts\Entities\MemberSchedule;

class CreateBulkScheduleIntegrationJob extends BaseHRMSBulkIntegrationJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $createScheduleLink = $this->baseUrl.'api/v1/schedules/create-bulk';

        try {
            $response = Http::withToken($this->accessToken)->acceptJson()->post(
                $createScheduleLink,
                $this->createSchedulesIntegrationObjects()
            );

            $response->throwIf(! $response->successful());
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->failed($e);
        }
    }

    private function createSchedulesIntegrationObjects()
    {
        $schedulesObject = [];
        foreach ($this->scheduleIds as $scheduleId) {
            $schedule          = MemberSchedule::find($scheduleId);
            $schedulesObject[] = [
                'schedule' => [
                    'id'          => $schedule->id,
                    'name'        => $schedule->name,
                    'description' => $schedule->description,
                    'from'        => Carbon::parse($schedule->date_from.' '.$schedule->time_from)->format('Y-m-d H:i:s'),
                    'to'          => Carbon::parse($schedule->date_to.' '.$schedule->time_to)->format('Y-m-d H:i:s'),
                ],
                'owner'        => [
                    'id'      => $schedule->member->id,
                    'api_key' => $schedule->member->api_key,
                    'color'   => $schedule->member->color,
                ],
            ];
        }

        return [
            'schedulesObject' => $schedulesObject,
            'deletedSchedulesObject' => $this->deletedScheduleIds,
        ];
    }
}
