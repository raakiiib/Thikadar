<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


class RawMaterial extends Model
{
    use SoftDeletes;

    public function supplier()
    {
        return $this->hasMany(Supplier::class);
    }

    public function material_expenses()
    {
        return $this->hasMany(Expense::class, 'product_id');
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
