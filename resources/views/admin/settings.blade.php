@extends('layouts.admin')

@section('content')

<h1 class="page-title">
    <i class="fa-solid fa-gears"></i>
    Settings
</h1>

<div class="settings-card">

    <form action="{{ route('admin.settings.update') }}"
          method="POST">

        @csrf

        <div class="form-group">
            <label>Panel Name</label>

            <input type="text"
                   name="site_name"
                   value="{{ $setting->site_name }}">
        </div>

        <button type="submit" class="save-btn">
            Save
        </button>

    </form>

</div>
@endsection