<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    public function product()
    {
        return $this->belongsTo(RawMaterial::class, 'product_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'product_id');
    }

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Service::class, 'vendor_id');
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
