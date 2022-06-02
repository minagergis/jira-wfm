<?php

namespace App\Modules\Distribution\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Modules\Teams\Services\TeamService;

class EnsureIssueValidity
{
    private $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $teams = $this->teamService->index()->pluck('jira_project_key')->toArray();
        /*
        if (! $request->has('user') ||
            $request->get('user')['displayName'] !== 'Zendesk Support for Jira') {
            return response('Invalid Creator', 401);
        }
        */

        if (! $request->has('issue')) {
            return response('Issue Not Found', 404);
        }

        $projectKey = $request->get('issue')['fields']['project']['key'] ?? null;

        if ($projectKey === null || ! in_array($projectKey, $teams)) {
            return response('Invalid Project', 401);

        }

        return $next($request);
    }
}
