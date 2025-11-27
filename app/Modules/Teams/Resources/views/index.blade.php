@extends('layouts.master')
@section('title')
    {!! config('teams.name') !!}
@endsection

@section('styles')
<style>
    .teams-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 0 0 24px 24px;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    .teams-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    .teams-card-header {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border-bottom: 1px solid #e2e8f0;
        padding: 1.5rem;
    }
    .teams-table {
        margin: 0;
    }
    .teams-table thead th {
        background: #f8f9fa;
        border: none;
        color: #4a5568;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem 1.5rem;
    }
    .teams-table tbody td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }
    .teams-table tbody tr {
        transition: all 0.2s ease;
    }
    .teams-table tbody tr:hover {
        background: #f8f9fa;
        transform: translateX(2px);
    }
    .teams-table tbody tr:last-child td {
        border-bottom: none;
    }
    .team-name {
        font-weight: 600;
        color: #1a202c;
        font-size: 1rem;
    }
    .team-description {
        color: #718096;
        font-size: 0.875rem;
    }
    .team-jira-key {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: #e2e8f0;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #4a5568;
        font-family: 'Courier New', monospace;
    }
    .team-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .team-action-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        border: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    .team-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }
    .team-action-btn i {
        font-size: 0.875rem;
    }
    .btn-edit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
    }
    .btn-edit:hover {
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    .btn-members {
        background: #f1f5f9;
        color: #4a5568;
    }
    .btn-members:hover {
        background: #e2e8f0;
        color: #1a202c;
    }
    .btn-shift {
        background: #fee2e2;
        color: #dc2626;
    }
    .btn-shift:hover {
        background: #fecaca;
        color: #b91c1c;
    }
    .btn-schedule {
        background: #fef3c7;
        color: #d97706;
    }
    .btn-schedule:hover {
        background: #fde68a;
        color: #b45309;
    }
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0;
    }
    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .btn-modern {
        padding: 0.625rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .btn-primary-modern {
        background: #ffffff;
        color: #667eea;
    }
    .btn-primary-modern:hover {
        background: #f8f9fa;
        color: #5568d3;
    }
    @media (max-width: 768px) {
        .teams-header {
            padding: 1.5rem 0;
        }
        .page-title {
            font-size: 1.5rem;
        }
        .team-actions {
            flex-direction: column;
        }
        .team-action-btn {
            width: 100%;
            justify-content: center;
        }
        .action-buttons {
            flex-direction: column;
            width: 100%;
        }
        .action-buttons .btn-modern {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
    <div class="main-content" id="panel">
        <!-- Header -->
        <div class="teams-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-7">
                        <h1 class="page-title">Teams</h1>
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block mt-2">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">List</a></li>
                                <li class="breadcrumb-item active text-white" aria-current="page">Teams</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <div class="action-buttons">
                            @can('create-team')
                            <a href="{{route('get.teams.create')}}" class="btn btn-modern btn-primary-modern">
                                <i class="fas fa-plus mr-2"></i>New Team
                            </a>
                            @endcan
                            @can('manual-distribution')
                            <a href="{{route('get.distribution.distribute')}}" class="btn btn-modern btn-primary-modern">
                                <i class="fas fa-tasks mr-2"></i>Distribute Manually
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card teams-card">
                        <div class="teams-card-header">
                            <h3 class="mb-0" style="color: #1a202c; font-weight: 700;">All Teams</h3>
                            <p class="text-muted mb-0 mt-1" style="font-size: 0.875rem;">Manage and organize your teams</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table teams-table" id="datatable-basic">
                                <thead>
                                <tr>
                                    <th>Team Name</th>
                                    <th>Description</th>
                                    <th>Jira Project Key</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($teams as $team)
                                <tr>
                                    <td>
                                        <div class="team-name">{{$team->name}}</div>
                                    </td>
                                    <td>
                                        <div class="team-description">{{ \Illuminate\Support\Str::limit($team->description ,50) }}</div>
                                    </td>
                                    <td>
                                        <span class="team-jira-key">{{$team->jira_project_key ?? 'N/A'}}</span>
                                    </td>
                                    <td>
                                        <div class="team-actions">
                                            @can('edit-team')
                                            <a href="{{route('get.teams.edit',$team->id)}}" class="team-action-btn btn-edit">
                                                <i class="fa fa-edit"></i>
                                                <span>Edit</span>
                                            </a>
                                            @endcan
                                            @can('list-team-member')
                                            <a href="{{route('get.team-member.list-by-team',$team->id)}}" class="team-action-btn btn-members">
                                                <i class="fa fa-users"></i>
                                                <span>Members</span>
                                            </a>
                                            @endcan
                                            @can('manual-distribution')
                                            <a href="{{route('get.schedule.shift-changer',$team->id)}}" class="team-action-btn btn-shift">
                                                <i class="fa fa-calendar-alt"></i>
                                                <span>Shift Changer</span>
                                            </a>
                                            @endcan
                                            @can('view-team-schedule')
                                            <a href="{{route('get.schedule.list-by-team',$team->id)}}" class="team-action-btn btn-schedule">
                                                <i class="fa fa-clock"></i>
                                                <span>Schedules</span>
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
