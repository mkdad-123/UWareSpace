<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property int $admin_id
 * @property string $name
 * @property string $email
 * @property string|null $location
 * @property string|null $latitude
 * @property string|null $longitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Note> $notes
 * @property-read int|null $notes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Phone> $phones
 * @property-read int|null $phones_count
 * @method static \Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'id' ,
        'name' ,
        'location' ,
        'email' ,
        'latitude',
        'longitude',
        'admin_id'
    ];

    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    public function warehousesByDistance()
    {
        return Warehouse::selectRaw("*, ( 6371 * acos( cos( radians(?) ) *
                   cos( radians( latitude ) )
                   * cos( radians( longitude ) - radians(?) )
                   + sin( radians(?) ) *
                   sin( radians( latitude ) ) ) ) AS distance", [
            $this->latitude, $this->longitude, $this->latitude
        ])->where('admin_id', $this->admin_id)
            ->orderBy('distance')
            ->get();
    }

}
