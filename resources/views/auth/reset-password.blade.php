{{-- resources/views/auth/reset-password.blade.php --}}

    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <!-- أضف هنا روابط CSS الخاصة بك -->
</head>
<body>
<div class="container">
    <h1> password reset</h1>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        {{-- حقل البريد الإلكتروني --}}
        <div class="form-group">
            <label for="email"> E-mail:</label>
            <input type="email" name="email" id="email" required autofocus>
        </div>

        {{-- حقل كلمة المرور الجديدة --}}
        <div class="form-group">
            <label for="password"> new password:</label>
            <input type="password" name="password" id="password" required>
        </div>

        {{-- حقل تأكيد كلمة المرور الجديدة --}}
        <div class="form-group">
            <label for="password_confirmation">  confirm a password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        {{-- حقل الـ token المخفي --}}
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="broker" value="{{ $broker }}">

        {{-- زر إرسال النموذج --}}
        <div class="form-group">
            <button type="submit">Password Reset</button>
        </div>
    </form>
</div>
</body>
</html>
