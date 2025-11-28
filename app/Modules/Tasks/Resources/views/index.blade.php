@extends('layouts.master')

@section('title')
    {!! config('tasks.name') !!}
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
                    <h1 class="h2 text-white mb-2">Tasks</h1>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Tasks</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    @can('create-task')
                    <a href="{{route('get.tasks.create')}}" class="btn btn-sm btn-white">
                        <i class="fas fa-plus mr-1"></i>New Task
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
                                    <th>Name</th>
                                    <th>Points</th>
                                    <th>Team Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                    <tr>
                                        <td>
                                            <div class="list-item-name">{{$task->name}}</div>
                                        </td>
                                        <td>
                                            <span class="list-item-badge">{{$task->points}}</span>
                                        </td>
                                        <td>
                                            <div class="list-item-description">{{$task->team->name ?? 'N/A'}}</div>
                                        </td>
                                        <td>
                                            <div class="list-actions">
                                                @can('edit-task')
                                                <a href="{{route('get.tasks.edit',$task->id)}}" class="list-action-btn btn-primary-gradient">
                                                    <i class="fa fa-edit"></i>
                                                    <span>Update</span>
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
