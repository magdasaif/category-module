<?php

namespace Modules\Category\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Traits\HasTranslate;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasTranslate,HasFactory,SoftDeletes;
    //=========================================================================================================
    protected $fillable = ['name_ar', 'name_en', 'slug', 'icon', 'active', 'description_ar', 'description_en', 'featured', 'type'];
    //=========================================================================================================    
    public function scopeActive(Builder $builder){
        $builder->where('active', true)->latest();
    }
    //=========================================================================================================
    public function scopeFeatured(Builder $builder){
        $builder->where('featured', true)->latest();
    }
    //=========================================================================================================
    public function scopeProductCategory(Builder $builder){
        $builder->where('type', 'product')->latest();
    }
    //=========================================================================================================
    public function scopeServiceCategory(Builder $builder){
        $builder->where('type', 'service')->latest();
    }
    //=========================================================================================================
    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }
}
