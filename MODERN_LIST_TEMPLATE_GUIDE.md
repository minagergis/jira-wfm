# Modern List Template Guide

This guide explains how to use the modern list template pattern for all list pages in the system.

## Files Created

1. **`/resources/views/partials/modern-list-simple.blade.php`** - Simple template using sections
2. **`/public/new-style-assets/lists/css/lists.css`** - Generic CSS for all lists
3. **`/public/new-style-assets/lists/js/lists.js`** - Generic JavaScript for all lists

## Quick Start - Using the Template

### Method 1: Using the Wrapper (Recommended)

This is the easiest method. Just extend your master layout and use the wrapper:

```blade
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
        ['label' => 'Current Page', 'url' => null]
    ],
    'headerButtons' => [
        [
            'label' => 'New Item', 
            'url' => route('your.create.route'), 
            'icon' => 'fas fa-plus', 
            'permission' => 'create-item',
            'spacing' => '' // First button doesn't need margin
        ],
        [
            'label' => 'Another Action', 
            'url' => route('another.route'), 
            'icon' => 'fas fa-tasks',
            'spacing' => 'ml-2' // Add margin for subsequent buttons
        ]
    ],
    'tableId' => 'your-datatable-id',
])
@endsection

@section('table-header')
    <th>Column 1</th>
    <th>Column 2</th>
    <th>Column 3</th>
    <th>Actions</th>
@endsection

@section('table-body')
    @foreach($items as $item)
    <tr>
        <td>{{ $item->column1 }}</td>
        <td>{{ $item->column2 }}</td>
        <td>{{ $item->column3 }}</td>
        <td>
            <div class="team-actions">
                <a href="{{ route('edit', $item->id) }}" class="team-action-btn btn-edit">
                    <i class="fa fa-edit"></i>
                    <span>Edit</span>
                </a>
            </div>
        </td>
    </tr>
    @endforeach
@endsection

@push('custom-styles')
<style>
    /* Your custom styles here - only for page-specific styling */
    .custom-class {
        color: #667eea;
    }
</style>
@endpush

@section('scripts')
<script src="{{asset('new-style-assets/lists/js/lists.js')}}"></script>
@stack('custom-scripts')
@endsection
```

## Features Included

### ✅ Automatic Features
- Modern header with gradient background
- Breadcrumb navigation
- Responsive design
- Modern search bar with icon
- Modern pagination with animations
- Length selector dropdown
- Info text with icon
- No text selection on table rows
- Smooth hover effects
- Mobile responsive
- **Unified action buttons** with animations
- **Unified table content styles** (name, description, badges)

### ✅ Unified CSS Classes (Available in lists.css)

**Action Buttons:**
- `.list-actions` - Container for action buttons
- `.list-action-btn` - Base button class with animations
- `.btn-primary-gradient` - Purple gradient (for primary actions like Edit)
- `.btn-secondary-gradient` - Gray gradient (for secondary actions)
- `.btn-danger-gradient` - Red gradient (for danger actions)
- `.btn-warning-gradient` - Yellow gradient (for warning actions)

**Table Content:**
- `.list-item-name` - For item names (bold, dark)
- `.list-item-description` - For descriptions (gray, smaller)
- `.list-item-badge` - For badges/keys (monospace, gray background)

### ✅ Customizable
- Page title
- Breadcrumbs (with icons support)
- Header buttons (with permissions)
- Table columns
- Table rows
- Custom CSS (only for page-specific needs)
- Custom JavaScript

## Examples

### Example 1: Teams List (Current Implementation)

```blade
@extends('layouts.master')
@section('title', 'Teams')

@include('partials.modern-list-simple', [
    'title' => 'Teams',
    'breadcrumbs' => [
        ['label' => 'Home', 'url' => '#', 'icon' => 'fas fa-home'],
        ['label' => 'List', 'url' => '#'],
        ['label' => 'Teams', 'url' => null]
    ],
    'headerButtons' => [
        [
            'label' => 'New Team', 
            'url' => route('get.teams.create'), 
            'icon' => 'fas fa-plus', 
            'permission' => 'create-team',
            'spacing' => ''
        ],
        [
            'label' => 'Distribute Manually', 
            'url' => route('get.distribution.distribute'), 
            'icon' => 'fas fa-tasks',
            'permission' => 'manual-distribution',
            'spacing' => 'ml-2'
        ]
    ],
    'tableId' => 'datatable-basic',
])

@section('table-header')
    <th>Team Name</th>
    <th>Description</th>
    <th>Jira Project Key</th>
    <th>Actions</th>
@endsection

@section('table-body')
    @foreach($teams as $team)
    <tr>
        <td>
            <div class="team-name">{{$team->name}}</div>
        </td>
        <td>
            <div class="team-description">{{ \Illuminate\Support\Str::limit($team->description ,50) }}</div>
        </td>
        <td>
            <span class="team-jira-key">{{$team->jira_project_key ?? 'N/A'}}</span>
        </td>
        <td>
            <div class="team-actions">
                @can('edit-team')
                <a href="{{route('get.teams.edit',$team->id)}}" class="team-action-btn btn-edit">
                    <i class="fa fa-edit"></i>
                    <span>Edit</span>
                </a>
                @endcan
                @can('list-team-member')
                <a href="{{route('get.team-member.list-by-team',$team->id)}}" class="team-action-btn btn-members">
                    <i class="fa fa-users"></i>
                    <span>Members</span>
                </a>
                @endcan
            </div>
        </td>
    </tr>
    @endforeach
@endsection

@section('custom-styles')
<style>
    .team-name {
        font-weight: 600;
        color: #1a202c;
        font-size: 1rem;
    }
    .team-description {
        color: #718096;
        font-size: 0.875rem;
    }
    .team-jira-key {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: #e2e8f0;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #4a5568;
        font-family: 'Courier New', monospace;
    }
    .team-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .team-action-btn {
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }
    .team-action-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }
    .team-action-btn:hover::before {
        width: 300px;
        height: 300px;
    }
    .team-action-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        text-decoration: none;
    }
    .btn-edit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    .btn-edit:hover {
        color: #ffffff;
        background: linear-gradient(135deg, #5568d3 0%, #6a3d91 100%);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }
    .btn-members {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #475569;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-members:hover {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #1e293b;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    @media (max-width: 768px) {
        .team-actions {
            flex-direction: column;
        }
        .team-action-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection
```

## Migration Guide

To convert an existing list page to use the modern template:

1. **Replace the header section** with the template include
2. **Move table header** to `@section('table-header')`
3. **Move table body** to `@section('table-body')`
4. **Move custom CSS** to `@section('custom-styles')`
5. **Move custom JS** to `@section('custom-scripts')`
6. **Add the template include** at the top with configuration

## Benefits

- ✅ Consistent design across all list pages
- ✅ Less code duplication
- ✅ Easy to maintain
- ✅ Automatic responsive design
- ✅ Modern UI/UX out of the box
- ✅ Easy to update globally

## Support

For questions or issues, refer to the Teams list page implementation as a reference example.

