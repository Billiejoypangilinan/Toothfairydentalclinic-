@extends('layouts.master')
@section('title', "Services")
@section('services', "active")
@section('specific-css')
@endsection

@section('main_content')

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4 class="text-primary mb-0 semi-bold">Services Offer</h4>
            <!-- hidden logged role -->
            
            <div class="">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal_add">
                    <i class="menu-icon tf-icons bx bx-plus"></i>
                    Add Service
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Table -->
        <table class="table" id="services_table">
            <thead>
                <tr>
                    <th>Service</th>
					<th>Price</th>
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
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Service Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="service" class="mb-3" data-parsley-validate>
                @csrf
                <div class="modal-body">

                    <div class="form-group mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="service_name" name="service_name" required>
                    </div>
				
					<div class="form-group mb-2">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="save_btn">Create new</button>
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- edit Modal -->
<div class="modal modal-top fade" data-bs-backdrop="static" id="modal_edit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title bold text-primary" id="modalTopTitle">Service Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="up_service" class="mb-3" data-parsley-validate>
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="hidden_id_edit" name="hidden_id_edit" />
                    <div class="form-group mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit_service_name" name="edit_service_name" required>
                    </div>
				
					<div class="form-group mb-2">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" id="edit_price" name="edit_price" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn_update">Update</button>
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
    <script src="{{ asset('custom/js/services.js') }}" type="text/javascript"></script>
    @endsection