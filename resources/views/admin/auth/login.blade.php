<form method="POST" action="{{ route('admin.handleLogin') }}">
    @csrf

    <!-- Thêm các trường email và password cho đăng nhập -->
    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <button type="submit">Đăng nhập</button>
</form>
