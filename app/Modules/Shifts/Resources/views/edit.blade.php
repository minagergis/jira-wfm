@extends('layouts.master')
@section('title')
    {!! config('shifts.name') !!} - Edit {{$shift->name}}
@endsection
@section('content')

    <div class="main-content" id="panel">

        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Shifts </h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('get.shifts.list')}}">Shifts</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit shift</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="{{route('get.shifts.create')}}" class="btn btn-sm btn-neutral">New</a>
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
                    <h3 class="mb-0">Edit {{$shift->name}}'s data</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('post.shifts.edit',$shift->id) }}">
                    @csrf
                    <!-- Form groups used in grid -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Name</label>
                                    <input required type="text" class="form-control" id="name"  name="name" placeholder="Name of shift" value="{{$shift->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Description</label>
                                    <input required type="text" class="form-control" id="description"  name="description" placeholder="description of shift" value="{{$shift->description}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlSelect3">Teams</label>
                                    @foreach($teams as $team)
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="text-gray">{{$team->name}}</p>
                                            </div>
                                            <div class="col-md-9">
                                                <label class="custom-toggle">
                                                    <input name="teams[]" value="{{$team->id}}" @if(in_array($team->id, $shift->teams->pluck('id')->toArray())) checked @endif type="checkbox">
                                                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="exampleFormControlSelect3">Working days</label>
                                    @foreach($days as $key => $day)
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="text-gray">{{$day}}</p>
                                            </div>
                                            <div class="col-md-9">
                                                <label class="custom-toggle custom-toggle-danger">
                                                    <input name="days[]" value="{{$key}}" @if(in_array($key,json_decode($shift->days))) checked @endif type="checkbox">
                                                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-time-input" class="col-md-2 col-form-label form-control-label">Shift starts at</label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="time_from" type="time" value="{{\Carbon\Carbon::parse($shift->time_from)->toTimeString('minutes')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-time-input" class="col-md-2 col-form-label form-control-label">Shift ends at</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="time"  name="time_to" value="{{\Carbon\Carbon::parse($shift->time_to)->toTimeString('minutes')}}">
                                    </div>
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
