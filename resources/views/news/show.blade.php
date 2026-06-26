@extends('layouts.main')

@section('header-title')
{{ $news->title }}
@endsection

@section('content')

<div class="single-news-card">

    <div class="single-news-image">
        <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}">
    </div>

    <div class="single-news-content">

        <h1>{{ $news->title }}</h1>

        <div class="news-meta">
            <span><i class="fa-regular fa-calendar"></i> {{ $news->created_at->format('d.m.Y H:i') }}</span>
            <span><i class="fa-regular fa-eye"></i> {{ $news->views ?? 0 }}</span>
            <span><i class="fa-regular fa-heart"></i> <span id="likes-count">{{ $likesCount ?? 0 }}</span></span>
        </div>

        <div class="news-text">
            {!! nl2br(e($news->content)) !!}
        </div>

        @auth
        <div class="news-actions">
            <button onclick="toggleLike({{ $news->id }})" 
                    class="like-btn {{ auth()->user() && auth()->user()->hasLiked($news->id) ? 'liked' : '' }}"
                    id="like-btn-{{ $news->id }}">
                <i class="fa-solid fa-heart"></i>
                <span id="likes-count-btn">{{ $likesCount ?? 0 }}</span>
            </button>
            
            <button onclick="toggleSave({{ $news->id }})" 
                    class="save-btn {{ $isSaved ? 'saved' : '' }}"
                    id="save-btn-{{ $news->id }}">
                <i class="fa-regular fa-bookmark"></i>
                <span id="save-text">{{ $isSaved ? 'Saved' : 'Save' }}</span>
            </button>
        </div>
        @endauth

        <div class="comments-section">
            <h3>Comments</h3>
            
            <div class="comments-list">
                @forelse($comments as $comment)
                <div class="comment-item" id="comment-{{ $comment->id }}">
                    <div class="comment-avatar">
                        @if($comment->user->avatar)
                            <img src="{{ asset('storage/'.$comment->user->avatar) }}" 
                                 alt="{{ $comment->user->name }}" 
                                 style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                        @else
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="comment-content">
                        <div class="comment-header">
                            <strong>{{ $comment->user->name }}</strong>
                            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="comment-text" id="comment-text-{{ $comment->id }}">
                            {{ $comment->content }}
                        </div>
                        <div class="comment-actions">
                            @if(Auth::check() && (Auth::id() === $comment->user_id || in_array(Auth::user()->role, ['admin', 'helper'])))
                                <button class="comment-btn edit-comment" onclick="editComment({{ $comment->id }})" title="Edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                <button class="comment-btn delete-comment" onclick="deleteComment({{ $comment->id }})" title="Delete">
                                    <i class="fa-regular fa-trash-alt"></i>
                                </button>
                            @endif
                        </div>
                        
                        <div class="edit-form" id="edit-form-{{ $comment->id }}" style="display: none;">
                            <textarea id="edit-text-{{ $comment->id }}" class="edit-textarea">{{ $comment->content }}</textarea>
                            <div class="edit-buttons">
                                <button class="save-edit" onclick="saveEdit({{ $comment->id }})">Save</button>
                                <button class="cancel-edit" onclick="cancelEdit({{ $comment->id }})">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="no-comments">
                    <i class="fa-regular fa-comment-dots"></i>
                    <p>No comments. Be the first!</p>
                </div>
                @endforelse
            </div>
            
            @auth
            <div class="comment-form">
                <textarea id="comment-content" placeholder="Write your comment..." class="comment-input"></textarea>
                <button onclick="submitComment()" class="btn-submit">
                    <i class="fa-regular fa-paper-plane"></i> Send
                </button>
            </div>
            @else
            <div class="login-to-comment">
                <p><a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Sign up</a> to write a comment</p>
            </div>
            @endauth
        </div>

        @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'helper']))
            <div class="admin-actions">
                <a href="{{ route('news.edit', $news->id) }}" class="edit-btn">
                    <i class="fa-regular fa-pen-to-square"></i> Edit
                </a>
                <form action="{{ route('news.destroy', $news->id) }}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this news?')">
                        <i class="fa-regular fa-trash-alt"></i> Delete
                    </button>
                </form>
            </div>
        @endif

    </div>

</div>

<script>
function toggleLike(newsId) {
    const btn = document.getElementById(`like-btn-${newsId}`);
    const likesCount = document.getElementById('likes-count');
    const likesCountBtn = document.getElementById('likes-count-btn');
    
    if (!btn) return;
    
    btn.disabled = true;
    
    fetch(`/news/${newsId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Response:', data);
        if (data.success) {
            if (data.liked) {
                btn.classList.add('liked');
                showToast('You liked this post ❤️', 'success');
            } else {
                btn.classList.remove('liked');
                showToast('You unliked this post', 'success');
            }
            
            if (likesCount) {
                likesCount.textContent = data.likes_count;
            }
            if (likesCountBtn) {
                likesCountBtn.textContent = data.likes_count;
            }
        } else {
            showToast(data.message || 'Error updating like', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred', 'error');
    })
    .finally(() => {
        btn.disabled = false;
    });
}

function toggleSave(newsId) {
    const btn = document.getElementById(`save-btn-${newsId}`);
    const saveText = document.getElementById('save-text');
    
    if (!btn) return;
    
    btn.disabled = true;
    
    fetch(`/news/${newsId}/save`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            if (data.saved) {
                btn.classList.add('saved');
                if (saveText) saveText.textContent = 'Saved';
                showToast('Article saved', 'success');
            } else {
                btn.classList.remove('saved');
                if (saveText) saveText.textContent = 'Save';
                showToast('Article removed from saved', 'success');
            }
        } else {
            showToast(data.message || 'Error saving article', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred', 'error');
    })
    .finally(() => {
        btn.disabled = false;
    });
}

function deleteComment(commentId) {
    if (!confirm('Are you sure you want to delete this comment?')) {
        return;
    }
    
    fetch(`/comments/${commentId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const commentElement = document.getElementById(`comment-${commentId}`);
            if (commentElement) {
                commentElement.style.transition = 'all 0.3s ease';
                commentElement.style.opacity = '0';
                commentElement.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    commentElement.remove();
                    const remainingComments = document.querySelectorAll('.comment-item');
                    if (remainingComments.length === 0) {
                        location.reload();
                    }
                }, 300);
            }
            showToast('Comment deleted', 'success');
        } else {
            showToast(data.message || 'Error while deleting', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error deleting comment', 'error');
    });
}

function editComment(commentId) {
    const commentText = document.getElementById(`comment-text-${commentId}`);
    const editForm = document.getElementById(`edit-form-${commentId}`);
    const commentActions = document.querySelector(`#comment-${commentId} .comment-actions`);
    
    if (commentText) commentText.style.display = 'none';
    if (editForm) editForm.style.display = 'block';
    if (commentActions) commentActions.style.display = 'none';
}

function cancelEdit(commentId) {
    const commentText = document.getElementById(`comment-text-${commentId}`);
    const editForm = document.getElementById(`edit-form-${commentId}`);
    const commentActions = document.querySelector(`#comment-${commentId} .comment-actions`);
    
    if (commentText) commentText.style.display = 'block';
    if (editForm) editForm.style.display = 'none';
    if (commentActions) commentActions.style.display = 'flex';
}

function saveEdit(commentId) {
    const textarea = document.getElementById(`edit-text-${commentId}`);
    if (!textarea) return;
    
    const newContent = textarea.value;
    
    if (!newContent.trim()) {
        showToast('Comment cannot be empty.', 'error');
        return;
    }
    
    fetch(`/comments/${commentId}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ content: newContent })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const commentText = document.getElementById(`comment-text-${commentId}`);
            if (commentText) {
                commentText.textContent = newContent;
            }
            cancelEdit(commentId);
            showToast('Comment updated', 'success');
        } else {
            showToast(data.message || 'Update error', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error updating comment', 'error');
    });
}

function submitComment() {
    const content = document.getElementById('comment-content');
    const newsId = {{ $news->id }};
    
    if (!content || !content.value.trim()) {
        showToast('Write a comment', 'error');
        return;
    }
    
    const btn = document.querySelector('.comment-form .btn-submit');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
    }
    
    fetch(`/news/${newsId}/comments`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ content: content.value })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showToast(data.message || 'Error adding', 'error');
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-regular fa-paper-plane"></i> Send';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error adding comment', 'error');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-regular fa-paper-plane"></i> Send';
        }
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
        if (toast.parentNode) {
            toast.remove();
        }
    }, 3000);
}
</script>

<style>
.single-news-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px #00000014;
    border: 1px solid #ececec;
}

.single-news-image img {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
}

.single-news-content {
    padding: 30px;
}

.single-news-content h1 {
    color: #000;
    font-size: 32px;
    margin-bottom: 15px;
}

.news-meta {
    color: #888;
    font-size: 14px;
    margin-bottom: 20px;
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.news-actions {
    display: flex;
    gap: 16px;
    margin: 20px 0 30px;
    padding: 16px 0;
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    flex-wrap: wrap;
}

.like-btn, .save-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border: 2px solid #e5e5e5;
    border-radius: 30px;
    background: transparent;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: inherit;
}

.like-btn {
    color: #666;
}

.like-btn:hover {
    border-color: #e30613;
    color: #e30613;
    transform: translateY(-2px);
}

.like-btn.liked {
    background: #e30613;
    border-color: #e30613;
    color: white;
}

.like-btn.liked:hover {
    background: #b8050f;
    border-color: #b8050f;
}

.like-btn i {
    font-size: 18px;
    transition: transform 0.3s ease;
}

.like-btn.liked i {
    animation: heartBeat 0.3s ease;
}

@keyframes heartBeat {
    0% { transform: scale(1); }
    50% { transform: scale(1.4); }
    100% { transform: scale(1); }
}

.save-btn {
    color: #666;
}

.save-btn:hover {
    border-color: #e30613;
    color: #e30613;
    transform: translateY(-2px);
}

.save-btn.saved {
    background: #e30613;
    border-color: #e30613;
    color: white;
}

.save-btn.saved:hover {
    background: #b8050f;
    border-color: #b8050f;
}

.like-btn:disabled, .save-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

.news-text {
    color: #222;
    font-size: 16px;
    line-height: 1.8;
}

.comments-section {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #eee;
}

.comments-section h3 {
    color: #000;
    font-size: 20px;
    margin-bottom: 20px;
}

.comment-item {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
}

.comment-item:hover {
    background: #f0f0f0;
}

.comment-avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #dc3545;
    color: white;
    font-weight: bold;
    font-size: 14px;
    flex-shrink: 0;
}

.comment-avatar img {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
}

.comment-content {
    display: inline-block;
    margin-left: 12px;
    vertical-align: top;
    width: calc(100% - 50px);
}

.comment-header strong {
    color: #000;
}

.comment-time {
    color: #888;
    font-size: 12px;
    margin-left: 8px;
}

.comment-text {
    color: #222;
    margin-top: 4px;
}

.comment-actions {
    margin-top: 6px;
}

.comment-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 12px;
    padding: 2px 6px;
    transition: color 0.2s;
}

.edit-comment {
    color: #dc3545;
}

.edit-comment:hover {
    color: #b02a37;
    text-decoration: underline;
}

.delete-comment {
    color: #dc3545;
}

.delete-comment:hover {
    color: #b02a37;
    text-decoration: underline;
}

.edit-form {
    margin-top: 12px;
}

.edit-form textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    color: #1a1a2e;
    background: #fff;
    transition: all 0.3s ease;
    resize: vertical;
}

.edit-form textarea:focus {
    outline: none;
    border-color: #dc3545;
    box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.08);
}

.edit-buttons {
    margin-top: 10px;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.edit-buttons .save-edit {
    padding: 8px 24px;
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.edit-buttons .save-edit:hover {
    background: linear-gradient(135deg, #c82333, #b02a37);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.25);
}

.edit-buttons .save-edit:active {
    transform: scale(0.96);
}

.edit-buttons .cancel-edit {
    padding: 8px 24px;
    background: #f8f9fa;
    color: #6c757d;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.edit-buttons .cancel-edit:hover {
    background: #e9ecef;
    color: #495057;
    border-color: #dee2e6;
    transform: translateY(-2px);
}

.edit-buttons .cancel-edit:active {
    transform: scale(0.96);
}

.no-comments {
    text-align: center;
    padding: 30px;
    color: #888;
}

.no-comments i {
    font-size: 48px;
    color: #ddd;
    display: block;
    margin-bottom: 10px;
}

.comment-form {
    margin-top: 20px;
}

.comment-input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    color: #000;
    background: #fff;
    font-size: 14px;
    resize: vertical;
    min-height: 80px;
    transition: border-color 0.3s;
}

.comment-input:focus {
    outline: none;
    border-color: #dc3545;
}

.comment-form .btn-submit {
    margin-top: 14px;
    padding: 12px 36px;
    background: linear-gradient(135deg, #dc3545, #b02a37);
    color: #fff;
    border: none;
    border-radius: 50px;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    position: relative;
    overflow: hidden;
    letter-spacing: 0.3px;
    box-shadow: 0 4px 16px rgba(220, 53, 69, 0.25);
}

.comment-form .btn-submit::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
    transition: left 0.6s ease;
}

.comment-form .btn-submit:hover::before {
    left: 100%;
}

.comment-form .btn-submit:hover {
    background: linear-gradient(135deg, #b02a37, #8f1f2a);
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(220, 53, 69, 0.35);
}

.comment-form .btn-submit:active {
    transform: scale(0.96);
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.2);
}

.comment-form .btn-submit i {
    font-size: 16px;
    transition: transform 0.3s ease;
}

.comment-form .btn-submit:hover i {
    transform: translateX(4px);
}

.comment-form .btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none !important;
}

.login-to-comment {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
}

.login-to-comment a {
    color: #dc3545;
    text-decoration: none;
}

.login-to-comment a:hover {
    text-decoration: underline;
}

.admin-actions {
    margin-top: 30px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.admin-actions .edit-btn {
    padding: 10px 20px;
    background: #0d6efd;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background 0.3s;
}

.admin-actions .edit-btn:hover {
    background: #0b5ed7;
}

.admin-actions .delete-btn {
    padding: 10px 20px;
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background 0.3s;
}

.admin-actions .delete-btn:hover {
    background: #b02a37;
}

.toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #fff;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    z-index: 9999;
    border-left: 4px solid #dc3545;
}

.toast-success {
    border-left-color: #28a745;
}

.toast-error {
    border-left-color: #dc3545;
}

.toast span {
    color: #222;
}

@media (max-width: 768px) {
    .single-news-content {
        padding: 16px;
    }

    .single-news-content h1 {
        font-size: 24px;
    }

    .single-news-image img {
        max-height: 250px;
    }

    .comment-content {
        width: calc(100% - 44px);
    }

    .admin-actions {
        flex-direction: column;
    }

    .admin-actions .edit-btn,
    .admin-actions .delete-btn {
        justify-content: center;
        width: 100%;
    }

    .comment-form .btn-submit {
        padding: 12px 28px;
        font-size: 14px;
        width: 100%;
        justify-content: center;
        border-radius: 40px;
    }

    .edit-buttons {
        flex-direction: column;
    }

    .edit-buttons .save-edit,
    .edit-buttons .cancel-edit {
        justify-content: center;
        width: 100%;
    }
    
    .news-actions {
        flex-direction: column;
    }
    
    .like-btn, .save-btn {
        justify-content: center;
        width: 100%;
    }
    
    .news-meta {
        font-size: 12px;
        gap: 12px;
    }
}
</style>

@endsection