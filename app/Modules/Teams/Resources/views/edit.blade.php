@extends('layouts.master')

@section('title')
    {!! config('teams.name') !!} - Edit {{$team->name}}
@endsection

@section('styles')
@include('partials.modern-form-wrapper', ['includeStyles' => true])
@stack('custom-styles')
@endsection

@php
ob_start();
@endphp
<form role="form" method="POST" action="{{ route('post.teams.edit', $team->id) }}">
    @csrf
    
    <div class="modern-form-group">
        <label class="modern-form-label required" for="name">Team Name</label>
        <input 
            type="text" 
            class="modern-form-control @error('name') is-invalid @enderror" 
            id="name" 
            name="name" 
            placeholder="Enter team name"
            value="{{ old('name', $team->name) }}"
            required
        >
        @error('name')
            <div class="modern-form-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="modern-form-group">
        <label class="modern-form-label required" for="description">Description</label>
        <textarea 
            class="modern-form-control @error('description') is-invalid @enderror" 
            id="description" 
            name="description" 
            placeholder="Enter team description"
            rows="4"
            required
        >{{ old('description', $team->description) }}</textarea>
        @error('description')
            <div class="modern-form-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="modern-form-group">
        <label class="modern-form-label required" for="jira_project_key">Jira Project Key</label>
        <input 
            type="text" 
            class="modern-form-control @error('jira_project_key') is-invalid @enderror" 
            id="jira_project_key" 
            name="jira_project_key" 
            placeholder="Enter JIRA board key"
            value="{{ old('jira_project_key', $team->jira_project_key) }}"
            required
        >
        @error('jira_project_key')
            <div class="modern-form-error">{{ $message }}</div>
        @enderror
        <div class="modern-form-help">The project key used in JIRA (e.g., PROJ, TEAM)</div>
    </div>

    <div class="modern-form-actions">
        <button type="submit" class="modern-form-btn modern-form-btn-primary">
            <i class="fas fa-save"></i>
            <span>Update Team</span>
        </button>
        <a href="{{route('get.teams.list')}}" class="modern-form-btn modern-form-btn-secondary">
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
    'title' => 'Edit Team',
    'breadcrumbs' => [
        ['label' => 'Home', 'url' => route('home'), 'icon' => 'fas fa-home'],
        ['label' => 'Teams', 'url' => route('get.teams.list')],
        ['label' => 'Edit ' . $team->name, 'url' => null]
    ],
    'headerButtons' => [
        [
            'label' => 'Back to List', 
            'url' => route('get.teams.list'), 
            'icon' => 'fas fa-arrow-left',
            'spacing' => ''
        ]
    ],
    'formTitle' => 'Edit ' . $team->name . ' Team',
    'formIcon' => 'fas fa-edit',
    'formContent' => $formContent,
])
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/forms/js/forms.js')}}"></script>
@stack('custom-scripts')
@endsection
