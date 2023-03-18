@extends('layouts.master')
@section('title')
    {!! config('teammembers.name') !!} - Statistics - {{$teamMember->name}}
@endsection
@section('content')

    <div class="main-content" id="panel">

        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Team Member </h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('get.team-member.list')}}">Team Member</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Show Insights for - {{$teamMember->name}}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="{{route('get.team-member.create')}}" class="btn btn-sm btn-neutral">New</a>
                        </div>
                    </div>
                    <!-- Card stats -->
                    <div class="row">

                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-gradient-purple">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Done points in @if($isInShiftNow) this @else last @endif shift </h5>
                                                <span class="h2 font-weight-bold mb-0 text-white">{{$totalPointsLastShift}} POINTS</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                                    <i class="fa fa-check-circle"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-gradient-green">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Remaining points in @if($isInShiftNow) this @else last @endif shift </h5>
                                            <span class="h2 font-weight-bold mb-0 text-white">{{$memberWeightLastShift - $totalPointsLastShift}} POINTS</span>

                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                                <i class="fa fa-clock"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card bg-gradient-danger">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total tasks in @if($isInShiftNow) this @else last @endif shift</h5>
                                            <span class="h2 font-weight-bold mb-0 text-white">{{$numberOfTasks}}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                                <i class="fa fa-tasks"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Total Points</h5>
                                            <span class="h2 font-weight-bold mb-0">{{$teamMember->weight}}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="fa fa-clipboard-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-nowrap">Number of points </span>
                                        <span class="text-success mr-2"> per shift</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">DONE POINTS</h5>
                                            <span class="h2 font-weight-bold mb-0">{{$perShiftTasksDone}}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="fa fa-calendar-day"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-nowrap">Daily Tasks</span>
                                        <span class="text-success mr-2"> last 7 days</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">DONE POINTS</h5>
                                            <span class="h2 font-weight-bold mb-0">{{$zendeskTasksDone}}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="fa fa-check-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-nowrap">Zendesk Tasks</span>
                                        <span class="text-success mr-2"> last 7 days</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Total tasks</h5>
                                            <span class="h2 font-weight-bold mb-0">{{$numberOfTasksLast7Days}}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="fa fa-chart-bar"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-nowrap">All Tasks count </span>
                                        <span class="text-success mr-2"> last 7 days</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Image-Text card -->

                    <!-- Members list group card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <!-- Title -->
                            <h5 class="h3 mb-0">Joined Teams</h5>
                        </div>
                        <!-- Card search -->

                        <!-- Card body -->
                        <div class="card-body">
                            <!-- List group -->
                            <ul class="list-group list-group-flush list my--3">
                                @foreach($teamMember->teams as $team)
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="#" class="avatar rounded-circle">
                                                <img alt="Image placeholder" src="{{asset('assets/img/brand/ds.png')}}">
                                            </a>
                                        </div>
                                        <div class="col ml--2">
                                            <h4 class="mb-0">
                                                <a href="#!">{{$team->name}}</a>
                                            </h4>
                                            <span class="text-success">●</span>
                                            <small><a class="text-success" target="_blank" href="https://digisay.atlassian.net/jira/core/projects/{{$team->jira_project_key}}/board">JIRA Board</a></small>
                                        </div>

                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <!-- Title -->
                            <h5 class="h3 mb-0">Team Members</h5>
                        </div>
                        <!-- Card search -->

                        <!-- Card body -->
                        <div class="card-body">
                            <!-- List group -->
                            <ul class="list-group list-group-flush list my--3">
                                @foreach($teamMember->teams[0]->teamMembers as $member)
                                    @if($member->id != $teamMember->id)
                                    <li class="list-group-item px-0">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <!-- Avatar -->
                                                <a href="#" class="avatar rounded-circle">
                                                    <img alt="Image placeholder" src="{{asset('assets/img/brand/ds.png')}}">
                                                </a>
                                            </div>
                                            <div class="col ml--2">
                                                <h4 class="mb-0">
                                                    <a href="#!">{{$member->name}}</a>
                                                </h4>
                                                <span class="text-success">●</span>
                                                <small><a class="text-success" target="_blank" href="{{route('get.team-member.statistics',$member->id)}}">Statistics</a></small>
                                            </div>

                                        </div>
                                    </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- Progress track -->


                </div>
                <div class="col-lg-4">

                    <!-- Timeline card -->
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <!-- Title -->
                            <h5 class="h3 mb-0">Latest 7 Days logs</h5>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="timeline timeline-one-side" data-timeline-content="axis" data-timeline-axis-style="dashed">
                                @if( $allLogs->count() === 0)
                                    <div class="timeline-block">

                                            <span class="timeline-step badge-danger">
                                              <i class="ni ni-spaceship"></i>
                                            </span>

                                        <div class="timeline-content">
                                            <div class="d-flex justify-content-between pt-1">
                                                <div>
                                                    <span class="text-muted text-xs font-weight-bold">Sorry !</span>
                                                </div>
                                                <div class="text-right">
                                                    <small class="text-muted"><i class="fas fa-clock mr-1"></i>1 Second Ago</small>
                                                </div>
                                            </div>
                                            <h6 class="text-sm mt-1 mb-0">We don't have any logs for {{$teamMember->name}}, he/she should get new tasks soon!
                                            </h6>
                                        </div>
                                    </div>
                                @else
                                    @foreach($allLogs as $logData)
                                        <div class="timeline-block">
                                            @if($logData->task_type === 'per_shift')
                                                <span class="timeline-step badge-success">
                                              <i class="ni ni-active-40 "></i>
                                            </span>
                                            @else
                                                <span class="timeline-step badge-warning">
                                              <i class="ni ni-chat-round "></i>
                                            </span>
                                            @endif
                                            <div class="timeline-content">
                                                <div class="d-flex justify-content-between pt-1">
                                                    <div>
                                                        <span class="text-muted text-xs font-weight-bold">@if($logData->task_type === 'per_shift') Shift task distributed @else Zendesk task assigned @endif</span>
                                                    </div>
                                                    <div class="text-right">
                                                        <small class="text-muted"><i class="fas fa-clock mr-1"></i>{{$logData->created_at->diffForHumans()}}</small>
                                                    </div>
                                                </div>
                                                <h6 class="text-sm mt-1 mb-0"> Capacity before task was {{$logData->before_member_capacity}}, And after task became {{$logData->after_member_capacity}}
                                                    @if($logData->task_type === 'zendesk'), You can check the task from <a class="text-blue" href="https://digisay.atlassian.net/jira/core/projects/{{$logData->team->jira_project_key}}/board?selectedIssue={{$logData->jira_issue_key}}">here</a>
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
                <div class="col-lg-4">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <!-- Title -->
                            <h5 class="h3 mb-0">@if($isInShiftNow) This @else Last @endif shift capacity track</h5>
                        </div>
                        <!-- Card body -->
                        <div class="card-body">
                            <!-- List group -->
                            <ul class="list-group list-group-flush list my--3">
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="#" class="avatar rounded-circle">
                                                <img alt="Image placeholder" src="{{asset('assets/img/brand/ds.png')}}">
                                            </a>
                                        </div>
                                        <div class="col">
                                            <?php
                                            use App\Modules\Distribution\Enums\TaskDistributionRatiosEnum;
                                            $pershiftRatio = TaskDistributionRatiosEnum::TYPES_RATIOS[TaskDistributionRatiosEnum::PER_SHIFT];
                                            $zendeskRatio = TaskDistributionRatiosEnum::TYPES_RATIOS[TaskDistributionRatiosEnum::ZENDESK];
                                            ?>
                                            <h5>Daily tasks</h5>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="{{$totalPointsLastShiftForPerShift}}" aria-valuemin="0" aria-valuemax="{{$memberWeightLastShift * $pershiftRatio}}" style="width: @if($memberWeightLastShift == 0) 0 @else  {{$totalPointsLastShiftForPerShift / ($memberWeightLastShift * $pershiftRatio) * 100}}@endif%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <!-- Avatar -->
                                            <a href="#" class="avatar rounded-circle">
                                                <img alt="Image placeholder" src="{{asset('/assets/img/icons/common/zendesk.png')}}">
                                            </a>
                                        </div>
                                        <div class="col">
                                            <h5>Zendesk tasks</h5>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="{{$totalPointsLastShiftForZendesk}}" aria-valuemin="0" aria-valuemax="100" style="width:@if($memberWeightLastShift == 0) 0 @else {{$totalPointsLastShiftForZendesk / ($memberWeightLastShift * $zendeskRatio) * 100}}@endif%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row justify-content-between align-items-center">
                                <div class="col">
                                    <img class="avatar rounded-circle" src="{{asset('assets/img/icons/common/jira.png')}}" alt="Image placeholder" />
                                </div>
                                <div class="col-auto">
                                    @if(isset($teamMember->jira_integration_id))
                                    <span class="badge badge-lg badge-success">Linked to JIRA</span>
                                    @else
                                        <span class="badge badge-lg badge-danger">Not Linked to JIRA</span>
                                    @endif
                                </div>
                            </div>
                            <div class="my-4">
                                <span class="h6 surtitle text-muted">JIRA ID</span>
                                <div class="h1">
                                    @if( isset($teamMember->jira_integration_id))
                                        {{$teamMember->jira_integration_id}}
                                    @else
                                        No JIRA ID
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="h6 surtitle text-muted">Name</span>
                                    <span class="d-block h3">{{$teamMember->name}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <span class="h6 surtitle text-muted">WFM Integration API Key</span>
                                    <span class="d-block h3">{{$teamMember->api_key}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
