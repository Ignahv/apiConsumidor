<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Tramite extends Model
{
    protected $table = 'tramites';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
    *
    */
    protected $fillable =[
        'idtramites',
        'estado',
        'fondo',
        'rbd'
    ];


}
