document.addEventListener('DOMContentLoaded', function() {
    const searchWrapper = document.getElementById('searchWrapper');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');

    if (!searchWrapper || !searchBtn) return;

    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
        searchWrapper.classList.remove('active');
        searchBtn.setAttribute('type', 'submit');
    } else {
        searchBtn.setAttribute('type', 'button');
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            searchWrapper.classList.toggle('active');
            if (searchWrapper.classList.contains('active')) {
                setTimeout(() => searchInput.focus(), 200);
            } else {
                searchInput.blur();
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            navMenu.classList.toggle('show');
            this.innerHTML = navMenu.classList.contains('show') ?
                '<i class="fas fa-times"></i>' :
                '<i class="fas fa-bars"></i>';
        });
    }
});


const input = document.getElementById('searchInput');
const results = document.getElementById('searchResults');

if (input && results) {
    input.addEventListener('keyup', async function() {
        const query = this.value.trim();
        if (query.length < 2) {
            results.style.display = 'none';
            return;
        }
        try {
            const response = await fetch(`/search/live?q=${encodeURIComponent(query)}`);
            const news = await response.json();
            results.innerHTML = '';
            if (news.length === 0) {
                results.style.display = 'none';
                return;
            }
            news.forEach(item => {
                results.innerHTML += `
                    <a href="/news/${item.id}" class="search-item">
                        ${item.title}
                    </a>
                `;
            });
            results.style.display = 'block';
        } catch(error) {
            console.error(error);
        }
    });
}


document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.popular-card');

    if (buttons.length && cards.length) {
        function filterPosts(category) {
            let shown = 0;
            cards.forEach(card => {
                const cardCategory = card.dataset.category;
                const match = category === 'all' || cardCategory === category;
                if (match && shown < 4) {
                    card.style.display = '';
                    shown++;
                } else {
                    card.style.display = 'none';
                }
            });
        }

        buttons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                buttons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                filterPosts(button.dataset.category);
            });
        });

        filterPosts('all');
    }
});


document.getElementById('saveForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const form = this;
    const btn = document.getElementById('saveBtn');
    const textSpan = document.getElementById('saveText');
    const icon = btn.querySelector('i');
    btn.style.opacity = '0.7';
    btn.style.pointerEvents = 'none';
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(form)
        });
        const data = await response.json();
        if (data.saved) {
            btn.classList.add('saved');
            textSpan.textContent = 'Saved';
            icon.className = 'fa-solid fa-bookmark';
            showToast('News saved!', 'success');
        } else {
            btn.classList.remove('saved');
            textSpan.textContent = 'Save';
            icon.className = 'fa-regular fa-bookmark';
            showToast('Removed from saved', 'info');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('An error occurred', 'error');
    } finally {
        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
    }
});

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <i class="fa-solid ${type === 'success' ? 'fa-check-circle' : type === 'info' ? 'fa-info-circle' : 'fa-exclamation-circle'}"></i>
        <span>${message}</span>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}


function deleteComment(commentId) {
    if (confirm('Are you sure you want to delete this comment?')) {
        fetch(`/comment/${commentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showToast('Error deleting', 'error');
            }
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
    const content = document.getElementById('comment-content');
    if (!content.value.trim()) {
        showToast('Please write a comment.', 'error');
        return;
    }

    const newsId = document.querySelector('meta[name="news-id"]')?.content;
    if (!newsId) {
        showToast('Error: news not found.', 'error');
        return;
    }

    fetch('/comments', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            news_id: newsId,
            content: content.value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showToast(data.message || 'Error posting comment.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error posting comment.', 'error');
    });
}