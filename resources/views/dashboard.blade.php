@extends('layouts.main')

@section('header-title')
Dashboard
@endsection

@section('content')
<div class="dashboard-container">
    <div class="dashboard-grid">
        <aside class="dashboard-sidebar">
            <div class="profile-card">
                <div class="profile-avatar" style="position: relative;">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/'.Auth::user()->avatar) }}" 
                             alt="{{ Auth::user()->name }}" 
                             style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                    @else
                        <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    @endif
                    <button onclick="document.getElementById('avatarInput').click()" 
                            style="position: absolute; bottom: 0; right: 0; background: #e30613; color: white; border: none; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; font-size: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-camera"></i>
                    </button>
                    <input type="file" id="avatarInput" accept="image/*" style="display: none;" onchange="uploadAvatar(this)">
                </div>
                <h3>{{ Auth::user()->name }}</h3>
                <p>{{ Auth::user()->email }}</p>
               <div class="profile-badge">
                    @if(Auth::user()->hasRole('admin'))
                    <i class="fa-solid fa-crown"></i> Administrator
                    @elseif(Auth::user()->hasRole('helper'))
                    <i class="fa-solid fa-user-check"></i> Helper
                    @else
                    <i class="fa-regular fa-user"></i> User
                    @endif
                </div>
            </div>
            
            <nav class="profile-nav">
                <a href="#" class="profile-nav-item active" data-tab="profile">
                    <i class="fa-regular fa-user"></i> My profile
                </a>
                <a href="#" class="profile-nav-item" data-tab="security">
                    <i class="fa-solid fa-shield-alt"></i> Security
                </a>
                <a href="#" class="profile-nav-item" data-tab="comments">
                    <i class="fa-regular fa-comment"></i> My comments
                </a>
                <a href="#" class="profile-nav-item" data-tab="saved">
                    <i class="fa-regular fa-bookmark"></i> Saved
                </a>
                <a href="#" class="profile-nav-item" data-tab="liked">
                    <i class="fa-solid fa-heart"></i> Liked
                </a>
                <a href="#" class="profile-nav-item" data-tab="history">
                    <i class="fa-regular fa-clock"></i> History
                </a>
            </nav>
            
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </aside>
        
    
        <main class="dashboard-main">
         
            <div class="tab-content active" id="tab-profile">
                <div class="tab-header">
                    <h2><i class="fa-regular fa-user"></i> My profile</h2>
                    <p>Your personal information</p>
                </div>
                
                @if(session('success'))
                    <div class="alert-success">
                        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                
                <form method="POST" action="{{ route('profile.update') }}" class="profile-form" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="form-group">
                        <label for="name"><i class="fa-regular fa-user"></i> Name</label>
                        <input type="text" id="name" name="name" class="form-control" 
                               value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email"><i class="fa-regular fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-save">
                       Save changes
                    </button>
                </form>
            </div>
            
            <div class="tab-content" id="tab-security">
                <div class="tab-header">
                    <h2><i class="fa-solid fa-shield-alt"></i> Security</h2>
                    <p>Change your password</p>
                </div>
                
                <form method="POST" action="{{ route('password.update') }}" class="profile-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="current_password"><i class="fa-solid fa-lock"></i> Current password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                        @error('current_password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password"><i class="fa-solid fa-key"></i> New password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation"><i class="fa-solid fa-check"></i> Confirm password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn-save">
                             Update password
                    </button>
                </form>
            </div>
            

<div class="tab-content" id="tab-comments">
    <div class="tab-header">
        <h2><i class="fa-regular fa-comment"></i> My comments</h2>
        <p>Total comments: {{ $myComments ?? 0 }}</p>
    </div>
    
    @if(isset($comments) && count($comments) > 0)
        <div class="comments-list-dashboard">
            @foreach($comments as $comment)
                <div class="comment-item-dashboard" id="dashboard-comment-{{ $comment->id }}">
                    <div class="comment-content-dashboard">
                        <a href="{{ route('news.show', $comment->news->slug) }}" class="comment-info">
                            <h3 class="comment-title">{{ $comment->news->title ?? 'News' }}</h3>
                            <p class="comment-text-dashboard">{{ $comment->content }}</p>
                            <div class="comment-footer">
                                <span class="comment-date">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $comment->created_at ? $comment->created_at->format('d.m.Y') : 'Date unknown' }}
                                </span>
                            </div>
                        </a>
                    </div>
                    <button class="btn-delete-comment-dashboard" onclick="deleteDashboardComment({{ $comment->id }}, this)">
                        <i class="fa-regular fa-trash-alt"></i> Delete
                    </button>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fa-regular fa-comment-dots"></i>
            <p>You have no comments yet</p>
            <a href="{{ route('news.index') }}" class="btn-empty">Go to news</a>
        </div>
    @endif
</div>
            

<div class="tab-content" id="tab-saved">
    <div class="tab-header">
        <h2><i class="fa-regular fa-bookmark"></i> Saved articles</h2>
        <p>Total saved: {{ $savedArticles ?? 0 }}</p>
    </div>
    
    @if(isset($saved) && count($saved) > 0)
        @foreach($saved as $item)
            <div class="saved-item" id="saved-item-{{ $item->id }}">
                <div class="saved-content">
                    <a href="{{ route('news.show', $item->slug) }}">
                        <h3>{{ $item->title ?? 'Untitled' }}</h3>
                        <p>{{ Str::limit($item->content ?? '', 100) }}</p>
                        <span>
                            <i class="fa-regular fa-calendar"></i>
                            {{ $item->created_at ? $item->created_at->format('d.m.Y') : 'Date unknown' }}
                        </span>
                    </a>
                </div>
                <button class="btn-delete-comment-dashboard" onclick="removeFromSaved({{ $item->id }}, this)">
                    <i class="fa-regular fa-trash-alt"></i> Delete
                </button>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <i class="fa-regular fa-bookmark"></i>
            <p>You have no saved articles</p>
            <a href="{{ route('news.index') }}" class="btn-empty">Read news</a>
        </div>
    @endif
</div>


<div class="tab-content" id="tab-liked">
    <div class="tab-header">
        <h2><i class="fa-solid fa-heart"></i> Liked articles</h2>
        <p>Total liked: {{ $likedCount ?? 0 }}</p>
    </div>
    
    @if(isset($likedNews) && count($likedNews) > 0)
        @foreach($likedNews as $item)
            <div class="saved-item" id="liked-item-{{ $item->id }}">
                <div class="saved-content">
                    <a href="{{ route('news.show', $item->slug) }}">
                        <h3>{{ $item->title ?? 'Untitled' }}</h3>
                        <p>{{ Str::limit($item->content ?? '', 100) }}</p>
                        <span>
                            <i class="fa-regular fa-calendar"></i>
                            {{ $item->created_at ? $item->created_at->format('d.m.Y') : 'Date unknown' }}
                        </span>
                    </a>
                </div>
                <button class="btn-delete-comment-dashboard" onclick="unlikeNews({{ $item->id }}, this)">
                    <i class="fa-regular fa-heart"></i> Unlike
                </button>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <i class="fa-regular fa-heart"></i>
            <p>You haven't liked any articles yet</p>
            <a href="{{ route('news.index') }}" class="btn-empty">Read news</a>
        </div>
    @endif
</div>


<div class="tab-content" id="tab-history">
    <div class="tab-header">
        <div class="tab-header-content">
            <div>
                <h2><i class="fa-regular fa-clock"></i> Viewing history</h2>
                <p id="history-count">Articles viewed: {{ $viewedArticles ?? 0 }}</p>
            </div>
            @if(isset($history) && count($history) > 0)
                <button onclick="clearHistory(this)" class="btn-delete-comment-dashboard" id="clear-history-btn">
                    <i class="fa-regular fa-trash-alt"></i> Clear history
                </button>
            @endif
        </div>
    </div>
    
    <div id="history-list">
        @if(isset($history) && count($history) > 0)
            @foreach($history as $item)
                <div class="history-item" id="history-item-{{ $item->id }}">
                    <a href="{{ route('news.show', $item->slug) }}">
                        <h3>{{ $item->title ?? 'Untitled' }}</h3>
                        <span>
                            @if(isset($item->pivot->created_at) && $item->pivot->created_at)
                                {{ \Carbon\Carbon::parse($item->pivot->created_at)->format('d.m.Y H:i') }}
                            @elseif(isset($item->pivot->viewed_at) && $item->pivot->viewed_at)
                                {{ \Carbon\Carbon::parse($item->pivot->viewed_at)->format('d.m.Y H:i') }}
                            @else
                                Date unknown
                            @endif
                        </span>
                    </a>
                </div>
            @endforeach
        @else
            <div class="empty-state" id="history-empty">
                <i class="fa-regular fa-clock"></i>
                <p>You haven't viewed any articles yet</p>
                <a href="{{ route('news.index') }}" class="btn-empty">Start reading</a>
            </div>
        @endif
    </div>
</div>
        </main>
    </div>
</div>

<!-- СТИЛІ ТА СКРИПТИ ЗАЛИШАЮТЬСЯ ТАКІ Ж ЯК БУЛИ -->

<style>
    .dashboard-container {
        max-width: 1400px;
        padding: 0 20px;
    }
    
    .dashboard-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 32px;
    }
    
    .dashboard-sidebar {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        position: sticky;
        top: 20px;
        height: fit-content;
    }
    
    .profile-card {
        text-align: center;
        padding-bottom: 24px;
        border-bottom: 1px solid #eee;
        margin-bottom: 24px;
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
        background: #e30613;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        position: relative;
    }
    
    .profile-avatar span {
        font-size: 32px;
        font-weight: 600;
        color: white;
    }
    
    .profile-avatar img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .profile-card h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 4px;
    }
    
    .profile-card p {
        font-size: 13px;
        color: #666;
        margin-bottom: 12px;
    }
    
    .profile-badge {
        display: inline-block;
        padding: 4px 12px;
        background: #f5f5f0;
        border-radius: 20px;
        font-size: 12px;
        color: #666;
    }
    
    .profile-badge i {
        color: #e30613;
        margin-right: 6px;
    }
    
    .profile-nav {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 24px;
    }
    
    .profile-nav-item {
        padding: 12px 16px;
        border-radius: 12px;
        color: #333;
        text-decoration: none;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .profile-nav-item i {
        width: 20px;
        color: #999;
    }
    
    .profile-nav-item:hover {
        background: #f5f5f0;
    }
    
    .profile-nav-item.active {
        background: #e30613;
        color: white;
    }
    
    .profile-nav-item.active i {
        color: white;
    }
    
    .logout-form {
        border-top: 1px solid #eee;
        padding-top: 20px;
    }
    
    .logout-btn {
        width: 100%;
        padding: 12px;
        background: none;
        border: 1px solid #e30613;
        border-radius: 12px;
        color: #e30613;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .logout-btn:hover {
        background: #e30613;
        color: white;
    }
    
    .dashboard-main {
        background: white;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    
    .tab-header {
        margin-bottom: 28px;
        padding-bottom: 16px;
        border-bottom: 1px solid #eee;
    }
    
    .tab-header h2 {
        font-size: 22px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 6px;
    }
    
    .tab-header h2 i {
        color: #e30613;
        margin-right: 10px;
    }
    
    .tab-header p {
        color: #666;
        font-size: 14px;
    }
    
    .tab-content {
        display: none;
    }
    
    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .profile-form .form-group {
        margin-bottom: 20px;
    }
    
    .profile-form label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }
    
    .profile-form label i {
        color: #e30613;
        margin-right: 8px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        font-size: 14px;
        border: 1.5px solid #e5e5e5;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #e30613;
        box-shadow: 0 0 0 3px rgba(227,6,19,0.1);
    }
    
    .btn-save {
        background: #e30613;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-save:hover {
        background: #b8050f;
        transform: translateY(-1px);
    }
    
    .error-message {
        color: #e30613;
        font-size: 12px;
        margin-top: 6px;
    }
    
    .alert-success {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .comment-item, .saved-item, .history-item {
        padding: 16px;
        border-bottom: 1px solid #eee;
        transition: all 0.3s ease;
    }
    
    .comment-item:last-child, .saved-item:last-child, .history-item:last-child {
        border-bottom: none;
    }
    
    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    
    .comment-header strong {
        color: #e30613;
        font-size: 14px;
    }
    
    .comment-header span {
        font-size: 12px;
        color: #999;
    }
    
    .comment-item p, .saved-item p {
        font-size: 14px;
        color: #555;
        line-height: 1.5;
    }
    
    .saved-item a, .history-item a {
        text-decoration: none;
        color: inherit;
    }
    
    .saved-item h3, .history-item h3 {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 8px;
        color: #1a1a1a;
    }
    
    .saved-item h3:hover, .history-item h3:hover {
        color: #e30613;
    }
    
    .saved-item span, .history-item span {
        font-size: 12px;
        color: #999;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state i {
        font-size: 48px;
        color: #ccc;
        margin-bottom: 16px;
        display: block;
    }
    
    .empty-state p {
        color: #999;
        margin-bottom: 20px;
    }
    
    .btn-empty {
        display: inline-block;
        padding: 10px 24px;
        background: #e30613;
        color: white;
        text-decoration: none;
        border-radius: 30px;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .btn-empty:hover {
        background: #b8050f;
    }
    

    .saved-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    border-bottom: 1px solid #eee;
    transition: all 0.3s ease;
}

.saved-item:hover {
    background: #fafafa;
}

.saved-content {
    flex: 1;
}

.saved-content a {
    text-decoration: none;
    color: inherit;
    display: block;
}

.saved-content h3 {
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 8px;
    color: #1a1a1a;
}

.saved-content h3:hover {
    color: #e30613;
}

.saved-content p {
    font-size: 14px;
    color: #666;
    line-height: 1.5;
    margin-bottom: 8px;
}

.saved-content span {
    font-size: 12px;
    color: #999;
}


.btn-delete-comment-dashboard {
    background: transparent;
    border: 1.5px solid #e30613;
    border-radius: 8px;
    padding: 8px 16px;
    color: #e30613;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    font-family: inherit;
}

.btn-delete-comment-dashboard:hover {
    background: #e30613;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(227, 6, 19, 0.2);
}

.btn-delete-comment-dashboard:active {
    transform: scale(0.96);
}

.btn-delete-comment-dashboard i {
    font-size: 13px;
}

.btn-delete-comment-dashboard:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

.btn-delete-comment-dashboard:disabled:hover {
    background: transparent;
    color: #e30613;
    box-shadow: none;
}


.comments-list-dashboard {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.comment-item-dashboard {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    background: #fff;
    padding: 20px;
    transition: all 0.3s ease;
}

.comment-item-dashboard:hover {
    border-color: #fafafa;
}

.comment-content-dashboard {
    flex: 1;
}

.comment-info {
    text-decoration: none;
    color: inherit;
    display: block;
}

.comment-item-dashboard:hover {
    background: #fafafa;
}

.comment-title {
    font-size: 16px;
    font-weight: 600;
    color: #1a1a1a;
    text-decoration: none;
    display: block;
    margin-bottom: 10px;
    transition: color 0.2s;
}


.comment-text-dashboard {
    font-size: 14px;
    color: #666;
    line-height: 1.5;
    margin-bottom: 12px;
}

.comment-footer {
    display: flex;
    align-items: center;
    gap: 16px;
}

.comment-date {
    font-size: 12px;
    color: #999;
    display: flex;
    align-items: center;
    gap: 5px;
}


.tab-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}


@media (max-width: 600px) {
    .comment-item-dashboard {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .btn-delete-comment-dashboard {
        align-self: flex-end;
        width: 100%;
        justify-content: center;
    }
    
    .saved-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .saved-item .btn-delete-comment-dashboard {
        align-self: flex-end;
        width: 100%;
        justify-content: center;
        margin-top: 10px;
    }
    
    .tab-header-content {
        flex-direction: column;
        align-items: flex-start;
    }
}


 @media (max-width: 900px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
        
        .dashboard-sidebar {
            position: static;
        }
    }
</style>



<script>
    document.querySelectorAll('.profile-nav-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            const tabId = this.dataset.tab;
            
            document.querySelectorAll('.profile-nav-item').forEach(nav => {
                nav.classList.remove('active');
            });
            this.classList.add('active');
            
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById(`tab-${tabId}`).classList.add('active');
        });
    });

    function uploadAvatar(input) {
        if (!input.files || !input.files[0]) return;
        
        const file = input.files[0];
        const formData = new FormData();
        formData.append('avatar', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        const btn = input.previousElementSibling;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        btn.disabled = true;
        
        fetch('/profile/avatar', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error uploading avatar');
                btn.innerHTML = '<i class="fa-solid fa-camera"></i>';
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error uploading avatar');
            btn.innerHTML = '<i class="fa-solid fa-camera"></i>';
            btn.disabled = false;
        });
    }

    function removeFromSaved(newsId, button) {
        if (!confirm('Are you sure you want to delete this saved article?')) {
            return;
        }
        
        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Deleting...';
        
        fetch(`/news/${newsId}/unsave`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.getElementById(`saved-item-${newsId}`);
                if (item) {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        item.remove();
                        
                        const countSpan = document.querySelector('#tab-saved .tab-header p');
                        if (countSpan) {
                            const match = countSpan.textContent.match(/\d+/);
                            if (match) {
                                const currentCount = parseInt(match[0]);
                                const newCount = currentCount - 1;
                                countSpan.textContent = `Total saved: ${newCount}`;
                            }
                        }
                        
                        const remainingItems = document.querySelectorAll('#tab-saved .saved-item');
                        if (remainingItems.length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
                showToast('Article deleted successfully', 'success');
            } else {
                showToast(data.message || 'Error deleting', 'error');
                button.disabled = false;
                button.innerHTML = '<i class="fa-regular fa-trash-alt"></i> Delete';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred', 'error');
            button.disabled = false;
            button.innerHTML = '<i class="fa-regular fa-trash-alt"></i> Delete';
        });
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <i class="fa-solid ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 2000);
    }

    function deleteDashboardComment(commentId, button) {
        if (!confirm('Are you sure you want to delete this comment?')) {
            return;
        }
        
        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Deleting...';
        
        fetch(`/comments/${commentId}`, { 
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.getElementById(`dashboard-comment-${commentId}`);
                if (item) {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        item.remove();
                        
                        const countSpan = document.querySelector('#tab-comments .tab-header p');
                        if (countSpan) {
                            const match = countSpan.textContent.match(/\d+/);
                            if (match) {
                                const currentCount = parseInt(match[0]);
                                const newCount = currentCount - 1;
                                countSpan.textContent = `Total comments: ${newCount}`;
                            }
                        }
                        
                        const remainingItems = document.querySelectorAll('#tab-comments .comment-item-dashboard');
                        if (remainingItems.length === 0) {
                            location.reload();
                        }
                    }, 200);
                }
                showToast('Comment deleted', 'success');
            } else {
                showToast(data.message || 'Error deleting', 'error');
                button.disabled = false;
                button.innerHTML = '<i class="fa-regular fa-trash-alt"></i> Delete';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred', 'error');
            button.disabled = false;
            button.innerHTML = '<i class="fa-regular fa-trash-alt"></i> Delete';
        });
    }

    function clearHistory(button) {
        if (!confirm('Are you sure you want to clear your entire viewing history? This action cannot be undone.')) {
            return;
        }
        
        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Clearing...';
        
        fetch('{{ route("profile.history.clear") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
             
                const historyItems = document.querySelectorAll('.history-item');
                const historyList = document.getElementById('history-list');
                const historyCount = document.getElementById('history-count');
                const clearBtn = document.getElementById('clear-history-btn');
                
          
                historyItems.forEach((item, index) => {
                    setTimeout(() => {
                        item.style.transition = 'all 0.2s ease';
                        item.style.opacity = '0';
                        item.style.transform = 'translateX(20px)';
                    }, index * 50);
                });
                
            
                setTimeout(() => {
                    historyItems.forEach(item => item.remove());
                    
                    if (historyCount) {
                        historyCount.textContent = 'Articles viewed: 0';
                    }
                    
                    if (clearBtn) {
                        clearBtn.style.display = 'none';
                    }
                    
                    if (historyList) {
                        const emptyState = document.createElement('div');
                        emptyState.className = 'empty-state';
                        emptyState.id = 'history-empty';
                        emptyState.innerHTML = `
                            <i class="fa-regular fa-clock"></i>
                            <p>You haven't viewed any articles yet</p>
                            <a href="{{ route('news.index') }}" class="btn-empty">Start reading</a>
                        `;
                        historyList.appendChild(emptyState);
                    }
                    
                    showToast('History cleared successfully', 'success');
                }, historyItems.length * 50 + 200);
                
            } else {
                showToast(data.message || 'Error clearing history', 'error');
                button.disabled = false;
                button.innerHTML = '<i class="fa-regular fa-trash-alt"></i> Clear history';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred', 'error');
            button.disabled = false;
            button.innerHTML = '<i class="fa-regular fa-trash-alt"></i> Clear history';
        });
    }

    function unlikeNews(newsId, button) {
        if (!confirm('Are you sure you want to remove your like from this article?')) {
            return;
        }
        
        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Removing...';
        
        fetch(`/news/${newsId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const item = document.getElementById(`liked-item-${newsId}`);
                if (item) {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        item.remove();
                        
                        const countSpan = document.querySelector('#tab-liked .tab-header p');
                        if (countSpan) {
                            const match = countSpan.textContent.match(/\d+/);
                            if (match) {
                                const currentCount = parseInt(match[0]);
                                const newCount = currentCount - 1;
                                countSpan.textContent = `Total liked: ${newCount}`;
                            }
                        }
                        
                        const remainingItems = document.querySelectorAll('#tab-liked .saved-item');
                        if (remainingItems.length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
                showToast('Like removed successfully', 'success');
            } else {
                showToast(data.message || 'Error removing like', 'error');
                button.disabled = false;
                button.innerHTML = '<i class="fa-regular fa-heart"></i> Unlike';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred', 'error');
            button.disabled = false;
            button.innerHTML = '<i class="fa-regular fa-heart"></i> Unlike';
        });
    }
</script>
@endsection