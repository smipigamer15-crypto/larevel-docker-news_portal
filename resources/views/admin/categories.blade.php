@extends('layouts.admin')

@section('content')

<div class="dashboard">
    <div class="dashboard-header">
        <h1>
            <i class="fa-solid fa-tags"></i> Categories
        </h1>
        <p>Manage all categories on the site</p>
    </div>

    <div class="dashboard-card">
        <div class="categories-header">
            <h3>
                <i class="fa-solid fa-list"></i> All Categories
                <span class="categories-count">{{ $categories->count() }}</span>
            </h3>
        </div>

        <div class="categories-grid">
            @forelse($categories as $category)
                <div class="category-card">
                    <div class="category-left">
                        @php
                            $icons = [
                                'Politics' => 'fa-solid fa-landmark',
                                'World' => 'fa-solid fa-globe',
                                'Sports' => 'fa-solid fa-futbol',
                                'Culture' => 'fa-solid fa-mask',
                                'Technology' => 'fa-solid fa-microchip',
                                'Economy' => 'fa-solid fa-chart-line',
                            ];
                            $icon = $icons[$category->category] ?? 'fa-regular fa-folder';
                        @endphp
                        <i class="{{ $icon }}"></i>
                        <span class="category-name">{{ $category->category }}</span>
                    </div>
                    <span class="category-count">{{ $category->count }} {{ trans_choice('post|posts|posts', $category->count) }}</span>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fa-regular fa-folder-open"></i>
                    <p>No categories yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection