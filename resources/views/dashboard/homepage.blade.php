@extends('dashboard.base')

@section('content')

          <div class="container-fluid">
            <div class="fade-in">
              <div class="row">
                @if(!$attendance)
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
                @else
                <div class="col-sm-6 col-lg-6">
                    <div class="card text-white bg-success">
                      <div class="card-body">
                        <div class="text-center mb-4">
                          <svg class="c-icon c-icon-2xl">
                            <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-people"></use>
                          </svg>
                        </div>
                        <div class="text-center text-value-lg">
                          <h2>@lang('master.your_are_registred')</h2>
                        </div>
                      </div>
                    </div>
                </div>
                @endif
                
                <!-- /.col-->
                <div class="col-sm-6 col-lg-6">
                  <form action="{{route('leaverequests.store')}}" method="POST"> @csrf 
                    <div class="card text-white bg-danger">
                      <div class="card-body text-center">
                        <button type="submit" class="btn-danger b-a-0" onclick="return confirm('{{__('master.are_you_sure_you_want_send_leave_request')}}')">
                          <div class="text-center mb-4">
                            <svg class="c-icon c-icon-2xl">
                              <use xlink:href="assets/icons/coreui/free-symbol-defs.svg#cui-envelope-letter"></use>
                            </svg>
                          </div>
                          <div class="text-center text-value-lg">
                            <h2>@lang('master.make_leave_request')</h2>
                          </div>
                        </button>
                      </div>
                    </div>
                </form>
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
