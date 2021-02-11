<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;


    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function product()
    {
        return $this->hasMany(Expense::class, 'product_id');
    }

    public function vendor_expenses()
    {
        return $this->hasMany(Expense::class, 'vendor_id');
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
