@extends('admin.layouts.app')

@section('title', 'Người dùng')
@section('page-title', 'Quản lý người dùng')

@section('content')
<div class="card">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <h3 class="card-title mb-0">Danh sách người dùng</h3>
        <form method="GET" class="form-inline">
            <div class="input-group input-group-sm">
                <input type="text" name="q" class="form-control" placeholder="Tìm tên hoặc email" value="{{ $search }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày tạo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @forelse ($user->roles as $role)
                                <span class="badge badge-secondary">{{ ucfirst($role->name) }}</span>
                            @empty
                                <span class="text-muted">Chưa gán</span>
                            @endforelse
                        </td>
                        <td>{{ $user->created_at?->format('d/m/Y') }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-pen"></i> Sửa
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Không tìm thấy người dùng.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $users->links() }}
    </div>
</div>
@endsection

