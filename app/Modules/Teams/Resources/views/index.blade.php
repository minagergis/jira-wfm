@extends('layouts.master')
@section('title')
    {!! config('teams.name') !!}
@endsection

@section('styles')
<link rel="stylesheet" href="{{asset('new-style-assets/dashboard/css/dashboard.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('new-style-assets/lists/css/lists.css')}}" type="text/css">
@endsection

@section('content')
    <!-- Header Section -->
    <div class="header-modern">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 col-7">
                    <h1 class="h2 text-white mb-2">Teams</h1>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">List</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Teams</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    @can('create-team')
                    <a href="{{route('get.teams.create')}}" class="btn btn-sm btn-white">
                        <i class="fas fa-plus mr-1"></i>New Team
                    </a>
                    @endcan
                    @can('manual-distribution')
                    <a href="{{route('get.distribution.distribute')}}" class="btn btn-sm btn-white ml-2">
                        <i class="fas fa-tasks mr-1"></i>Distribute Manually
                    </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <div class="chart-card card">
                    <div class="chart-body">
                        <div class="table-responsive">
                            <table class="table modern-list-table" id="datatable-basic">
                                <thead>
                                <tr>
                                    <th>Team Name</th>
                                    <th>Description</th>
                                    <th>Jira Project Key</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teams as $team)
                                <tr>
                                    <td>
                                        <div class="list-item-name">{{$team->name}}</div>
                                    </td>
                                    <td>
                                        <div class="list-item-description">{{ \Illuminate\Support\Str::limit($team->description ,50) }}</div>
                                    </td>
                                    <td>
                                        <span class="list-item-badge">{{$team->jira_project_key ?? 'N/A'}}</span>
                                    </td>
                                    <td>
                                        <div class="list-actions">
                                            @can('edit-team')
                                            <a href="{{route('get.teams.edit',$team->id)}}" class="list-action-btn btn-primary-gradient">
                                                <i class="fa fa-edit"></i>
                                                <span>Edit</span>
                                            </a>
                                            @endcan
                                            @can('list-team-member')
                                            <a href="{{route('get.team-member.list-by-team',$team->id)}}" class="list-action-btn btn-secondary-gradient">
                                                <i class="fa fa-users"></i>
                                                <span>Members</span>
                                            </a>
                                            @endcan
                                            @can('manual-distribution')
                                            <a href="{{route('get.schedule.shift-changer',$team->id)}}" class="list-action-btn btn-danger-gradient">
                                                <i class="fa fa-calendar-alt"></i>
                                                <span>Shift Changer</span>
                                            </a>
                                            @endcan
                                            @can('view-team-schedule')
                                            <a href="{{route('get.schedule.list-by-team',$team->id)}}" class="list-action-btn btn-warning-gradient">
                                                <i class="fa fa-clock"></i>
                                                <span>Schedules</span>
                                            </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/lists/js/lists.js')}}"></script>
@endsection
