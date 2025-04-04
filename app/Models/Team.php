<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    const UPDATED_AT = null; // Disable updated_at column

    protected $fillable = [
        'name',
        'abbr',
        'logo',
        'confId',
        'divId',
        'city',
        'state',
        'country',
        'stadium',
        'mascot',
        'created_at'
    ];

    // public $name = 'teams'; <-- Laravel will automatically use lowercase plural form of model name as table name

    public function conference(): HasOne{
        return $this->hasOne(related: Conference::class, foreignKey: 'id', localKey: 'confId');
    }
}