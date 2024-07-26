<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation:: morphMap([
    'Admin' => 'App\Models\Admin',
    'Employee' => 'App\Models\Employee',
]);
class Compliant extends Model
{
    use HasFactory;
    protected $table = 'complaints';
    protected $fillable = [ 'id', 'content'] ;

    public function compliantable(){
        return $this->morphTo();
    }
}
