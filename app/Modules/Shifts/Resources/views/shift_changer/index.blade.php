@extends('layouts.master')
@section('title')
    {!! config('shifts.name') !!}
@endsection

@section('styles')
@endsection

@section('scripts')
    // First, include the SweetAlert library in your HTML file
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Then, create a function to handle the delete button click event

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
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Shift Changer</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
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
                                    <th>Assignee</th>
                                    {{--                                    <th>Days</th>--}}
                                    <th>Starts from</th>
                                    <th>Ends At</th>
                                    <th>Controls ⌘</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($schedules as $schedule)
                                    <tr>
                                        <td>{{$schedule->name}}</td>
                                        <td>{{$schedule->member->name}}</td>
                                        <td>{{\Carbon\Carbon::parse($schedule->date_from)->format('Y-m-d')}} {{\Carbon\Carbon::createFromTimeString($schedule->time_from)->format('g:i A')}}</td>
                                        <td>{{\Carbon\Carbon::parse($schedule->date_to)->format('Y-m-d')}} {{\Carbon\Carbon::createFromTimeString($schedule->time_to)->format('g:i A')}}</td>
                                        <td>
                                            <a onclick="handleDeleteClick($(this))"  data-token = "{!!  csrf_token() !!}"  data-href="{{route('put.schedule.shift-changer.delete',[$schedule->id])}}" class="btn btn-icon btn-danger" type="button">
                                                <span class="btn-inner--icon"><i class="fa fa-trash"></i></span>
                                                <span class="btn-inner--text">Delete</span>
                                            </a>
                                            <a href="{{route('get.schedule.shift-changer.people-swap',$schedule->id)}}" class="btn btn-icon btn-danger" type="button">
                                                <span class="btn-inner--icon"><i class="fa fa-users"></i></span>
                                                <span class="btn-inner--text">People swap</span>
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
