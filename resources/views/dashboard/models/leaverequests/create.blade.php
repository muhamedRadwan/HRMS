@extends('dashboard.base')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection
@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> {{  __('master.add') .' '. __('master.leave_request') }}</div>
                    <div class="card-body">
                        <br>
                        <form method="POST" action="{{route("leaverequests.store")}}">
                            @csrf
                            <label class="form-label">{{__("master.choose_hour")}}</label>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="input-group mb-3">
                                  <label class="form-label">{{__("master.from")}}</label>
                                  <input type="text"  required name="_from_time" class=" form-control"  value="{{old("from_time")}}"/>
                                  <input type="hidden"  name="from_time" class=" form-control"   value="{{old("from_time")}}"/>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="input-group mb-3 ">
                                  <label class="form-label">{{__("master.to")}}</label>
                                  <input type="text" required name="_to_time" class="form-control" value="{{old("to_time")}}" />
                                  <input type="hidden"  name="to_time" class="form-control" value="{{old("to_time")}}" />
                                </div>
                              </div>
                            </div>
                            <label class="form-label">{{__("master.note")}}</label>
                            <div class="input-group mb-3">
                              <textarea class="form-control" type="text" 
                            name="note" value="" >{{old("note")}}</textarea>
                          </div>
                          <button class="btn btn-block btn-success" type="submit">{{ __('master.save') }}</button>
                          <a  href="{{ route('leaverequests.index') }}" class="btn btn-block btn-primary">
                            {{ __('master.return') }}
                          </a> 
                        </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@section('javascript')
@if(config('roles.enablejQueryCDN'))
        <script type="text/javascript" src="{{ config('roles.JQueryCDN') }}"></script>
@endif
@if(config('roles.enableSelectizeJsCDN'))
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
@endif
<script type="text/javascript">
    var noConflictMode = jQuery.noConflict(true);
    (function ($) {
        $(document).ready(function () {
            $("#roles").selectize({
                placeholder: '{{__('master.select_roles')}}',
                allowClear: true,
                create: false,
                highlight: true,
                diacritics: true
            });
        });
    }(noConflictMode));
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
        $('input[name="_from_time"]').daterangepicker({
          opens: 'center',
          autoApply: true,
          timePicker: true,
          singleDatePicker: true,
          autoUpdateInput: false,
           locale: {
            format: 'Y-M-D hh:mm A'
          }
        }, function(start, end, label) {
            $('input[name="_from_time"]').val(start.format('YYYY-MM-DD HH:mm:ss A'));
            moment.locale("en");
            $("input[name='from_time'").val(moment(start.unix()*1000).format("YYYY-MM-DD HH:mm:ss"));
            moment.locale("ar");
        });

        $('input[name="_to_time"]').daterangepicker({
          opens: 'center',
          autoApply: true,
          timePicker: true,
          singleDatePicker: true,
          autoUpdateInput: false,
           locale: {
            format: 'Y-M-D hh:mm A',
            cancelLabel: 'Clear'
          }
        }, function(start, end, label) {
            $('input[name="_to_time"]').val(start.format('YYYY-MM-DD HH:mm:ss'));
            moment.locale("en");
            $("input[name='to_time'").val(moment(start.unix()*1000).format("YYYY-MM-DD HH:mm:ss"));
            moment.locale("ar");
        });
      });
      
    </script>
@endsection