<?php

namespace Stuartmccord\Sluggable;


trait Sluggable
{
    public static function bootSluggable()
    {
        static::creating(function ($model) {
            $model->setSlug();
        });
    }

    public function setSlug()
    {
        $this->slug = str_slug($this->title);

        $latest_slug =
            $this::whereRaw("slug RLIKE '^{$this->slug}(-[0-9]*)?$'")
                ->latest('id')
                ->pluck('slug');

        if (isset($latest_slug)) {
            $pieces = explode('-', $latest_slug);

            $number = intval(end($pieces));

            $this->slug .= '-' . ($number + 1);
        }
    }
}