<?php

namespace Stuartmccord\Sluggable;

use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
