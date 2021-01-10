<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    public function products()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function services()
    {
        return $this->belongsTo(Service::class);
    }

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'product_id');
        // return $this->belongsTo('App\VocType', 'type_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
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
