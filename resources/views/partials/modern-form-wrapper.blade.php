{{-- 
    Modern Form Wrapper - Reusable template for all form pages
    
    Usage:
    
    @extends('layouts.master')
    @section('title', 'Create Team')
    
    @section('styles')
    @include('partials.modern-form-wrapper', ['includeStyles' => true])
    @stack('custom-styles')
    @endsection
    
    @section('content')
    @include('partials.modern-form-wrapper', [
        'title' => 'Create Team',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => route('home'), 'icon' => 'fas fa-home'],
            ['label' => 'Teams', 'url' => route('get.teams.list')],
            ['label' => 'Create', 'url' => null]
        ],
        'headerButtons' => [
            [
                'label' => 'Back to List', 
                'url' => route('get.teams.list'), 
                'icon' => 'fas fa-arrow-left',
                'spacing' => ''
            ]
        ],
        'formTitle' => 'Add Team Form',
        'formIcon' => 'fas fa-plus-circle',
        'formAction' => route('post.teams.create'),
        'formMethod' => 'POST',
        'formWidth' => 'col-lg-8 col-xl-6', // Optional, defaults to col-lg-8 col-xl-6
    ])
    @endsection
    
    @section('form-content')
        <div class="modern-form-group">
            <label class="modern-form-label required" for="name">Team Name</label>
            <input 
                type="text" 
                class="modern-form-control @error('name') is-invalid @enderror" 
                id="name" 
                name="name" 
                placeholder="Enter team name"
                value="{{ old('name') }}"
                required
            >
            @error('name')
                <div class="modern-form-error">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- More form fields -->
    @endsection
    
    @section('form-actions')
        <button type="submit" class="modern-form-btn modern-form-btn-primary">
            <i class="fas fa-save"></i>
            <span>Create Team</span>
        </button>
        <a href="{{route('get.teams.list')}}" class="modern-form-btn modern-form-btn-secondary">
            <i class="fas fa-times"></i>
            <span>Cancel</span>
        </a>
    @endsection
    
    @section('scripts')
    <script src="{{asset('new-style-assets/forms/js/forms.js')}}"></script>
    @stack('custom-scripts')
    @endsection
--}}

@if(isset($includeStyles) && $includeStyles)
    <link rel="stylesheet" href="{{asset('new-style-assets/dashboard/css/dashboard.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('new-style-assets/forms/css/forms.css')}}" type="text/css">
@else
    <!-- Header Section -->
    <div class="header-modern">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 col-7">
                    <h1 class="h2 text-white mb-2">{{ $title ?? 'Form' }}</h1>
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
            <div class="{{ $formWidth ?? 'col-lg-8 col-xl-6' }} mx-auto">
                <div class="modern-form-card card">
                    <div class="modern-form-card-header">
                        <h3>
                            @if(isset($formIcon))
                                <i class="{{ $formIcon }} mr-2" style="color: #667eea;"></i>
                            @endif
                            {{ $formTitle ?? 'Form' }}
                        </h3>
                    </div>
                    <div class="modern-form-card-body">
                        @if(isset($formContent))
                            {!! $formContent !!}
                        @else
                            <p class="text-muted">No form content provided. Please pass formContent variable.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

