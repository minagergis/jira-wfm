@extends('layouts.master')

@section('title')
    {!! config('teammembers.name') !!} - Edit {{$teamMember->name}}
@endsection

@section('styles')
@include('partials.modern-form-wrapper', ['includeStyles' => true])
@stack('custom-styles')
@endsection

@php
ob_start();
@endphp
<form role="form" method="POST" action="{{ route('post.team-member.edit', $teamMember->id) }}">
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
                    placeholder="Name of team member"
                    value="{{ old('name', $teamMember->name) }}"
                    required
                >
                @error('name')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="jira_integration_id">Jira Integration Id</label>
                <input 
                    type="text" 
                    class="modern-form-control @error('jira_integration_id') is-invalid @enderror" 
                    id="jira_integration_id" 
                    name="jira_integration_id" 
                    placeholder="Jira Integration Id of team member"
                    value="{{ old('jira_integration_id', $teamMember->jira_integration_id) }}"
                    required
                >
                @error('jira_integration_id')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="is_active">Active</label>
                <select 
                    class="modern-form-control @error('is_active') is-invalid @enderror" 
                    id="is_active" 
                    name="is_active" 
                    required
                >
                    <option value="1" {{ old('is_active', $teamMember->is_active) == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('is_active', $teamMember->is_active) == 0 ? 'selected' : '' }}>No</option>
                </select>
                @error('is_active')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="weight">Weight</label>
                <div class="range-slider-wrapper">
                    <input 
                        type="range" 
                        class="modern-form-control @error('weight') is-invalid @enderror" 
                        id="weight" 
                        name="weight" 
                        min="0" 
                        max="1000" 
                        value="{{ old('weight', $teamMember->weight) }}"
                        required
                    >
                    <span class="range-value-display" id="weight-display">{{ old('weight', $teamMember->weight) }}</span>
                </div>
                @error('weight')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="color">Color</label>
                <input 
                    type="text" 
                    class="modern-form-control @error('color') is-invalid @enderror" 
                    id="demo-input" 
                    name="color" 
                    placeholder="Select color"
                    value="{{ old('color', $teamMember->color ?? '#FFFFFF') }}"
                    style="background-color: {{ old('color', $teamMember->color ?? '#FFFFFF') }}"
                    required
                >
                @error('color')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="modern-form-group">
                <label class="modern-form-label required" for="team">Team</label>
                <select 
                    class="modern-form-control @error('team') is-invalid @enderror" 
                    id="team" 
                    name="team" 
                    required
                >
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" {{ old('team', $teamMember->teams[0]->id ?? '') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
                @error('team')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="modern-form-group">
                <label class="modern-form-label" for="email">Email</label>
                <input 
                    type="email" 
                    class="modern-form-control @error('email') is-invalid @enderror" 
                    id="email" 
                    name="email" 
                    placeholder="Email of team member"
                    value="{{ old('email', $teamMember->email) }}"
                >
                @error('email')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="modern-form-actions">
        <button type="submit" class="modern-form-btn modern-form-btn-primary">
            <i class="fas fa-save"></i>
            <span>Update Team Member</span>
        </button>
        <a href="{{route('get.team-member.list')}}" class="modern-form-btn modern-form-btn-secondary">
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
    'title' => 'Edit Team Member',
    'breadcrumbs' => [
        ['label' => 'Home', 'url' => route('home'), 'icon' => 'fas fa-home'],
        ['label' => 'Team Members', 'url' => route('get.team-member.list')],
        ['label' => 'Edit ' . $teamMember->name, 'url' => null]
    ],
    'headerButtons' => [
        [
            'label' => 'Back to List', 
            'url' => route('get.team-member.list'), 
            'icon' => 'fas fa-arrow-left',
            'spacing' => ''
        ]
    ],
    'formTitle' => 'Edit ' . $teamMember->name . '\'s data',
    'formIcon' => 'fas fa-edit',
    'formContent' => $formContent,
])
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/forms/js/forms.js')}}"></script>
<script>
    $(function () {
        // Color picker
        $('#demo-input').colorpicker();
        $('#demo-input').on('colorpickerChange', function(event) {
            $('#demo-input').css('background-color', event.color.toString());
        });

        // Range slider for weight
        const weightSlider = document.getElementById('weight');
        const weightDisplay = document.getElementById('weight-display');

        function updateWeight(value) {
            weightDisplay.textContent = value;
        }

        weightSlider.addEventListener('input', function() {
            updateWeight(this.value);
        });

        // Initialize
        updateWeight(weightSlider.value);
    });
</script>
@stack('custom-scripts')
@endsection
