<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CmsPages extends Model
{
    use HasFactory;
    protected $fillable = ['title','type','is_enabled','feature_image','meta_description'];


    public function scopeStatus($query)
    {
        return $query->where('is_enabled', 1);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function getSlugAttribute()
    {
        $title = str_replace('?','', $this->title);
        return strtolower(str_replace(' ', '-', $title));
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function pageMeta()
    {
        return $this->hasMany(CmsPageMeta::class, 'cms_page_id', 'id');
    }

}
