@extends('layouts.master')

@section('title')
    {!! config('shifts.name') !!} - Shift Changer
@endsection

@section('styles')
<link rel="stylesheet" href="{{asset('new-style-assets/dashboard/css/dashboard.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('new-style-assets/lists/css/lists.css')}}" type="text/css">
@stack('custom-styles')
@endsection

@section('content')
    <!-- Header Section -->
    <div class="header-modern">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 col-7">
                    <h1 class="h2 text-white mb-2">Shift Changer</h1>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Shift Changer</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{route('get.distribution.distribute')}}" class="btn btn-sm btn-white">
                        <i class="fas fa-sync-alt mr-1"></i>Distribution
                    </a>
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
                                    <th>Name</th>
                                    <th>Assignee</th>
                                    <th>Starts from</th>
                                    <th>Ends At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schedules as $schedule)
                                    <tr>
                                        <td>
                                            <div class="list-item-name">{{$schedule->name}}</div>
                                        </td>
                                        <td>
                                            <div class="list-item-name">{{$schedule->member->name}}</div>
                                        </td>
                                        <td>
                                            <div class="list-item-description">
                                                {{\Carbon\Carbon::parse($schedule->date_from)->format('Y-m-d')}} 
                                                {{\Carbon\Carbon::createFromTimeString($schedule->time_from)->format('g:i A')}}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="list-item-description">
                                                {{\Carbon\Carbon::parse($schedule->date_to)->format('Y-m-d')}} 
                                                {{\Carbon\Carbon::createFromTimeString($schedule->time_to)->format('g:i A')}}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="list-actions">
                                                <a onclick="handleDeleteClick($(this))" 
                                                   data-token="{!! csrf_token() !!}" 
                                                   data-href="{{route('put.schedule.shift-changer.delete',[$schedule->id])}}" 
                                                   class="list-action-btn btn-danger-gradient">
                                                    <i class="fa fa-trash"></i>
                                                    <span>Delete</span>
                                                </a>
                                                <a href="{{route('get.schedule.shift-changer.people-swap',$schedule->id)}}" 
                                                   class="list-action-btn btn-primary-gradient">
                                                    <i class="fa fa-users"></i>
                                                    <span>People Swap</span>
                                                </a>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('new-style-assets/lists/js/lists.js')}}"></script>
<script>
    // Handle delete button click event
    function handleDeleteClick(elem) {
        console.log(elem);
        Swal.fire({
            title: 'Are you sure you want to delete the schedule?',
            inputAttributes: {autocapitalize: 'off'},
            showCancelButton: true,
            confirmButtonText: 'Approve',
            showLoaderOnConfirm: true,
            preConfirm: (approvalMessage) => {
                return $.ajax({
                    type: 'PUT',
                    url: elem.data('href'),
                    data: {"note" : approvalMessage, "_token" : elem.data('token')},
                    async: false,
                    dataType: "json",
                    success: function(resultData) {
                    },
                    error : function(errorData) {
                        Swal.fire(
                            errorData.responseJSON.message,
                            '',
                            'error'
                        );
                    }
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if(result.value.message === 'success'){
                Swal.fire(
                    'Approved!',
                    'The record deleted successfully',
                    'success'
                )
            }
            location.reload();
        })
    }
</script>
@stack('custom-scripts')
@endsection
