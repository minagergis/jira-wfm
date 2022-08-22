@extends('layouts.master')
@section('title')
    Homepage
@endsection

@section('scripts')
   <script>
       var SalesChart = (function() {

           // Variables

           var $chart = $('#chart-sales-dark-id');
           var $chartsData = {!! $lineChartData !!}

           // Methods

           function init($this) {
               var salesChart = new Chart($this, {
                   type: 'line',
                   options: {
                       scales: {
                           yAxes: [{
                               gridLines: {
                                   color: Charts.colors.gray[700],
                                   zeroLineColor: Charts.colors.gray[700]
                               },
                               ticks: {

                               }
                           }]
                       }
                   },
                   data: $chartsData
               });

               // Save to jQuery object

               $this.data('chart', salesChart);

           };


           // Events

           if ($chart.length) {
               init($chart);
           }

       })();
       var BarsChart = (function() {

           //
           // Variables
           //

           var $chart = $('#chart-bars-id');
           var $batChartsData = {!! $barChartData !!}

           //
           // Methods
           //

           // Init chart
           function initChart($chart) {

               // Create chart
               var ordersChart = new Chart($chart, {
                   type: 'bar',
                   data: $batChartsData
               });

               // Save to jQuery object
               $chart.data('chart', ordersChart);
           }


           // Init chart
           if ($chart.length) {
               initChart($chart);
           }

       })();
   </script>
@endsection
@section('content')
    <!-- Main content -->

        <!-- Header -->
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <h6 class="h2 text-white d-inline-block mb-0">Work Force Management</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Work Force Management</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-lg-6 col-5 text-right">
                            @can('list-team')
                            <a href="{{route('get.teams.list')}}" class="btn btn-sm btn-neutral">List Teams</a>
                            @endcan
                        </div>
                    </div>
                    <!-- Card stats -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Teams</h5>
                                            <span class="h2 font-weight-bold mb-0">{!! $teamsCount !!}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                                <i class="fa fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> @if($teamsCount > 0 )  {!! ceil(($teamsLastDaysCount/$teamsCount)*100)  !!} @else 0 @endif%</span>
                                        <span class="text-nowrap">Since last week</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Total Members</h5>
                                            <span class="h2 font-weight-bold mb-0">{!! $teamMembersCount !!}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="fa fa-user"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> @if($teamMembersCount === 0) 0 @else {!! ceil(($teamMembersLastDaysCount/$teamMembersCount)*100)  !!} @endif %</span>
                                        <span class="text-nowrap">Since last week</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Tasks</h5>
                                            <span class="h2 font-weight-bold mb-0">{!! $tasksCount !!}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="fa fa-tasks"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> @if($tasksCount === 0) 0 @else {!! ceil(($tasksLastDaysCount / $tasksCount) * 100)  !!} @endif %</span>
                                        <span class="text-nowrap">Since last week</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Schedules</h5>
                                            <span class="h2 font-weight-bold mb-0">{!! $schedulesCount !!}</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="fa fa-clock"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> @if($schedulesCount > 0) {!! ceil(($schedulesLastDaysCount/$schedulesCount)*100)  !!} @else 0 @endif %</span>
                                        <span class="text-nowrap">Since last week</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--6">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card bg-default">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-light text-uppercase ls-1 mb-1">Automatic distributed tasks for last 7 days</h6>
                                    <h5 class="h3 text-white mb-0">OVERVIEW</h5>
                                </div>
{{--                                <div class="col">--}}
{{--                                    <ul class="nav nav-pills justify-content-end">--}}
{{--                                        <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales-dark-id" data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 100, 40, 20, 60, 60]}]}}' data-prefix="$" data-suffix="k">--}}
{{--                                            <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">--}}
{{--                                                <span class="d-none d-md-block">Month</span>--}}
{{--                                                <span class="d-md-none">M</span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li class="nav-item" data-toggle="chart" data-target="#chart-sales-dark-id" data-update='{"data":{"datasets":[{"data":[0, 20, 5, 25, 10, 30, 15, 40, 40]}]}}' data-prefix="$" data-suffix="k">--}}
{{--                                            <a href="#" class="nav-link py-2 px-3" data-toggle="tab">--}}
{{--                                                <span class="d-none d-md-block">Week</span>--}}
{{--                                                <span class="d-md-none">W</span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Chart -->
                            <div class="chart">
                                <!-- Chart wrapper -->
                                <canvas id="chart-sales-dark-id" class="chart-canvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="text-uppercase text-muted ls-1 mb-1">zendesk tasks performance for last 7 days</h6>
                                    <h5 class="h3 mb-0 ">Performance</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Chart -->
                            <div class="chart">
                                <canvas id="chart-bars-id" class="chart-canvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="footer pt-0">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-xl-12">
                        <div class="copyright text-center text-xl-center text-muted">
                            &copy; <?php echo date('Y')?> <a href="http://wfm.antipiracy.me" class="font-weight-bold ml-1" target="_blank">Made with love ❤️</a>
                        </div>
                    </div>

                </div>
            </footer>
        </div>

@endsection
