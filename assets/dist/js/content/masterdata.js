$(document).ready(function() {

    $('#arsipSekCreateForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            angka_kode: {
                validators: {
                    notEmpty: {
                        message: 'Angka Kode Arsip tidak boleh kosong.'
                    },
                    digits: {
                        message: 'Angka Kode Arsip Harus Angka'
                    }
                }
            },
            rincian_kode: {
                validators: {
                    notEmpty: {
                        message: 'Rincian Arsip tidak boleh kosong.'
                    }
                }
            },
            kode_primer: {
                validators: {
                    notEmpty: {
                        message: 'Kode Primer tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#arsipSekCreateForm")[0]);
        $.ajax({
              type: 'POST',
              url: 'insertsek',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var new_id = JSON.parse(data).new_id_surat;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#arsipSekCreateForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        //document.location.assign('./');
                    }, 2000);
                    //printDisposisiSuratMasuk(new_id);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 3000);
                    $("#arsipSekCreateForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#arsipSekCreateForm").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#arsipSekEditForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            kode_arsip: {
                validators: {
                    notEmpty: {
                        message: 'Kode Arsip tidak boleh kosong.'
                    }
                }
            },
            rincian_kode: {
                validators: {
                    notEmpty: {
                        message: 'Rincian Arsip tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#arsipSekEditForm")[0]);
        $.ajax({
              type: 'POST',
              url: '../update',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var no_resi = JSON.parse(data).no_resi;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#arsipSekEditForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../');
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
                    }, 3000);
                    $("#arsipSekEditForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#arsipSekEditForm").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#arsipCreateForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            kode_arsip: {
                validators: {
                    notEmpty: {
                        message: 'Kode Arsip tidak boleh kosong.'
                    }
                }
            },
            rincian_kode: {
                validators: {
                    notEmpty: {
                        message: 'Rincian Arsip tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#arsipCreateForm")[0]);
        $.ajax({
              type: 'POST',
              url: 'insert',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var new_id = JSON.parse(data).new_id_surat;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#arsipCreateForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('./');
                    }, 2000);
                    //printDisposisiSuratMasuk(new_id);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 3000);
                    $("#arsipCreateForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#arsipCreateForm").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#arsipEditForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            kode_arsip: {
                validators: {
                    notEmpty: {
                        message: 'Kode Arsip tidak boleh kosong.'
                    }
                }
            },
            rincian_kode: {
                validators: {
                    notEmpty: {
                        message: 'Rincian Arsip tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#arsipEditForm")[0]);
        $.ajax({
              type: 'POST',
              url: '../update',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var no_resi = JSON.parse(data).no_resi;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#arsipEditForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../');
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
                    }, 3000);
                    $("#arsipEditForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#arsipEditForm").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#asalCreateForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            asal: {
                validators: {
                    notEmpty: {
                        message: 'Asal Surat tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#asalCreateForm")[0]);
        $.ajax({
              type: 'POST',
              url: 'insert',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var new_id = JSON.parse(data).new_id_surat;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#asalCreateForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('./');
                    }, 2000);
                    //printDisposisiSuratMasuk(new_id);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 3000);
                    $("#asalCreateForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#asalCreateForm").data('formValidation').resetForm();
                }
              }
          });
    });
    
    $('#asalEditForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            asal: {
                validators: {
                    notEmpty: {
                        message: 'Asal Surat tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#asalEditForm")[0]);
        $.ajax({
              type: 'POST',
              url: '../update',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var no_resi = JSON.parse(data).no_resi;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#asalEditForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../');
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
                    }, 3000);
                    $("#asalEditForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#asalEditForm").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#kategoriCreateForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            kode: {
                validators: {
                    notEmpty: {
                        message: 'Kode tidak boleh kosong.'
                    }
                }
            },
            kategori: {
                validators: {
                    notEmpty: {
                        message: 'Kategori Surat tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#kategoriCreateForm")[0]);
        $.ajax({
              type: 'POST',
              url: 'insert',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var new_id = JSON.parse(data).new_id_surat;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#kategoriCreateForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('./');
                    }, 2000);
                    //printDisposisiSuratMasuk(new_id);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 3000);
                    $("#kategoriCreateForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#kategoriCreateForm").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#kategoriEditForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            kode: {
                validators: {
                    notEmpty: {
                        message: 'Kode tidak boleh kosong.'
                    }
                }
            },
            kategori: {
                validators: {
                    notEmpty: {
                        message: 'Kategori Surat tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#kategoriEditForm")[0]);
        $.ajax({
              type: 'POST',
              url: '../update',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var no_resi = JSON.parse(data).no_resi;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#kategoriEditForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../');
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
                    }, 3000);
                    $("#kategoriEditForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#kategoriEditForm").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#disposisiCreateForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            isi: {
                validators: {
                    notEmpty: {
                        message: 'Disposisi tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#disposisiCreateForm")[0]);
        $.ajax({
              type: 'POST',
              url: 'insert',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var new_id = JSON.parse(data).new_id_surat;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#disposisiCreateForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('./');
                    }, 2000);
                    //printDisposisiSuratMasuk(new_id);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 3000);
                    $("#disposisiCreateForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#disposisiCreateForm").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#isidisposisiCreateForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            isi: {
                validators: {
                    notEmpty: {
                        message: 'Isi Disposisi tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#isidisposisiCreateForm")[0]);
        $.ajax({
              type: 'POST',
              url: 'insertisi',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var new_id = JSON.parse(data).new_id_surat;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#isidisposisiCreateForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('./');
                    }, 2000);
                    //printDisposisiSuratMasuk(new_id);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 3000);
                    $("#isidisposisiCreateForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#isidisposisiCreateForm").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#disposisiEditForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            isi: {
                validators: {
                    notEmpty: {
                        message: 'Disposisi tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#disposisiEditForm")[0]);
        $.ajax({
              type: 'POST',
              url: '../update',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var no_resi = JSON.parse(data).no_resi;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#disposisiEditForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../');
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
                    }, 3000);
                    $("#disposisiEditForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#disposisiEditForm").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#isidisposisiEditForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            isi: {
                validators: {
                    notEmpty: {
                        message: 'Disposisi tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#isidisposisiEditForm")[0]);
        $.ajax({
              type: 'POST',
              url: '../update',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var no_resi = JSON.parse(data).no_resi;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#isidisposisiEditForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../');
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
                    }, 3000);
                    $("#isidisposisiEditForm").data('formValidation').resetForm();
                }
                else if (status == 'warning')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-warning');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                    }, 5000);
                    $("#isidisposisiEditForm").data('formValidation').resetForm();
                }
              }
          });
    });

});


$('#kode_primer').on('change', function() {
    var kode = $("#kode_primer option:selected").attr('data-kd');
    $('#kode_arsip').val(kode);
})
