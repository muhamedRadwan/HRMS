@extends('dashboard.base')
@section('content')

          <div class="container-fluid">
            <div class="card text-center">
              <div class="card-header">
                {{__("master.userQrCode")}}
              </div>
              <div class="card-bod m-2">
              <img class="img img-block" src="{{'qrcodes/'.Auth::user()->token.".svg"}}" alt="{{__("master.userQrCode")}}">
              <br>
              <a class="btn btn-outline-success m-2" href="{{'qrcodes/'.Auth::user()->token.".svg"}}" download="{{__("master.userQrCode")}}.svg">{{__("master.download")}}</a>
            </div>
            </div>
          </div>
      
@endsection
