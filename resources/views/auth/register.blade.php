<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Register</title>
</head>
<body>
    <h2 style="text-align: center;">Daftar Akun</h2>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <table style="margin: 50px auto;">
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" required autofokus></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" required></td>
            <tr>
                <td>Konfirmasi Password</td>
                <td><input type="password" name="password_confirmation" required></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">Daftar</button>
                </td>
            </tr>
</table>
</form>
<p style="text-align: center;">Sudah Punya Akun?
    <a href="{{ route('login') }}">Login Di Sini</a>
</p>
</body>
</html>