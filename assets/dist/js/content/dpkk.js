$(document).ready(function () {
	
	$('#createDPKKForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            no_sk_dpkk: {
                validators: {
                    notEmpty: {
                        message: 'No SK Penetapan tidak boleh kosong.'
                    }
                }
            },
            luas_dpkk: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Luas harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            fileskpenetapan: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 2MB'
                    }
                }
            },
            filepeta: {
                validators: {
                    file: {
                        extension: 'kml',
                        type: 'application/vnd.google-earth.kml+xml',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat KML dengan ukuran maksimal 2MB'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createDPKKForm")[0]);
	    Pace.track(function(){
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
                $.toast({
                      heading: title,
                      text: message,
                      icon: status,
                      position: 'top-right',
                      afterHidden: function () {
                        if (status == 'success')
                        {
                            document.location.assign('../dpkk');
                        }
                        else if (status == 'error')
                        {
                            $("#createDPKKForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

	$('#updateDPKKForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            no_sk_dpkk: {
                validators: {
                    notEmpty: {
                        message: 'No SK Penetapan tidak boleh kosong.'
                    }
                }
            },
            luas_dpkk: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Luas harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            fileskpenetapan: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 2MB'
                    }
                }
            },
            filepeta: {
                validators: {
                    file: {
                        extension: 'kml',
                        type: 'application/vnd.google-earth.kml+xml',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat KML dengan ukuran maksimal 2MB'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#updateDPKKForm")[0]);
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
                            document.location.assign('../../dpkk');
                        }
                        else if (status == 'error')
                        {
                            $("#updateDPKKForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

	


});

function deleteData(iddata){
    var dialog = confirm("Anda yakin akan menghapus Data Daerah Penyangga Kawasan Konservasi ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../delete',
              data: {id:iddata},
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
                            document.location.assign('../../dpkk');
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


