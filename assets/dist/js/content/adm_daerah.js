$(document).ready(function() {
    $('#createProvinsiForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_prov: {
                validators: {
                    notEmpty: {
                        message: 'Nama Provinsi tidak boleh kosong.'
                    },
                    stringLength: {
                        max: 250,
                        message: 'Nama Provinsi Maksimal 250 karakter.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createProvinsiForm")[0]);

        $.ajax({
              type: 'POST',
              url: '../createprovinsi',
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
                            document.location.assign('../data');
                        }
                        else if (status == 'error')
                        {
                            $("#createProvinsiForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
              }
          });
    });

    $('#createKabKotaForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_kab_kota: {
                validators: {
                    notEmpty: {
                        message: 'Nama Kabupaten/Kota tidak boleh kosong.'
                    },
                    stringLength: {
                        max: 250,
                        message: 'Nama Kabupaten/Kota Maksimal 250 karakter.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createKabKotaForm")[0]);

        $.ajax({
              type: 'POST',
              url: '../../createkabkota',
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
                            var id_prov = JSON.parse(data).id_prov;
                            document.location.assign('../../data/' + id_prov);
                        }
                        else if (status == 'error')
                        {
                            $("#createKabKotaForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
              }
          });
    });

    $('#createKecForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_kec: {
                validators: {
                    notEmpty: {
                        message: 'Nama Kecamatan tidak boleh kosong.'
                    },
                    stringLength: {
                        max: 250,
                        message: 'Nama Kecamatan Maksimal 250 karakter.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createKecForm")[0]);

        $.ajax({
              type: 'POST',
              url: '../../createkec',
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
                            var id_kab_kota = JSON.parse(data).id_kab_kota;
                            var id_prov = JSON.parse(data).id_prov;
                            document.location.assign('../../data/' + id_prov + '/' + id_kab_kota);
                        }
                        else if (status == 'error')
                        {
                            $("#createKecForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
              }
          });
    });

    $('#createDesaForm')
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
        var data = new FormData($("#createDesaForm")[0]);

        $.ajax({
              type: 'POST',
              url: '../../createdesa',
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
                            var id_kec = JSON.parse(data).id_kec;
                            var id_kab_kota = JSON.parse(data).id_kab_kota;
                            var id_prov = JSON.parse(data).id_prov;
                            document.location.assign('../../data/' + id_prov + '/' + id_kab_kota + '/' + id_kec);
                        }
                        else if (status == 'error')
                        {
                            $("#createDesaForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
              }
          });
    });

    $('#editAdmDaerahForm')
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
        var data = new FormData($("#editAdmDaerahForm")[0]);

        $.ajax({
              type: 'POST',
              url: '../../updatedata',
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
                            var kategori = JSON.parse(data).kategori;
                            var id_kec = JSON.parse(data).id_kec;
                            var id_kab_kota = JSON.parse(data).id_kab_kota;
                            var id_prov = JSON.parse(data).id_prov;
                            if (kategori == 'prov') {
                                document.location.assign('../../data');
                            } else if (kategori == 'kabkota') {
                                document.location.assign('../../data/' + id_prov);
                            } else if (kategori == 'kec') {
                                document.location.assign('../../data/' + id_prov + '/' + id_kab_kota);
                            } else if (kategori == 'desa') {
                                document.location.assign('../../data/' + id_prov + '/' + id_kab_kota + '/' + id_kec);
                            }
                                
                        }
                        else if (status == 'error')
                        {
                            $("#editAdmDaerahForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
              }
          });
    });

    

});

function deleteVideo(idrecord){
    var dialog = confirm("Anda yakin akan menghapus Data ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../deletevideo',
              data: {id:idrecord},
              success: function(data) {
                console.log(data);
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $('.alert').html(message).show();
                    setTimeout(function() {
                        $('.alert').hide();
                        document.location.assign('../video');
                    }, 2000);
                }
                else if (status == 'error')
                {
                    $('.alert').removeClass('alert-success');
                    $('.alert').addClass('alert-danger');
                    $('.alert').html(message).show();
                    setTimeout(function() {
                        $('.alert').hide();
                    }, 2000);
                }
                
              }
        });
    } else {
        return false;
    }
    
}
