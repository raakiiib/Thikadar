<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseService extends Model
{
    use SoftDeletes;

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }


    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? null, function ($query, $search){
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

