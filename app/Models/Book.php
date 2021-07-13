<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'author',
        'description',
        'fk_users'
    ];

    public function user(){
        return $this->belongsTo(User::class,'fk_users');
    }
    public function reservationsBook(){
        return $this->belongsToMany(User::class, 'reservations', 'fk_book_reservation','fk_user_reservation')->withPivot('id','date_reservation', 'date_devolution');
    }
}
