<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    // use notifiable
    protected $primaryKey = 'userID';
    protected $fillable = ['username', 'email', 'password',
    'namaLengkap', 'alamat'];
    protected $shidden = ['password', 'remember_token'];
}
