@extends('layouts.master')

@section('title')
    Bulk Shift Assignation
@endsection

@section('styles')
<link rel="stylesheet" href="{{asset('new-style-assets/dashboard/css/dashboard.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('new-style-assets/lists/css/lists.css')}}" type="text/css">
@endsection

@section('content')
    <!-- Header Section -->
    <div class="header-modern">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 col-7">
                    <h1 class="h2 text-white mb-2">Bulk Shift Assignation</h1>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">List</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Teams for bulk assignation</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <!-- No header buttons needed for this page -->
                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col">
                <div class="chart-card card">
                    <div class="chart-body">
                        <div class="table-responsive">
                            <table class="table modern-list-table" id="datatable-basic">
                                <thead>
                                <tr>
                                    <th>Team Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($teams as $team)
                                    <tr>
                                        <td>
                                            <div class="list-item-name">{{$team->name}}</div>
                                        </td>
                                        <td>
                                            <div class="list-actions">
                                                @can('schedule-shift-to-members')
                                                <a href="{{route('get.shifts.bulk.schedule',$team->id)}}" class="list-action-btn btn-primary-gradient">
                                                    <i class="fa fa-calendar-check"></i>
                                                    <span>Bulk Schedule</span>
                                                </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/lists/js/lists.js')}}"></script>
@endsection
