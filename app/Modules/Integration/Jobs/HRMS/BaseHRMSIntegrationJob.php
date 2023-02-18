<?php

namespace App\Modules\Integration\Jobs\HRMS;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Modules\Integration\Traits\IntegrationAuthTrait;

class BaseHRMSIntegrationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use IntegrationAuthTrait;

    public $schedule;

    public string $baseUrl;

    public string $id;

    public string $secret;

    public string $accessToken;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($schedule)
    {
        $this->schedule    = $schedule;
        $this->baseUrl     = config('integration.hrms.host');
        $this->id          = config('integration.hrms.client_id');
        $this->secret      = config('integration.hrms.client_secret');
        $this->accessToken = $this->getAccessToken(
            $this->baseUrl.'oauth/token',
            $this->id,
            $this->secret
        );
    }

    public function failed($exception)
    {
        Log::error($exception->getMessage());

        return $exception;
    }
}
