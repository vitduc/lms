@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Tổng quan hệ thống')

@section('content')
<div class="row">
    @php
        $statCards = [
            ['label' => 'Học viên', 'value' => $stats['students'] ?? 0, 'icon' => 'fa-user-graduate', 'color' => 'bg-primary'],
            ['label' => 'Giảng viên', 'value' => $stats['instructors'] ?? 0, 'icon' => 'fa-chalkboard-teacher', 'color' => 'bg-success'],
            ['label' => 'Khoá học', 'value' => $stats['courses'] ?? 0, 'icon' => 'fa-book', 'color' => 'bg-warning'],
            ['label' => 'Ghi danh', 'value' => $stats['activeEnrollments'] ?? 0, 'icon' => 'fa-users', 'color' => 'bg-danger'],
        ];
    @endphp

    @foreach ($statCards as $card)
        <div class="col-lg-3 col-6">
            <div class="small-box {{ $card['color'] }}">
                <div class="inner">
                    <h3>{{ $card['value'] }}</h3>
                    <p>{{ $card['label'] }}</p>
                </div>
                <div class="icon">
                    <i class="fas {{ $card['icon'] }}"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Người dùng mới nhất</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Vai trò</th>
                            <th>Đăng ký</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge badge-info">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $user->created_at?->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Chưa có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">Ghi chú nhanh</h3>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">🎯 Triển khai CRUD khoá học</li>
                    <li class="list-group-item">🧑‍🏫 Duyệt hồ sơ giảng viên mới</li>
                    <li class="list-group-item">📢 Thiết lập luồng thông báo bài học</li>
                    <li class="list-group-item">💳 Hoàn thiện tích hợp thanh toán</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

