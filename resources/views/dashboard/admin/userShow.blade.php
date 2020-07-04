@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> User {{ $user->name }}</div>
                    <div class="card-body">
                        <h4>{{ __('laravelroles::laravelroles.roles-table.name') }}: {{ $user->name }}</h4>
                        <h4>{{ __('laravelroles::laravelroles.roles-table.name') }} : {{ $user->email }}</h4>
                        <h4> {{ __("master.roles") }} : {{ $userRoles}}</h4>
                        <div class="text-center">
                          <img class="img" src="{{ url("qrcodes/$user->token.svg")}}" width="250" title="{{__('master.userQrCode')}}" >
                        </div>
                    </div>
                    <a href="{{ route('users.index') }}" class="btn btn-block btn-primary">{{ __('master.return') }}</a>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection