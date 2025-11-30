# Modern Form Template Guide

This guide explains how to use the reusable form template (`modern-form-wrapper.blade.php`) for creating consistent, modern forms across the application.

## Overview

The form template provides:
- Consistent header with breadcrumbs
- Modern form card styling
- Reusable CSS and JavaScript
- Responsive design
- Built-in validation styling
- Loading states

## Basic Usage

### 1. Include Styles

In your Blade file, include the styles section:

```blade
@section('styles')
@include('partials.modern-form-wrapper', ['includeStyles' => true])
@stack('custom-styles')
@endsection
```

### 2. Include Form Content

Use the template in your content section:

```blade
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
])
@endsection
```

### 3. Define Form Fields

Use the `form-content` section for your form fields:

```blade
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
```

### 4. Define Form Actions

Use the `form-actions` section for buttons:

```blade
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
```

### 5. Include Scripts

Include the form JavaScript:

```blade
@section('scripts')
<script src="{{asset('new-style-assets/forms/js/forms.js')}}"></script>
@stack('custom-scripts')
@endsection
```

## Template Parameters

### Required Parameters

- `title` - Page title displayed in header
- `formTitle` - Form card title
- `formAction` - Form submission URL

### Optional Parameters

- `breadcrumbs` - Array of breadcrumb items
  - `label` - Breadcrumb text
  - `url` - Link URL (null for current page)
  - `icon` - FontAwesome icon class (optional)
  
- `headerButtons` - Array of header action buttons
  - `label` - Button text
  - `url` - Button link
  - `icon` - FontAwesome icon class (optional)
  - `class` - Additional CSS classes (optional)
  - `id` - Button ID (optional)
  - `permission` - Gate permission check (optional)
  - `spacing` - Spacing class (optional)
  
- `formIcon` - FontAwesome icon for form card header
- `formMethod` - HTTP method (default: 'POST')
- `formWidth` - Bootstrap column classes (default: 'col-lg-8 col-xl-6')
- `formId` - Form element ID (optional)
- `formEnctype` - Form encoding type (optional, for file uploads)

## Form CSS Classes

### Form Structure
- `.modern-form-card` - Form container card
- `.modern-form-card-header` - Form header
- `.modern-form-card-body` - Form body
- `.modern-form-group` - Form field group
- `.modern-form-actions` - Form buttons container

### Form Elements
- `.modern-form-label` - Form label
- `.modern-form-label.required` - Required field label (adds asterisk)
- `.modern-form-control` - Input, textarea, select
- `.modern-form-control.is-invalid` - Invalid input styling
- `.modern-form-btn` - Form button base
- `.modern-form-btn-primary` - Primary button (gradient)
- `.modern-form-btn-secondary` - Secondary button

### Messages
- `.modern-form-error` - Error message
- `.modern-form-success` - Success message
- `.modern-form-help` - Help text

## Example: Complete Form

```blade
@extends('layouts.master')

@section('title')
    Create Team
@endsection

@section('styles')
@include('partials.modern-form-wrapper', ['includeStyles' => true])
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
            'icon' => 'fas fa-arrow-left'
        ]
    ],
    'formTitle' => 'Add Team Form',
    'formIcon' => 'fas fa-plus-circle',
    'formAction' => route('post.teams.create'),
    'formMethod' => 'POST',
])
@endsection

@section('form-content')
    <div class="modern-form-group">
        <label class="modern-form-label required" for="name">Name</label>
        <input 
            type="text" 
            class="modern-form-control @error('name') is-invalid @enderror" 
            id="name" 
            name="name" 
            value="{{ old('name') }}"
            required
        >
        @error('name')
            <div class="modern-form-error">{{ $message }}</div>
        @enderror
    </div>
@endsection

@section('form-actions')
    <button type="submit" class="modern-form-btn modern-form-btn-primary">
        <i class="fas fa-save"></i>
        <span>Submit</span>
    </button>
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/forms/js/forms.js')}}"></script>
@endsection
```

## Features

- **Automatic Validation**: Real-time validation feedback
- **Loading States**: Submit buttons show loading spinner
- **Error Handling**: Built-in error message styling
- **Responsive**: Mobile-friendly design
- **Accessible**: Proper labels and ARIA attributes
- **Consistent**: Matches dashboard and list page styling

## Notes

- The template automatically includes CSRF token
- PUT/PATCH/DELETE methods are automatically converted to POST with method spoofing
- Form JavaScript handles auto-resize for textareas
- All forms are responsive by default

