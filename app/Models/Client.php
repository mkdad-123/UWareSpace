<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = ['id' , 'name' , 'location' , 'client_email' , 'admin_id'];

    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
}
