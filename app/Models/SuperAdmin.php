<?php

namespace App\Models;
use Illuminate\Contracts\Auth\CanResetPassword as Resetable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin query()
 * @property int $id
 * @property string $name
 * @property string $email
 * @property mixed $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\SuperAdminFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SuperAdmin extends Authenticatable implements Resetable , JWTSubject
{
    use HasFactory, Notifiable , CanResetPassword;

    protected $fillable = [
        "email",
        "password",
        "name"
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts =[
     'password' => 'hashed'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
