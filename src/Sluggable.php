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
        $this->slug = str_slug($this->getSlugField());

        $latest_slug = $this->getLatestSlug();

        if ($latest_slug) {
            $pieces = explode('-', $latest_slug);

            $number = intval(end($pieces));

            $this->slug .= '-' . ($number + 1);
        }
    }

    public function getSlugField()
    {
        return $this->title;
    }

    public function getLatestSlug()
    {
        return $this::where('slug', 'regexp', "{$this->slug}(-[0-9]*)?$'")
            ->latest('id')
            ->pluck('slug')
            ->first();
    }
}
