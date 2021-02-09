$(document).ready(function () {
    
    $('#myModal').on('shown.bs.modal', function() {
        $('#createAlbum')
        .formValidation({
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nama_album: {
                    validators: {
                        notEmpty: {
                            message: 'Judul Album tidak boleh kosong.'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#createAlbum")[0]);
            $.ajax({
                  type: 'POST',
                  url: 'createalbum',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        
                        var id = JSON.parse(data).new_id_album;
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $form.find('.alert').html(message).show();
                        setTimeout(function() {
                            $form.find('.alert').hide();
                            $('#myModal').modal('hide');
                            document.location.assign('./album/' + id);
                            
                        }, 4000);
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
                        $("#createAlbum").data('formValidation').resetForm();
                    }
                  }
              });
        });

        $('#updateAlbum')
        .formValidation({
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nama_album: {
                    validators: {
                        notEmpty: {
                            message: 'Judul Album tidak boleh kosong.'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#updateAlbum")[0]);
            $.ajax({
                  type: 'POST',
                  url: 'updatealbum',
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
                            $form.find('.alert').hide();
                            $('#myModal').modal('hide');
                            document.location.reload();
                        }, 3000);
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
                        $("#updateAlbum").data('formValidation').resetForm();
                    }
                  }
              });
        });
    });
    //var fotoIndex = 5;
    
    var filefotoValidators = {
            validators: {
                notEmpty: {
                    message: 'File Foto tidak boleh kosong.'
                },
                file: {
                    extension: 'jpg,jpeg,png',
                    type: 'image/jpeg,image/png',
                    maxSize: 5*1024*1024,
                    message: 'File Foto harus berformat JPG/JPEG/PNG dengan ukuran maksimal 5MB'
                }
            }
        },
        captionValidators = {
            validators: {
                notEmpty: {
                    message: 'Caption Foto tidak boleh kosong.'
                }
            }
        };

    $('#createFotoGaleri')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            file: {
                selector: '[type="file"]',
                validators: {
                    notEmpty: {
                        message: 'File Foto tidak boleh kosong.'
                    },
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 5*1024*1024,
                        message: 'File Foto harus berformat JPG/JPEG/PNG dengan ukuran maksimal 5MB'
                    }
                }
            },
            text: {
                selector: '[type="text"]',
                validators: {
                    notEmpty: {
                        message: 'Caption Foto tidak boleh kosong.'
                    }
                }
            }
        }
    }).on('click', '#addFilePhoto', function() {
        var countFile = parseInt($('#countFile').val());
        var newCount = countFile + 1;

        var row = "";
            row += "<div class=\"form-group\">";
            row += "<label class=\"col-lg-2 control-label\">File Foto "+ newCount +"</label>";
            row += "<div class=\"col-lg-3\">";
            row += "<input type=\"file\" class=\"form-control\" id=\"filefoto"+ newCount +"\" name=\"filefoto"+ newCount +"\" />";
            row += "</div><label class=\"col-lg-1 control-label\">Caption</label>";
            row += "<div class=\"col-lg-4\">";
            row += "<input type=\"text\" class=\"form-control\" id=\"caption"+ newCount +"\" name=\"caption"+ newCount +"\" />";
            row += "</div></div>";
        $('#countFile').val(newCount);
        $('#fieldFotoGaleri').append(row);
        $('#createFotoGaleri')
            .formValidation('addField', 'filefoto' + newCount, filefotoValidators)
            .formValidation('addField', 'caption' + newCount, captionValidators);
    }).on('success.form.fv', function(e) {
        var count = $("#countFile").val();
        var dialog = confirm("Foto yang akan Anda upload sebanyak " + count + " foto. Akan membutuhkan beberapa waktu untuk proses upload, mohon menunggu sampai proses upload selesai. Terimakasih");
        if (dialog == true) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createFotoGaleri")[0]);
        $.ajax({
              type: 'POST',
              url: '../createfotogaleri',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                var cek_form = JSON.parse(data).cekform;
                var id = JSON.parse(data).id_album;
                if (status == 'success')
                {
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        if (cek_form == "1") {
                            document.location.reload();
                        } else {
                            document.location.assign('../album/' + id);
                        }
                        
                    }, 3000);
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
                    $("#createFotoGaleri").data('formValidation').resetForm();
                }
              }
          });
        } else {
            return false;
        }
    });

});

function addAlbum(kategori){
    var d = new Date();
    var bodyModal = "";
    $(".modal-title").html("Buat Album");
        bodyModal += "<form id=\"createAlbum\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Judul Album</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"nama_album\" id=\"nama_album\" />";
        bodyModal += "<input type=\"hidden\" name=\"kategori_galeri\" id=\"kategori_galeri\"";
        bodyModal += " value=\"" + kategori + "\"/>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;Buat</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function addFilePhoto() {
    var countFile = parseInt($('#countFile').val());
    var newCount = countFile + 1;

    var row = "";
        row += "<div class=\"form-group\">";
        row += "<label class=\"col-lg-2 control-label\">File Foto "+ newCount +"</label>";
        row += "<div class=\"col-lg-3\">";
        row += "<input type=\"file\" class=\"form-control\" id=\"filefoto"+ newCount +"\" name=\"filefoto"+ newCount +"\" />";
        row += "</div><label class=\"col-lg-1 control-label\">Caption</label>";
        row += "<div class=\"col-lg-4\">";
        row += "<input type=\"text\" data-fv-notempty data-fv-notempty-message=\"Caption tidak boleh kosong\" class=\"form-control\" id=\"caption"+ newCount +"\" name=\"caption"+ newCount +"\" />";
        row += "</div></div>";
    $('#countFile').val(newCount);
    $('#fieldFotoGaleri').append(row);
    $('#createFotoGaleri')
        .formValidation('addField', 'filefoto' + newCount, filefotoValidators)
        .formValidation('addField', 'caption' + newCount, captionValidators);
}

function ubahAlbum(id) {
    var dataalbum = $.parseJSON($.ajax({
          url:  'getalbum',
          type: 'GET',
          data: {id_album_galeri:id},
          dataType: "json", 
          async: false
      }).responseText);

    var bodyModal = "";
    $(".modal-title").html("Ubah Album");
        bodyModal += "<form id=\"updateAlbum\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Judul Album</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"nama_album\" id=\"nama_album\" value=\""+dataalbum.nama_album+"\" />";
        bodyModal += "<input type=\"hidden\" name=\"id_album_galeri\" id=\"id_album_galeri\"";
        bodyModal += " value=\"" + dataalbum.id_album_galeri + "\"/>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;Simpan</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');
}

function deleteAlbum(id) {
    var dialog = confirm("Yakin akan menghapus album ini?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: 'hapusalbum',
          data: {id_album_galeri:id},
          success: function(data) {
            var status = JSON.parse(data).status;
            var message = JSON.parse(data).message;
            if (status == 'success')
            {
                $('.alert').removeClass('alert-warning');
                $('.alert').removeClass('alert-danger');
                $('.alert').addClass('alert-success');
                $('.alert').html(message).show();
                setTimeout(function() {
                    $('.alert').hide();
                    $('#myModal').modal('hide');
                    document.location.reload();
                }, 3000);
            }
            else if (status == 'error')
            {
                $('.alert').removeClass('alert-warning');
                $('.alert').removeClass('alert-success');
                $('.alert').addClass('alert-danger');
                $('.alert').html(message).show();
                setTimeout(function() {
                   $('.alert').hide();
                }, 3000);
            }
          }
      });
    } else {
        return false;
    }
}

