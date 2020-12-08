<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class RawMaterial extends Model
{
    use SoftDeletes;

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? null, function ($query, $search){
            $query->where('product_name', 'like', '%'.$search.'%');
        });

    }
}
