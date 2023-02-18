<?php

namespace App\Modules\Integration\Jobs\HRMS;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class EditScheduleIntegrationJob extends BaseHRMSIntegrationJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $editScheduleUrl = $this->baseUrl.'api/v1/schedules/edit';

        try {
            $response = Http::withToken($this->accessToken)->acceptJson()->post(
                $editScheduleUrl,
                [
                    'id'       => $this->schedule->id,
                    'schedule' => [
                        'id'          => $this->schedule->id,
                        'name'        => $this->schedule->name,
                        'description' => $this->schedule->description,
                        'from'        => Carbon::parse($this->schedule->date_from.' '.$this->schedule->time_from)->format('Y-m-d H:i:s'),
                        'to'          => Carbon::parse($this->schedule->date_to.' '.$this->schedule->time_to)->format('Y-m-d H:i:s'),
                    ],
                    'owner'        => [
                        'id'      => $this->schedule->member->id,
                        'api_key' => $this->schedule->member->api_key,
                        'color'   => $this->schedule->member->color,
                    ],
                ]
            );

            $response->throwIf(! $response->successful());
        } catch (\Exception $e) {
            return $this->failed($e);
        }
    }

}
