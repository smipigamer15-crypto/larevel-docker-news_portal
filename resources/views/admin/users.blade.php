@extends('layouts.admin')

@section('content')

<h1 class="page-title">
   <i class="fa-solid fa-person"></i>
    Users
</h1>

<div class="table-card">

    <table class="admin-table">

        <thead>

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>

        </thead>

        <tbody>

            @foreach($users as $user)

            <tr>

                <td>{{ $user->id }}</td>

                <td>{{ $user->name }}</td>

                <td>{{ $user->email }}</td>

                <td>

                    @foreach($user->getRoleNames() as $role)

                        <span class="role-badge">
                            {{ $role }}
                        </span>

                    @endforeach

                </td>

                <td>
                    @if(Auth::user()->hasRole('admin'))
                <form action="{{ route('admin.users.role', $user->id) }}" method="POST" class="role-form">
            @csrf
    
    <select name="role" class="role-select">
        <option value="reader" {{ $user->hasRole('reader') ? 'selected' : '' }}>Reader</option>
        <option value="helper" {{ $user->hasRole('helper') ? 'selected' : '' }}>Helper</option>
        <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
    </select>
    
    <button type="submit" class="save-role-btn">
             Save
    </button>
                </form>
                    @else
                  <button class="no-permission-btn" onclick="showNoPermissionToast()">
                            <i class="fa-solid fa-lock"></i> No permission
                        </button>
                    @endif



                    
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection