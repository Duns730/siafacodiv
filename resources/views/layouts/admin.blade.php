<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> @yield('title') | {{ config('app.name', 'Laravel') }} </title>

    <!-- Bootstrap -->
    {!! Html::style('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') !!}
    <!-- Font Awesome -->
    {!! Html::style('gentelella/vendors/font-awesome/css/font-awesome.min.css') !!}
    <!-- NProgress -->
    {!! Html::style('gentelella/vendors/nprogress/nprogress.css') !!}
    <!-- jQuery custom content scroller -->
    {!! Html::style('gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css') !!}
    {!! Html::style('gentelella/vendors/pnotify/dist/pnotify.css') !!}
      {!! Html::style('gentelella/vendors/pnotify/dist/pnotify.buttons.css') !!}
    <!-- Custom Theme Style -->
    {!! Html::style('gentelella/build/css/custom.min.css') !!}

    
    @yield('style')
  </head>

  <body class="nav-md">
    
    <div class="container body">
      <div class="main_container ">
        


        @include('layouts._lateralMenu')

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <ul class=" navbar-right">
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                      <img src="{{ config('app.url', 'Laravel') }}images/img.jpg" alt="">{{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      

                    <a class="dropdown-item"  class="dropdown-item"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">

                        <i class="fa fa-sign-out pull-right"></i> Salir
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                    </div>
                  </li>
  
                  <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-envelope-o"></i>
                      <span class="badge bg-green">0</span>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{ config('app.url', 'Laravel') }}images/img.jpg" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{ config('app.url', 'Laravel') }}images/img.jpg" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{ config('app.url', 'Laravel') }}images/img.jpg" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="dropdown-item">
                          <span class="image"><img src="{{ config('app.url', 'Laravel') }}images/img.jpg" alt="Profile Image" /></span>
                          <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                          <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                        </a>
                      </li>
                      <li class="nav-item">
                        <div class="text-center">
                          <a class="dropdown-item">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                          </a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        <!-- /top navigation -->
      
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="" id="app">
            <div class="page-title">
              @if (session('info'))
              <div class="alert alert-success alert-dismissible fade show" role="alert" >
                {{session('info')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert" >
                <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{$error}}</li>
                  @endforeach
                  <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </ul>
              </div>
              @endif

              <div class="title_left">
                <h3>@yield('title') <small></small></h3>
              </div>

              <form-search></form-search>
            </div>
            <div class="clearfix"></div>
            <loading-img></loading-img>
            @yield('content')

          </div>
        </div>
        
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <b>{{ config('app.name', 'Laravel') }}</b> - Sistema Auxiliar de Facturación y Cobro de Divisas. Creado por <a href="/"><b>Duns730</b></a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    {!! Html::script('gentelella/vendors/jquery/dist/jquery.min.js') !!}
    <!-- Bootstrap -->
    {!! Html::script('gentelella/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') !!}
    <!-- FastClick -->
    {!! Html::script('gentelella/vendors/fastclick/lib/fastclick.js') !!}
    <!-- NProgress -->
    {!! Html::script('gentelella/vendors/nprogress/nprogress.js') !!}
    <!-- jQuery custom content scroller -->
    {!! Html::script('gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js') !!}
    {!! Html::script('gentelella/vendors/pnotify/dist/pnotify.js') !!}
     {!! Html::script('gentelella/vendors/pnotify/dist/pnotify.buttons.js') !!}
    <!-- Custom Theme Scripts -->
    {!! Html::script('gentelella/build/js/custom.min.js') !!}
    {!! Html::script('js/app.js') !!}
    {!! Html::script('js/components/FormSearch.js') !!}
    {!! Html::script('js/components/LoadingImg.js') !!}
    <script>
/**/    $(document).ready( function () {
      //$('body').toUpperCase();
      $("input").on("keypress", function () {
       $input=$(this);

       if ($(this).attr('name') !=  'password' || $(this).attr('name') !=  'newValue') {
          setTimeout(function () {
          $input.val($input.val().toUpperCase());
         },50);
       }
       
      })
     }) 
    </script>
    @yield('scripts')
  </body>
</html>