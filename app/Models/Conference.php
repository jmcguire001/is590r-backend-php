<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conference extends Model
{
    use HasFactory;

    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'conference_divisions', 'confId', 'divId');
    }      
}
