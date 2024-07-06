<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{route('home')}}">
                <img src="{{asset('assets/img/brand/ds.png')}}" class="navbar-brand-img" alt="...">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    @can('view-dashboard-stats')

                    <li class="nav-item">
                        <a class="nav-link active" href="#navbar-dashboards" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Dashboards</span>
                        </a>
                        <div class="collapse show" id="navbar-dashboards">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('home')}}" class="nav-link">Dashboard</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endcan
                    @if(auth()->user()->can('list-team') || auth()->user()->can('create-team'))
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms">
                            <i class="ni ni-single-copy-04 text-pink"></i>
                            <span class="nav-link-text">Teams</span>
                        </a>
                        <div class="collapse" id="navbar-forms">
                            <ul class="nav nav-sm flex-column">
                                @can('create-team')
                                <li class="nav-item">
                                    <a href="{{route('get.teams.create')}}" class="nav-link">Add Team</a>
                                </li>
                                @endcan
                                @can('list-team')
                                <li class="nav-item">
                                    <a href="{{route('get.teams.list')}}" class="nav-link">List Teams</a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                 @endif
                    @if(auth()->user()->can('list-team-member') || auth()->user()->can('create-team-member'))

                        <li class="nav-item">
                        <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                            <i class="ni ni-ungroup text-orange"></i>
                            <span class="nav-link-text">Team Member </span>
                        </a>
                        <div class="collapse" id="navbar-examples">
                            <ul class="nav nav-sm flex-column">
                                @can('list-team-member')
                                <li class="nav-item">
                                    <a href="{{route('get.team-member.create')}}" class="nav-link">Add Team Member</a>
                                </li>
                                @endcan
                                @can('create-team-member')

                                    <li class="nav-item">
                                    <a href="{{route('get.team-member.list')}}" class="nav-link">List Team Members</a>
                                </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                        @endif
                    @if(auth()->user()->can('list-task') || auth()->user()->can('create-task'))
                        <li class="nav-item">
                        <a class="nav-link" href="#navbar-components-tasks" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-components-tasks">
                            <i class="ni ni-ui-04 text-info"></i>
                            <span class="nav-link-text">Tasks</span>
                        </a>
                        <div class="collapse" id="navbar-components-tasks">
                            <ul class="nav nav-sm flex-column">
                                @can('create-task')
                                <li class="nav-item">
                                    <a href="{{route('get.tasks.create')}}" class="nav-link">Add Task</a>
                                </li>
                                @endcan
                                @can('list-task')
                                <li class="nav-item">
                                    <a href="{{route('get.tasks.list')}}" class="nav-link">List Tasks</a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                        @endif

                        @if(auth()->user()->can('list-shift') || auth()->user()->can('create-shift'))
                            <li class="nav-item">
                                <a class="nav-link" href="#navbar-components-tasks" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-components-tasks">
                                    <i class="ni ni-ui-04 calendar"></i>
                                    <span class="nav-link-text">Shifts</span>
                                </a>
                                <div class="collapse" id="navbar-components-tasks">
                                    <ul class="nav nav-sm flex-column">
                                        @can('create-shift')
                                            <li class="nav-item">
                                                <a href="{{route('get.shifts.create')}}" class="nav-link">Add Shift</a>
                                            </li>
                                        @endcan
                                        @can('list-shifts')
                                            <li class="nav-item">
                                                <a href="{{route('get.shifts.list')}}" class="nav-link">List Shift</a>
                                            </li>
                                        @endcan

                                            @can('schedule-shift-to-members')
                                                <li class="nav-item">
                                                    <a href="{{route('get.shifts.bulk.schedule.teams')}}" class="nav-link">Bulk Schedule</a>
                                                </li>
                                            @endcan
                                    </ul>
                                </div>
                            </li>
                        @endif
                    @if(auth()->user()->can('list-contact-type') || auth()->user()->can('create-contact-type'))

                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-components-c-types" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-components-c-types">
                            <i class="ni ni-satisfied text-red"></i>
                            <span class="nav-link-text">Contact types</span>
                        </a>
                        <div class="collapse" id="navbar-components-c-types">
                            <ul class="nav nav-sm flex-column">
                                @can('list-contact-type')
                                <li class="nav-item">
                                    <a href="{{route('get.contact-type.create')}}" class="nav-link">Add Contact type</a>
                                </li>
                                @endcan
                                @can('create-contact-type')
                                <li class="nav-item">
                                    <a href="{{route('get.contact-type.list')}}" class="nav-link">List Contact types</a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                </ul>
                @endif
            </div>
        </div>
    </div>
</nav>
