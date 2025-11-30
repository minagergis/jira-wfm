@extends('layouts.master')

@section('title')
    {!! config('contacttypes.name') !!} - Create
@endsection

@section('styles')
@include('partials.modern-form-wrapper', ['includeStyles' => true])
@stack('custom-styles')
@endsection

@php
ob_start();
@endphp
<form role="form" method="POST" action="{{ route('post.contact-type.create') }}">
    @csrf
    
    <div class="row">
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="name">Name</label>
                <input 
                    type="text" 
                    class="modern-form-control @error('name') is-invalid @enderror" 
                    id="name" 
                    name="name" 
                    placeholder="Name of the contact type [Same as in Jira (Case sensitive)]"
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
                <div class="modern-form-help">Must match exactly as it appears in JIRA (case sensitive)</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="team_id">Team</label>
                <select 
                    class="modern-form-control @error('team_id') is-invalid @enderror" 
                    id="team_id" 
                    name="team_id" 
                    required
                >
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
                @error('team_id')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="description">Description</label>
                <textarea 
                    class="modern-form-control @error('description') is-invalid @enderror" 
                    id="description" 
                    name="description" 
                    placeholder="Description"
                    rows="4"
                    required
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="sla">Points</label>
                <div class="range-slider-wrapper range-slider-centered">
                    <input 
                        type="range" 
                        class="modern-form-control @error('sla') is-invalid @enderror" 
                        id="sla" 
                        name="sla" 
                        min="1" 
                        max="1000" 
                        value="{{ old('sla', 1) }}"
                        required
                    >
                    <span class="range-value-display" id="sla-display">{{ old('sla', 1) }}</span>
                </div>
                @error('sla')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="modern-form-actions">
        <button type="submit" class="modern-form-btn modern-form-btn-primary">
            <i class="fas fa-save"></i>
            <span>Create Contact Type</span>
        </button>
        <a href="{{route('get.contact-type.list')}}" class="modern-form-btn modern-form-btn-secondary">
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
    'title' => 'Create Contact Type',
    'breadcrumbs' => [
        ['label' => 'Home', 'url' => route('home'), 'icon' => 'fas fa-home'],
        ['label' => 'Contact Types', 'url' => route('get.contact-type.list')],
        ['label' => 'Create Contact Type', 'url' => null]
    ],
    'headerButtons' => [
        [
            'label' => 'Back to List', 
            'url' => route('get.contact-type.list'), 
            'icon' => 'fas fa-arrow-left',
            'spacing' => ''
        ]
    ],
    'formTitle' => 'Add Contact Type Form',
    'formIcon' => 'fas fa-plus-circle',
    'formContent' => $formContent,
])
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/forms/js/forms.js')}}"></script>
<script>
    $(function () {
        // Range slider for SLA/Points
        const slaSlider = document.getElementById('sla');
        const slaDisplay = document.getElementById('sla-display');

        function updateSLA(value) {
            slaDisplay.textContent = value;
        }

        slaSlider.addEventListener('input', function() {
            updateSLA(this.value);
        });

        // Initialize
        updateSLA(slaSlider.value);
    });
</script>
@stack('custom-scripts')
@endsection
