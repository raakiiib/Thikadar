<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    // Material Info
    public function getMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'product_id');
    }

    public function getService()
    {
        return $this->belongsTo(Service::class, 'product_id');
    }

    public function material_expenses()
    {
        return $this->belongsTo(RawMaterial::class, 'product_id');
    }

    public function service_expenses()
    {
        return $this->belongsTo(Service::class, 'product_id');
    }

    public function vendor_expenses()
    {
        return $this->belongsTo(Supplier::class, 'vendor_id');
    }

    // Service Info
    public function service()
    {
        return $this->belongsTo(Service::class, 'product_id');
    }

    // Expense type
    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'product_id');
    }

    // Beneficiary info
    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class, 'product_id');
    }

    // Supplier info
    public function getSupplier()
    {
        return $this->belongsTo(Supplier::class, 'vendor_id');
    }

    public function cost_types()
    {
        return $this->belongsTo(CostType::class, 'product_id');
    }

    // Payments
    public function payments()
    {
        return $this->hasMany(Payment::class, 'expense_id');
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
