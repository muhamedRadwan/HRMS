@extends('dashboard.base')
@section('css')
@if(config('roles.enableSelectizeJsCssCDN'))
<link rel="stylesheet" type="text/css" href="{{ config('roles.SelectizeJsCssCDN') }}">
@endif
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
                                  <input class="form-control" type="time" 
                                  name="from_time" required value="{{old("from_time")}}" >
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="input-group mb-3 ">
                                  <label class="form-label">{{__("master.to")}}</label>
                                  <input class="form-control" type="time" 
                                   name="to_time" required value="{{old("to_time")}}" >
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
@endsection