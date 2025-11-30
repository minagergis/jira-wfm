@extends('layouts.master')

@section('title')
    {!! config('shifts.name') !!} - Create
@endsection

@section('styles')
@include('partials.modern-form-wrapper', ['includeStyles' => true])
@stack('custom-styles')
@endsection

@php
ob_start();
@endphp
<form role="form" method="POST" action="{{ route('post.shifts.create') }}">
    @csrf
    
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="name">Name</label>
                <input 
                    type="text" 
                    class="modern-form-control @error('name') is-invalid @enderror" 
                    id="name" 
                    name="name" 
                    placeholder="Name of shift"
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="description">Description</label>
                <input 
                    type="text" 
                    class="modern-form-control @error('description') is-invalid @enderror" 
                    id="description" 
                    name="description" 
                    placeholder="Description of shift"
                    value="{{ old('description') }}"
                    required
                >
                @error('description')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        @if(auth()->user()->hasRole('team-leader'))
            <input type="hidden" name="teams[]" value="{{auth()->user()->managed_team_id}}">
        @else
            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label required">Teams</label>
                    <div class="modern-checkbox-group">
                        @foreach($teams as $team)
                            <div class="modern-checkbox-item">
                                <label for="team_{{ $team->id }}">{{ $team->name }}</label>
                                <label class="custom-toggle">
                                    <input 
                                        name="teams[]" 
                                        value="{{ $team->id }}" 
                                        type="checkbox" 
                                        id="team_{{ $team->id }}"
                                        {{ old('teams') && in_array($team->id, old('teams')) ? 'checked' : '' }}
                                    >
                                    <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('teams')
                        <div class="modern-form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        @endif

        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required">Working Days</label>
                <div class="modern-checkbox-group">
                    @foreach($days as $key => $day)
                        <div class="modern-checkbox-item">
                            <label for="day_{{ $key }}">{{ $day }}</label>
                            <label class="custom-toggle custom-toggle-danger">
                                <input 
                                    name="days[]" 
                                    value="{{ $key }}" 
                                    type="checkbox" 
                                    id="day_{{ $key }}"
                                    {{ old('days') && in_array($key, old('days')) ? 'checked' : '' }}
                                >
                                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('days')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="time_from">Shift Starts At</label>
                <input 
                    type="time" 
                    class="modern-form-control @error('time_from') is-invalid @enderror" 
                    id="time_from" 
                    name="time_from" 
                    value="{{ old('time_from', '08:30') }}"
                    required
                >
                @error('time_from')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="time_to">Shift Ends At</label>
                <input 
                    type="time" 
                    class="modern-form-control @error('time_to') is-invalid @enderror" 
                    id="time_to" 
                    name="time_to" 
                    value="{{ old('time_to', '16:30') }}"
                    required
                >
                @error('time_to')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="modern-form-actions">
        <button type="submit" class="modern-form-btn modern-form-btn-primary">
            <i class="fas fa-save"></i>
            <span>Create Shift</span>
        </button>
        <a href="{{route('get.shifts.list')}}" class="modern-form-btn modern-form-btn-secondary">
            <i class="fas fa-times"></i>
            <span>Cancel</span>
        </a>
    </div>
</form>
@php
$formContent = ob_get_clean();
@endphp

@section('content')
@include('partials.modern-form-wrapper', [
    'title' => 'Create Shift',
    'breadcrumbs' => [
        ['label' => 'Home', 'url' => '#', 'icon' => 'fas fa-home'],
        ['label' => 'Shifts', 'url' => route('get.shifts.list')],
        ['label' => 'Create Shift', 'url' => null]
    ],
    'headerButtons' => [
        [
            'label' => 'Back to List', 
            'url' => route('get.shifts.list'), 
            'icon' => 'fas fa-arrow-left',
            'spacing' => ''
        ]
    ],
    'formTitle' => 'Add Shift Form',
    'formIcon' => 'fas fa-plus-circle',
    'formContent' => $formContent,
])
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/forms/js/forms.js')}}"></script>
@stack('custom-scripts')
@endsection
