@extends('layouts.master')
@section('title')
    {!! config('tasks.name') !!}
@endsection
@section('content')

    <div class="main-content" id="panel">

        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Tasks </h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#">Tasks</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Task Item</li>
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
                    <h3 class="mb-0">Add Task Form</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('post.tasks.create') }}">
                    @csrf
                    <!-- Form groups used in grid -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Name</label>
                                    <input required type="text" class="form-control" id="name"  name="name" placeholder="Name of task">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="description">Description</label>
                                    <input required type="text" class="form-control" id="description"  name="description" placeholder="Description of task">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="active">Frequency</label>
                                    <select required class="form-control" name="frequency" data-toggle="select">
                                        <option value="per_shift">Every shift</option>
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="weight">Points</label>
                                    <select required class="form-control" name="points" data-toggle="select">
                                        @for ($i = 0; $i <= 10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="team">Team</label>
                                    <select required class="form-control" name="team_id" data-toggle="select">
                                        @foreach ($teams as $team)
                                            <option value="{{$team->id}}">{{$team->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="is_automatic">Is Automatic</label>
                                    <select required class="form-control" name="is_automatic" data-toggle="select">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn btn-icon btn-primary" type="submit">
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
