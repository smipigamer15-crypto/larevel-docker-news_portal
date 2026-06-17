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

    <div class="dashboard-card graph-card">

        <h3>News Views</h3>

        <canvas id="viewsChart"></canvas>

    </div>

    <div class="dashboard-card">

        <h3>Users</h3>

        @foreach($users as $user)

            <div class="user-row">
                <div class="avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <div>
                    <strong>{{ $user->name }}</strong>
                    <p>{{ $user->email }}</p>
                </div>
            </div>

        @endforeach

    </div>

</div>

<div class="dashboard-card">

    <h3>Latest News</h3>

    <table class="news-table">

        <thead>

            <tr>
                <th>News</th>
                <th>Category</th>
                <th>Views</th>
                <th>Date</th>
            </tr>

        </thead>

        <tbody>

            @foreach($latestNews as $news)

            <tr>

                <td>

                    <div class="news-info">

                        <img src="{{ asset('storage/'.$news->image) }}">

                        <span>
                            {{ $news->title }}
                        </span>

                    </div>

                </td>

                <td>

                    <span class="category-badge">
                        {{ $news->category }}
                    </span>

                </td>

                <td>{{ $news->views }}</td>

                <td>
                    {{ $news->created_at->format('d.m.Y H:i') }}
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
document.getElementById('viewsChart'),
{
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            label: 'Views',
            data: @json($viewsData),
            fill: true,
            tension: 0.4,
            backgroundColor: 'rgba(107, 60, 161, 0.45)',
            borderColor: '#8b5cf6',
            borderWidth: 2,
            pointBackgroundColor: '#8b5cf6',
            pointBorderColor: '#fff',
            pointRadius: 4,
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
        
    }
});

</script>

@endsection