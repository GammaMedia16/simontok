$(document).ready(function() {

    $('#createBMNForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            kode_bmn: {
                validators: {
                    notEmpty: {
                        message: 'Kode BMN tidak boleh kosong.'
                    }
                }
            },
            nama_bmn: {
                validators: {
                    notEmpty: {
                        message: 'Nama BMN tidak boleh kosong.'
                    }
                }
            },
            nup: {
                validators: {
                    notEmpty: {
                        message: 'NUP tidak boleh kosong.'
                    }
                }
            },
            merk_type: {
                validators: {
                    notEmpty: {
                        message: 'Merk Type tidak boleh kosong.'
                    }
                }
            },
            satuan: {
                validators: {
                    notEmpty: {
                        message: 'satuan tidak boleh kosong.'
                    }
                }
            },
            jumlah: {
                validators: {
                    notEmpty: {
                        message: 'jumlah tidak boleh kosong.'
                    },
                    digits: {
                        message: 'jumlah harus diisi angka'
                    }
                }
            },
            tahun: {
                validators: {
                    notEmpty: {
                        message: 'tahun tidak boleh kosong.'
                    },
                    digits: {
                        message: 'tahun harus diisi angka'
                    }
                }
            },
            filefoto: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 800*1024,
                        message: 'File foto harus berformat JPEG/JPG/PNG dengan ukuran maksimal 800KB'
                    },
                    notEmpty: {
                        message: 'File foto tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createBMNForm")[0]);
        
        $.ajax({
              type: 'POST',
              url: 'insertbmn',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                console.log(data);
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $("#createBMNForm").data('formValidation').resetForm();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('./');
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
    });
    
    $('#editBMNForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            kode_bmn: {
                validators: {
                    notEmpty: {
                        message: 'Kode BMN tidak boleh kosong.'
                    }
                }
            },
            nama_bmn: {
                validators: {
                    notEmpty: {
                        message: 'Nama BMN tidak boleh kosong.'
                    }
                }
            },
            nup: {
                validators: {
                    notEmpty: {
                        message: 'NUP tidak boleh kosong.'
                    }
                }
            },
            merk_type: {
                validators: {
                    notEmpty: {
                        message: 'Merk Type tidak boleh kosong.'
                    }
                }
            },
            satuan: {
                validators: {
                    notEmpty: {
                        message: 'satuan tidak boleh kosong.'
                    }
                }
            },
            jumlah: {
                validators: {
                    notEmpty: {
                        message: 'jumlah tidak boleh kosong.'
                    },
                    digits: {
                        message: 'jumlah harus diisi angka'
                    }
                }
            },
            tahun: {
                validators: {
                    notEmpty: {
                        message: 'tahun tidak boleh kosong.'
                    },
                    digits: {
                        message: 'tahun harus diisi angka'
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
              url: '../updatebmn',
              data: $("#editBMNForm").serialize(),
              success: function(data) {
                console.log(data);
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $("#editBMNForm").data('formValidation').resetForm();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../../admin');
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
    });
    
    $('#createKondisiForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            filefoto: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 2*1024*1024,
                        message: 'File foto harus berformat JPEG/JPG/PNG dengan ukuran maksimal 2 MB'
                    },
                    notEmpty: {
                        message: 'File foto tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createKondisiForm")[0]);
        
        $.ajax({
              type: 'POST',
              url: 'updatekondisibmn',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                console.log(data);
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id_bmn = JSON.parse(data).id_bmn;
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $("#createKondisiForm").data('formValidation').resetForm();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('./edit/' + id_bmn);
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
    });

    $('#createKondisiFormQRCode')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            filefoto: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 2*1024*1024,
                        message: 'File foto harus berformat JPEG/JPG/PNG dengan ukuran maksimal 2 MB'
                    },
                    notEmpty: {
                        message: 'File foto tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createKondisiFormQRCode")[0]);
        
        $.ajax({
              type: 'POST',
              url: '../updatekondisibmnqrcode',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                console.log(data);
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id_bmn = JSON.parse(data).id_bmn;
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $("#createKondisiFormQRCode").data('formValidation').resetForm();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../detail/' + id_bmn);
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
    });


    $('#cetakQRCodeBMNForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            lokasi: {
                validators: {
                    notEmpty: {
                        message: 'Lokasi tidak boleh kosong.'
                    }
                }
            },
            nama_bmn: {
                validators: {
                    notEmpty: {
                        message: 'Nama BMN tidak boleh kosong.'
                    }
                }
            },
            kondisi: {
                validators: {
                    notEmpty: {
                        message: 'Kondisi tidak boleh kosong.'
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
              url: 'cetakqrcode',
              data: $("#cetakQRCodeBMNForm").serialize(),
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                
                if (status == 'success')
                {
                    var getdata = JSON.parse(data).get;
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $("#cetakQRCodeBMNForm").data('formValidation').resetForm();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        var win = window.open('./lembarcetakqrcode' + getdata, '_blank');
                        win.window.print();
                        win.focus();
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
    });

    

    $('#myModal').on('shown.bs.modal', function() {
        $('#loginBMNForm')
        .formValidation().on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#loginBMNForm")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../../../access/validatebmn',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    console.log(data);
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        
                        var id_bmn = JSON.parse(data).id_bmn;
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $('#loginBMNForm').find('.alert').html(message).show();
                        setTimeout(function() {
                            $('#loginBMNForm').find('.alert').hide();
                            document.location.assign('../addhistoryqrcode/' + id_bmn);
                            /*var win = window.open('../printsimaksi/' + id, '_blank');
                            document.location.reload();
                            window.scrollTo(0,0);
                            win.focus();*/
                        }, 3000);
                        //$('#myModal').modal('hide');
                    }
                    else if (status == 'error')
                    {
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-danger');
                        $('#loginBMNForm').find('.alert').html(message).show();
                        setTimeout(function() {
                            $('#loginBMNForm').find('.alert').hide();
                        }, 3000);
                    }
                  }
              });
        });
    });
});

function printQRCode1(id) {
    var win = window.open('./admin/lembarcetakqrcode1/' + id, '_blank');
    win.window.print();
    win.focus();
}
function loginBMN(id){
    var bodyModal = "";
    $(".modal-title").html("Form Login SIMPUL SERIBU");
                bodyModal += "<form id=\"loginBMNForm\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
                bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Username</label><div class=\"col-lg-8\">";
                bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
                bodyModal += "<input type=\"text\" class=\"form-control\" name=\"username\" id=\"username\" placeholder=\"Username\" autofocus=\"\"";
                bodyModal += " value=\"\"/>";
                bodyModal += "<input type=\"hidden\" name=\"id_bmn\" id=\"id_bmn\"";
                bodyModal += " value=\"" + id + "\"/>";
                bodyModal += "</div></div>";
                bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Password</label><div class=\"col-lg-8\">";
                bodyModal += "<input type=\"password\" class=\"form-control\" name=\"userpass\" placeholder=\"Password\" id=\"userpass\" ";
                bodyModal += " value=\"\"/>";
                bodyModal += "</div></div>";
                bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
                bodyModal += "<button type=\"submit\" class=\"btn btn-success\">Login</button>";
                bodyModal += "</div></div>";
                bodyModal += "</form>";
            $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');        
}

function deleteKondisiBMN(id){
    var dialog = confirm("Anda yakin akan menghapus Data Kondisi BMN ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../deletekondisi',
              data: {id_update_bmn:id},
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
                        document.location.reload();
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

function deleteBMN(id){
    var dialog = confirm("Anda yakin akan menghapus Data BMN ini? Data Kondisi BMN akan terhapus semua.");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../deletebmn',
              data: {id_bmn:id},
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
                        document.location.assign('../');
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