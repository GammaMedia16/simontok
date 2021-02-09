$(document).ready(function () {
	
	$('#createPDSKKForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            keuntungan_usaha: {
                validators: {
                    digits: {
                        message: 'Keuntungan Usaha harus diisi angka'
                    }
                }
            },
            rata_pendapatan: {
                validators: {
                    digits: {
                        message: 'Rerata Pendapatan harus diisi angka'
                    }
                }
            },
            jml_kas: {
                validators: {
                    digits: {
                        message: 'Jumlah Kas harus diisi angka'
                    }
                }
            },
            filerpl: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 5*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 5MB'
                    }
                }
            },
            filerkt: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 5*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 5MB'
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
            },
            fotousaha: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 1*1024*1024,
                        message: 'File harus berformat JPG/JPEG/PNG dengan ukuran maksimal 1MB'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createPDSKKForm")[0]);
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
                            $("#createPDSKKForm").data('formValidation').resetForm();
                            document.location.assign('../binadesa');
                        }
                        else if (status == 'error')
                        {
                            $("#createPDSKKForm").data('formValidation').resetForm();
                            //document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

	$('#updatePDSKKForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            keuntungan_usaha: {
                validators: {
                    digits: {
                        message: 'Keuntungan Usaha harus diisi angka'
                    }
                }
            },
            rata_pendapatan: {
                validators: {
                    digits: {
                        message: 'Rerata Pendapatan harus diisi angka'
                    }
                }
            },
            jml_kas: {
                validators: {
                    digits: {
                        message: 'Jumlah Kas harus diisi angka'
                    }
                }
            },
            filerpl: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 5*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 5MB'
                    }
                }
            },
            filerkt: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 5*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 5MB'
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
            },
            fotousaha: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 1*1024*1024,
                        message: 'File harus berformat JPG/JPEG/PNG dengan ukuran maksimal 1MB'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#updatePDSKKForm")[0]);
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
                            document.location.assign('../../binadesa');
                        }
                        else if (status == 'error')
                        {
                            $("#updatePDSKKForm").data('formValidation').resetForm();
                            //document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

	


});

function deleteData(idkelompok,tahun){
    var dialog = confirm("Anda yakin akan menghapus Pembinaan Desa Sekitar KK ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../delete',
              data: {kelompok_id:idkelompok, tahun_keg:tahun},
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
                            document.location.assign('../../binadesa');
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

