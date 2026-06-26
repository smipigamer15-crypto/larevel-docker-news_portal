@extends('layouts.admin')

@section('content')

<div class="dashboard">
    <div class="dashboard-header">
        <h1>
            <i class="fa-solid fa-pen-clip"></i> Create News
        </h1>
        <p>Add a new article to the site</p>
    </div>

    <div class="admin-card">
        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">
                    <i class="fa-solid fa-heading"></i> Title
                </label>
                <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                       placeholder="Enter news title..." value="{{ old('title') }}" required>
                @error('title')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">
                    <i class="fa-solid fa-align-left"></i> Content
                </label>
                <textarea id="content" name="content" rows="10" class="form-control @error('content') is-invalid @enderror" 
                          placeholder="Write the full news content here..." required>{{ old('content') }}</textarea>
                @error('content')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">
                    <i class="fa-solid fa-image"></i> Image
                </label>
                <input type="file" id="image" name="image" class="form-control-file @error('image') is-invalid @enderror" 
                       accept="image/*">
                <small class="form-text">Supported formats: JPG, PNG, WEBP. Max size: 2MB</small>
                @error('image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">
                    <i class="fa-solid fa-tag"></i> Category
                </label>
                <select id="category" name="category" class="form-control @error('category') is-invalid @enderror" required>
                    <option value="">Select a category</option>
                    <option value="Politics" {{ old('category') == 'Politics' ? 'selected' : '' }}>Politics</option>
                    <option value="World" {{ old('category') == 'World' ? 'selected' : '' }}>World</option>
                    <option value="Sports" {{ old('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                    <option value="Culture" {{ old('category') == 'Culture' ? 'selected' : '' }}>Culture</option>
                    <option value="Technology" {{ old('category') == 'Technology' ? 'selected' : '' }}>Technology</option>
                    <option value="Economy" {{ old('category') == 'Economy' ? 'selected' : '' }}>Economy</option>
                </select>
                @error('category')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="save-btn">
                    <i class="fa-solid fa-paper-plane"></i> Create news
                </button>
                <a href="{{ route('admin.dashboard') }}" class="cancel-btn">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection