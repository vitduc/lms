@extends('admin.layouts.app')

@section('title', 'Cập nhật người dùng')
@section('page-title', 'Cập nhật thông tin')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Người dùng</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
</ol>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Thông tin cơ bản</h3>
    </div>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Vai trò hiện tại</label>
                <div>
                    @forelse ($user->roles as $role)
                        <span class="badge badge-info">{{ ucfirst($role->name) }}</span>
                    @empty
                        <span class="text-muted">Chưa gán</span>
                    @endforelse
                </div>
                <small class="form-text text-muted">Tính năng gán vai trò sẽ bổ sung ở bước tiếp theo.</small>
            </div>
        </div>
        <div class="card-footer text-right">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Huỷ</a>
            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </div>
    </form>
</div>
@endsection

