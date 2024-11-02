<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class HomeController extends Controller {
    // Menampilkan halaman utama dgn dftar fto
   public function index() {
    // ngambil smua fto untk ditampilkan di halamn home
    $photos = Photo::all();
    return view('home', compact('photos'));
   }
}    
   