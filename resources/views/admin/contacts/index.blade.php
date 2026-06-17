@extends('layouts.admin')

@section('content')
<div class="contacts-admin">
    
    <div class="contacts-header">
        <h1>
            <i class="fa-solid fa-envelope"></i> 
            Messages
        </h1>
        
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="new">
                New 
                @php $newCount = \App\Models\Contact::where('status', 'new')->count(); @endphp
                @if($newCount > 0)
                    <span class="count-badge">{{ $newCount }}</span>
                @endif
            </button>
            <button class="filter-btn" data-filter="read">Read</button>
            <button class="filter-btn" data-filter="replied">Replied</button>
        </div>
    </div>

    <div class="contacts-table-wrapper">
        <table class="contacts-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Subject</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr data-status="{{ $contact->status }}" 
                    data-id="{{ $contact->id }}"
                    data-user-name="{{ $contact->user->name }}"
                    data-user-email="{{ $contact->user->email }}"
                    data-subject="{{ $contact->subject }}"
                    data-message="{{ $contact->message }}"
                    data-topic="{{ $contact->topic_label }}"
                    data-status-label="{{ $contact->status_label }}"
                    data-created="{{ $contact->created_at->format('d.m.Y H:i') }}">
                    
                    <td><strong>#{{ $contact->id }}</strong></td>
                    <td class="user-info-cell">
                        <div class="user-info">
                            <div class="user-avatar">
                                {{ strtoupper(substr($contact->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="user-name">{{ $contact->user->name }}</div>
                                <div class="user-email">{{ $contact->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="subject-cell">
                        <div class="subject-preview">
                            {{ Str::limit($contact->subject, 50) }}
                        </div>
                    </td>
                    <td class="category-cell">
                        <span class="topic-badge">
                            {{ $contact->topic_label }}
                        </span>
                    </td>
                    <td class="status-cell">
                        <span class="status-badge status-{{ $contact->status }}">
                            {{ $contact->status_label }}
                        </span>
                    </td>
                    <td class="date-cell">
                        <div class="date-cell">
                            {{ $contact->created_at->format('d.m.Y') }}
                            <span class="time">{{ $contact->created_at->format('H:i') }}</span>
                        </div>
                    </td>
                    <td class="actions-cell">
                        {{-- Mark as read button --}}
                        <button class="btn-icon btn-mark-read" 
                                onclick="markAsRead({{ $contact->id }}, this)" 
                                title="Mark as read"
                                {{ $contact->status == 'read' || $contact->status == 'replied' ? 'disabled' : '' }}>
                            <i class="fa-solid fa-check"></i>
                        </button>
                        
                        {{-- View details button --}}
                        <button class="btn-icon btn-view-details" 
                                onclick='showMessageDetails(this.closest("tr"))' 
                                title="View message details">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </button>
                        
                        {{-- Reply button --}}
                        <a href="mailto:{{ $contact->user->email }}" class="btn-icon btn-reply" title="Reply">
                            <i class="fa-solid fa-reply"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 60px;">
                        <i class="fa-solid fa-inbox" style="font-size: 48px; color: #475569; margin-bottom: 15px; display: block;"></i>
                        <p style="color: #64748b;">No messages</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $contacts->links() }}
    </div>
</div>

{{-- Modal window for detailed view --}}
<div id="messageModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>
                <i class="fa-solid fa-envelope-open-text"></i>
                Message Details
            </h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body" id="modalBody">
         
        </div>
    </div>
</div>

<script>

function markAsRead(id, button) {
    fetch(`/admin/contacts/${id}/mark-as-read`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = button.closest('tr');
            const statusBadge = row.querySelector('.status-badge');
            statusBadge.textContent = 'Read';
            statusBadge.className = 'status-badge status-read';
            
            button.disabled = true;
            button.style.opacity = '0.5';
            
            showToast('Message marked as read');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error updating status', 'error');
    });
}


function showMessageDetails(row) {
    const data = {
        id: row.dataset.id,
        user_name: row.dataset.userName,
        user_email: row.dataset.userEmail,
        subject: row.dataset.subject,
        message: row.dataset.message,
        topic_label: row.dataset.topic,
        status: row.dataset.status,
        status_label: row.dataset.statusLabel,
        created_at: row.dataset.created
    };
    
    const modal = document.getElementById('messageModal');
    const modalBody = document.getElementById('modalBody');
    
    modalBody.innerHTML = `
        <div class="message-detail">
            <label><i class="fa-solid fa-user"></i> From user</label>
            <div class="detail-card">
                <strong>${escapeHtml(data.user_name)}</strong>
                <span>${escapeHtml(data.user_email)}</span>
            </div>
        </div>
        
        <div class="message-detail">
            <label><i class="fa-solid fa-heading"></i> Subject</label>
            <div class="detail-card">${escapeHtml(data.subject)}</div>
        </div>
        
        <div class="message-detail">
            <label><i class="fa-solid fa-tag"></i> Category</label>
            <div class="detail-card">${escapeHtml(data.topic_label)}</div>
        </div>
        
        <div class="message-detail">
            <label><i class="fa-solid fa-comment"></i> Message content</label>
            <div class="message-text">${escapeHtml(data.message).replace(/\n/g, '<br>')}</div>
        </div>
        
        <div class="message-detail">
            <label><i class="fa-solid fa-flag-checkered"></i> Status</label>
            <div class="detail-card">
                <span class="status-badge status-${data.status}">${escapeHtml(data.status_label)}</span>
            </div>
        </div>
        
        <div class="message-detail">
            <label><i class="fa-solid fa-calendar"></i> Received date</label>
            <div class="detail-card">${escapeHtml(data.created_at)}</div>
        </div>
        
        <form method="POST" action="/admin/contacts/${data.id}/status" class="status-form" onsubmit="return updateStatus(event, ${data.id})">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PATCH"> 
        </form>
        
        <div class="modal-actions">
            <a href="mailto:${escapeHtml(data.user_email)}" class="btn-reply-email">
                <i class="fa-solid fa-reply"></i> Reply by email
            </a>
        </div>
    `;
    
    modal.classList.add('active');
}

function updateStatus(event, id) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    
    fetch(`/admin/contacts/${id}/status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Status updated');
            setTimeout(() => location.reload(), 1000);
        }
    })
    .catch(error => {
        showToast('Error updating status', 'error');
    });
    
    return false;
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function closeModal() {
    document.getElementById('messageModal').classList.remove('active');
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


document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const filter = this.dataset.filter;
        
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        document.querySelectorAll('.contacts-table tbody tr').forEach(row => {
            if (filter === 'all' || row.dataset.status === filter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});

window.onclick = function(event) {
    const modal = document.getElementById('messageModal');
    if (event.target === modal) {
        closeModal();
    }
}
</script>
@endsection