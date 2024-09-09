<?php

namespace Modules\Category\Traits;

use Illuminate\Support\Str;

trait GeneralTrait
{
    //===================================================================================
    public function handleCategoryRequest($request){
        return $request->input() + ['slug' => Str::slug($request->name_en).'_category'];
    }
    //===================================================================================
}
