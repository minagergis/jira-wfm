@extends('layouts.master')
@section('title')
    {!! config('teammembers.name') !!}
@endsection
@section('content')
    <div class="main-content" id="panel">

        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Team Members</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Team Members</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            @can('create-team-member')
                            <a href="{{route('get.team-member.create')}}" class="btn btn-sm btn-neutral">New</a>
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
                            <h3 class="mb-0">Team Members</h3>
                        </div>
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Weight</th>
                                    <th>Team Name</th>
                                    <th>API Integration Key</th>
                                    <th>Controls ⌘</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($teamMembers as $member)
                                    <tr>
                                        <td>{{$member->name}}</td>
                                        <td>{{$member->weight}}</td>
                                        <td>{{$member->teams[0]->name ?? 'N/A'}}</td>
                                        <td>{{$member->api_key ?? 'N/A'}}</td>
                                        <td>
                                            @can('edit-team-member')
                                            <a href="{{route('get.team-member.edit',$member->id)}}" class="btn btn-icon btn-dribbble" type="button">
                                                <span class="btn-inner--icon"><i class="fa fa-edit"></i></span>
                                                <span class="btn-inner--text">Update</span>
                                            </a>
                                            @endcan
                                            @can('view-team-member-stats')
                                            <a href="{{route('get.team-member.statistics',$member->id)}}" class="btn btn-icon btn-github" type="button">
                                                <span class="btn-inner--icon"><i class="fa fa-chart-bar"></i></span>
                                                <span class="btn-inner--text">Stats</span>
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
