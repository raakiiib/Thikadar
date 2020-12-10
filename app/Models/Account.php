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
        return $this->hasMany(Staff::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function materials()
    {
        return $this->hasMany(RawMaterial::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }


}
