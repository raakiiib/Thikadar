<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use League\Glide\Server;

class Staffs extends Model
{
    use SoftDeletes;

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

    public function photoUrl(array $attributes)
    {
        if ($this->photo_path) {
            return URL::to(App::make(Server::class)->fromPath($this->photo_path, $attributes));
        }
    }
}

