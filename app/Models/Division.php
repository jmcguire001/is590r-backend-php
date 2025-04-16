<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Division extends Model
{
    use HasFactory;

    public function conferences(): BelongsToMany
    {
        return $this->belongsToMany(Conference::class, 'conference_divisions', 'divId', 'confId');
    }  
}
