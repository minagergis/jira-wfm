@extends('layouts.master')
@section('title')
    {!! config('teams.name') !!}
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
                            <a href="{{route('get.teams.create')}}" class="btn btn-sm btn-neutral">New</a>
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
                    <h3 class="mb-0">Add Team Form</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('post.teams.create') }}">
                    @csrf
                    <!-- Form groups used in grid -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Name</label>
                                <input required type="text" class="form-control" id="name"  name="name" placeholder="Name of team">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="description">Description</label>
                                <textarea required type="text" class="form-control" id="description" name="description" placeholder="Description of team"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="name">Jira Project Key</label>
                                <input required type="text" class="form-control" id="jira_project_key"  name="jira_project_key" placeholder="Board key in JIRA">
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
