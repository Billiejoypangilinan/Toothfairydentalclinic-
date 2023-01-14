@extends('layouts.master')
@section('title', "Services")
@section('services', "active")
@section('specific-css')
@endsection

@section('main_content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="text-primary mb-0 semi-bold">Doctors</h4>
            <!-- hidden logged role -->
            
            <div class="">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal_add" id="new">
                    <i class="menu-icon tf-icons bx bx-plus"></i>
                    Add Doctor
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Table -->
        <table class="table" id="services_table">
            <thead>
                <tr>
                    <th>Fullname</th>
					<th>Address</th>
                    <th>Contact</th>
                    <th>Email Address</th>
                    <th>Birthdate</th>
                    <th>Date Created</th>
                    <th></th> 
                </tr>
            </thead>
        </table>
    </div>
</div>


<!-- Create Modal -->
<div class="modal modal-top fade" data-bs-backdrop="static" id="modal_add" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Doctor Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="mb-3" data-parsley-validate>
              @csrf
              <div class="modal-body">
              <input type="hidden" id="data_id" name="data_id" value="0"/>
              <div class="form-group mb-2">
                <label for="email" class="form-label">Fullname</label>
                <input type="text" class="form-control" id="name"  name="name" autofocus autocomplete="off" required />
              </div>
              <div class="form-group mb-2">
                <label for="email" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" autofocus autocomplete="off" required />
              </div>
              <div class="form-group mb-2">
                <label for="email" class="form-label">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" autofocus autocomplete="off" required />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Birthdate</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" autofocus autocomplete="off" required />
              </div>
              <div class="form-group mb-2">
                <label for="email" class="form-label">Email address</label>
                <input type="text" class="form-control" id="email" name="email" autofocus autocomplete="off" required  />
              </div>
              <div class="form-group mb-2 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label">Password</label>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" name="password" autocomplete="off" required />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
            </div>
              <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save_btn">Save</button>
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>


    @endsection

    @section('specific-js')
    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/parsley.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.form.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('custom/js/doctor.js') }}" type="text/javascript"></script>
    @endsection