{{-- 
    Modern List Template - Reusable template for all list pages
    
    Usage:
    @include('partials.modern-list', [
        'title' => 'Page Title',
        'breadcrumbs' => [
            ['label' => 'Home', 'url' => '#'],
            ['label' => 'List', 'url' => '#'],
            ['label' => 'Current', 'url' => null]
        ],
        'headerButtons' => [
            ['label' => 'New Item', 'url' => route('create'), 'icon' => 'fa-plus', 'permission' => 'create-item']
        ],
        'tableId' => 'datatable-basic',
        'tableColumns' => [
            ['title' => 'Column 1', 'data' => 'column1'],
            ['title' => 'Column 2', 'data' => 'column2'],
        ],
        'tableData' => $items, // Collection or array
        'customStyles' => '', // Optional: Additional CSS
        'customScripts' => '', // Optional: Additional JS
    ])
--}}

@section('styles')
<link rel="stylesheet" href="{{asset('new-style-assets/dashboard/css/dashboard.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('new-style-assets/lists/css/lists.css')}}" type="text/css">
@if(isset($customStyles) && !empty($customStyles))
<style>
    {!! $customStyles !!}
</style>
@endif
@endsection

@section('content')
    <!-- Header Section -->
    <div class="header-modern">
        <div class="container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-lg-6 col-7">
                    <h1 class="h2 text-white mb-2">{{ $title ?? 'List' }}</h1>
                    @if(isset($breadcrumbs) && is_array($breadcrumbs))
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark mb-0">
                            @foreach($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item {{ $loop->last ? 'active text-white' : '' }}" 
                                {{ $loop->last ? 'aria-current="page"' : '' }}>
                                @if($breadcrumb['url'] && !$loop->last)
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
                           class="btn btn-sm btn-white {{ isset($button['class']) ? $button['class'] : '' }}"
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
            <div class="col">
                <div class="chart-card card">
                    <div class="chart-body">
                        <div class="table-responsive">
                            <table class="table modern-list-table" id="{{ $tableId ?? 'datatable-basic' }}">
                                <thead>
                                <tr>
                                    @if(isset($tableColumns) && is_array($tableColumns))
                                        @foreach($tableColumns as $column)
                                        <th>{{ $column['title'] ?? $column }}</th>
                                        @endforeach
                                    @else
                                        {{ $tableHeader ?? '' }}
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @if(isset($tableBody))
                                        {!! $tableBody !!}
                                    @elseif(isset($tableData) && (is_array($tableData) || is_object($tableData)))
                                        @foreach($tableData as $item)
                                            {{ $tableRow ?? '' }}
                                        @endforeach
                                    @else
                                        {{ $slot ?? '' }}
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{asset('new-style-assets/lists/js/lists.js')}}"></script>
@if(isset($customScripts) && !empty($customScripts))
<script>
    {!! $customScripts !!}
</script>
@endif
@endsection

