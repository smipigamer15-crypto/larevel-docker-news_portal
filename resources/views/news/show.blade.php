@extends('layouts.main')

@section('header-title')
{{ $news->title }}
@endsection

@section('content')

<div class="single-news-card">

    <div class="single-news-image">
        <img src="{{ asset('storage/'.$news->image) }}"
             alt="{{ $news->title }}">
    </div>

    <div class="single-news-content">

        <h1>{{ $news->title }}</h1>

        <div class="news-meta">
            <span>
                <i class="fa-regular fa-calendar"></i>
                {{ $news->created_at }}
            </span>

            <span>
                <i class="fa-regular fa-eye"></i>
                {{ $news->views }}
            </span>
        </div>

        <div class="news-text">
            {!! nl2br(e($news->content)) !!}
        </div>

        @auth
            <form method="POST" action="{{ route('news.save', $news->id) }}" class="save-form" id="saveForm">
                @csrf
                <button type="submit" class="btn-save {{ $isSaved ? 'saved' : '' }}" id="saveBtn">
                    <i class="fa-regular {{ $isSaved ? 'fa-bookmark' : 'fa-bookmark' }}"></i>
                    <span id="saveText">{{ $isSaved ? 'Saved' : 'Save' }}</span>
                </button>
            </form>
        @endauth

        <div class="comments-section">
            <h3>Comments</h3>
            
            @foreach($comments as $comment)
            <div class="comment-item" id="comment-{{ $comment->id }}">
                <div class="comment-avatar">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
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
                        @if(Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->role === 'admin'))
                            <button class="comment-btn edit-comment" 
                                    onclick="editComment({{ $comment->id }})"
                                    title="Edit">
                                <i class="fa-regular fa-pen-to-square"></i>
                            </button>
                        @endif
                        
                        @if(Auth::check() && (Auth::id() === $comment->user_id || Auth::user()->role === 'admin'))
                            <button class="comment-btn delete-comment" 
                                    onclick="deleteComment({{ $comment->id }})"
                                    title="Delete">
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
            @endforeach

            @if($comments->count() == 0)
                <div class="no-comments">
                    <i class="fa-regular fa-comment-dots"></i>
                    <p>No comments. Be the first!</p>
                </div>
            @endif
            
            @auth
            <div class="comment-form">
                <textarea id="comment-content" placeholder="Write your comment..." class="comment-input"></textarea>
                <button onclick="submitComment()" class="btn-submit">Send</button>
            </div>
            @else
            <div class="login-to-comment">
                <p style="margin-bottom: 0;"><a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Sign up</a>, to write a comment</p>
            </div>
            @endauth
        </div>

        @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'helper']))
            <div class="admin-actions">
                <a href="{{ route('news.edit', $news->id) }}" class="edit-btn">
                    Edit
                </a>

                <form action="{{ route('news.destroy', $news->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">
                        Delete
                    </button>
                </form>
            </div>
        @endif

    </div>

</div>



<script>

function deleteComment(commentId) {
    if (confirm('Are you sure you want to delete this comment?')) {
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
                document.getElementById(`comment-${commentId}`).remove();
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
}


function editComment(commentId) {
    const commentText = document.getElementById(`comment-text-${commentId}`);
    const editForm = document.getElementById(`edit-form-${commentId}`);
    const commentActions = document.querySelector(`#comment-${commentId} .comment-actions`);
    
    commentText.style.display = 'none';
    editForm.style.display = 'block';
    commentActions.style.display = 'none';
}


function cancelEdit(commentId) {
    const commentText = document.getElementById(`comment-text-${commentId}`);
    const editForm = document.getElementById(`edit-form-${commentId}`);
    const commentActions = document.querySelector(`#comment-${commentId} .comment-actions`);
    
    commentText.style.display = 'block';
    editForm.style.display = 'none';
    commentActions.style.display = 'flex';
}


function saveEdit(commentId) {
    const newContent = document.getElementById(`edit-text-${commentId}`).value;
    
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
            document.getElementById(`comment-text-${commentId}`).textContent = newContent;
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
    const content = document.getElementById('comment-content').value;
    const newsId = {{ $news->id }};
    
    if (!content.trim()) {
        showToast('Write a comment', 'error');
        return;
    }
    
    fetch(`/news/${newsId}/comments`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ content: content })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showToast(data.message || 'Error adding', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error adding comment', 'error');
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
    }, 3000);
}
</script>

@endsection