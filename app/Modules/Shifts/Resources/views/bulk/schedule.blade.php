@extends('layouts.master')
@section('title')
    {!! config('shifts.name') !!}
@endsection
@section('content')

    <div class="main-content" id="panel">

        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Bulk Shift Assignation</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#">List</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Teams for bulk assignation</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
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
                    <h3 class="mb-0">Bulk Shift Assignation</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('post.shifts.bulk.schedule',$teamId) }}">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- Form groups used in grid -->
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="form-control-label col-md-1" for="team">Shifts</label>
                                    <div class="col-md-11">
                                    <select  required class="form-control" name="shift" data-toggle="select">
                                        @foreach ($shifts as $shift)
                                            <option value="{{$shift->id}}">{{$shift->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="example-time-input" class="col-md-3 col-form-label form-control-label">Recurring From</label>
                                    <div class="col-md-9">
                                        <input class="form-control" name="recurring_from" type="date" value="01/06/2020">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="example-time-input" class="col-md-3 col-form-label form-control-label">Recurring To</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="date"  name="recurring_to" value="16:30:00">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">



                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="exampleFormControlSelect3">Team Members</label>
                                        @foreach($teamMembers as $teamMember)
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p class="text-gray">{{$teamMember->name}}</p>
                                                </div>
                                                <div class="col-md-9">
                                                    <label class="custom-toggle">
                                                        <input name="team_members[]" value="{{$teamMember->id}}" type="checkbox">
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
