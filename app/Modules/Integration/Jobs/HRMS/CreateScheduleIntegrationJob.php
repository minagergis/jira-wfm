<?php

namespace App\Modules\Integration\Jobs\HRMS;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\Shifts\Entities\MemberSchedule;

class CreateScheduleIntegrationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public MemberSchedule $schedule;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MemberSchedule $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $createScheduleLink = config('integration.hrms.host').'api/v1/schedules/create';
        $id                 = config('integration.hrms.client_id');
        $secret             = config('integration.hrms.client_secret');

        try {
            $response = Http::withBasicAuth($id, $secret)->post(
                $createScheduleLink,
                [
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
                    ],
                ]
            );

            $response->throwIf(! $response->successful());
        } catch (\Exception $e) {
            return $this->failed($e);
        }
    }

    public function failed($exception)
    {
        Log::error($exception->getMessage());

        return $exception;
    }
}
