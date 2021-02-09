$(document).ready(function () {
    
    $('#createTargetPenerimaan')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            kode_akun_penerimaan: {
                validators: {
                    notEmpty: {
                        message: 'Kode akun tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Kode akun harus diisi angka'
                    }
                }
            },
            jenis_penerimaan: {
                validators: {
                    notEmpty: {
                        message: 'Jenis target penerimaan tidak boleh kosong.'
                    }

                }
            },
            jml_target_penerimaan: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah target penerimaan tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Jumlah target penerimaan harus diisi angka'
                    }

                }
            },
            thn_target_penerimaan: {
                validators: {
                    notEmpty: {
                        message: 'Tahun tidak boleh kosong.'
                    }

                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createTargetPenerimaan")[0]);
        $.ajax({
              type: 'POST',
              url: 'createtarget',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        document.location.assign('./target');
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                       $form.find('.alert').hide();
                    }, 2000);
                    $("#createTargetPenerimaan").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#editTargetPenerimaan')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            kode_akun_penerimaan: {
                validators: {
                    notEmpty: {
                        message: 'Kode akun tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Kode akun harus diisi angka'
                    }
                }
            },
            jenis_penerimaan: {
                validators: {
                    notEmpty: {
                        message: 'Jenis target penerimaan tidak boleh kosong.'
                    }

                }
            },
            jml_target_penerimaan: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah target penerimaan tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Jumlah realisasi harus diisi angka'
                    }

                }
            },
            thn_target_penerimaan: {
                validators: {
                    notEmpty: {
                        message: 'Tahun tidak boleh kosong.'
                    }

                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#editTargetPenerimaan")[0]);
        $.ajax({
              type: 'POST',
              url: '../updatetarget',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                	setTimeout(function() {
                        document.location.assign('../target');
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                       $form.find('.alert').hide();
                    }, 2000);
                    $("#editTargetPenerimaan").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#createRealisasiPenerimaan')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            jml_rterima: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah realisasi tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Jumlah realisasi harus diisi angka'
                    }

                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createRealisasiPenerimaan")[0]);
        $.ajax({
              type: 'POST',
              url: '../createrealisasipenerimaan',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        document.location.reload('');
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                       $form.find('.alert').hide();
                    }, 2000);
                    $("#createRealisasiPenerimaan").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#editRealisasiTerima')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            jml_rterima: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah realisasi tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Jumlah realisasi harus diisi angka'
                    }

                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#editRealisasiTerima")[0]);
        $.ajax({
              type: 'POST',
              url: '../updaterealisasipenerimaan',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    var kdakun = JSON.parse(data).kdakun;
                    setTimeout(function() {
                        document.location.assign('../addrealisasipenerimaan/'+kdakun);
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                       $form.find('.alert').hide();
                    }, 2000);
                    $("#editRealisasiTerima").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#editPengembalian')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            jml_pengembalian: {
                validators: {
                    notEmpty: {
                        message: 'Jumlah pengembalian tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Jumlah pengembalian harus diisi angka'
                    }

                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#editPengembalian")[0]);
        $.ajax({
              type: 'POST',
              url: '../updatepengembalian',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    var kdakun = JSON.parse(data).kdakun;
                    setTimeout(function() {
                        document.location.assign('../addrealisasipenerimaan/'+kdakun);
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                       $form.find('.alert').hide();
                    }, 2000);
                    $("#editPengembalian").data('formValidation').resetForm();
                }
              }
          });
    });
});
