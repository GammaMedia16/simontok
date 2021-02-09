$(document).ready(function() {
    $('#createBeritaForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            judul: {
                validators: {
                    notEmpty: {
                        message: 'Judul Konten tidak boleh kosong.'
                    },
                    stringLength: {
                        max: 250,
                        message: 'Judul Konten Maksimal 250 karakter.'
                    }
                }
            },
            isi: {
                group: '.textarea',
                validators: {
                    notEmpty: {
                        message: 'Isi Konten tidak boleh kosong.'
                    }
                }
            },
            filegambar: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 800*1024,
                        message: 'File Gambar harus berformat JPEG/PNG dengan ukuran maksimal 800KB'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var editorText = CKEDITOR.instances.isi.getData();
        var data = new FormData($("#createBeritaForm")[0]);
        data.append('isivalue', editorText);

        $.ajax({
              type: 'POST',
              url: 'create',
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
                             document.location.assign('../berita');
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

    $('#editBeritaForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            judul: {
                validators: {
                    notEmpty: {
                        message: 'Judul Konten tidak boleh kosong.'
                    },
                    stringLength: {
                        max: 250,
                        message: 'Judul Konten Maksimal 250 karakter.'
                    }
                }
            },
            isi: {
                group: '.textarea',
                validators: {
                    notEmpty: {
                        message: 'Isi Konten tidak boleh kosong.'
                    }
                }
            },
            filegambar: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 800*1024,
                        message: 'File Gambar harus berformat JPEG/PNG dengan ukuran maksimal 800KB'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var editorText = CKEDITOR.instances.isi.getData();
        var data = new FormData($("#editBeritaForm")[0]);
        data.append('isivalue', editorText);
        
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
                             document.location.assign('../../berita');
                        }
                        else if (status == 'error')
                        {
                            $("#editBeritaForm").data('formValidation').resetForm();
                        }

                        
                      }
                })
              }
          });
    });

    $('#contactUsForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama: {
                validators: {
                    notEmpty: {
                        message: 'Nama tidak boleh kosong.'
                    },
                    stringLength: {
                        max: 250,
                        message: 'Nama Maksimal 250 karakter.'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Email tidak boleh kosong.'
                    },
                    emailAddress: {
                        message: 'Email belum valid.'
                    }
                }
            },
            subyek: {
                validators: {
                    notEmpty: {
                        message: 'Subyek tidak boleh kosong.'
                    },
                    stringLength: {
                        max: 250,
                        message: 'Subyek Maksimal 250 karakter.'
                    }
                }
            },
            isi: {
                group: '.textarea',
                validators: {
                    notEmpty: {
                        message: 'Isi Konten tidak boleh kosong.'
                    }
                }
            }
        }
    })
    .on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#contactUsForm")[0]);
        
        $.ajax({
              type: 'POST',
              url: 'createkontakkami',
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
                    $('#contactUsForm').formValidation('resetForm', true);
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
                    $("#contactUsForm").data('formValidation').resetForm();
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
                    $("#contactUsForm").data('formValidation').resetForm();
                }
              }
          });
    });

});

function detailBerita(id_berita){
    var baseURL = $("#base_url").val();
    $.ajax({
          type: 'GET',
          url: 'berita/detail',
          data: {id:id_berita},
          success: function(data) {
            //console.log(data);
            var row = JSON.parse(data).row;
            $(".modal-title").html(row['judul']);
            if (row['gambar'] == '') {
                row['gambar'] = 'none.jpg';
            }
            var bodyModal = "<center><img style=\"max-width:100%;margin:10px;\" class=\"img-responsive\" src=\""+ baseURL + "assets/image-news/" + row['gambar'] +"\"></center>";
                bodyModal += "<span style=\"text-align: justify !important; padding: 10px 15px !important;\">" + row['isi'] + "</span>";
                bodyModal += "<p class=\"text-muted\" style=\"font-size:12px\">";
                bodyModal += "<i>Diposting oleh: "+ row['nama_user'] +", "+ row['newtgl'] +"</i></p>";
            $(".modal-body").html(bodyModal);
          }
    });
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function deleteBerita(idrecord){
    var dialog = confirm("Anda yakin akan menghapus Data ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: '../delete',
              data: {id:idrecord},
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
                             document.location.assign('../../berita');
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
