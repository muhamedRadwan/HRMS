<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v3.0.0-alpha.1
* @link https://coreui.io
* Copyright (c) 2019 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="ar" dir="rtl">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Mohamed Radwan">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>HRMS SYstem</title>
    
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Icons-->
    <link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
    <link href="{{ asset('css/flag.min.css') }}" rel="stylesheet"> <!-- icons -->
    <!-- Main styles for this application-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">
    @yield('css')

  </head>



  <body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

      @include('dashboard.shared.nav-builder')

      @include('dashboard.shared.header')

      <div class="c-body">

        <main class="c-main" id="app">
          @include('flash-messages')
          @yield('content') 

        </main>
        @include('dashboard.shared.footer')
      </div>
    </div>



    <!-- CoreUI and necessary plugins-->
    <script src="{!! asset('js/app.js') !!}" ></script>
    <script src="{{ asset('js/coreui.bundle.min.js') }}" ></script>
    <script src="{{ asset('js/coreui-utils.js') }}" ></script>
    
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script> --}}
    <script src="/vendor/datatables/buttons.server-side.js"></script>

    @yield('javascript')


    {{-- <script>
      (function ($, DataTable) {

      // Datatable global configuration
      $.extend(true, $.fn.dataTable.defaults, {
          Language: {
            "url" :'/js/arabic.json'
          }
      });

      })(jQuery, jQuery.fn.dataTable);
    </script> --}}

  </body>
  <script>
   function deleteRecord(mech_id,row_index) {
      // confirm then
      $.post(window.location.href,{
        _method: 'DELETE',
        _token:  $('meta[name="csrf-token"]').attr('content'),
        id: mech_id,
        dataType: 'application/json'
      }).done(function (data) {
        row_index.parentNode.parentNode.remove();
        // window.LaravelDataTables["users-table"].rows("#users-table tr.active"))
      });
    }
  </script>
</html>
