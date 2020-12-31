<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    public function material()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? null, function ($query, $search){
            $query->where('created_at', 'like', '%'.$search.'%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });

    }
}

