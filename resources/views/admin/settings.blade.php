@extends('layouts.admin')

@section('content')

<div class="dashboard">
    <div class="dashboard-header">
        <h1>
            <i class="fa-solid fa-gear"></i> Settings
        </h1>
        <p>Manage site settings and configuration</p>
    </div>

    <div class="settings-card">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="site_name">
                    <i class="fa-solid fa-tag"></i> Panel Name
                </label>
                <input type="text" id="site_name" name="site_name" 
                       class="form-control" 
                       value="{{ $setting->site_name ?? 'ADMIN PANEL' }}" 
                       placeholder="Enter site name...">
            </div>

            <div class="form-actions">
                <button type="submit" class="save-btn">
                    <i class="fa-solid fa-floppy-disk"></i> Save
                </button>
            </div>
        </form>
    </div>
</div>

@endsection