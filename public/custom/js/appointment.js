$(document).ready(function() {
   
    const user = $('#user_type').val()
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
            url: "/scheduleList",
            error: function(xhr) {
                if (xhr.status == 401) {
                    window.location.replace("/login");
                } else {
                    toastr.error('An error occured, please try again later');
                }
            }
        },
        columns: [{
                data: 'patient',
                name: 'patient',
                searchable: true
            },
            {
                data: "service",
                name: "services",
                searchable: true
            },
            {
                data: "price",
                name: "price",
                searchable: true
            },
			{
                data: "schedule_date",
                name: "schedule_date",
                searchable: true
            },
            {
                data: "doctor_name",
                name: "doctor_name",
                searchable: true
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                class: 'text-right',
                render: function(data, type, row) {
                    if (data.status == '0') {
                        return 'PENDING';
                    }else if (data.status == '1') {
                        return 'APPROVED';
                    }else{
                        return 'DISAPPROVED';
                    }
                  }
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
                console.log(data)
                    if(user == 'patient' && data.status == 0){
                        return '<button type="button"  data-id=' + data.id + ' data-doctor="' + data.doctor 
                        + '" data-service="' + data.service_id 
                        + '" data-schedule_date="' + data.schedule_date
                        + '"  data-bs-toggle="modal" data-bs-target="#modal_add" class="edit btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i></button>';
                    }else if(user == 'patient' && (data.status == 1 || data.status == 2)){
                        return '<span>No available</span>';
                    }else if (user == 'doctor' && data.status == 0){
                        return '<button type="button"  data-id=' + data.id 
                        + '" data-patient="' + data.patient
                        + '" data-patient_id="' + data.user_id
                        + '" data-schedule_date="' + data.schedule_date
                        + '"  data-bs-toggle="modal" data-bs-target="#modal_approve" id="approve" class="btn btn-sm btn-secondary"><i class="fa fa-thumbs-up"></i></button>';
                    }else if (user == 'doctor' && (data.status == 1 || data.status == 2)){
                        return '<span>No available</span>';
                    }else if (user == 'admin' && data.status == 0){
                        return '<button type="button"  data-id=' + data.id 
                        + '" data-patient="' + data.patient 
                        + '" data-schedule_date="' + data.schedule_date
                        + '" data-patient_id="' + data.user_id
                        + '"  data-bs-toggle="modal" data-bs-target="#modal_approve" id="approve" class="btn btn-sm btn-secondary"><i class="fa fa-thumbs-up"></i></button>'
                        +'<button type="button"  data-id=' + data.id + ' data-doctor="' + data.doctor 
                        + '" data-service="' + data.service_id 
                        + '" data-schedule_date="' + data.schedule_date
                        + '"  data-bs-toggle="modal" data-bs-target="#modal_add" class="edit btn btn-sm btn-secondary"><i class="fa fa-pencil-alt"></i></button>';
                    }else if (user == 'admin' && (data.status == 1 || data.status == 2)){
                        return '<span>No available</span>';
                    }
				}
			}
        ],
        drawCallback: function(settings, json) {
            $('.tooltips').tooltip();
        },

    });

    $('#new').on('click', function(e) {
        $('#data_id').val(0);
        $('#service').val('');
        $('#doctor').val('');
        $('#schedule_date').val('');
       
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
        let url = $('#data_id').val() == 0 ? '/createAppointment' : '/updateAppointment'

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
        console.log($(this).data())
        $('#data_id').val($(this).data('id'));
        $('#service').val($(this).data('service'));
        $('#doctor').val($(this).data('doctor'));
        $('#schedule_date').val($(this).data('schedule_date'));
       
    });
    
    $('table tbody').on('click', '#approve', function() {
        $('#data_id').val($(this).data('id'));
        $('#patient_id').val($(this).data('patient_id'));
        $('#client_info').html('patient '+$(this).data('patient')+' on '+$(this).data('schedule_date'))
    });

    $('#approve_btn').click(function(){
        $.ajax({
            type: 'GET',
            url: '/approveAppointment/'+$('#data_id').val()+'/approved/'+$('#patient_id').val(),
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

    $('#cancel_btn').click(function(){
        $.ajax({
            type: 'GET',
            url: '/approveAppointment/'+$('#data_id').val()+'/disapproved/'+$('#patient_id').val(),
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