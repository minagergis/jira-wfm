@extends('layouts.master')
@section('title')
    {!! config('teammembers.name') !!} - {{$teamMember->name}}
@endsection
@section('content')

    <div class="main-content" id="panel">

        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Team Member </h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{route('get.team-member.list')}}">Team Member</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Show Team Member - {{$teamMember->name}}</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            <a href="{{route('get.team-member.create')}}" class="btn btn-sm btn-neutral">New</a>
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
                    <h3 class="mb-0">Show {{$teamMember->name}}'s Data</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form role="form">
                    <!-- Form groups used in grid -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Name</label>
                                    <input disabled type="text" class="form-control" id="name"  name="name" value="{{$teamMember->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="iraIntegrationId">Jira Integration Id</label>
                                    <input disabled type="text" class="form-control" id="jira_integration_id" name="jira_integration_id" value="{{$teamMember->jira_integration_id}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="active">Active</label>
                                    <select disabled class="form-control" name="is_active" data-toggle="select">
                                        <option @if($teamMember->is_active == 1) selected @endif value="1">Yes</option>
                                        <option @if($teamMember->is_active == 0) selected @endif value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="weight">Weight</label>
                                    <select disabled class="form-control" name="weight" data-toggle="select">
                                        @for ($i = 0; $i <= 10; $i++)
                                        <option @if($teamMember->weight == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="shift">shift now</label>
                                    <select disabled class="form-control" name="is_in_shift_now" data-toggle="select">
                                        <option @if($teamMember->is_in_shift_now == 1) selected @endif value="1">Yes</option>
                                        <option @if($teamMember->is_in_shift_now == 0) selected @endif value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="team">Team</label>
                                    <select disabled class="form-control" name="team" data-toggle="select">
                                        <option value="{{$teamMember->teams[0]->id}}">{{$teamMember->teams[0]->name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn btn-icon btn-primary" type="submit">
                                        <span class="btn-inner--icon"><i class="ni ni-bag-17"></i></span>
                                        <span class="btn-inner--text">Print</span>
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
