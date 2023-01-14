$(document).ready(function() {

    var table = $('#users_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        autoWidth: false,
        buttons: false,
        order: [
            [0, 'asc']
        ],
        ajax: {
            url: "/get_users",
            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.replace("/login");
                } else {
                    toastr.error('An error occured, please try again later');
                }
            }
        },
        columns: [{
            data: 'name',
            name: 'name',
            searchable: true
        }, {
            data: null,
            name: null,
            searchable: true,
            class: 'v-middle',
            render: function(data, type) {

                return data.role;
                /*let role = data.role == 'Admin' ? '<span class="badge bg-outline-primary">'+data.role+'</span>' : '<span class="badge bg-outline-secondary">'+data.role+'</span>';
                return type === 'sort' ? data : role; */
            }
        }, {
            data: "email",
            name: "email",
            searchable: true
        }, {
            data: null,
            name: null,
            searchable: true,
            class: 'v-middle',
            render: function(data, type) {
                let status = data.status == 1 ? '<span class="badge bg-primary">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                return type === 'sort' ? data : status; 
            }
        }, {
            data: "created_at",
            name: "created_at",
            searchable: true,
            class: 'v-middle',
            render: function(data, type) {
                return type === 'sort' ? data : moment(data).isValid() ? moment(data).format('ll') : '---';
            }

        }, {
            data: null,
            orderable: false,
            searchable: false,
            class: 'text-right',
            render: function(data, type, row) {
                if (data.status == 1) {
                    return '<button type="button" data-table="users" data-id=' + data.id + ' data-role=' + data.role + ' data-name="' + data.name + '" data-email="' + data.email + '" data-bs-toggle="modal" data-bs-target="#modal_edit" data-placement="top" title="Edit Account" data-original-title="Edit Account" class="edit btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i></button> ' +
                        '<button type="button" data-table="users"  data-id=' + data.id + '  data-role=' + data.role + ' data-name="' + data.name + '" data-bs-toggle="modal" data-bs-target="#modal_reset" data-placement="top" title="Reset Password" data-original-title="Reset Password" class="reset-pass btn btn-sm btn-secondary"><i class="fa fa-redo"></i></button> ' +
                        '<button type="button" data-table="users" data-id="' + data.id + '"  data-role=' + data.role + ' data-name="' + data.name + '" data-bs-toggle="modal" data-bs-target="#deactivate" data-placement="top" title="Deactivate" data-original-title="Deactivate" class="deactivate btn btn-sm btn-secondary"><i class="fa fa-toggle-on"></i></button> ';
                } else {
                    return '<button type="button" data-table="users" data-id="' + data.id + '" data-name="' + data.name + '" data-bs-toggle="modal" data-bs-target="#activate"  data-placement="top" title="Activate" data-original-title="Activate" class="activate btn btn-sm btn-secondary"><i class="fa fa-toggle-off"></i></button> ';
                }

            }
        }],
        drawCallback: function(settings, json) {
            $('.tooltips').tooltip();
        },

    });

    $('#save_btn').on('click', function(e) {
        e.preventDefault();

        Parsley._remoteCache = {};
        Parsley.addAsyncValidator("check_unique_email", function(xhr) {
            return xhr.responseText === 'false' ? false : true;
        }, "/check_unique_email");

        $(this).crud_click();
    });

    $('#update_btn').on('click', function(e) {
        e.preventDefault();

        Parsley._remoteCache = {};
        Parsley.addAsyncValidator("check_unique_email_edit", function(xhr) {
            return xhr.responseText === 'false' ? false : true;
        }, "/check_unique_email_edit", {
            "data": {
                "id": $("#hidden_id_edit").val()
            }
        });

        $(this).crud_click();
    });

    // Edit - with universal route
    $('table tbody').on('click', '.edit', function() {
        let role = $(this).data('role');
        // hidden inputs
        $('#hidden_edit_in_table').val($(this).data('table'));
        $('#hidden_id_edit').val($(this).data('id'));
        // header
        $('#edit_name_header').text("Edit - " + $(this).data('name'));
        // inputs
        $('#edit_name').val($(this).data('name'));
        $('#edit_email').val($(this).data('email'));
        $('#edit_role').val(role).change();

    });
    $('#edit_form').crud_delete();

    $('table tbody').on('click', '.reset-pass', function() {
        var base = $(this);
        id = base.data('id');
        $('#reset_pass_id').val(id);
    });


    $('#reset_pass_form').crud_delete();




});