@extends('layouts.master')
@section('title')
    {!! config('teams.name') !!} - {{ $team->name }}
@endsection
@section('content')

    <div class="main-content" id="panel">

        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Teams </h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#">Teams</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Team Item</li>
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
                    <h3 class="mb-0">Show Team Data</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form role="form">

                    <!-- Form groups used in grid -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Name</label>
                                <input disabled type="text" class="form-control" id="name"  name="name" value="{{$team->name}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="description">Description</label>
                                <input disabled type="text" class="form-control" id="description" name="description" value="{{$team->description}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Jira Project Key</label>
                                <input disabled type="text" class="form-control" id="jira_project_key"  name="jira_project_key" value="{{$team->jira_project_key}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button disabled class="btn btn-icon btn-primary" type="submit">
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
