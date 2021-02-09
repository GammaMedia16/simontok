$(document).ready(function () {
    
    

    

	$('#createOtherForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            detail_1: {
                validators: {
                    notEmpty: {
                        message: 'Data referensi tidak boleh kosong.'
                    }
                }
            }
            
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createOtherForm")[0]);
	    Pace.track(function(){
	    $.ajax({
	        type: 'POST',
	        url: '../insert',
	        data: data,
	        processData: false,
	        contentType: false,
	        success: function(data) {
	        	var title = JSON.parse(data).title;
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                $.toast({
                      heading: title,
                      text: message,
                      icon: status,
                      position: 'top-right',
                      afterHidden: function () {
                        if (status == 'success')
                        {
                            var get_ref = JSON.parse(data).get_ref;
                            document.location.assign('../data/' + get_ref);
                        }
                        else if (status == 'error')
                        {
                            $("#createOtherForm").data('formValidation').resetForm();
                            //document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });


	$('#updateOtherForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            detail_1: {
                validators: {
                    notEmpty: {
                        message: 'Data referensi tidak boleh kosong.'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#updateOtherForm")[0]);
	    Pace.track(function(){
	    $.ajax({
	        type: 'POST',
	        url: '../../update',
	        data: data,
	        processData: false,
	        contentType: false,
	        success: function(data) {
	        	var title = JSON.parse(data).title;
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                $.toast({
                      heading: title,
                      text: message,
                      icon: status,
                      position: 'top-right',
                      afterHidden: function () {
                        if (status == 'success')
                        {
                            var get_ref = JSON.parse(data).get_ref;
                            document.location.assign('../../data/' + get_ref);
                        }
                        else if (status == 'error')
                        {
                            $("#updateOtherForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

});


