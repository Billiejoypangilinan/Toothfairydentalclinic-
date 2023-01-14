$(document).ready(function() {
   

    var table = $('#services_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        autoWidth: false,
        buttons: false,
        order: [
            [0, 'asc']
        ],
        ajax: {
            url: "/get_doctors",
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
            },
            {
                data: "address",
                name: "address",
                searchable: true
            },
        
			{
                data: "contact",
                name: "contact",
                searchable: true
            },
            {
                data: "email",
                name: "email",
                searchable: true
            },
            {
                data: "birthdate",
                name: "birthdate",
                searchable: true
            },
			{
                data: "created_at",
                name: "created_at",
                searchable: true,
                class: 'v-middle',
                render: function(data, type) {
                    return type === 'sort' ? data : moment(data).isValid() ? moment(data).format('ll') : '---';
                }

            }, 
			{
            data: null,
            orderable: false,
            searchable: false,
            class: 'text-right',
            render: function(data, type, row) {
               
                    return '<button type="button"  data-id=' + data.id + ' data-name="' + data.name 
                                    + '" data-address="' + data.address 
                                    + '" data-contact="' + data.contact
                                    + '" data-email="' + data.email
                                    + '" data-birthdate="' + data.birthdate
                                    + '"  data-bs-toggle="modal" data-bs-target="#modal_add" class="edit btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i></button> ';
				

				}
			}
        ],
        drawCallback: function(settings, json) {
            $('.tooltips').tooltip();
        },

    });

    $('#new').on('click', function(e) {
        $('#data_id').val(0);
        $('#name').val('');
        $('#address').val('');
        $('#contact').val('');
        $('#birthdate').val('');
        $('#email').val('');
        $('.form-password-toggle').show();
    })

    $('#save_btn').on('click', function(e) {
        
        e.preventDefault();

        var btn = $(this);
    var form = $(this).closest('form');

        form.validate({
            rules: {
                service_name: {
                    required: true,
                
                },
                price: {
                    required: true,
                
                }
            }
        });

        if (!form.valid()) {
            return;
        }


        btn.attr('disabled', true);
        var data = new FormData(form[0]);

        //$('#msg').css('display', 'block');
        let url = $('#data_id').val() == 0 ? '/createDoctor' : '/updateDoctor'

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#msg').empty();
            },
            success: function(result) {
                //toastr.clear();
                if(result != 'success'){
                    alert(result)
                }else{
                    alert('save')
                    window.location.reload();
                }
                btn.attr('disabled', false);
            }
        });
      
    });

   

    // Edit - with universal route
    $('table tbody').on('click', '.edit', function() {
       
        $('#data_id').val($(this).data('id'));
        $('.form-password-toggle').hide();
        $('#name').val($(this).data('name'));
        $('#address').val($(this).data('address'));
        $('#contact').val($(this).data('contact'));
        $('#birthdate').val($(this).data('birthdate'));
        $('#email').val($(this).data('email'));
       
    });

    $('#btn_update').click(function(e){
        e.preventDefault();

        var btn = $(this);
    var form = $(this).closest('form');

        form.validate({
            rules: {
                service_name: {
                    required: true,
                
                },
                price: {
                    required: true,
                
                }
            }
        });

        if (!form.valid()) {
            return;
        }


        btn.attr('disabled', true);
        var data = new FormData(form[0]);

        //$('#msg').css('display', 'block');

        $.ajax({
            type: 'POST',
            url: '/updateService',
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $('#msg').empty();
            },
            success: function(result) {
                //toastr.clear();
                if(result != 'success'){
                    alert(result)
                }else{
                    alert('save')
                    window.location.reload();
                }
                btn.attr('disabled', false);
            }
        });
    })

});