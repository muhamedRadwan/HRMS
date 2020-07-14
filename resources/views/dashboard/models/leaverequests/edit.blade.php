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
                      <i class="fa fa-align-justify"></i> {{ __('master.edit') .' '. __('master.leave_request') }}</div>
                    <div class="card-body">
                        <br>
                        <form method="POST" action="{{route("leaverequests.update", $leaverequest->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                      <svg class="c-icon c-icon-sm">
                                          <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-user"></use>
                                      </svg>
                                    </span>
                                </div>
                                <input class="form-control" disabled type="text" 
                                name="name" value="{{ $leaverequest->creator->name }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input class="form-control" disabled type="text" 
                                 name="email" value="{{ $leaverequest->creator->email }}" >
                            </div>
                            <label class="form-label">{{__("master.time")}}</label>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="input-group mb-3">
                                  <label class="form-label">{{__("master.from")}}</label>
                                  <input  class="form-control" type="time" 
                                name="from_time" disabled value="{{$leaverequest->from_time}}" >
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="input-group mb-3 ">
                                  <label class="form-label">{{__("master.to")}}</label>
                                  <input class="form-control" type="time" 
                                   name="to_time" disabled value="{{$leaverequest->to_time}}" >
                                </div>
                              </div>
                            </div>
                            <label class="form-label">{{__("master.note")}}</label>
                            <div class="input-group mb-3">
                              <textarea class="form-control" disabled 
                            name="note">{{$leaverequest->note}}</textarea>
                          </div>
                            <div class="form-group has-feedback row col-12">
                              <label for="roles" class="col-12 control-label">
                                  {{ __("master.request_status") }}
                              </label>
                              <div class="col-12">
                                <label>{{__("master.accept")}}</label>
                                <input type="radio" name="status" @if($leaverequest->status == 1) selected="selected" @endif value="1" class="form-control"/>
                                <label>{{__("master.reject")}}</label>
                                <input type="radio" name="status" @if($leaverequest->status == 2) selected="selected" @endif value="2" class="form-control"/>

                              </div>
                          </div>
                            <button class="btn btn-block btn-success" type="submit">{{ __('master.save') }}</button>
                            <a href="{{ route('leaverequests.index') }}" class="btn btn-block btn-primary">{{ __('master.return') }}</a> 
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