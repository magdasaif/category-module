@extends('category::layouts.app')

@section('page.title', 'اضافة تصنيف رئيسي')

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
      <form method="POST" action="{{route('admin.categories.store')}}" enctype="multipart/form-data">
        @csrf
        @include('category::admin._form')
      </form>
    </div>
@endsection


