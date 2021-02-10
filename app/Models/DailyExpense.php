<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyExpense extends Model
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

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'vendor_id');
    }

    public function cost_types()
    {
        return $this->belongsTo(CostType::class, 'product_id');
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
