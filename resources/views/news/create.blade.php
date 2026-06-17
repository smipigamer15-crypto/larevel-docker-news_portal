@extends('layouts.admin')

@section('title', 'Create news')

@section('content')

<h1 class="page-title">
    <i class="fa-solid fa-pen-clip"></i>
    Create news
</h1>

<div class="admin-card">

    <form action="{{ route('news.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label>Title</label>

            <input type="text"
                   name="title"
                   required>
        </div>

        <div class="form-group">
            <label>Content</label>

            <textarea name="content"
                      rows="10"
                      required></textarea>
        </div>

        <div class="form-group">
            <label>Image</label>

            <input type="file"
                   name="image">
        </div>

        <div class="form-group">
            <label>Category</label>

            <select name="category">

                <option value="Politics">Politics</option>
                <option value="World">World</option>
                <option value="Sports">Sports</option>
                <option value="Culture">Culture</option>

            </select>
        </div>

        <button type="submit" class="save-btn">
            Create news
        </button>

    </form>

</div>

@endsection