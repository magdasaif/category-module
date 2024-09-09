<?php

namespace Modules\Category\Traits;

trait HasTranslate
{
     //=========================================================================================================
     public function getNameAttribute(){
        if (app('request')->header('locale') === 'en' || app()->getLocale() === 'en') {
            return $this->name_en;
        } else {
            return $this->name_ar;
        }
    }
    //=========================================================================================================
    public function getDescriptionAttribute(){
        if (app('request')->header('locale') === 'en' || app()->getLocale() === 'en') {
            return $this->description_en;
        } else {
            return $this->description_ar;
        }
    }
    //=========================================================================================================
}
