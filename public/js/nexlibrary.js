toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-left",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}


//PARSELY VALIDATION
  window.Parsley.addValidator('maxFileSize', {
    validateString: function(_value, maxSize, parsleyInstance) {
      if (!window.FormData) {
        return true;
      }

         var fp       = parsleyInstance.$element[0].files;

         var lg       = fp.length; // get length
         var items    = fp;
         var fileSize = 0;
     
       if (lg > 0) {
           for (var i = 0; i < lg; i++) {
               fileSize = fileSize+items[i].size; // get file size
           }
           if(fileSize > 25600000) {
                return false;
           }
       }

    },
    requirementType: 'integer',
    messages: {
      en: 'The files reach the maximum of 25MB'
    }
  });

  window.Parsley.addValidator('fileextension', {
    validateString: function(value, requirement) {
      var fileExtension = value.split('.').pop();
      return fileExtension === requirement;
    },
    messages: {
      en: 'It only accept PDF file.'
    }
  });


function alert_warning(msg){
	var a = '<div class="alert alert-warning">';
	a +='<button data-dismiss="alert" class="close"></button>';
	a +=''+msg+'';
	a += '</div>';
	return a;
}



function alert_default(text){
	var div = "";
		div +='<div class="alert alert-secondary">';
		div += text;
		div +='</div>';
		return div;
}

function alert_success(text){
	var div = "";
		div +='<div class="alert alert-success">';
		div += text;
		div +='</div>';
		return div;
}

function alert_error(text){
		var div = "";
		div +='<div class="alert alert-danger">';
		div += text;
		div +='</div>';
		return div;
}


/*function alert_default(text){
		var div = "";
		div +='<div class="alert alert-gradient">';
		div +='<div class="d-flex justify-content-between">';
				div +='<div class="icon-big">';
				div +=		'<i class="fa fa-info-circle"></i>';
				div +='</div>';
				div +='<div class="alert-msg">';
				div +=	'<h4 class="bold mb-0">Notification</h4>';
				div +=	'<p class="mb-0">'+text+'</p>';
				div +=	'</div>';
				div +='</div>';
			  div +='</div>';
		return div;
}*/

function alert_default_error(text){
		var div = "";
		div +='<div class="alert alert-gradient-error">';
		div +='<div class="d-flex justify-content-between">';
				div +='<div class="icon-big">';
				div +=		'<i class="fa fa-times-circle"></i>';
				div +='</div>';
				div +='<div class="alert-msg">';
				div +=	'<h4 class="bold mb-0">Notification</h4>';
				div +=	'<p class="mb-0">'+text+'</p>';
				div +=	'</div>';
				div +='</div>';
			  div +='</div>';
		return div;
}

function alert_default_success(text){
		var div = "";
		div +='<div class="alert alert-gradient-success">';
		div +='<div class="d-flex justify-content-between">';
				div +='<div class="icon-big">';
				div +=		'<i class="fa fa-check-circle"></i>';
				div +='</div>';
				div +='<div class="alert-msg">';
				div +=	'<h4 class="bold mb-0">Success</h4>';
				div +=	'<p class="mb-0">'+text+'</p>';
				div +=	'</div>';
				div +='</div>';
			  div +='</div>';
		return div;
}



/*
* GRITTER Alert Box
* */
function gritter_err(res) {
	$.gritter.add({
		title: 'Error',
		text: res,
		class_name: 'with-icon times-circle danger'
	});
}

function gritter_succ(res) {
	$.gritter.add({
		title: 'Success',
		text: res,
		class_name: 'with-icon check-circle success'
	});
}

/**
* CRUD Function using ajax request
* */

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 46 && charCode > 31
		&& (charCode < 48 || charCode > 57))
		return false;

	return true;
}

function format_number(number) {
	let format = '';

	if (number <= 9) {
		format = '000' + number;

	} else if (number <= 99) {
		format = '00' + number;

	} else if (number <= 999) {
		format = '0' + number;

	} else {
		format = number;
	}
	return format;
}


jQuery.fn.crud = function () {

	//INITIALIZATION
	var base = $(this);
	var btn = base.find("button");

	base.submit(function (e) {
		e.preventDefault();
		var form = base.parsley();
		form.whenValidate().done(function () {
			//e.preventDefault();

			//AJAX REQUEST
			$.ajax({
				type: base.attr("method"),//get/post
				data: base.serializeArray(),
				url: base.attr("action"),//location for the url

				beforeSend: function () {
					btn.prop("disabled", true);
				},

				success: function (res) {
					btn.prop("disabled", false);

					var response = JSON.parse(res);
					stat = response.stat;
					msg = response.msg;

					if (stat == 'success') {
						toastr.success("Success.", msg);

						var modal = $('.modal').hasClass('show');
						if (modal) {
							$('.modal').modal('hide');
						}

					} else if (stat == 'error') {
						toastr.error("Failed.", msg);
					} else if (stat == 'no_changes') {
						toastr.warning("No changes made.");
					}

					base.trigger('reset');
					form.reset();

				},
				error: function (res) {
					btn.prop("disabled", false);
					toastr.error('An error occured, please try again later');
				}
			});
		});




	});
}


jQuery.fn.crud_refresh = function () {
	var base = $(this).closest('form');
	var btn = base.find("button");

	var form = base.parsley();
	form.whenValidate().done(function () {

		//AJAX REQUEST
		$.ajax({
			type: base.attr("method"),//get/post
			data: base.serializeArray(),
			url: base.attr("action"),//location for the url

			beforeSend: function () {
				btn.prop("disabled", true);
			},

			success: function (res) {
				btn.prop("disabled", false);

				var response = JSON.parse(res);
				stat = response.stat;
				msg = response.msg;

				if (stat == 'success') {
					toastr.success("Success.", msg);

					var modal = $('.modal').hasClass('show');
					if (modal) {
						$('.modal').modal('hide');
					}

					setTimeout(function () { location.reload(); }, 2000);


				} else if (stat == 'error') {
					toastr.error("Failed.", msg);
				} else if (stat == 'no_changes') {
					toastr.warning("No changes made.");
				}

				base.trigger('reset');
				form.reset();

			},
			error: function (res) {
				btn.prop("disabled", false);
				toastr.error('An error occured, please try again later');
			}
		});

	});

	return false;
}


jQuery.fn.crud_click = function () {
	var base = $(this).closest('form');
	var btn = base.find("button");

	var form = base.parsley();
	form.whenValidate().done(function () {

		//AJAX REQUEST
		$.ajax({
			type: base.attr("method"),//get/post
			data: base.serializeArray(),
			url: base.attr("action"),//location for the url

			beforeSend: function () {
				btn.prop("disabled", true);
			},

			success: function (res) {
				btn.prop("disabled", false);

				var response = JSON.parse(res);
				stat = response.stat;
				msg = response.msg;

				if (stat == 'success') {
					toastr.success("Success.", msg);

					var modal = $('.modal').hasClass('show');
					if (modal) {
						$('.modal').modal('hide');
					}

					var dtable = $('table').DataTable();
					dtable.ajax.reload();

				} else if (stat == 'error') {
					toastr.error("Failed.", msg);
				} else if (stat == 'no_changes') {
					toastr.warning("No changes made.");
				}

				base.trigger('reset');
				form.reset();
				base.find(".select2").val([]).trigger("change");
				

			},
			error: function (res) {
				btn.prop("disabled", false);
				toastr.error('An error occured, please try again later');
			}
		});

	});

	return false;
}

jQuery.fn.crud_table = function () {
	var base 	= $(this).closest('form');
	var btn 	= base.find("button");

	var form = base.parsley();
	form.whenValidate().done(function () {

		//AJAX REQUEST
		$.ajax({
			type: base.attr("method"),//get/post
			data: base.serializeArray(),
			url: base.attr("action"),//location for the url

			beforeSend: function () {
				btn.prop("disabled", true);
			},

			success: function (res) {
				btn.prop("disabled", false);

				var response = JSON.parse(res);
				stat = response.stat;
				msg = response.msg;

				if (stat == 'success') {
					toastr.success("Success.", msg);

					var modal = $('.modal').hasClass('show');
					if (modal) {
						$('.modal').modal('hide');
					}

					var dtable = $('.dtbl').DataTable();
					dtable.ajax.reload();

					$('.select2').val("").trigger("change");
					base.trigger('reset');
					form.reset();
					base.find(".select2").val([]).trigger("change");


				} else if (stat == 'error') {
					toastr.error("Failed.", msg);
				} else if (stat == 'no_changes') {
					toastr.warning("No changes made.");
				}

				
				

			},
			error: function (res) {
				btn.prop("disabled", false);
				toastr.error('An error occured, please try again later');
			}
		});

	});

	return false;
}



jQuery.fn.basic_crud = function () {
	var base = $(this).closest('form');
	var btn = base.find("button");

	var form = base.parsley();
	form.whenValidate().done(function () {

		//AJAX REQUEST
		$.ajax({
			type: base.attr("method"),//get/post
			data: base.serializeArray(),
			url: base.attr("action"),//location for the url

			beforeSend: function () {
				btn.prop("disabled", true);
			},

			success: function (res) {
				btn.prop("disabled", false);

				var response = JSON.parse(res);
				stat = response.stat;
				msg = response.msg;

				if (stat == 'success') {
					toastr.success("Success.", msg);

					var modal = $('.modal').hasClass('show');
					if (modal) {
						$('.modal').modal('hide');
					}


					base.trigger('reset');
					form.reset();
					base.find(".select2").val([]).trigger("change");

				} else if (stat == 'error') {
					toastr.error("Failed.", msg);
				} else if (stat == 'no_changes') {
					toastr.warning("No changes made.");
				}

				
			},
			error: function (res) {
				btn.prop("disabled", false);
				toastr.error('An error occured, please try again later');
			}
		});

	});

	return false;
}

/**
* CRUD REFRESH Function using ajax request
* */

jQuery.fn.crud_delete = function () {

	//INITIALIZATION
	var base = $(this);
	var btn = base.find("button");

	base.submit(function (e) {
		e.preventDefault();


		//AJAX REQUEST
		$.ajax({
			type: base.attr("method"),//get/post
			data: base.serialize(),
			url: base.attr("action"),//location for the url

			beforeSend: function () {
				btn.prop("disabled", true);
			},

			success: function (res) {
				btn.prop("disabled", false);

				var response = $.parseJSON(res);
				stat = response.stat;
				msg = response.msg;

				if (stat == 'success') {
					toastr.success("Success.", msg);

					var modal = $('.modal').hasClass('show');
					if (modal) {
						$('.modal').modal('hide');
					}

					var dtable = $('table').DataTable();
					dtable.ajax.reload();

				} else if (stat == 'error') {
					// console.log(msg);
					toastr.error("Failed.", msg);
				} else if (stat == 'no_changes') {
					toastr.warning("No changes made.");
				}

				base.trigger('reset');

			},
			error: function (res) {
				if (res.status == 401) {
					window.location.replace("/login");
				} else {
					btn.prop("disabled", false);
					toastr.error('An error occured, please try again later');
				}
			}
		});

	});
}

jQuery.fn.crud_change_status = function () {

	//INITIALIZATION
	var base = $(this);
	var btn = base.find("button");

	base.submit(function (e) {
		e.preventDefault();


		//AJAX REQUEST
		$.ajax({
			type: base.attr("method"),//get/post
			data: base.serialize(),
			url: base.attr("action"),//location for the url

			beforeSend: function () {
				btn.prop("disabled", true);
			},

			success: function (res) {
				btn.prop("disabled", false);

				var response = $.parseJSON(res);
				stat = response.stat;
				msg = response.msg;

				if (stat == 'success') {
					toastr.success("Success.", msg);

					var modal = $('.modal').hasClass('show');
					if (modal) {
						$('.modal').modal('hide');
					}

					var dtable = $('table.dtbl').DataTable();
					dtable.ajax.reload();

				} else if (stat == 'error') {
					// console.log(msg);
					toastr.error("Failed.", msg);
				} else if (stat == 'no_changes') {
					toastr.warning("No changes made.");
				}

				base.trigger('reset');

			},
			error: function (res) {
				if (res.status == 401) {
					window.location.replace("/login");
				} else {
					btn.prop("disabled", false);
					toastr.error('An error occured, please try again later');
				}
			}
		});

	});
}

//javascript convert image to base64
jQuery.fn.encodeImageFileAsURL = function(element) {
    var file 		= element.files[0];
    var reader 	= new FileReader();
    reader.onloadend = function() {
      return reader.result;
    }
    //return reader.readAsDataURL(file);
}


jQuery.fn.set_date = function() {
	var date = new Date();
  var day = ("0" + date.getDate()).slice(-2); var month = ("0" + (date.getMonth() + 1)).slice(-2);
  var today = date.getFullYear()+"-"+(month)+"-"+(day) ;
  
  $('input[type=date]').val(today);
}


jQuery.fn.file_upload = function(){
		var upload_form = $(this);
    var bar     		= upload_form.find('.bar');
    var percent 		= bar;
    var percentVal 	= '0%';


      upload_form.ajaxForm({
              data:$(this).serialize(),
              beforeSend: function() {
                //percentVal = '0%';
                bar.empty().width(percentVal);
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete,e){
                percentVal = percentComplete + '%';
                bar.empty().width(percentVal);
                percent.html(percentVal);
            },
            success: function(res) {
                percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            complete: function(res){
            		var response = $.parseJSON(res.responseText);
                stat = response.stat;
                msg  = response.msg;

                toastr.success(res);
            },
            error:function(){
                toastr.error('An error occured, please try again later');
            }
      });//END AJAX UPLOAD
}

jQuery.fn.dateDiff = function(date){
	let given   = moment(date, "YYYY-MM-DD");
  let current = moment().startOf('day');

  //Difference in number of days
  let days = moment.duration(given.diff(current)).asDays();

 return days;
}




//image to base64
/*var newImage = document.createElement('img');
        newImage.src = srcData;

        document.getElementById("imgTest").innerHTML = newImage.outerHTML;
        alert("Converted Base64 version is " + document.getElementById("imgTest").innerHTML);
        console.log("Converted Base64 version is " + document.getElementById("imgTest").innerHTML);
      }
      fileReader.readAsDataURL(fileToLoad);
    }*/
  



/*jQuery.fn.confirm = function (options) {
  var settings = $.extend({}, $.fn.confirm.defaults, options);

	return this.each(function () {
	  var element = this;

	  $('.modal-title', this).html(settings.title);
	  $('.message', this).html(settings.message);
	  $('.confirm', this).html(settings.confirm);
	  $('.dismiss', this).html(settings.dismiss);

	  $(this).on('click', '.confirm', function (event) {
		$(element).data('confirm', true);
	  });

	  $(this).on('hide.bs.modal', function (event) {
		if ($(this).data('confirm')) {
		  $(this).trigger('confirm', event);
		  $(this).removeData('confirm');
		} else {
		  $(this).trigger('dismiss', event);
		}

		$(this).off('confirm dismiss');
	  });

	  $(this).modal('show');
	});
};*/


/**
* INITIALIZE DATA TABLES
* */

// $(".datatable").DataTable();



/* =========================================================================================
*
*Toastr Other Options
*
*
// Display a warning toast, with no title
toastr.warning('My name is Inigo Montoya. You killed my father, prepare to die!')

// Display a success toast, with a title
toastr.success('Have fun storming the castle!', 'Miracle Max Says')

// Display an error toast, with a title
toastr.error('I do not think that word means what you think it means.', 'Inconceivable!')

// Immediately remove current toasts without using animation
toastr.remove()

// Remove current toasts using animation
toastr.clear()

// Override global options
toastr.success('We do have the Kapua suite available.', 'Turtle Bay Resort', {timeOut: 5000})

**/




