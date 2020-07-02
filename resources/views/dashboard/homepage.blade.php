@extends('dashboard.base')

@section('content')

          <div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <div class="col-sm-6 col-lg-6">
                  <a href="{{route('attendance.store', Auth::user()->token)}}">
                    <div class="card text-white bg-info">
                      <div class="card-body">
                        <div class="text-center mb-4">
                          <svg class="c-icon c-icon-2xl">
                            <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-people"></use>
                          </svg>
                        </div>
                        <div class="text-center text-value-lg">
                          <h2>@lang('master.register_attendance_now')</h2>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-6">
                  <div class="card text-white bg-info">
                    <div class="card-body">
                      <div class="text-muted text-right mb-4">
                        <svg class="c-icon c-icon-2xl">
                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-people"></use>
                        </svg>
                      </div>
                      <div class="text-value-lg">87.500</div><small class="text-muted text-uppercase font-weight-bold">Techaers Today</small>
                      <div class="progress progress-white progress-xs mt-3">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.row-->
             
              
            </div>
          </div>

@endsection

@section('javascript')

    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
