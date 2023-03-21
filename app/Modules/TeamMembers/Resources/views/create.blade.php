@extends('layouts.master')
@section('title')
    {!! config('teammembers.name') !!}
@endsection
@section('scripts')
    <script>
        $(function () {
            // Basic instantiation:
            $('#demo-input').colorpicker();

            // Example using an event, to change the color of the #demo div background:
            $('#demo-input').on('colorpickerChange', function(event) {
                $('#demo-input').css('background-color', event.color.toString());
            });
        });
    </script>
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
                                    <li class="breadcrumb-item active" aria-current="page">Add Team Member</li>
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
                    <h3 class="mb-0">Add Team Member Form</h3>
                </div>
                <!-- Card body -->
                <div class="card-body">
                    <form role="form" method="POST" action="{{ route('post.team-member.create') }}">
                    @csrf
                    <!-- Form groups used in grid -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Name</label>
                                    <input required type="text" class="form-control" id="name"  name="name" placeholder="Name of team member">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="iraIntegrationId">Jira Integration Id</label>
                                    <input required type="text" class="form-control" id="jira_integration_id" name="jira_integration_id" placeholder="Jira Integration Id of team member">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="active">Active</label>
                                    <select required class="form-control" name="is_active" data-toggle="select">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="weight">Weight</label>
                                    <select required class="form-control" name="weight" data-toggle="select">
                                        @for ($i = 0; $i <= 1000; $i++)
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="shift">Color</label>
                                   <input required type="text" class="form-control" name="color"  id="demo-input">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="team">Team</label>
                                    <select required class="form-control" name="team" data-toggle="select">
                                        @foreach ($teams as $team)
                                        <option value="{{$team->id}}">{{$team->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="email">Email</label>
                                    <input  type="email" class="form-control" id="email"  name="email" placeholder="Email of team member">
                                </div>
                                @error('email')
                                <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
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
