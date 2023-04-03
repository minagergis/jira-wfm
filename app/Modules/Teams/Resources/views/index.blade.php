@extends('layouts.master')
@section('title')
    {!! config('teams.name') !!}
@endsection
@section('content')
    <div class="main-content" id="panel">

        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Teams</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#">List</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Teams</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            @can('create-team')
                            <a href="{{route('get.teams.create')}}" class="btn btn-sm btn-neutral">New</a>
                            @endcan
                            @can('manual-distribution')
                            <a href="{{route('get.distribution.distribute')}}" class="btn btn-sm btn-neutral">Distribute Manually</a>
                            @endcan
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Teams</h3>
                        </div>
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>description</th>
                                    <th>jira project key</th>
                                    <th>Controls ⌘</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teams as $team)
                                <tr>
                                    <td>{{$team->name}}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($team->description ,50) }}</td>
                                    <td>{{$team->jira_project_key ?? 'N/A'}}</td>
                                    <td>
                                        @can('edit-team')
                                        <a href="{{route('get.teams.edit',$team->id)}}" class="btn btn-icon btn-dribbble" type="button">
                                            <span class="btn-inner--icon"><i class="fa fa-edit"></i></span>
                                            <span class="btn-inner--text">Update</span>
                                        </a>
                                        @endcan
                                        @can('list-team-member')
                                        <a href="{{route('get.team-member.list-by-team',$team->id)}}" class="btn btn-icon btn-default" type="button">
                                            <span class="btn-inner--icon"><i class="fa fa-heart"></i></span>
                                            <span class="btn-inner--text">Members</span>
                                        </a>
                                        @endcan
                                            @can('manual-distribution')
                                                <a href="{{route('get.schedule.shift-changer',$team->id)}}" class="btn btn-icon btn-danger" type="button">
                                                    <span class="btn-inner--icon"><i class="fa fa-calendar"></i></span>
                                                    <span class="btn-inner--text">Shift changer</span>
                                                </a>
                                            @endcan
                                        @can('view-team-schedule')
                                        <a href="{{route('get.schedule.list-by-team',$team->id)}}" class="btn btn-icon btn-outline-warning" type="button">
                                            <span class="btn-inner--icon"><i class="fa fa-user-clock"></i></span>
                                            <span class="btn-inner--text">Schedules</span>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@endsection
