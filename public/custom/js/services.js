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
            url: "/get_services",
            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.replace("/login");
                } else {
                    toastr.error('An error occured, please try again later');
                }
            }
        },
        columns: [{
                data: 'service_name',
                name: 'service_name',
                searchable: true
            },
            {
                data: "price",
                name: "price",
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
               
                    return '<button type="button"  data-id=' + data.id + ' data-service_name="' + data.service_name + '" data-price="' + data.price + '"  data-bs-toggle="modal" data-bs-target="#modal_edit" class="edit btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i></button> ';
				

				}
			}
        ],
        drawCallback: function(settings, json) {
            $('.tooltips').tooltip();
        },

    });

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

        $.ajax({
            type: 'POST',
            url: '/newService',
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
       
        $('#hidden_id_edit').val($(this).data('id'));
        $('#edit_service_name').val($(this).data('service_name'));
        $('#edit_price').val($(this).data('price'));
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