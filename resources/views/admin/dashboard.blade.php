@extends('layouts.admin')

@section('content')

<div class="dashboard">

    <div class="dashboard-header">
        <div>
            <h1>
                <i class="fa-solid fa-chart-simple"></i>
                Statistics
            </h1>
            <p>Overview of key site metrics</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card purple">
            <h4>Total Posts</h4>
            <h2>{{ $postsCount }}</h2>
        </div>
        <div class="stat-card blue">
            <h4>Views</h4>
            <h2>{{ number_format($viewsCount) }}</h2>
        </div>
        <div class="stat-card green">
            <h4>Users</h4>
            <h2>{{ $usersCount }}</h2>
        </div>
        <div class="stat-card orange">
            <h4>Comments</h4>
            <h2>{{ $commentsCount }}</h2>
        </div>
    </div>

    <div class="dashboard-row">

        {{-- GRAPH --}}
        <div class="dashboard-card graph-card">
            <h3><i class="fa-solid fa-chart-line"></i> News Views</h3>
            <div class="graph-wrapper">
                <canvas id="viewsChart"></canvas>
            </div>
        </div>

        {{-- USERS --}}
        <div class="dashboard-card users-card">
            <div class="card-header-with-btn">
                <h3><i class="fa-solid fa-users"></i> Users</h3>
                @if($users->count() > 4)
                    <button class="view-more-btn" onclick="toggleUsers()">
                        <i class="fa-regular fa-eye" id="toggleIcon"></i>
                        <span id="toggleText">View more</span>
                        <span class="user-count-badge">{{ $users->count() }}</span>
                    </button>
                @endif
            </div>

            <div class="users-list" id="usersList">
                @foreach($users->take(4) as $user)
                    <div class="user-row">
                        @if($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" 
                                 alt="{{ $user->name }}" 
                                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        @else
                            <div class="avatar purple-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <strong>{{ $user->name }}</strong>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>
                @endforeach

                @if($users->count() > 4)
                    <div id="extraUsers" style="display: none;">
                        @foreach($users->skip(4) as $user)
                            <div class="user-row">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/'.$user->avatar) }}" 
                                         alt="{{ $user->name }}" 
                                         style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                @else
                                    <div class="avatar purple-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    <p>{{ $user->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- LATEST NEWS --}}
    <div class="dashboard-card">
        <h3><i class="fa-solid fa-newspaper"></i> Latest News</h3>

        <div class="table-scroll-wrapper">
            <table class="news-table">
                <thead>
                    <tr>
                        <th>News</th>
                        <th>Category</th>
                        <th>Views</th>
                        <th>Likes</th>
                        <th>Comments</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestNews as $news)
                    <tr>
                        <td>
                            <div class="news-info">
                                <img src="{{ asset('storage/'.$news->image) }}" alt="{{ $news->title }}">
                                <span>{{ $news->title }}</span>
                            </div>
                        </td>
                        <td><span class="category-badge">{{ $news->category }}</span></td>
                        <td>{{ $news->views ?? 0 }}</td>
                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 4px; color: #e4e4e7;">
                                <i class="fa-regular fa-heart" style="color: #ef4444;"></i>
                                {{ $news->likes_count ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 4px; color: #e4e4e7;">
                                <i class="fa-regular fa-comment" style="color: #8b5cf6;"></i>
                                {{ $news->comments->count() ?? 0 }}
                            </span>
                        </td>
                        <td>{{ $news->created_at->format('d.m.Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('viewsChart');
    
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Views',
                    data: @json($viewsData),
                    fill: true,
                    tension: 0.4,
                    backgroundColor: 'rgba(139,92,246,0.2)',
                    borderColor: '#8b5cf6',
                    borderWidth: 2,
                    pointBackgroundColor: '#8b5cf6',
                    pointBorderColor: '#fff',
                    pointRadius: 3,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Views: ' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#94a3b8' },
                        grid: { color: 'rgba(255,255,255,0.04)' }
                    },
                    y: {
                        ticks: { color: '#94a3b8' },
                        grid: { color: 'rgba(255,255,255,0.04)' }
                    }
                }
            }
        });
    }
});

function toggleUsers() {
    const extraUsers = document.getElementById('extraUsers');
    const toggleText = document.getElementById('toggleText');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (extraUsers) {
        if (extraUsers.style.display === 'none') {
            extraUsers.style.display = 'block';
            toggleText.textContent = 'Show less';
            toggleIcon.className = 'fa-regular fa-eye-slash';
        } else {
            extraUsers.style.display = 'none';
            toggleText.textContent = 'View more';
            toggleIcon.className = 'fa-regular fa-eye';
        }
    }
}
</script>

@endsection