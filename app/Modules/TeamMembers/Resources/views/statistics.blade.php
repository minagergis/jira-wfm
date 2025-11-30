@extends('layouts.master')

@section('title')
    {!! config('teammembers.name') !!} - Statistics - {{$teamMember->name}}
@endsection

@section('styles')
<link rel="stylesheet" href="{{asset('new-style-assets/dashboard/css/dashboard.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('new-style-assets/statistics/css/statistics.css')}}" type="text/css">
@stack('custom-styles')
@endsection

@section('content')
    <!-- Header Section -->
    <div class="header-modern">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 col-7">
                    <h1 class="h2 text-white mb-2">{{$teamMember->name}} - Statistics</h1>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{route('get.team-member.list')}}">Team Members</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Statistics - {{$teamMember->name}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{route('get.team-member.list')}}" class="btn btn-sm btn-white">
                        <i class="fas fa-arrow-left mr-1"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="container-fluid mt-5">
        <!-- Current/Last Shift Stats -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="chart-card card stat-card">
                    <div class="chart-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Done Points</h6>
                                <h2 class="mb-0 font-weight-bold">
                                    <span class="stat-number">{{$totalPointsLastShift}}</span> 
                                    <small class="text-muted">POINTS</small>
                                </h2>
                                <p class="text-sm text-muted mb-0 mt-2">@if($isInShiftNow) This @else Last @endif shift</p>
                            </div>
                            <div class="icon-shape bg-gradient-purple text-white rounded-circle shadow-lg">
                                <i class="fa fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="chart-card card stat-card">
                    <div class="chart-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Remaining Points</h6>
                                <h2 class="mb-0 font-weight-bold">
                                    <span class="stat-number">{{$memberWeightLastShift - $totalPointsLastShift}}</span> 
                                    <small class="text-muted">POINTS</small>
                                </h2>
                                <p class="text-sm text-muted mb-0 mt-2">@if($isInShiftNow) This @else Last @endif shift</p>
                            </div>
                            <div class="icon-shape bg-gradient-green text-white rounded-circle shadow-lg">
                                <i class="fa fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="chart-card card stat-card">
                    <div class="chart-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Total Tasks</h6>
                                <h2 class="mb-0 font-weight-bold">
                                    <span class="stat-number">{{$numberOfTasks}}</span>
                                </h2>
                                <p class="text-sm text-muted mb-0 mt-2">@if($isInShiftNow) This @else Last @endif shift</p>
                            </div>
                            <div class="icon-shape bg-gradient-danger text-white rounded-circle shadow-lg">
                                <i class="fa fa-tasks"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 7 Days Stats -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="chart-card card stat-card">
                    <div class="chart-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Total Points</h6>
                                <h2 class="mb-0 font-weight-bold">
                                    <span class="stat-number">{{$teamMember->weight}}</span>
                                </h2>
                                <p class="text-sm text-muted mb-0 mt-2">Per shift</p>
                            </div>
                            <div class="icon-shape bg-gradient-red text-white rounded-circle shadow-lg">
                                <i class="fa fa-clipboard-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="chart-card card stat-card">
                    <div class="chart-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Done Points</h6>
                                <h2 class="mb-0 font-weight-bold">
                                    <span class="stat-number">{{$perShiftTasksDone}}</span>
                                </h2>
                                <p class="text-sm text-muted mb-0 mt-2">Daily tasks - Last 7 days</p>
                            </div>
                            <div class="icon-shape bg-gradient-orange text-white rounded-circle shadow-lg">
                                <i class="fa fa-calendar-day"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="chart-card card stat-card">
                    <div class="chart-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Done Points</h6>
                                <h2 class="mb-0 font-weight-bold">
                                    <span class="stat-number">{{$zendeskTasksDone}}</span>
                                </h2>
                                <p class="text-sm text-muted mb-0 mt-2">Zendesk tasks - Last 7 days</p>
                            </div>
                            <div class="icon-shape bg-gradient-green text-white rounded-circle shadow-lg">
                                <i class="fa fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="chart-card card stat-card">
                    <div class="chart-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted mb-2">Total Tasks</h6>
                                <h2 class="mb-0 font-weight-bold">
                                    <span class="stat-number">{{$numberOfTasksLast7Days}}</span>
                                </h2>
                                <p class="text-sm text-muted mb-0 mt-2">All tasks - Last 7 days</p>
                            </div>
                            <div class="icon-shape bg-gradient-info text-white rounded-circle shadow-lg">
                                <i class="fa fa-chart-bar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-4 mb-4">
                <!-- Joined Teams Card -->
                <div class="chart-card card">
                    <div class="chart-header">
                        <h5 class="h3 mb-0">Joined Teams</h5>
                    </div>
                    <div class="chart-body">
                        <ul class="list-group list-group-flush">
                            @foreach($teamMember->teams as $team)
                            <li class="list-group-item px-0 border-0">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm rounded-circle mr-3">
                                        <img alt="Team" src="{{asset('assets/img/brand/ds.png')}}">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{$team->name}}</h6>
                                        <small class="text-muted">
                                            <span class="text-success">●</span>
                                            <a class="text-success" target="_blank" href="https://digisay.atlassian.net/jira/core/projects/{{$team->jira_project_key}}/board">JIRA Board</a>
                                        </small>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Team Members Card -->
                <div class="chart-card card mt-4">
                    <div class="chart-header">
                        <h5 class="h3 mb-0">Team Members</h5>
                    </div>
                    <div class="chart-body">
                        <ul class="list-group list-group-flush">
                            @foreach($teamMember->teams[0]->teamMembers as $member)
                                @if($member->id != $teamMember->id)
                                <li class="list-group-item px-0 border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm rounded-circle mr-3">
                                            <img alt="Member" src="{{asset('assets/img/brand/ds.png')}}">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{$member->name}}</h6>
                                            <small class="text-muted">
                                                <span class="text-success">●</span>
                                                <a class="text-success" href="{{route('get.team-member.statistics',$member->id)}}">Statistics</a>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Middle Column -->
            <div class="col-lg-4 mb-4">
                <!-- Latest Logs Card -->
                <div class="chart-card card">
                    <div class="chart-header">
                        <h5 class="h3 mb-0">Latest 7 Days Logs</h5>
                    </div>
                    <div class="chart-body">
                        <div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">
                            @if($allLogs->count() === 0)
                                <div class="timeline-block">
                                    <span class="timeline-step badge-danger">
                                        <i class="ni ni-spaceship"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between pt-1">
                                            <div>
                                                <span class="text-muted text-xs font-weight-bold">Sorry!</span>
                                            </div>
                                            <div class="text-right">
                                                <small class="text-muted"><i class="fas fa-clock mr-1"></i>Just now</small>
                                            </div>
                                        </div>
                                        <h6 class="text-sm mt-1 mb-0">We don't have any logs for {{$teamMember->name}}, he/she should get new tasks soon!</h6>
                                    </div>
                                </div>
                            @else
                                @foreach($allLogs as $logData)
                                    <div class="timeline-block">
                                        @if($logData->task_type === 'per_shift')
                                            <span class="timeline-step badge-success">
                                                <i class="ni ni-active-40"></i>
                                            </span>
                                        @else
                                            <span class="timeline-step badge-warning">
                                                <i class="ni ni-chat-round"></i>
                                            </span>
                                        @endif
                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between pt-1">
                                                <div>
                                                    <span class="text-muted text-xs font-weight-bold">
                                                        @if($logData->task_type === 'per_shift') 
                                                            Shift task distributed 
                                                        @else 
                                                            Zendesk task assigned 
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="text-right">
                                                    <small class="text-muted"><i class="fas fa-clock mr-1"></i>{{$logData->created_at->diffForHumans()}}</small>
                                                </div>
                                            </div>
                                            <h6 class="text-sm mt-1 mb-0">
                                                Capacity before task was {{$logData->before_member_capacity}}, And after task became {{$logData->after_member_capacity}}
                                                @if($logData->task_type === 'zendesk')
                                                    , You can check the task from <a class="text-primary" href="https://digisay.atlassian.net/jira/core/projects/{{$logData->team->jira_project_key}}/board?selectedIssue={{$logData->jira_issue_key}}">here</a>
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4 mb-4">
                <!-- Capacity Track Card -->
                <div class="chart-card card">
                    <div class="chart-header">
                        <h5 class="h3 mb-0">@if($isInShiftNow) This @else Last @endif Shift Capacity Track</h5>
                    </div>
                    <div class="chart-body">
                        <?php
                        use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;
                        $pershiftRatio = TaskDistributionRatiosEnum::TYPES_RATIOS[TaskDistributionRatiosEnum::PER_SHIFT];
                        $zendeskRatio = TaskDistributionRatiosEnum::TYPES_RATIOS[TaskDistributionRatiosEnum::ZENDESK];
                        ?>
                        <div class="capacity-track-item">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar avatar-sm rounded-circle mr-3 avatar-pulse">
                                    <img alt="Daily" src="{{asset('assets/img/brand/ds.png')}}">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Daily tasks</h6>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-orange" role="progressbar" 
                                             aria-valuenow="{{$totalPointsLastShiftForPerShift}}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="{{$memberWeightLastShift * $pershiftRatio}}" 
                                             style="width: @if($memberWeightLastShift == 0) 0 @else {{$totalPointsLastShiftForPerShift / ($memberWeightLastShift * $pershiftRatio) * 100}}@endif%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="capacity-track-item">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar avatar-sm rounded-circle mr-3 avatar-pulse">
                                    <img alt="Zendesk" src="{{asset('/assets/img/icons/common/zendesk.png')}}">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Zendesk tasks</h6>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar bg-green" role="progressbar" 
                                             aria-valuenow="{{$totalPointsLastShiftForZendesk}}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100" 
                                             style="width:@if($memberWeightLastShift == 0) 0 @else {{$totalPointsLastShiftForZendesk / ($memberWeightLastShift * $zendeskRatio) * 100}}@endif%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Member Info Card -->
                <div class="chart-card card mt-4">
                    <div class="chart-body">
                        <div class="text-center mb-4">
                            <img class="avatar avatar-lg rounded-circle mb-3 avatar-pulse" src="{{asset('assets/img/icons/common/jira.png')}}" alt="JIRA" />
                            @if(isset($teamMember->jira_integration_id))
                                <span class="badge badge-lg badge-success member-info-badge">Linked to JIRA</span>
                            @else
                                <span class="badge badge-lg badge-danger member-info-badge">Not Linked to JIRA</span>
                            @endif
                        </div>
                        <div class="mb-4">
                            <span class="h6 surtitle text-muted">JIRA ID</span>
                            <div class="h3 mt-1 member-info-value">
                                @if(isset($teamMember->jira_integration_id))
                                    {{$teamMember->jira_integration_id}}
                                @else
                                    <span class="text-muted">No JIRA ID</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4">
                            <span class="h6 surtitle text-muted">Name</span>
                            <div class="h4 mt-1 member-info-value">{{$teamMember->name}}</div>
                        </div>
                        <div>
                            <span class="h6 surtitle text-muted">WFM Integration API Key</span>
                            <div class="h5 mt-1 font-weight-normal text-break member-info-value">{{$teamMember->api_key}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/statistics/js/statistics.js')}}"></script>
@stack('custom-scripts')
@endsection
