{{-- 
    Modern List Wrapper - Use this in your list pages
    
    This template provides the structure, you define the table content in sections.
    
    Usage:
    
    @extends('layouts.master')
    @section('title', 'Your Page Title')
    
    @section('styles')
    @include('partials.modern-list-wrapper', ['includeStyles' => true])
    @stack('custom-styles')
    @endsection
    
    @section('content')
    @include('partials.modern-list-wrapper', [
        'title' => 'Your Page Title',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => '#', 'icon' => 'fas fa-home'],
            ['label' => 'List', 'url' => '#'],
            ['label' => 'Current', 'url' => null]
        ],
        'headerButtons' => [
            [
                'label' => 'New Item', 
                'url' => route('create'), 
                'icon' => 'fas fa-plus', 
                'permission' => 'create-item',
                'spacing' => ''
            ]
        ],
        'tableId' => 'datatable-basic',
    ])
    @endsection
    
    @section('table-header')
        <th>Column 1</th>
        <th>Column 2</th>
        <th>Actions</th>
    @endsection
    
    @section('table-body')
        @foreach($items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->description }}</td>
            <td>
                <a href="{{ route('edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
            </td>
        </tr>
        @endforeach
    @endsection
    
    @section('scripts')
    <script src="{{asset('new-style-assets/lists/js/lists.js')}}"></script>
    @stack('custom-scripts')
    @endsection
--}}

@if(isset($includeStyles) && $includeStyles)
    <link rel="stylesheet" href="{{asset('new-style-assets/dashboard/css/dashboard.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('new-style-assets/lists/css/lists.css')}}" type="text/css">
@else
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
                                @if(isset($breadcrumb['url']) && $breadcrumb['url'] && !$loop->last)
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
                           class="btn btn-sm btn-white {{ isset($button['class']) ? $button['class'] : '' }} {{ isset($button['spacing']) && $button['spacing'] ? $button['spacing'] : ($loop->first ? '' : 'ml-2') }}"
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
                                    @if(isset($tableHeader))
                                        {!! $tableHeader !!}
                                    @elseif(View::hasSection('table-header'))
                                        @yield('table-header')
                                    @else
                                        <th>Name</th>
                                        <th>Actions</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @if(isset($tableBody))
                                        {!! $tableBody !!}
                                    @elseif(View::hasSection('table-body'))
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
@endif

