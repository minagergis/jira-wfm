<?php

namespace App\Modules\Integration\Jobs\HRMS;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class DeleteScheduleIntegrationJob extends BaseHRMSIntegrationJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $deleteScheduleUrl = $this->baseUrl.'api/v1/schedules/delete';

        try {
            $response = Http::withToken($this->accessToken)->acceptJson()->post(
                $deleteScheduleUrl,
                [
                    'id'       => $this->schedule,
                ]
            );

            $response->throwIf(! $response->successful());
        } catch (\Exception $e) {
            return $this->failed($e);
        }
    }

}
