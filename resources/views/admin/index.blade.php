@extends('category::layouts.app')

@section('page.title', 'التصنيفات')

@section('content')
  <div class="card">
    <header class="card-header">
      <a href="{{ route('admin.categories.create') }}" class="button is-success">
        <span class="icon is-small">
          <i class="fa fa-plus-circle"></i>
        </span>
        <span>اضافة تصنيف</span>
      </a>
    </header>
    <div class="card-content">
      <div class="table-container">
        <table class="table is-fullwidth" id="categories">
          <thead>
            <tr>
              <th>الايقونة</th>
              <th>اسم التصنيف</th>
              <th>النوع</th>
              <th>الحالة</th>
              <th>ظهور فى الرئيسيه</th>
              <th>الاجراءات</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $category)
            <tr>
              <td>
                <div class="icon-container">
                  <i class="{{ $category->icon }}"></i>
                </div>
              </td>
              {{--<td>{{ Illuminate\Support\Str::limit($category->name, 30, '') }} </td>--}}
              <td>{{$category->name }} </td>

              @if($category->type == 'product')
                <td> منتجات</td>
              @elseif($category->type == 'service')
                <td> خدمات</td>
              @endif
              <td>{{ $category->active ? 'مفعل' : 'غير مفعل' }}</td>
              <td>{{ $category->featured ? 'ظهور' : 'اخفاء' }}</td>
              <td>
                <div class="buttons has-addons">
                  <a class="button is-info" href="{{ route('admin.categories.edit', $category->slug) }}"> تعديل </a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <footer class="card-footer">
    </footer>
  </div>
@endsection
@section('scripts')
<script src="{{asset('vendor/category/admin/js/datatables.min.js')}}"></script>
<script>
  $(document).ready(function() {
    $('#categories').DataTable( {
      dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'print'
        ]
    });
  });
</script>
@endsection


