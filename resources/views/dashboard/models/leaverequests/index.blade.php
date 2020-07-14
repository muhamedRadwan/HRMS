@extends('dashboard.base')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection
@section('content')

          <div class="container-fluid">
            <div class="fade-in">
              <div class="row input-daterange form-inline m-2">
                <label class="form-label">{{__("master.choose_period")}}:</label>
                <input type="text" name="daterange" class="col-md-4 form-control" value="" />
            </div>
              <div class="card">
                  <div class="card-header">{{ __("master.leave_request_report")}}
                    <div class="card-header-actions">
                      
                    </div>
                  </div>
                  <div class="card-body">
                    
                    {{$dataTable->table()}}

                  </div>
              </div>
            </div>
          </div>
      
@endsection

@section('javascript')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    {{$dataTable->scripts()}}
    <script>
        $(function() {
        
        $('input[name="daterange"]').daterangepicker({
          opens: 'left'
        }, function(start, end, label) {

          var from_date = start.format('YYYY-MM-DD');
          var to_date = end.format('YYYY-MM-DD');
          if(from_date != '' &&  to_date != '')
          {
          $('#users-table').DataTable().destroy();
          load_data(from_date, to_date);
          }
          else
          {
          alert('Both Date is required');
          }
        });
      });
      function load_data(from_date = '', to_date = '')
      {
        $("#users-table").DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "https:\/\/hrms.test\/leaverequests",
            "type": "GET",
            data:{from_date:from_date, to_date:to_date}

        },
        "columns": window.LaravelDataTables["users-table"].init().aoColumns,
        "dom": window.LaravelDataTables["users-table"].init().dom,
        "order": window.LaravelDataTables["users-table"].init().order,
        "buttons": window.LaravelDataTables["users-table"].init().buttons,
        "className": window.LaravelDataTables["users-table"].init().className,
        "language": window.LaravelDataTables["users-table"].init().language
    });
    }
    </script>
@endsection