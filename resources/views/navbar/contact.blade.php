@extends('layouts.main')

@section('header-title')
Contact
@endsection

@section('content')
<div class="contacts-page">
    <div class="container">
        
        <div class="contacts-content">
            
            <div class="contact-info">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h3>Contact us</h3>
                    <p>Have questions, suggestions, or want to report a news tip?<br>Write to us, and we will respond as soon as possible.</p>
                </div>

                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3>For press</h3>
                    <p>If you are a media representative, please use the form for official inquiries.</p>
                </div>

                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Advertising</h3>
                    <p>Advertising inquiries and partnerships are discussed through the contact form.</p>
                </div>

                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <h3>Follow us</h3>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-telegram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

         
            <div class="contact-form-wrapper">
                <div class="form-header">
                    <h2>Write to us</h2>
                    <p>Fill out the form below and we will get back to you as soon as possible</p>
                </div>

    
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        Please fix the errors in the form
                    </div>
                @endif

            
                <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                    @csrf

                    <div class="form-group">
                        <label for="subject">
                            <i class="fas fa-heading"></i>
                            Subject
                        </label>
                        <input type="text" id="subject" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Enter the subject of your message..." value="{{ old('subject') }}" autocomplete="off" required>
                        @error('subject')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="topic">
                            <i class="fas fa-tag"></i>
                            Category
                        </label>
                        <select id="topic" name="topic" class="form-control @error('topic') is-invalid @enderror" required>
                            <option value="">Select a category</option>
                            <option value="general" {{ old('topic') == 'general' ? 'selected' : '' }}>General question</option>
                            <option value="advertising" {{ old('topic') == 'advertising' ? 'selected' : '' }}>Advertising & Partnership</option>
                            <option value="cooperation" {{ old('topic') == 'cooperation' ? 'selected' : '' }}>Cooperation</option>
                            <option value="news_tip" {{ old('topic') == 'news_tip' ? 'selected' : '' }}>News tip</option>
                            <option value="bug" {{ old('topic') == 'bug' ? 'selected' : '' }}>Website bug</option>
                            <option value="other" {{ old('topic') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('topic')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="message">
                            <i class="fas fa-comment"></i>
                            Message
                        </label>
                        <textarea id="message" name="message" rows="6" class="form-control @error('message') is-invalid @enderror" placeholder="Describe your question in detail..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    @guest
                        <div class="auth-warning">
                            <i class="fas fa-lock"></i>
                            <span>To send a message you need to <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">register</a></span>
                        </div>
                    @endguest

                    <button type="submit" class="submit-btn" {{ Auth::check() ? '' : 'disabled' }}>
                        <i class="fas fa-paper-plane"></i>
                        <span>Send message</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection