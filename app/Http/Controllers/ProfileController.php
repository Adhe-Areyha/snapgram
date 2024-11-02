<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {
    public function index() {
        $user = Auth::user();
        return view('profile', compact('user')); 
}

public function update(Request $request) {
    // update user profile
    // mendapatkan user yg sdg login
    $user = Auth::user();
    // melakukn validasi input yg dkrmkn dri form
    $request->validate([
        // username wajib diisi, hrs string,
        //dan maksimal 255 karakter
        'username' => 'required|string|max:255',
        // email wajib diisi, hrs string,
        // hrs format email valid, n maksimal 255 karakter
        'email' => 'required|string|max:255',
        // pass boleh tdk diisi (nullable),
        // minim 8 karakter,
        // n hrs dikonformasi dgn password_confirmation
        'password' => 'nullable|string|min:8|confirmed',
    ]);
    // memperbarui atribut user dgn input yg valid
    $user->username = $request->username;
    $user->namaLengkap = $request->namaLengkap;
    $user->email = $request->email;
    
    if ($request->filled('password')) {

        $user->password = Hash::make($request->password);
    }
    // menyimpan perubahan profile user k db
    $user->save();
    // mengarahkn kmbli pengguna ke hlmn profile
    // stlh update brhsil
    return redirect()->route('profile.index');
}
}