@extends('layouts.master')
@section('title')
    {!! config('teams.name') !!} - Schedule Calendar
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css">
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/toastr-calendar/tui-calendar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/toastr-calendar/css/default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/toastr-calendar/css/icons.css')}}">
@endsection

@section('scripts')

    <script src="https://uicdn.toast.com/tui.code-snippet/v1.5.2/tui-code-snippet.min.js"></script>
    <script src="https://uicdn.toast.com/tui.time-picker/v2.0.3/tui-time-picker.min.js"></script>
    <script src="https://uicdn.toast.com/tui.date-picker/v4.0.3/tui-date-picker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chance/1.0.13/chance.min.js"></script>
    <script src="{{asset('assets/vendor/toastr-calendar/tui-calendar.js')}}"></script>
    <script src="{{asset('assets/vendor/toastr-calendar/js/data/calendars.js')}}"></script>
    <script src="{{asset('assets/vendor/toastr-calendar/js/data/schedules.js')}}"></script>
    <script>
        (function() {
            ScheduleList = [];
            let calendar;


            let teamMembers = {!! $teamMembers !!};

            teamMembers.forEach(member => {
                calendar = new CalendarInfo();

                calendar.id = String(member.id);
                calendar.name = member.name;
                calendar.color = '#ffffff';
                calendar.bgColor = member.color;
                calendar.dragBgColor = member.color;
                calendar.borderColor = member.color;
                addCalendar(calendar);

                var localSchedules = member.schedules;

                localSchedules.forEach(memberSchedule => {
                    let schedule = new ScheduleInfo();
                    schedule.id = String(memberSchedule.id);
                    schedule.calendarId = String(memberSchedule.team_member_id);
                    schedule.title = memberSchedule.name;
                    schedule.body = 'memberSchedule.description';
                    schedule.start = moment(memberSchedule.date_from + ' '+ memberSchedule.time_from).toDate();
                    schedule.end = moment(memberSchedule.date_to+ ' '+ memberSchedule.time_to).toDate();
                    schedule.color = '#ffffff';
                    schedule.bgColor = member.color;
                    schedule.dragBgColor = member.color;
                    schedule.borderColor = member.color;
                    schedule.category = 'time';

                    ScheduleList.push(schedule);
                })
            })
//console.log(ScheduleList);
        })();
    </script>

    <script>
        let addScheduleUrl = "{!! route('post.schedule.add') !!}"
        let editScheduleUrl = "{!! route('post.schedule.edit') !!}"
        let deleteScheduleUrl = "{!! route('post.schedule.delete') !!}"
    </script>
    <script src="{{asset('assets/vendor/toastr-calendar/js/app.js')}}"></script>
    <script>
        document.getElementById("calendar").addEventListener("click", hideButtons);
        function hideButtons() {
            var editButton = document.getElementsByClassName("tui-full-calendar-popup-edit")[0];
            var deleteButton = document.getElementsByClassName("tui-full-calendar-popup-delete")[0];
            // if (editButton) {
            //     editButton.style.display = "none";
            //     editButton.nextElementSibling.style.display = "none";
            //     deleteButton.style.width = "100%";
            // }
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
                            <h6 class="h2 text-white d-inline-block mb-0">Schedule Calendar</h6>
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Teams</li>
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
            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card">
                        <!-- Card header -->
                        <div class="card-header">
                            <h3 class="mb-0">Team Members</h3>
                        </div>
                        <div id="top">

                        </div>
                        <div id="lnb">
                            <div class="lnb-new-schedule">
                                <button id="btn-new-schedule" type="button" class="btn btn-default btn-block lnb-new-schedule-btn" data-toggle="modal">
                                    New schedule</button>
                            </div>
                            <div id="lnb-calendars" class="lnb-calendars">
                                <div>
                                    <div class="lnb-calendars-item">
                                        <label>
                                            <input class="tui-full-calendar-checkbox-square" type="checkbox" value="all" checked>
                                            <span></span>
                                            <strong>View all</strong>
                                        </label>
                                    </div>
                                </div>
                                <div id="calendarList" class="lnb-calendars-d1">
                                </div>
                            </div>

                        </div>
                        <div id="right">
                            <div id="menu">
            <span class="dropdown">
                <button id="dropdownMenu-calendarType" class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true">
                    <i id="calendarTypeIcon" class="calendar-icon ic_view_month" style="margin-right: 4px;"></i>
                    <span id="calendarTypeName">Dropdown</span>&nbsp;
                    <i class="calendar-icon tui-full-calendar-dropdown-arrow"></i>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu-calendarType">
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-daily">
                            <i class="calendar-icon ic_view_day"></i>Daily
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weekly">
                            <i class="calendar-icon ic_view_week"></i>Weekly
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-monthly">
                            <i class="calendar-icon ic_view_month"></i>Month
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks2">
                            <i class="calendar-icon ic_view_week"></i>2 weeks
                        </a>
                    </li>
                    <li role="presentation">
                        <a class="dropdown-menu-title" role="menuitem" data-action="toggle-weeks3">
                            <i class="calendar-icon ic_view_week"></i>3 weeks
                        </a>
                    </li>
                    <li role="presentation" class="dropdown-divider"></li>
                    <li role="presentation">
                        <a role="menuitem" data-action="toggle-workweek">
                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-workweek" checked>
                            <span class="checkbox-title"></span>Show weekends
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" data-action="toggle-start-day-1">
                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-start-day-1">
                            <span class="checkbox-title"></span>Start Week on Monday
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" data-action="toggle-narrow-weekend">
                            <input type="checkbox" class="tui-full-calendar-checkbox-square" value="toggle-narrow-weekend">
                            <span class="checkbox-title"></span>Narrower than weekdays
                        </a>
                    </li>
                </ul>
            </span>
                                <span id="menu-navi">
                <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">Today</button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
                    <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
                    <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
                </button>
            </span>
                                <span id="renderRange" class="render-range"></span>
                            </div>
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
