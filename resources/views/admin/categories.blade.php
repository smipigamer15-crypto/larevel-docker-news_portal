@extends('layouts.admin')

@section('content')

<h1 class="page-title">
    <i class="fa-solid fa-tags"></i> Categories
</h1>

<div class="table-card">

    @foreach($categories as $category)

        <div class="category-card">

            <div class="category-info">
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

        </div>

    @endforeach

</div>

@endsection