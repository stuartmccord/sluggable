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
        $results = $this::where('slug', 'like', "{$this->slug}%")
            ->get();

        // doing this here as sqlite doesn't support regex out of the box
        $results = $results->filter(function ($model, $key) {
            return preg_match("/{$this->slug}(-[0-9]*)?$/", $model->slug);
        });

        return $results
            ->sortByDesc('id')
            ->pluck('slug')
            ->first();
    }
}
