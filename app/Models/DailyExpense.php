<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class DailyExpense extends Model
{
    use SoftDeletes;

    public function material()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
