<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 *
 *
 * @property int $id
 * @property string $phoneable_type
 * @property int $phoneable_id
 * @property string $number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $phoneable
 * @method static \Illuminate\Database\Eloquent\Builder|Phone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Phone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Phone query()
 * @method static \Illuminate\Database\Eloquent\Builder|Phone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Phone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Phone whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Phone wherePhoneableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Phone wherePhoneableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Phone whereUpdatedAt($value)
 * @mixin \Eloquent
 */
Relation:: morphMap([
    'Admin' => 'App\Models\Admin',
    'Employee' => 'App\Models\Employee',
    'Client'  => 'App\Models\Client',
    'Supplier' => 'App\Models\Supplier'
]);

class Phone extends Model

{
    use HasFactory;

    protected $fillable = ['number'];

    public function phoneable(): MorphTo
    {
        return $this->morphTo();
    }
}
