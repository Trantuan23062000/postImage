@component('mail::message')
# Xác Nhận Email

Bạn nhận được email này vì yêu cầu cập nhật mật khẩu cho tài khoản của bạn.

@component('mail::button', ['url' => route('reset-password', ['email' => $user->email, 'token' => $token])])
Xác Nhận Email
@endcomponent

Nếu bạn không thực hiện yêu cầu này, bạn có thể bỏ qua email này.

Cảm ơn,<br>
@endcomponent
