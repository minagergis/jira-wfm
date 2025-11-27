@extends('layouts.master')
@section('title')
    Dashboard
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('new-style-assets/dashboard/css/dashboard.css')}}" type="text/css">
@endsection

@section('scripts')

    <script>
        var lineChartData = {!! $lineChartData !!};
        var barChartData = {!! $barChartData !!};
</script>
    <script src="{{asset('new-style-assets/dashboard/js/dashboard.js')}}"></script>


@endsection
@section('content')
    <!-- Header Section -->
    <div class="header-modern">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 col-7">
                    <h1 class="h2 text-white mb-2">Work Force Management</h1>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    @can('list-team')
                    <a href="{{route('get.teams.list')}}" class="btn btn-sm btn-white">List Teams</a>
                    @endcan
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="stat-label">Teams</div>
                                    <div class="stat-value">{!! $teamsCount !!}</div>
                                    <div class="stat-change text-success mt-2">
                                        <i class="fa fa-arrow-up"></i>
                                        @if($teamsCount > 0)
                                            {!! ceil(($teamsLastDaysCount/$teamsCount)*100) !!}%
                                        @else
                                            0%
                                        @endif
                                        <span class="text-muted ml-1">Since last week</span>
                                    </div>
                                </div>
                                <div class="stat-icon bg-gradient-orange text-white">
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="stat-label">Total Members</div>
                                    <div class="stat-value">{!! $teamMembersCount !!}</div>
                                    <div class="stat-change text-success mt-2">
                                        <i class="fa fa-arrow-up"></i>
                                        @if($teamMembersCount === 0)
                                            0%
                                        @else
                                            {!! ceil(($teamMembersLastDaysCount/$teamMembersCount)*100) !!}%
                                        @endif
                                        <span class="text-muted ml-1">Since last week</span>
                                    </div>
                                </div>
                                <div class="stat-icon bg-gradient-red text-white">
                                    <i class="fa fa-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="stat-label">Tasks</div>
                                    <div class="stat-value">{!! $tasksCount !!}</div>
                                    <div class="stat-change text-success mt-2">
                                        <i class="fa fa-arrow-up"></i>
                                        @if($tasksCount === 0)
                                            0%
                                        @else
                                            {!! ceil(($tasksLastDaysCount / $tasksCount) * 100) !!}%
                                        @endif
                                        <span class="text-muted ml-1">Since last week</span>
                                    </div>
                                </div>
                                <div class="stat-icon bg-gradient-green text-white">
                                    <i class="fa fa-tasks"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stat-card card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="stat-label">Schedules</div>
                                    <div class="stat-value">{!! $schedulesCount !!}</div>
                                    <div class="stat-change text-success mt-2">
                                        <i class="fa fa-arrow-up"></i>
                                        @if($schedulesCount > 0)
                                            {!! ceil(($schedulesLastDaysCount/$schedulesCount)*100) !!}%
                                        @else
                                            0%
                                        @endif
                                        <span class="text-muted ml-1">Since last week</span>
                                    </div>
                                </div>
                                <div class="stat-icon bg-gradient-info text-white">
                                    <i class="fa fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-xl-8 col-lg-12 mb-4">
                <div class="chart-card card">
                    <div class="chart-card-header">
                        <div class="chart-title">Automatic distributed tasks for last 7 days</div>
                        <div class="chart-subtitle">Overview</div>
                    </div>
                    <div class="chart-body">
                        <div class="chart-wrapper">
                            <canvas id="chart-sales-dark-id"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 mb-4">
                <div class="chart-card card">
                    <div class="chart-card-header">
                        <div class="chart-title">Zendesk tasks performance for last 7 days</div>
                        <div class="chart-subtitle">Performance</div>
                    </div>
                    <div class="chart-body">
                        <div class="chart-wrapper">
                            <canvas id="chart-bars-id"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer pt-4 mt-5">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-xl-12">
                    <div class="copyright text-center text-muted">
                        &copy; <?php echo date('Y')?> <a href="http://wfm.antipiracy.me" class="font-weight-bold ml-1" target="_blank">Made with love ❤️</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
