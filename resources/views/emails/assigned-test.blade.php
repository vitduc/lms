<h2>Xin chào {{ $user->name }},</h2>

<p>Bạn vừa được gán bài kiểm tra mới:</p>

<p>
    <strong>{{ $test->title }}</strong><br>
    Mô tả: {{ $test->description }}<br>
    Hạn nộp: {{ $test->deadline->format('d/m/Y H:i') }}
</p>

<p>Hãy đăng nhập và làm bài sớm nhất có thể.</p>

<p>Trân trọng,<br>LMS Team</p>
