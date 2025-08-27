@component('mail::message')
# Selamat Datang, {{ $user->name }}

Akun Anda untuk Sistem Informasi RT telah dibuat. Berikut informasi login:

- **NIK**: {{ $user->nik }}
- **Username (email)**: {{ $user->email ?? '-' }}
- **Password**: {{ $password }}

Silakan login dan ubah password Anda setelah masuk.

@component('mail::button', ['url' => route('login')])
Login Sekarang
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
