{{-- 
    Simple Modern List Template - Easier to use version
    
    Usage Example:
    
    @extends('layouts.master')
    @section('title', 'Teams')
    
    @include('partials.modern-list-simple', [
        'title' => 'Teams',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => '#', 'icon' => 'fas fa-home'],
            ['label' => 'List', 'url' => '#'],
            ['label' => 'Teams', 'url' => null]
        ],
        'headerButtons' => [
            ['label' => 'New Team', 'url' => route('get.teams.create'), 'icon' => 'fas fa-plus', 'permission' => 'create-team']
        ],
        'tableId' => 'datatable-basic',
    ])
    
    @section('table-header')
        <th>Team Name</th>
        <th>Description</th>
        <th>Jira Project Key</th>
        <th>Actions</th>
    @endsection
    
    @section('table-body')
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
                    <!-- More action buttons -->
                </div>
            </td>
        </tr>
        @endforeach
    @endsection
    
    @section('custom-styles')
    <style>
        /* Your custom styles here */
        .team-name {
            font-weight: 600;
            color: #1a202c;
        }
    </style>
    @endsection
--}}

@push('styles')
<link rel="stylesheet" href="{{asset('new-style-assets/dashboard/css/dashboard.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('new-style-assets/lists/css/lists.css')}}" type="text/css">
@stack('custom-styles')
@endpush

@php
    // This will be included in the content section
@endphp
    <!-- Header Section -->
    <div class="header-modern">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 col-7">
                    <h1 class="h2 text-white mb-2">{{ $title ?? 'List' }}</h1>
                    @if(isset($breadcrumbs) && is_array($breadcrumbs))
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                            @foreach($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item {{ $loop->last ? 'active text-white' : '' }}" 
                                {{ $loop->last ? 'aria-current="page"' : '' }}>
                                @if($breadcrumb['url'] && !$loop->last)
                                    <a href="{{ $breadcrumb['url'] }}">
                                        @if(isset($breadcrumb['icon']))
                                            <i class="{{ $breadcrumb['icon'] }}"></i>
                                        @else
                                            {{ $breadcrumb['label'] }}
                                        @endif
                                    </a>
                                @else
                                    @if(isset($breadcrumb['icon']))
                                        <i class="{{ $breadcrumb['icon'] }}"></i>
                                    @else
                                        {{ $breadcrumb['label'] }}
                                    @endif
                                @endif
                            </li>
                            @endforeach
                        </ol>
                    </nav>
                    @endif
                </div>
                @if(isset($headerButtons) && is_array($headerButtons) && count($headerButtons) > 0)
                <div class="col-lg-6 col-5 text-right">
                    @foreach($headerButtons as $button)
                        @if(!isset($button['permission']) || (isset($button['permission']) && Gate::allows($button['permission'])))
                        <a href="{{ $button['url'] }}" 
                           class="btn btn-sm btn-white {{ isset($button['class']) ? $button['class'] : '' }} {{ isset($button['spacing']) ? $button['spacing'] : 'ml-2' }}"
                           @if(isset($button['id'])) id="{{ $button['id'] }}" @endif>
                            @if(isset($button['icon']))
                                <i class="{{ $button['icon'] }} mr-1"></i>
                            @endif
                            {{ $button['label'] }}
                        </a>
                        @endif
                    @endforeach
                </div>
                @endif
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
                            <table class="table modern-list-table" id="{{ $tableId ?? 'datatable-basic' }}">
                                <thead>
                                <tr>
                                    @hasSection('table-header')
                                        @yield('table-header')
                                    @else
                                        <th>Name</th>
                                        <th>Actions</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @hasSection('table-body')
                                        @yield('table-body')
                                    @else
                                        <tr>
                                            <td colspan="100%" class="text-center text-muted py-4">
                                                No data available
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{asset('new-style-assets/lists/js/lists.js')}}"></script>
@stack('custom-scripts')
@endpush

