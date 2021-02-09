$(document).ready(function() {
    


    $('#editDesaBinaanForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_desa: {
                validators: {
                    notEmpty: {
                        message: 'Nama Desa tidak boleh kosong.'
                    },
                    stringLength: {
                        max: 250,
                        message: 'Nama Desa Maksimal 250 karakter.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#editDesaBinaanForm")[0]);

        $.ajax({
              type: 'POST',
              url: '../update',
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
                            document.location.assign('../../desabinaan');
                                
                        }
                        else if (status == 'error')
                        {
                            $("#editDesaBinaanForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
              }
          });
    });

    

});

