<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class album extends Model {
    protected $primaryKey = 'albumID';
    protected $fillable =['NamaAlbum',
                        'deskripsi','tanggalDibuat','userID'];
    /**  
     * relasi one-to-one antara album n user
     * setiap album dimiliki oleh 1 user
     * relasi ini menggunakan foreign key 'userID'.
     */                    
    public function user() {
        return $this->belongsTo(User::class, 'userId');
    }

        /** 
         * relasi one-to-one antara album n photo
         * setiap album bisa memiliki banyak fto
        * relasi ini menggunakan foreign key 'albumID'.   
        */
    public function photos() {
        return $this->hasMany(Photo::class, 'albumID');
    }    
}