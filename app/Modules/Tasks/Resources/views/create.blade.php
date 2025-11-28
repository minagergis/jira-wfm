@extends('layouts.master')

@section('title')
    {!! config('tasks.name') !!} - Create
@endsection

@section('styles')
@include('partials.modern-form-wrapper', ['includeStyles' => true])
@stack('custom-styles')
@endsection

@php
ob_start();
@endphp
<form role="form" method="POST" action="{{ route('post.tasks.create') }}">
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
                    placeholder="Name of task"
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
                    placeholder="Description of task"
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
                <label class="modern-form-label required" for="points">Points</label>
                <div class="range-slider-wrapper range-slider-centered">
                    <input 
                        type="range" 
                        class="modern-form-control @error('points') is-invalid @enderror" 
                        id="points" 
                        name="points" 
                        min="0" 
                        max="1000" 
                        value="{{ old('points', 0) }}"
                        required
                    >
                    <span class="range-value-display" id="points-display">{{ old('points', 0) }}</span>
                </div>
                @error('points')
                    <div class="modern-form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="modern-form-actions">
        <button type="submit" class="modern-form-btn modern-form-btn-primary">
            <i class="fas fa-save"></i>
            <span>Create Task</span>
        </button>
        <a href="{{route('get.tasks.list')}}" class="modern-form-btn modern-form-btn-secondary">
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
    'title' => 'Create Task',
    'breadcrumbs' => [
        ['label' => 'Home', 'url' => '#', 'icon' => 'fas fa-home'],
        ['label' => 'Tasks', 'url' => route('get.tasks.list')],
        ['label' => 'Create Task', 'url' => null]
    ],
    'headerButtons' => [
        [
            'label' => 'Back to List', 
            'url' => route('get.tasks.list'), 
            'icon' => 'fas fa-arrow-left',
            'spacing' => ''
        ]
    ],
    'formTitle' => 'Add Task Form',
    'formIcon' => 'fas fa-plus-circle',
    'formContent' => $formContent,
])
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/forms/js/forms.js')}}"></script>
<script>
    $(function () {
        // Range slider for points
        const pointsSlider = document.getElementById('points');
        const pointsDisplay = document.getElementById('points-display');

        function updatePoints(value) {
            pointsDisplay.textContent = value;
        }

        pointsSlider.addEventListener('input', function() {
            updatePoints(this.value);
        });

        // Initialize
        updatePoints(pointsSlider.value);
    });
</script>
@stack('custom-scripts')
@endsection
