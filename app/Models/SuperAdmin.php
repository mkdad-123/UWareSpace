<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin query()
 * @mixin \Eloquent
 */
class SuperAdmin extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        "email",
        "password",
        "name"
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

}
