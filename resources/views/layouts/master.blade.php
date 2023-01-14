<!DOCTYPE html>

<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>DENTAL MANAGEMENT SYSTEM</title>

  <meta name="description" content="" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href=" {{asset('images/favicon.jpg')}}" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="{{asset('/asset/fonts/boxicons.css')}}" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{asset('/asset/css/core.css')}}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{asset('/asset/css/theme-default.css')}}" class="template-customizer-theme-css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{asset('/asset/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

  <link rel="stylesheet" href="{{asset('/asset/libs/apex-charts/apex-charts.css')}}" />

  <!-- Page CSS -->
  <link href="{{ asset('css/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/parsley.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('asset/libs/datatable/datatables.min.css')}}" rel="stylesheet" type="text/css" />

  <link href="{{ asset('custom/css/custom.css')}}" rel="stylesheet" type="text/css" />


  @yield('specific-css')

  <!-- Helpers -->
  <script src="{{asset('/asset/js/helpers.js')}}"></script>
  <script src="{{asset('/asset/js/config.js')}}"></script>
</head>

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="{{ url('/dashboard') }}" class="app-brand-link d-flex flex-column">

            <span class="app-brand-text demo menu-text fw-bolder text-primary mb-1"><img src="{{ asset('images/logo_clinic.png') }}" style="width: 275px; height: 75px; margin-left: -42px;"></span>
            <small class="text-muted">Dental Clinic Management System</small>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <hr class="m-0" />

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">

          @include('layouts.sidebar')

        </ul>
      </aside>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->

        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
              <div class="nav-item d-flex align-items-center">
                <span>Welcome, <span class="text-primary semi-bold">{{ ucwords(Auth::user()->name) }}</span> | {{date('F d, Y - D')}} </span>

                {{-- <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." /> --}}
              </div>
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">

              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img src="{{ asset('images/favicon.jpg')}}" alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="{{ asset('images/favicon.jpg')}}" alt class="w-px-40 h-auto rounded-circle" />
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block">{{ ucwords(Auth::user()->name) }} </span>
                          <small class="text-muted">{{ ucwords(Auth::user()->role) }}</small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                      <i class="bx bx-power-off me-2"></i>
                      <span class="align-middle">Log Out</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/ User -->
            </ul>
          </div>
        </nav>

        <!-- / Navbar -->



        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('main_content')
          </div>

          <!-- <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
              <div class="mb-2 mb-md-0">
              </div>
              <div class="font-weight-light">
                Powered by
                <a href="https://nexbridgetech.com" target="_blank" class="footer-link fw-bold font-italic">Nexbridge Technologies Inc</a>
              </div>
            </div>
          </footer> -->

          <!-- APPROVE MODAL -->
          <div class="modal fade" id="approve" role="dialog" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
              <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title bold text-primary">Request Approval</h5>

                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body pt-5">
                  <form id="approve_form" method="post" action="{{ url('/change_requests/approve') }}">
                    @csrf
                    <div class="text-center">
                      <h1><i class="fa fa-question-circle"></i></h1>

                      <h4>Are you sure?</h4>
                      <p>Do you confirm this approval</p>
                    </div>

                    <div class="form-group">
                      <input type="hidden" class="form-control" name="id" id="approve_id">
                      <input type="hidden" class="form-control" name="table" id="approve_in_table">
                      <input type="hidden" class="form-control" name="change_table_id" id="approve_change_table_id">
                      <input type="hidden" class="form-control" name="change_table" id="approve_change_table">

                    </div>

                    <br />
                    <div class="text-right">
                      <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">Close</button>
                      <button type="submit" id="approve_btn" class="btn btn-primary">Yes, Approve</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- REJECT MODAL -->
          <div class="modal fade" id="reject" role="dialog" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
              <div class="modal-content">

                <div class="modal-header">
                  <h5 class="modal-title bold">Reject Request</h5>

                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body pt-5">
                  <form id="reject_form" method="post" action="{{ url('/change_requests/reject') }}">
                    @csrf

                    <div class="text-center">
                      <h1><i class="fa fa-times-circle"></i></h1>

                      <h4>Are you sure?</h4>
                      <p>Do you confirm this rejection</p>
                    </div>

                    <div class="form-group">
                      <input type="hidden" class="form-control" name="id" id="reject_id">
                      <input type="hidden" class="form-control" name="table" id="reject_in_table">
                      <input type="hidden" class="form-control" name="change_table_id" id="reject_change_table_id">
                      <input type="hidden" class="form-control" name="change_table" id="reject_change_table">
                    </div>

                    <br />
                    <div class="text-right">
                      <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">Close</button>
                      <button type="submit" id="approve_btn" class="btn btn-primary">Yes, Reject</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>


        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
      </div>
    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('asset/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('asset/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{ asset('asset/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('asset/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

    <script src="{{ asset('asset/vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('asset/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <!-- Main JS -->
    <script src="{{ asset('asset/js/main.js')}}"></script>

    <!-- Page JS -->
    <script src="{{ asset('asset/js/dashboards-analytics.js')}}"></script>

    <script src="{{ asset('asset/libs/datatable/datatables.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/parsley.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-idleTimeout.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/store.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/sticky.min.js')}}" type="text/javascript"></script>
    <!-- Nex Library -->
    <script src="{{ asset('js/fileupload.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/nexlibrary.js') }}" type="text/javascript"></script>


    @yield('specific-js')
    <script type="text/javascript">
      $(document).ready(function() {

        const ps_el = document.querySelector('.ps');
        const ps = new PerfectScrollbar(ps_el);

        //$('.ps').perfectScrollbar();

        /* new PerfectScrollbar('.ps', {
           wheelPropagation: false
         });*/



        $("input").attr("autocomplete", "off");

        $('table tbody').on('click', '.activate', function(e) {
          e.preventDefault();

          $("#activate_in_table").val($(this).data('table'));
          $("#activate_id").val($(this).data('id'));
        });

        $('table tbody').on('click', '.deactivate', function(e) {
          e.preventDefault();
          $("#deactivate_in_table").val($(this).data('table'));
          $("#deactivate_id").val($(this).data('id'));
        });

        $('table tbody').on('click', '.approve', function(e) {
          e.preventDefault();
          $("#approve_in_table").val($(this).data('table'));
          $("#approve_id").val($(this).data('id'));
          $("#approve_change_table").val($(this).data('change_table'));
          $("#approve_change_table_id").val($(this).data('change_table_id'));
        });

        $('table tbody').on('click', '.reject', function(e) {
          e.preventDefault();
          $("#reject_in_table").val($(this).data('table'));
          $("#reject_id").val($(this).data('id'));
          $("#reject_change_table").val($(this).data('change_table'));
          $("#reject_change_table_id").val($(this).data('change_table_id'));
        });

        $('table tbody').on('click', '.delete', function(e) {
          e.preventDefault();
          $("#deactivate_in_table").val($(this).data('table'));
          $("#deactivate_id").val($(this).data('id'));
        });

        // Activate & Deactivate
        $('#activate_form').crud_delete();
        $('#deactivate_form').crud_delete();

        // Approve & Reject
        $('#approve_form').crud_delete();
        $('#reject_form').crud_delete();


        //AUTOMATIC LOGOUT IF IDLE
        $(document).idleTimeout({
          redirectUrl: '/logout',
          idleTimeLimit: 3600,
          activityEvents: 'click keypress scroll wheel mousewheel',
          sessionKeepAliveTimer: false,
          enableDialog: false,
        });


        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });



        //SET DATE TODAY
        var date = new Date();
        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var today = date.getFullYear() + "-" + (month) + "-" + (day);

        $('input[type=date]').val(today);

        //CHECK ALL IN TABLE
        $('.check-all').prop('checked', false);

        $('.check-all').click(function() {
          $('.check-item').not(":disabled").prop('checked', this.checked);
        });

        /*$(document).on('change','input[type=file]',function(){
               var fp       = $(this);
               var lg       = fp[0].files.length; // get length
               var items    = fp[0].files;
               var fileSize = 0;
           
           if (lg > 0) {
               for (var i = 0; i < lg; i++) {
                   fileSize = fileSize+items[i].size; // get file size
               }
               if(fileSize > 25600000) {
                    toastr.warning('Warning','File size must not be more than 25 MB');
                    $(this).val('');
               }
           }
        });*/

      });
    </script>

</body>

</html>