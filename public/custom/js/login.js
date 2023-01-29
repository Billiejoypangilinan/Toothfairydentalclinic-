$('#login_submit').click(function(e) {
    e.preventDefault();

    var btn = $(this);
    var form = $(this).closest('form');

    form.validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
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
        url: '/authenticate',
        data: data,
        processData: false,
        contentType: false,
        beforeSend: function(){
            $('#msg').empty();
        },
        success: function(result) {
            //toastr.clear();

            if (result == 'success') {
                location.href = '/dashboard';
            } else if (result == 'no_user') {
                $('#msg').html(alert_error('Username and password does\'nt match.')).delay(4000).fadeOut('slow');
                // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
            } else if (result == 'not_verified') {
                $('#msg').html(alert_error('Please verify your account. Check your email')).delay(4000).fadeOut('slow');
                // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
            } else {    
                $('#msg').html(alert_error('Ooops! something went wrong'));
                //btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
            }
            btn.attr('disabled', false);
        }
    });

});

$('#register_btn').click(function(e) {
    e.preventDefault();

    var btn = $(this);
    var form = $(this).closest('form');

    form.validate({
        rules: {
            name: {
                required: true,
               
            },
            address: {
                required: true,
              
            },
            contact: {
                required: true,
               
            },
            birthdate: {
                required: true,
               
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            },
            confirm_password:{
                required: true

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
        url: '/registerUser',
        data: data,
        processData: false,
        contentType: false,
        beforeSend: function(){
            $('#msg').empty();
        },
        success: function(result) {
            //toastr.clear();
            if(result != 'success'){
                $('#msg').html(alert_error(result)).delay(4000).fadeOut('slow');
            }else{
                $('#msg').html(alert_success('Successful registered.! An email sent to you')).delay(4000).fadeOut('slow');
            }
            // else if (result == 'no_user') {
            //     $('#msg').html(alert_error('Username and password does\'nt match.')).delay(4000).fadeOut('slow');
            //     // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
            // }
            // if (result == 'success') {
            //     location.href = '/dashboard';
            // } else if (result == 'no_user') {
            //     $('#msg').html(alert_error('Username and password does\'nt match.')).delay(4000).fadeOut('slow');
            //     // btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
            // } else {
            //     $('#msg').html(alert_error('Ooops! something went wrong'));
            //     //btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
            // }
            btn.attr('disabled', false);
        }
    });

});

$('#btn_fp').click(function(e){
    e.preventDefault();

    var btn = $(this);
    var form = $(this).closest('form');

    form.validate({
        rules: {
            email: {
                required: true,
                email: true
            },
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
        url: '/resetPassword',
        data: data,
        processData: false,
        contentType: false,
        beforeSend: function(){
            $('#msg').empty();
        },
        success: function(result) {
            //toastr.clear();
            if(result != 'success'){
                $('#msg').html(alert_error(result)).delay(4000).fadeOut('slow');
            }else{
                $('#msg').html(alert_success('Please check your email for default password')).delay(4000).fadeOut('slow');
            }
            
            btn.attr('disabled', false);
        }
    });
})