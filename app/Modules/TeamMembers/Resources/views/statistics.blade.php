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
                                                <i class="ni ni-active-40"></i>
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
                                                <i class="ni ni-chart-pie-35"></i>
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
                                                <i class="ni ni-money-coins"></i>
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
                                            <h5 class="card-title text-uppercase text-muted mb-0">Performance</h5>
                                            <span class="h2 font-weight-bold mb-0">High</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="ni ni-chart-bar-32"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-danger mr-2"><i class="fa fa-arrow-up"></i> 150%</span>
                                        <span class="text-nowrap">today</span>
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
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <!-- Title -->
                            <h5 class="h3 mb-0">Today's Capacity track</h5>
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
                                            <h5>Daily tasks</h5>
                                            <div class="progress progress-xs mb-0">
                                                <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
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
                                                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

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
                        </div>
                    </div>

                    <div class="card bg-gradient-default">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total traffic</h5>
                                    <span class="h2 font-weight-bold mb-0 text-white">350,897</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                        <i class="ni ni-active-40"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-white mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap text-light">Since last month</span>
                            </p>
                        </div>
                    </div>
                    <div class="card bg-gradient-primary">
                        <!-- Card body -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0 text-white">New users</h5>
                                    <span class="h2 font-weight-bold mb-0 text-white">2,356</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                        <i class="ni ni-atom"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-sm">
                                <span class="text-white mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                <span class="text-nowrap text-light">Since last month</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Footer -->
            <footer class="footer pt-0">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6">
                        <div class="copyright text-center text-lg-left text-muted">
                            &copy; 2019 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/license" class="nav-link" target="_blank">License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
