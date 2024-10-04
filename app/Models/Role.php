<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'slug',
    ];
    
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
