$(document).ready(function() {

    $('#userCreateForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            gender: {
                validators: {
                    notEmpty: {
                        message: 'Gender harus diisi dengan L/P'
                    }
                }
            },
            username: {
                validators: {
                    regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'The username can only consist of alphabetical and number'
                        },
                    notEmpty: {
                        message: 'The username is required and can\'t be empty'
                    },
                    stringLength: {
                        max: 200,
                        message: 'The username must be 6  to 200 characters long'
                    },
                }
            },
            new_password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        message: 'The Password must be minimal 6 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: 'The Password can only consist of alphabetical and number'
                    },
                    different: {
                    field: 'old_password',
                    message: 'The New Password cannot be the same as Old Password'
                    }
                }
            },
            confirm_new_password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        message: 'The Password must be minimal 6 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: 'The Password can only consist of alphabetical and number'
                    },
                    identical: {
                    field: 'new_password',
                    message: 'The New Password and its confirm are not the same'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        
        $.ajax({
              type: 'POST',
              url: 'insert',
              data: $("#userCreateForm").serialize(),
              success: function(data) {
                console.log(data);
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
                             document.location.assign('../users');
                        }
                        else if (status == 'error')
                        {
                            document.location.reload();
                        }

                        
                      }
                })
              }
        });
    });

    $('#userEditForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                validators: {
                    regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'The username can only consist of alphabetical and number'
                        },
                    notEmpty: {
                        message: 'The username is required and can\'t be empty'
                    },
                    stringLength: {
                        max: 200,
                        message: 'The username must be 6  to 200 characters long'
                    },
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        
        $.ajax({
              type: 'POST',
              url: '../update',
              data: $("#userEditForm").serialize(),
              success: function(data) {
                console.log(data);
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                var title = JSON.parse(data).title;
                var sub_role = JSON.parse(data).sub_role;
                $.toast({
                      heading: title,
                      text: message,
                      icon: status,
                      position: 'top-right',
                      afterHidden: function () {
                        if (status == 'success')
                        {
                            if (sub_role == 3) {
                                document.location.assign('../../users');
                            } else {
                                document.location.assign('../../../access/logout');
                            }
                        }
                        else if (status == 'error')
                        {
                            document.location.reload();
                        }

                        
                      }
                })
                        
              }
        });
    });

    /*$('#userThisEditForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                validators: {
                    regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'Username hanya huruf dan angka'
                        },
                    notEmpty: {
                        message: 'Username tidak boleh kosong'
                    },
                    stringLength: {
                        min: 5,
                        max: 200,
                        message: 'Username minimal 5 - 200 karakter'
                    },
                }
            },
            nama: {
                validators: {
                    notEmpty: {
                        message: 'Nama tidak boleh kosong'
                    }
                }
            },
            gender: {
                validators: {
                    notEmpty: {
                        message: 'Gender tidak boleh kosong'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        
        $.ajax({
              type: 'POST',
              url: '../updateuser',
              data: $("#userThisEditForm").serialize(),
              success: function(data) {
                console.log(data);
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $("#userThisEditForm").data('formValidation').resetForm();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../../../access/logout');
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 2000);
                }
              }
        });
    });*/

    $('#userChangePass')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            old_password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        message: 'The Password must be minimal 6 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: 'The Password can only consist of alphabetical and number'
                    }
                }
            },
            new_password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        message: 'The Password must be minimal 6 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: 'The username can only consist of alphabetical and number'
                    },
                    different: {
                    field: 'old_password',
                    message: 'The New Password cannot be the same as Old Password'
                    }
                }
            },
            confirm_new_password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        message: 'The Password must be minimal 6 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: 'The Password can only consist of alphabetical and number'
                    },
                    identical: {
                    field: 'new_password',
                    message: 'The New Password and its confirm are not the same'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var idUser = $('#id_user').val();
        $.ajax({
              type: 'POST',
              url: '../changepass',
              data: $("#userChangePass").serialize(),
              success: function(data) {
                console.log(data);
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
                            document.location.assign('../../../access/logout');
                        }
                        else if (status == 'error')
                        {
                            document.location.reload();
                        }

                        
                      }
                })
              }
        });
    });
// end document ready
});

function deleteUser(id){
    var dialog = confirm("Anda yakin akan menghapus User ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: './users/delete',
              data: {id_user:id},
              success: function(data) {
                console.log(data);
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
                            document.location.reload();
                        }
                        else if (status == 'error')
                        {
                            document.location.reload();
                        }

                        
                      }
                })
                
              }
        });
    } else {
        return false;
    }
    
}