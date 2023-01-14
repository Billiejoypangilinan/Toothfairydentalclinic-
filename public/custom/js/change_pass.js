$(document).ready(function() {

    Parsley.addAsyncValidator("check_password", function(xhr) {
        return xhr.responseText === 'false' ? false : true;
    }, "/check_password");

    $("#save_btn").on("click", function(e) {

        e.preventDefault();

        var btn = $(this);
        var form = $(this).closest('form');

            form.validate({
                rules: {
                    old_password: {
                        required: true,
                    
                    },
                    new_password: {
                        required: true,
                    
                    },
                    confirm_password: {
                        required: true,
                    
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

        if($('#new_password').val() == $('#old_password').val()){
            alert('You cannot use your old password as new one')
            return false
        }

        if($('#new_password').val() != $('#confirm_password').val()){
            alert('Password mismatch')
            return false
        }


        btn.attr('disabled', true);
        var data = new FormData(form[0]);
        
            $.ajax({
                type: 'POST',
                url: '/updatePass',
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