@extends('layouts.master')

@section('title')
    {!! config('shifts.name') !!} - Bulk Schedule
@endsection

@section('styles')
@include('partials.modern-form-wrapper', ['includeStyles' => true])
@stack('custom-styles')
@endsection

@php
ob_start();
@endphp
<form role="form" method="POST" action="{{ route('post.shifts.bulk.schedule', $teamId) }}">
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
        <div class="col-md-12">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="shift">Shift</label>
                <select 
                    class="modern-form-control @error('shift') is-invalid @enderror" 
                    id="shift" 
                    name="shift" 
                    required
                >
                    @foreach ($shifts as $shift)
                        <option value="{{ $shift->id }}" {{ old('shift') == $shift->id ? 'selected' : '' }}>{{ $shift->name }}</option>
                    @endforeach
                </select>
                @error('shift')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="recurring_from">Recurring From</label>
                <input 
                    type="date" 
                    class="modern-form-control @error('recurring_from') is-invalid @enderror" 
                    id="recurring_from" 
                    name="recurring_from" 
                    value="{{ old('recurring_from', date('Y-m-d')) }}"
                    required
                >
                @error('recurring_from')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="recurring_to">Recurring To</label>
                <input 
                    type="date" 
                    class="modern-form-control @error('recurring_to') is-invalid @enderror" 
                    id="recurring_to" 
                    name="recurring_to" 
                    value="{{ old('recurring_to', date('Y-m-d', strtotime('+1 month'))) }}"
                    required
                >
                @error('recurring_to')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="modern-form-group">
                <label class="modern-form-label required">Team Members</label>
                <div class="modern-checkbox-group">
                    @foreach($teamMembers as $teamMember)
                        <div class="modern-checkbox-item">
                            <label for="team_member_{{ $teamMember->id }}">{{ $teamMember->name }}</label>
                            <label class="custom-toggle">
                                <input 
                                    name="team_members[]" 
                                    value="{{ $teamMember->id }}" 
                                    type="checkbox" 
                                    id="team_member_{{ $teamMember->id }}"
                                    {{ old('team_members') && in_array($teamMember->id, old('team_members')) ? 'checked' : '' }}
                                >
                                <span class="custom-toggle-slider rounded-circle" data-label-off="No" data-label-on="Yes"></span>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('team_members')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="modern-form-actions">
        <button type="submit" class="modern-form-btn modern-form-btn-primary">
            <i class="fas fa-save"></i>
            <span>Schedule Shifts</span>
        </button>
        <a href="{{route('get.shifts.bulk.schedule.teams')}}" class="modern-form-btn modern-form-btn-secondary">
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
    'title' => 'Bulk Shift Assignation',
    'breadcrumbs' => [
        ['label' => 'Home', 'url' => '#', 'icon' => 'fas fa-home'],
        ['label' => 'Bulk Schedule', 'url' => route('get.shifts.bulk.schedule.teams')],
        ['label' => 'Schedule Team', 'url' => null]
    ],
    'headerButtons' => [
        [
            'label' => 'Back to List', 
            'url' => route('get.shifts.bulk.schedule.teams'), 
            'icon' => 'fas fa-arrow-left',
            'spacing' => ''
        ]
    ],
    'formTitle' => 'Bulk Shift Assignation',
    'formIcon' => 'fas fa-calendar-check',
    'formContent' => $formContent,
])
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/forms/js/forms.js')}}"></script>
@stack('custom-scripts')
@endsection
