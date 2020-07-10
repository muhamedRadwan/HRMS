@extends('dashboard.base')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <form method="POST" action="{{route("change-password.change")}}">
            @csrf
            @method('PUT')
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                      <svg class="c-icon c-icon-sm">
                          <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-lock-locked"></use>
                      </svg>
                    </span>
                </div>
                <input class="form-control" type="password" placeholder="{{__("master.current_password")}}"
                    name="current_password" value="{{old("current_password")}}">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                      <svg class="c-icon c-icon-sm">
                          <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-lock-locked"></use>
                      </svg>
                    </span>
                </div>
                <input class="form-control" type="password" placeholder="{{__("master.new_password")}}"
                    name="password" value="{{old("password")}}">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                      <svg class="c-icon c-icon-sm">
                          <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-lock-locked"></use>
                      </svg>
                    </span>
                </div>
                <input class="form-control" type="password" placeholder="{{__("master.password_confirmation")}}"
                    name="password_confirmation" value="">
            </div>
            <button class="btn btn-block btn-success" type="submit">{{ __('master.save') }}</button>
            <a href="{{ route('users.index') }}" class="btn btn-block btn-primary">{{ __('master.return') }}</a> 
        </form>
    </div>
</div>
@endsection