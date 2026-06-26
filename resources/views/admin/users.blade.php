@extends('layouts.admin')

@section('content')

<div class="dashboard">
    <div class="dashboard-header">
        <h1>
            <i class="fa-solid fa-users"></i> Users
        </h1>
        <p>Manage all registered users and their roles</p>
    </div>

    <div class="dashboard-card">
        <div class="users-header">
            <h3>
                <i class="fa-solid fa-user-group"></i> All Users
                <span class="users-count">{{ $users->count() }}</span>
            </h3>
        </div>

        <div class="table-scroll-wrapper">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <span class="user-id">#{{ $user->id }}</span>
                            </td>
                            <td>
                                <div class="user-info">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/'.$user->avatar) }}" 
                                             alt="{{ $user->name }}" 
                                             style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <div class="user-avatar-small" style="background: #8b5cf6;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="user-name">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="user-email">{{ $user->email }}</span>
                            </td>
                            <td>
                                @php
                                    $userRole = $user->getRoleNames()->first() ?? 'reader';
                                    $roleLabels = [
                                        'admin' => 'Admin',
                                        'helper' => 'Helper',
                                        'reader' => 'Reader',
                                    ];
                                    $roleLabel = $roleLabels[$userRole] ?? 'Reader';
                                @endphp
                                <span class="role-badge">
                                    <i class="fa-solid fa-user"></i>
                                    {{ $roleLabel }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.users.role', $user->id) }}" method="POST" class="role-form">
                                    @csrf
                                    <select name="role" class="role-select">
                                        <option value="admin" {{ $userRole == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="helper" {{ $userRole == 'helper' ? 'selected' : '' }}>Helper</option>
                                        <option value="reader" {{ $userRole == 'reader' ? 'selected' : '' }}>Reader</option>
                                    </select>
                                    <button type="submit" class="save-role-btn">
                                        <i class="fa-solid fa-check"></i> Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-cell">
                                <div class="empty-state">
                                    <i class="fa-solid fa-users-slash"></i>
                                    <p>No users registered yet</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection