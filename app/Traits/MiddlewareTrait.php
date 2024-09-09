<?php

namespace Modules\Category\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

trait MiddlewareTrait
{
    //===================================================================================
    public function checkMiddlewareApply(){
        $middleware_setting=Config::get('category.middleware');
        if($middleware_setting['allow_middleware']){
            return $middleware_setting['list_of_middlewares'];
        }else{
            return [];
        }
    }
    //===================================================================================
}
