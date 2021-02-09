$(document).ready(function () {
    
    

    

	$('#createKelompokForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_kelompok: {
                validators: {
                    notEmpty: {
                        message: 'Nama Kelompok tidak boleh kosong.'
                    }
                }
            },
            telp_ketua: {
                validators: {
                    digits: {
                        message: 'Telepon harus diisi angka'
                    }
                }
            },
            telp_tokoh: {
                validators: {
                    digits: {
                        message: 'Telepon harus diisi angka'
                    }
                }
            },
            telp_pendamping: {
                validators: {
                    digits: {
                        message: 'Telepon harus diisi angka'
                    }
                }
            },
            fileskkelompok: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 2MB'
                    }
                }
            }
            
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createKelompokForm")[0]);
        
	    $.ajax({
	        type: 'POST',
	        url: 'insert',
	        data: data,
	        processData: false,
	        contentType: false,
	        success: function(data) {
	        	var title = JSON.parse(data).title;
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                var flag = JSON.parse(data).flag;
                var id_pdskk = JSON.parse(data).id_pdskk;
                $.toast({
                      heading: title,
                      text: message,
                      icon: status,
                      position: 'top-right',
                      afterHidden: function () {
                        if (status == 'success')
                        {
                            if (flag == 1) {
                                document.location.assign('../../pemberdayaan/binadesa/add');
                            } else if (flag == 2) {
                                document.location.assign('../../pemberdayaan/binadesa/edit/' + id_pdskk);
                            } else if (flag == 3) {
                                document.location.assign('../../pemberdayaan/kemkon/add');
                            } else if (flag == 4) {
                                document.location.assign('../../pemberdayaan/kemkon/edit/' + id_pdskk);
                            } else {
                                document.location.assign('../kelompok');
                            }
                        }
                        else if (status == 'error')
                        {
                            $("#createKelompokForm").data('formValidation').resetForm();
                            //document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
    });


	$('#updateKelompokForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_kelompok: {
                validators: {
                    notEmpty: {
                        message: 'Nama Kelompok tidak boleh kosong.'
                    }
                }
            },
            telp_ketua: {
                validators: {
                    digits: {
                        message: 'Telepon harus diisi angka'
                    }
                }
            },
            telp_tokoh: {
                validators: {
                    digits: {
                        message: 'Telepon harus diisi angka'
                    }
                }
            },
            telp_pendamping: {
                validators: {
                    digits: {
                        message: 'Telepon harus diisi angka'
                    }
                }
            },
            fileskkelompok: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 2MB'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#updateKelompokForm")[0]);
	    Pace.track(function(){
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
                            document.location.assign('../../kelompok');
                        }
                        else if (status == 'error')
                        {
                            $("#updateKelompokForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

});


