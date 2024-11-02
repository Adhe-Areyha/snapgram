<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm() {
        return view('auth.login');
    }

    // Menghandle postLogin (proses login pengguna)
    public function postLogin(Request $request) {
        // Validasi input dari form login.
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $credentials = $request->only('username', 'password');

        // Mengecek kredensial login menggunakan Auth::attempt.
        if (Auth::attempt($credentials)) {
            return redirect()->route('home')->with('success', 'Anda berhasil login.');
        }

        // Jika login gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    // Menampilkan halaman registrasi
    public function showRegistrationForm() {
        return view('auth.register');
    }

    // Proses registrasi
    public function register(Request $request) {
        $request->validate([
            'username' => 'required|string|unique:users,username|max:255', // Memperbaiki validasi
            'password' => 'required|string|confirmed|min:8',
        ]);
        
        // Membuat pengguna baru
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), // Hashing password
        ]);
        
        // Setelah registrasi berhasil
        return redirect()->route('login')->with('success', 'Anda berhasil mendaftar, silakan login.');
    }

    // Menghandle proses logout
    public function logout(Request $request) {
        // Mengeluarkan pengguna dari sesi (proses logout).
        Auth::logout();
        
        // Setelah logout, pengguna akan diarahkan kembali ke halaman login
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}