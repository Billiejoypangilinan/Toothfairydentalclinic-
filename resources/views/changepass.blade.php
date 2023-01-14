@extends('layouts.master')
@section('title', "Change Password")
@section('maintenance', "active open")
@section('settings', "active")
@section('specific-css')
<style>

</style>
@endsection
@section('main_content')
<div class="card mb-4">
 

  <div class="card-body">

    <h4 class="text-primary bold">Change Password</h4>

    <form  class="mb-3" data-parsley-validate>
        @csrf
        <div class="mb-3 col-md-12">
        <label class="form-label">Old Password</label>
            <input class="form-control" type="password" name="old_password" id="old_password" placeholder="Enter old password" required >
        </div>

        <div class="mb-3 col-md-12">
            <label class="form-label">New Password</label>
            <input type="password" data-parsley-trigger="keyup" required name="new_password" id="new_password" class="form-control" placeholder="Enter new password" >
        </div>

        <div class="mb-3 col-md-12">
            <label class="form-label">Confirm Password</label>
            <input type="password" data-parsley-trigger="keyup" name="confirm_password" id="confirm_password" required class="form-control" placeholder="Enter confirm password" >
        </div>

        <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2" id="save_btn">Save changes</button>
            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
        </div>
    </form>
   
  </div>
  <!-- /Account -->
</div>

</div>
@endsection

@section('specific-js')
<script src="{{ asset('js/parsley.min.js')}}" type="text/javascript"></script>
  <script src="{{ asset('js/jquery.form.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('custom/js/change_pass.js')}}" type="text/javascript"></script>

@endsection