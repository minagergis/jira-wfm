@extends('layouts.master')

@section('title')
    {!! config('shifts.name') !!} - People Swapping
@endsection

@section('styles')
@include('partials.modern-form-wrapper', ['includeStyles' => true])
@stack('custom-styles')
@endsection

@php
ob_start();
@endphp
<form role="form" method="POST" action="{{route('post.schedule.shift-changer.people-swap', $memberSchedule->id)}}">
    @csrf
    
    <div class="row">
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label" for="name">Shift Name</label>
                <input 
                    type="text" 
                    class="modern-form-control" 
                    id="name" 
                    value="{{$memberSchedule->name}}" 
                    placeholder="Name of shift"
                    disabled
                >
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="modern-form-group h-100">
                <label class="modern-form-label highlight-label" for="date_from">
                    <i class="fas fa-calendar-alt mr-2"></i>From
                </label>
                <div class="date-time-display">
                    <div class="date-time-value">
                        <i class="fas fa-clock mr-2"></i>
                        <span class="date-part">{{\Carbon\Carbon::parse($memberSchedule->date_from)->format('M d, Y')}}</span>
                        <span class="time-part">{{\Carbon\Carbon::createFromTimeString($memberSchedule->time_from)->format('g:i A')}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-form-group h-100">
                <label class="modern-form-label highlight-label" for="date_to">
                    <i class="fas fa-calendar-check mr-2"></i>To
                </label>
                <div class="date-time-display">
                    <div class="date-time-value">
                        <i class="fas fa-clock mr-2"></i>
                        <span class="date-part">{{\Carbon\Carbon::parse($memberSchedule->date_to)->format('M d, Y')}}</span>
                        <span class="time-part">{{\Carbon\Carbon::createFromTimeString($memberSchedule->time_to)->format('g:i A')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label" for="assigned_to">Currently Assigned To</label>
                <input 
                    type="text" 
                    class="modern-form-control" 
                    id="assigned_to" 
                    value="{{$memberSchedule->member->name}}" 
                    placeholder="Assigned team member"
                    disabled
                >
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="new_member_id">Swap With</label>
                <select 
                    class="modern-form-control @error('new_member_id') is-invalid @enderror" 
                    id="new_member_id" 
                    name="new_member_id" 
                    required
                >
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}" {{ old('new_member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                    @endforeach
                </select>
                @error('new_member_id')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
                <div class="modern-form-help">Select the team member to swap with</div>
            </div>
        </div>
    </div>

    <div class="modern-form-actions">
        <button type="submit" class="modern-form-btn modern-form-btn-primary">
            <i class="fas fa-exchange-alt"></i>
            <span>Swap People</span>
        </button>
        <a href="{{ url()->previous() }}" class="modern-form-btn modern-form-btn-secondary">
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
    'title' => 'People Swapping',
    'breadcrumbs' => [
        ['label' => 'Home', 'url' => route('home'), 'icon' => 'fas fa-home'],
        ['label' => 'Shift Changer', 'url' => url()->previous()],
        ['label' => 'People Swapping', 'url' => null]
    ],
    'headerButtons' => [
        [
            'label' => 'Back', 
            'url' => url()->previous(), 
            'icon' => 'fas fa-arrow-left',
            'spacing' => ''
        ]
    ],
    'formTitle' => 'People Swapping Form',
    'formIcon' => 'fas fa-exchange-alt',
    'formContent' => $formContent,
])
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/forms/js/forms.js')}}"></script>
@stack('custom-scripts')
@endsection
