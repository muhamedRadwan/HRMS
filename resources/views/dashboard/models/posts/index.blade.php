@extends('dashboard.base')
@section('css')
    <style>
      
    </style>
@endsection
@section('content')

          <div class="container-fluid">
            <div class="fade-in">
              <div class="card">
                  <div class="card-header"> {{__("master.posts")}}
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
    {{$dataTable->scripts()}}
   
@endsection