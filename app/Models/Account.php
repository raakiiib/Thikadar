<?php

namespace App\Models;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function suppliers()
    {
        return $this->hasmany(Supplier::class);
    }

    public function staffs()
    {
        return $this->hasMany(Staffs::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function materials()
    {
        return $this->hasMany(RawMaterial::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function purchase_services()
    {
        return $this->hasMany(PurchaseService::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function product()
    {
        return $this->hasMany(RawMaterial::class);
    }

    public function reports()
    {
        return $this->hasMany(Purchase::class);
    }

     public function beneficiary()
    {
        return $this->hasMany(Beneficiary::class);
    }

}
