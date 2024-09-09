<div class="card-content">
    <input type="hidden" name="id" value="{{ isset($category) ? $category->id : null }}">
  
    <!-- -------------------- name ar ------------------------------- -->
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label required">اسم التصنيف</label>
      </div>
      <div class="field-body">
        <div class="field">
          <div class="control">
            <input type="text" name="name_ar" class="input" @if(isset($category)) value="{{ $category->name_ar }}" @else value="{{old('name_ar')}}" @endif required>
          </div>
        </div>
      </div>
    </div>
    <!-- ------------------------------------------------------------ -->
    <!-- -------------------- name ar ------------------------------- -->
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label required">اسم التصنيف بالانجليزية </label>
      </div>
      <div class="field-body">
        <div class="field">
          <div class="control">
            <input type="text" name="name_en" class="input" @if(isset($category)) value="{{ $category->name_en }}" @else value="{{old('name_en')}}"  @endif required>
          </div>
        </div>
      </div>
    </div>
    <!-- ------------------------------------------------------------- -->
    <!-- -------------------- active --------------------------------- -->
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label required">الحالة</label>
      </div>
      <div class="field-body">
        <div class="field">
          <div class="control">
            <label class="radio">
              <input type="radio" name="active" value="1" @if(isset($category) && $category->active) checked @else checked @endif>
              مفعل {{old('active')}}
            </label>
            <label class="radio">
              <input type="radio" name="active" value="0" @if(isset($category) && !$category->active)  checked  @endif>
              غير مفعل {{old('active')}}
            </label>
          </div>
        </div>
      </div>
    </div>
    <!-- ------------------------------------------------------------- -->
    <!-- -------------------- show on home --------------------------- -->
    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label required">اظهار في الرئيسية</label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <label class="radio">
                        <input type="radio" name="featured" value="1" @if(isset($category) && $category->featured) checked @else checked @endif>
                        اظهار
                    </label>
                    <label class="radio">
                        <input type="radio" name="featured" value="0" @if(isset($category) && !$category->featured) checked  @endif>
                         اخفاء
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- ------------------------------------------------------------- -->
    <!-- -------------------- type------------------------------------ -->
    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label required">النوع</label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <label class="radio">
                        <input type="radio" name="type" value="product" @if(isset($category) && $category->type == 'product') checked @else checked @endif>
                         منتجات
                    </label>
                    <label class="radio">
                        <input type="radio" name="type" value="service" @if(isset($category) && $category->type == 'service') checked  @endif>
                         خدمات
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- ------------------------------------------------------------- -->
    <!-- ------------------------- icon------------------------------- -->
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label required">ايقونة التصنيف</label>
      </div>
      <div class="field-body">
        <div class="field">
          <div class="control">
            {{--<input type="text" id="iconPicker" data-action="iconPicker" name="icon" @if(isset($category)) value="{{ $category->icon }}" @else value="fa fa-star" @endif />--}}
                
            <!-- ------------------------- icon using bootstrap------------------------------- -->
            <!-- Button tag -->
            <button name="icon" 
            @if(isset($category)) data-icon="{{ $category->icon }}" @else data-icon="fas fa-truck-monster" @endif
            data-rows="10" 
            data-cols="20"  
            class="btn btn-default" 
            role="iconpicker"
            data-selected-class="btn-info"
            data-unselected-class="btn-default"
            data-align="center"
            ></button>
            <!-- ----------------------------------------------------------------------------- -->
        </div>
        </div>
      </div>
    </div>
    <!-- ------------------------------------------------------------- -->
    <!-- -------------------- description ar ------------------------- -->
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label required">وصف التصنيف</label>
      </div>
      <div class="field-body">
        <div class="field">
          <div class="control">
            <!-- <murabba-editor id="description_ar" name="description_ar" @if(isset($category)) old-data="{{ $category->description_ar }}" @else old-data="{{old('description_ar')}}" @endif></murabba-editor>
            <hr> -->
            <textarea class="form-control tinymce-editor" id="description_ar" name="description_ar"  placeholder="Enter description_ar"  > @if(isset($category)) {!! $category->description_ar !!} @else {!! old('description_ar')!!} @endif </textarea>
          </div>
        </div>
      </div>
    </div>
    <!-- ------------------------------------------------------------- -->
    <!-- -------------------- description en ------------------------- -->
    <div class="field is-horizontal">
      <div class="field-label is-normal">
        <label class="label required"> وصف التصنيف بالانجليزية</label>
      </div>
      <div class="field-body">
        <div class="field">
          <div class="control">
            <!-- <murabba-editor id="description_en" name="description_en" @if(isset($category)) old-data="{{ $category->description_en }}" @else old-data="{{old('description_en')}}" @endif></murabba-editor> -->
            <textarea class="form-control tinymce-editor" id="description_en" name="description_en"  placeholder="Enter description_en" > @if(isset($category)) {!! $category->description_en !!} @else {!! old('description_ar')!!} @endif </textarea>
          </div>
        </div>
      </div>
    </div>
    <!-- ------------------------------------------------------------- -->
</div>

<footer class="card-footer">
  <div class="buttons has-addons">
    <a class="button is-info" href="{{ route('admin.categories.index') }}"> الغاء </a>
    <button type="submit" class="button is-success">حفظ</button>
  </div>
</footer>