<!DOCTYPE html>
<html lang="ar">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="locale" content="{{ config('app.locale') }}">
  <title>Building Materails | @yield('page.title')</title>
  <link href="{{asset('vendor/category/admin/css/app.css')}}" rel="stylesheet" type="text/css">


  <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
  <!-- Bootstrap-Iconpicker -->
  <link rel="stylesheet" href="{{asset('vendor/category/dist/css/bootstrap-iconpicker.min.css')}}"/>


</head>
<body>
  <div class="wrapper" id="app">
    <div class="pageloader is-active"><span class="title">Building Materails</span></div>
    @include('category::partials.alerts')
    {{-- @include('admin.includes.header') --}}
    <main class="main-content">
      <div class="columns is-gapless">
        {{--
          <div class="column is-2" id="aside-container">
              @if(auth()->check() && auth()->user()->type == 'admin')
                  @include('admin.includes.aside')
              @elseif(auth()->check() && auth()->user()->type == 'entry')
                  @include('admin.includes.data_entry')
              @elseif(auth()->check() && auth()->user()->type == 'clients_supervisor')
                  @include('admin.includes.clients_supervisor')
              @elseif(auth()->check() && auth()->user()->type == 'merchants_supervisor')
                  @include('admin.includes.merchants_supervisor')
              @elseif(auth()->check() && auth()->user()->type == 'merchant')
                  @include('admin.includes.merchant')
              @endif
          </div>
        --}}
        <div class="column is-10" id="main-container">
          <div class="page-container">
            <div class="page-header">
              <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul>
                  @if(Route::current()->getName() != 'admin.dashboard')
                  <li class="is-active">
                    <a href="#">
                      <span>@yield('page.title')</span>
                    </a>
                  </li>
                  @endif
                </ul>
              </nav>
            </div>
            <div class="page-content">
              @yield('content')
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  
  <!-- Scripts -->
    <!-- ============================================================== -->
    <script src="{{asset('vendor/category/admin/js/app.js')}}"></script>
    <!-- ============================================================== -->
    <!-- icon picker part -->
    <!-- jQuery CDN -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap CDN -->
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap-Iconpicker Bundle -->
    <script type="text/javascript" src="{{asset('vendor/category/dist/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
    <!-- ============================================================== -->
    <!-- text editor part -->
    <script src="https://cdn.tiny.cloud/1/div0zlj4qzq9w3wt68h87voqu1ap6sqne85lj5zc4igh0vlk/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- <script type="text/javascript" src="{{ asset('vendor/category/admin/js/tinymce.min.js') }}" referrerpolicy="origin"></script> -->
    <script type="text/javascript" src="{{ asset('vendor/category/admin/js/tiny.js') }}"></script> 
    <!-- ============================================================== -->
    @yield('scripts')
    <!-- ============================================================== -->

  <!-- Enf Scripts -->
<style>
  .modal{
    max-width: unset!important;
    width: unset!important;
    top: 0!important;
    -webkit-transform: unset!important;
    -moz-transform: unset!important;
    -ms-transform: unset!important;
    -o-transform: unset!important;
    transform: unset!important;
  }
</style>
</body>
</html>


