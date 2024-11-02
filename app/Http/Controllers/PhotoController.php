<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Album;
use App\Models\Photo;
use App\Models\LikePhoto;
use App\Models\Comment; // tambhkn import modal comment
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller{

    public function index(Album $album ) {
        $album->load('photos');
        return view('photos.index', compact('album'));
}
public function create() {
    $albums = Album::where('userID', auth()->id())->get();
    return view('photos.create', compact('albums'));
}
public function store(Request $request) {
$request->validate([
    'photo' => 'required|image|max:2048',
    'judulFoto' => 'required|string|max:255',
    'description' => 'nullable|string|max:255',
    'albumID' => 'required|exists:albums,albumID',
]);
$photo = $request->file('photo');
$path = $photo->store('photos', 'public');

Photo::create([
    'userID' => auth()->id(),
    'lokasiFile' => $path,
    'judulFoto' => $request->judulFoto,
    'deskripsiFoto' => $request->description,
    'tanggalUnggah' => now(),
    'albumID' => $request->albumID,
]);
return redirect()->route('home');
}
public function show(Photo $photo) {

}
public function edit(Photo $photo) {
if ($photo->userID !== Auth::id()) {
    abort(403, 'Unauthorized action.');
}
$albums = Album::where('userID', Auth::id())->get();
return view('photos.edit', compact('photo', 'albums'));
}
public function update(Request $request, Photo $photo) {
if ($photo->userID !== Auth::id()) {
    abort(403, 'Unauthorized action.');
}
$request->validate([
    'judulFoto' => 'required|string|max:255',
    'description' => 'nullable|string|max:255',
]);
 // jika ad fto bru, validasi n simpan fto bru
 if ($request->hasFile('photo')) {
    // validasi fto bru
    $request->validate(['photo' => 'image|max:2048']);
    // menghapus fto lama dri storage
    Storage::delete($photo->lokasiFile);
    // menyimpan fto bru
    $path = $request->file('photo')->store('photos', 'public');
    // mengupdate path fto
    $photo->lokasiFile =$path;
}
// mengupdate informasi judul n deskripsi fto
$photo->judulFoto = $request->judulFoto;
$photo->deskripsiFoto = $request->description;
// menyimpan perubahan d db
$photo->save();
// mengalihkan penguguna kmbli ke album fto stlh brhasil diupdate
return redirect()->route('albums.photos', $photo->albumID);
}
public function destroy(Photo $photo) {
if ($photo->userID !== Auth::id()) {
    abort(403, 'Unauthorized action.');
}
Storage::delete($photo->lokasiFile);
$photo->delete();
return redirect()->route('albums.photos', $photo->albumID);
}
public function like(Photo $photo) {
if ($photo->isLikedByAuthUser()){
    $photo->likes()->where('userID', Auth::user()->userID)->delete();
} else {
    $photo->likes()->create([
        'userID' => Auth::user()->userID,
        'fotoID' => $photo->fotoID,
        'tanggalLike' => now(),
    ]);
}
return redirect()->route('home');
}
public function showComments(Photo $photo) {
$photo->load('comments.user');
return view('photos.comment', compact('photo'));
}
public function storeComment(Request $request, Photo $photo) {
$request->validate([
    'isiKomentar' => 'required|string|max:200',
]);
Comment::create([
    'isiKomentar' => $request->isiKomentar,
    'fotoID' => $photo->fotoID, 
    'userID' => Auth::id(),
]);
return redirect()->route('photos.comments', $photo);
}
}