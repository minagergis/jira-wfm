@extends('layouts.master')
@section('title')
    {!! config('shifts.name') !!}
@endsection
@section('content')
    <div class="main-content" id="panel">

        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Shifts</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Shifts</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="{{route('get.shifts.create')}}" class="btn btn-sm btn-neutral">New</a>
                            <a href="{{route('get.distribution.distribute')}}" class="btn btn-sm btn-neutral">Distribution</a>
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
                            <h3 class="mb-0">Shifts</h3>
                        </div>
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="datatable-basic">
                                <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
{{--                                    <th>Days</th>--}}
                                    <th>Starts from</th>
                                    <th>Ends At</th>
                                    <th>Controls ⌘</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($shifts as $shift)
                                    <tr>
                                        <td>{{$shift->name}}</td>
                                        <td>{{$shift->description}}</td>
{{--                                        <td>{{$shift->days}}</td>--}}
                                        <td>{{\Carbon\Carbon::createFromTimeString($shift->time_from)->format('g:i A')}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($shift->time_to)->format('g:i A')}}</td>
                                        <td>
                                            <a href="{{route('get.shifts.edit',$shift->id)}}" class="btn btn-icon btn-dribbble" type="button">
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
