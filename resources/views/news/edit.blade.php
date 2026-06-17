@extends('layouts.admin')

@section('title', 'Edit news')

@section('content')

<div class="admin-page">

    <h1 class="page-title">
        <i class="fa-solid fa-file-pen"></i>
        Edit news
    </h1>

    <div class="admin-card">

        <form action="{{ route('news.update', $news->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label>Title</label>

                <input type="text"
                       name="title"
                       value="{{ $news->title }}">

            </div>

            <div class="form-group">

                <label>Category</label>

                <select name="category">

                    <option value="Politics" {{ $news->category == 'Politics' ? 'selected' : '' }}>
                        Politics
                    </option>

                    <option value="Economy" {{ $news->category == 'Economy' ? 'selected' : '' }}>
                        Economy
                    </option>

                    <option value="World" {{ $news->category == 'World' ? 'selected' : '' }}>
                        World
                    </option>

                    <option value="Technology" {{ $news->category == 'Technology' ? 'selected' : '' }}>
                        Technology
                    </option>

                    <option value="Sports" {{ $news->category == 'Sports' ? 'selected' : '' }}>
                        Sports
                    </option>

                    <option value="Culture" {{ $news->category == 'Culture' ? 'selected' : '' }}>
                        Culture
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Content</label>

                <textarea name="content" rows="12">{{ $news->content }}</textarea>

            </div>

            <div class="form-group">

                <label>Current image</label>

                <div class="image-preview">

                    <img src="{{ asset('storage/'.$news->image) }}"
                         alt="{{ $news->title }}">

                </div>

            </div>

            <div class="form-group">

                <label>New image</label>

                <input type="file" name="image">

            </div>

            <button type="submit" class="save-btn">
                Save changes
            </button>

        </form>

    </div>

</div>

@endsection