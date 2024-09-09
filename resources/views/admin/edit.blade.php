@extends('category::layouts.app')

@section('page.title', 'تعديل تصنيف رئيسي')

@section('content')
    <div class="card">
      <header class="card-header">
        <a href="{{ route('admin.categories.index') }}" class="button is-success">
          <span class="icon is-small">
            <i class="fa fa-list"></i>
          </span>
          <span>قائمة التصنيفات الرئيسية</span>
        </a>
      </header>
     {{-- {!! Form::model($category,['method' => 'PATCH', 'files' => true, 'url' => route('admin.categories.update', $category->slug)]) !!}
      @include('admin.categories._form')
      {!! Form::close() !!}
      --}}
      <form method="POST" action="{{route('admin.categories.update',$category->slug)}}" enctype="multipart/form-data">
        @csrf
        @method('patch')
        @include('category::admin._form')
      </form>
    </div>
@endsection


