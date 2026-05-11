<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuplicateGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_code',
        'match_type',
        'confidence_score',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(DuplicateGroupItem::class);
    }

    public function mergeLogs()
    {
        return $this->hasMany(MergeLog::class);
    }
}
