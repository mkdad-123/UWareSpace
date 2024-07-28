<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $fillable = ['id' , 'name' , 'location' , 'suppliers_email' , 'admin_id'];

    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
}
