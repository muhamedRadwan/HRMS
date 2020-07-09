@extends('dashboard.base')
{{-- total Teachers Total attendance today Tottal request live in this month doneTotal live reuqest opned this month --}}
@section('content')

          <div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-primary">
                    <div class="card-body">
                      <div class="text-muted text-right mb-4">
                        <svg class="c-icon c-icon-2xl">
                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-people"></use>
                        </svg>
                      </div>
                      <div class="text-value-lg">{{$attendance->today}}</div>
                        <small class="text-muted text-uppercase font-weight-bold">{{__('master.attendance_today')}}</small>
                        <div class="progress progress-white progress-xs mt-3">
                          <div class="progress-bar" role="progressbar" style="width: {{$attendance->precentage_today}}%" aria-valuenow="{{$attendance->precentage_today}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                  </div>
                </div>
                <!-- /.col-->
                 <!-- /.col-->
                 <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-info">
                    <div class="card-body">
                      <div class="text-muted text-right mb-4">
                        <svg class="c-icon c-icon-2xl">
                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-people"></use>
                        </svg>
                      </div>
                      <div class="text-value-lg">{{$attendance->month}}</div>
                    <small class="text-muted text-uppercase font-weight-bold">{{__('master.attendance_month')}}</small>
                    <div class="progress progress-white progress-xs mt-3">
                      <div class="progress-bar" role="progressbar" style="width: {{$attendance->precentage_month}}%" aria-valuenow="{{$attendance->precentage_month}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                 <!-- /.col-->
                 <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-success">
                    <div class="card-body">
                      <div class="text-muted text-right mb-4">
                        <svg class="c-icon c-icon-2xl">
                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-envelope-open"></use>
                        </svg>
                      </div>
                    <div class="text-value-lg">{{$LeaveRequest->approved}}</div>
                    <small class="text-muted text-uppercase font-weight-bold">{{__("master.leave_requests_approved")}}</small>
                      <div class="progress progress-white progress-xs mt-3">
                      <div class="progress-bar" role="progressbar" style="width: {{$LeaveRequest->precentage_approved}}%" aria-valuenow="{{$LeaveRequest->precentage_approved}}" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                  <div class="card text-white bg-danger">
                    <div class="card-body">
                      <div class="text-muted text-right mb-4">
                        <svg class="c-icon c-icon-2xl">
                          <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-envelope-open"></use>
                        </svg>
                      </div>
                    <div class="text-value-lg">{{$LeaveRequest->notApproved}}</div>
                    <small class="text-muted text-uppercase font-weight-bold">{{__("master.leave_requests_notApproved")}}</small>
                      <div class="progress progress-white progress-xs mt-3">
                      <div class="progress-bar" role="progressbar" style="width: {{$LeaveRequest->precentage_notApproved}}%" aria-valuenow="{{$LeaveRequest->precentage_notApproved}}" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.row-->
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-5">
                      <h4 class="card-title mb-0">{{__('master.chart')}}</h4>
                      <div class="small text-muted"></div>
                    </div>
                  </div>
                  <!-- /.row-->
                  <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                    <canvas class="chart" id="main-chart" height="300"></canvas>
                  </div>
                </div>
              </div>
              <!-- /.card-->
              
             
            </div>
          </div>

@endsection

@section('javascript')

    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
@endsection
