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
                            <a href="{{route('get.teams.create')}}" class="btn btn-sm btn-neutral">New</a>
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
                                        <a href="{{route('get.teams.edit',$team->id)}}" class="btn btn-icon btn-dribbble" type="button">
                                            <span class="btn-inner--icon"><i class="fa fa-edit"></i></span>
                                            <span class="btn-inner--text">Update</span>
                                        </a>
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
