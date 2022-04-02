@extends('layouts.master')
@section('title')
    {!! config('teammembers.name') !!} - Assign shifts to {{$teamMember->name}}
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
                                    <li class="breadcrumb-item active" aria-current="page">Assign shifts</li>
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
                    <h3 class="mb-0">Assign shifts to  {{$teamMember->name}}</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('post.team-member.assign-shift',$teamMember->id) }}">
                    @csrf
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
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="datatable-basic">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>Shift Name</th>
                                        <th>Shift Days</th>
                                        <th>Shift Time</th>
                                        <th>Controls ⌘</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($teamMember->teams[0]->shifts as $shift)
                                        <tr>
                                            <td>{{$shift->name}}</td>
                                            <td>{{$shift->days}}</td>
                                            <td>{{$shift->time_from}} -> {{$shift->time_to}}</td>
                                            <td>
                                                <label class="custom-toggle">
                                                    <input name="shifts[]" @if(in_array($shift->id,$teamMember->shifts->pluck('id')->toArray())) checked @endif value="{{$shift->id}}" type="checkbox">
                                                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn btn-icon btn-primary" type="submit">
                                        <span class="btn-inner--icon"><i class="ni ni-watch-time"></i></span>
                                        <span class="btn-inner--text">Assign</span>
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
