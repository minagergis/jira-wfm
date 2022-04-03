@extends('layouts.master')
@section('title')
    {!! config('tasks.name') !!} - {{$task->name}}
@endsection
@section('content')

    <div class="main-content" id="panel">

        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Task</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('get.team-member.list')}}">Task</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Show Task - {{$task->name}}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="#" class="btn btn-sm btn-neutral">New</a>
                            <a href="#" class="btn btn-sm btn-neutral">Filters</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="card mb-4">
                <!-- Card header -->
                <div class="card-header">
                    <h3 class="mb-0">Show {{$task->name}}'s Data</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Name</label>
                                    <input disabled type="text" class="form-control" id="name"  name="name" placeholder="Name of task" value="{{$task->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Description</label>
                                    <input disabled type="text" class="form-control" id="description"  name="description" placeholder="Description of task" value="{{$task->description}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="active">Frequency</label>
                                    <select disabled class="form-control" name="frequency" data-toggle="select">
                                        <option @if($task->frequency == 'daily') selected @endif value="daily">Daily</option>
                                        <option @if($task->frequency == 'weekly') selected @endif value="weekly">Weekly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="weight">Points</label>
                                    <select disabled class="form-control" name="points" data-toggle="select">
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option @if($task->points == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="team">Team</label>
                                    <select disabled class="form-control" name="team_id" data-toggle="select">
                                        @foreach ($teams as $team)
                                            <option @if($task->team_id == $team->id) selected @endif value="{{$team->id}}">{{$team->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="is_automatic">Is Automatic</label>
                                    <select disabled class="form-control" name="is_automatic" data-toggle="select">
                                        <option  @if($task->is_automatic == 1) selected @endif  value="1">Yes</option>
                                        <option  @if($task->is_automatic == 1) selected @endif  value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button disabled class="btn btn-icon btn-primary" type="submit">
                                        <span class="btn-inner--icon"><i class="ni ni-bag-17"></i></span>
                                        <span class="btn-inner--text">Add</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
