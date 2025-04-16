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

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class, 'confId', 'id');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class, 'divId', 'id');
    }

    public function sponsors(): BelongsToMany
    {
        return $this->belongsToMany(Sponsors::class, 'team_sponsors', 'teamId', 'sponsorId');
    }

    public function stadium(): BelongsTo
    {
        return $this->belongsTo(Stadium::class, 'stadium', 'id')->withDefault();
    }    
}