@extends('layouts.master')
@section('title', "Dashboard")
@section('dashboard', "active")
@section('specific-css')
{{-- <link rel="stylesheet" href="{{ asset('asset/vendor/libs/apex-charts/apex-charts.css')}}" /> --}}
<style>
  .tab-pane ul,
  .handlers-container {
    max-height: 25vw;
  }
  .dashboard{
    cursor: pointer;
  }
</style>
@endsection
@section('main_content')

<div class="row">
  <!-- Total Revenue -->
  <div class="col-md-12">

    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card dashboard">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <h5 class="mb-0">Patient</h5>
              <!-- <span class="badge bg-label-info rounded-pill">Year 2022</span> -->
            </div>
            <h3 class="card-title mb-2">{{$user}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card dashboard" >
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <h5 class="mb-0">Appointment</h5>
              <!-- <span class="badge bg-label-info rounded-pill">Year 2022</span> -->
            </div>
            <h3 class="card-title mb-2">{{$appointments}}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card dashboard" >
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <h5 class="mb-0">Doctors</h5>
            </div>
            <h3 class="card-title mb-2">{{$doctors}}</h3>
          </div>
        </div>
      </div>

    </div>
    <br />
  </div>
</div>
<!-- contents -->
<div class="row">
  <div class="col-md-12 order-0 mb-4">
    <div class="card">
      <div class="card-header bg-primary">
        <h5 class=" semi-bold text-white m-0">Monthly patient</h5>
      </div>
    </div>
    <div class="nav-align-top mb-4">
      <div class="card p-3 overflow-auto">
        <div  style="min-height: 150px;">
        <canvas id="patientChart" width="100" height="100"></canvas>
        </div>
       
        <div class="resize-triggers">
          <div class="expand-trigger">
            <div style="width: 446px; height: 377px;"></div>
          </div>
          <div class="contract-trigger"></div>
        </div>
      </div>
    </div>

  </div>
  


</div>


@endsection

@section('specific-js')
<script src="{{ asset('custom/js/dashboard.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- <script src="{{ asset('custom/js/dashboard.js') }}" type="text/javascript"></script> -->
@endsection