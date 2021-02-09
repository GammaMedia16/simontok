$(document).ready(function () {
    
    $('#createDokPublik')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            file_publikasi: {
                validators: {
                    notEmpty: {
                        message: 'File Artikel/Dokumen tidak boleh kosong.'
                    },
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 2 MB'
                    }
                }
            },
            cover_file: {
                validators: {
                    notEmpty: {
                        message: 'File Cover tidak boleh kosong.'
                    },
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat JPG/JPEG/PNG dengan ukuran maksimal 2 MB'
                    }
                }
            },
            judul_publikasi: {
                validators: {
                    notEmpty: {
                        message: 'Judul Dokumen tidak boleh kosong.'
                    }
                }
            },
            isi_publikasi: {
                validators: {
                    notEmpty: {
                        message: 'Isi Ringkas Dokumen tidak boleh kosong.'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createDokPublik")[0]);
        $.ajax({
              type: 'POST',
              url: 'createdokpublik',
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
                            document.location.assign('../publikasi');
                        }
                        else if (status == 'error')
                        {
                            $("#createDokPublik").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
              }
          });
    });

    $('#updatePublikasi')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            file_publikasi: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat PDF dengan ukuran maksimal 2 MB'
                    }
                }
            },
            cover_file: {
                validators: {
                    notEmpty: {
                        message: 'File Cover tidak boleh kosong.'
                    },
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 2*1024*1024,
                        message: 'File harus berformat JPG/JPEG/PNG dengan ukuran maksimal 2 MB'
                    }
                }
            },
            judul_publikasi: {
                validators: {
                    notEmpty: {
                        message: 'Judul Dokumen tidak boleh kosong.'
                    }
                }
            },
            isi_publikasi: {
                validators: {
                    notEmpty: {
                        message: 'Isi Ringkas Dokumen tidak boleh kosong.'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#updatePublikasi")[0]);
        $.ajax({
              type: 'POST',
              url: '../updatedokpublik',
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
                            document.location.assign('../../publikasi');
                        }
                        else if (status == 'error')
                        {
                            $("#updatePublikasi").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
              }
          });
    });   

    /*$('#myModal').on('shown.bs.modal', function() {
    
    });*/

});

function ubahPublikasi(id) {
    var datapublikasi = $.parseJSON($.ajax({
          url:  'getpublikasi',
          type: 'GET',
          data: {id_publikasi:id},
          dataType: "json", 
          async: false
      }).responseText);
    var baseURL = $("#base_url").val();
    var bodyModal = "";
    $(".modal-title").html("Ubah Data Publikasi");
        bodyModal += "<form id=\"updatePublikasi\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Judul</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"judul_publikasi\" id=\"judul_publikasi\" value=\""+datapublikasi.judul_publikasi+"\" />";
        bodyModal += "<input type=\"hidden\" name=\"id_publikasi\" id=\"id_publikasi\"";
        bodyModal += " value=\"" + datapublikasi.id_publikasi + "\"/>";
        bodyModal += "<input type=\"hidden\" name=\"kategori_publikasi\" id=\"kategori_publikasi\"";
        bodyModal += " value=\"" + datapublikasi.kategori_publikasi + "\"/>";
        bodyModal += "<input type=\"hidden\" name=\"file_old\" id=\"file_old\"";
        bodyModal += " value=\"" + datapublikasi.file_publikasi + "\"/>";
        bodyModal += "<input type=\"hidden\" name=\"file_old_cover\" id=\"file_old_cover\"";
        bodyModal += " value=\"" + datapublikasi.cover_file + "\"/>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Isi Ringkas</label><div class=\"col-lg-6\">";
        bodyModal += "<textarea id=\"isi_publikasi\" class=\"form-control\" name=\"isi_publikasi\" cols=\"50\">"+datapublikasi.isi_publikasi+"</textarea>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">File Dokumen Publik</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"file_publikasi\" name=\"file_publikasi\" />";
        bodyModal += "<p class=\"text-muted\">*) Apabila File tidak diubah, dikosongkan saja.</p>";
        bodyModal += "File : <a target=\"_blank\" href=\""+ baseURL +"assets/filepublikasi/" + datapublikasi.kategori_publikasi + "/" + datapublikasi.file_publikasi + "\">";
        bodyModal += datapublikasi.file_publikasi + "</a>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Cover File</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"cover_file\" name=\"cover_file\" />";
        bodyModal += "<p class=\"text-muted\">*) Apabila File tidak diubah, dikosongkan saja.</p>";
        bodyModal += "File : <a target=\"_blank\" href=\""+ baseURL +"assets/filepublikasi/" + datapublikasi.kategori_publikasi + "/" + datapublikasi.cover_file + "\">";
        bodyModal += datapublikasi.cover_file + "</a>";
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

function detailPublikasi(id_publikasi){
    var baseURL = $("#base_url").val();
    $.ajax({
          type: 'GET',
          url: 'publikasi/detail',
          data: {id:id_publikasi},
          success: function(data) {
            //console.log(data);
            var row = JSON.parse(data).row;
            $(".modal-title").html(row['judul_publikasi']);
            if (row['cover_file'] == '') {
                row['cover_file'] = 'none.jpg';
            }
            if (row['file_publikasi'] == '') {
                row['file_publikasi'] = 'File Kosong';
            }
            var bodyModal = "<center><img style=\"max-width:100%;margin:10px;\" class=\"img-responsive\" src=\""+ baseURL + "assets/filepublikasi/" + row['cover_file'] +"\"></center>";
                bodyModal += "<span style=\"text-align: justify !important; padding: 10px 15px !important;\">" + row['isi_publikasi'] + "</span>";
                bodyModal += "<p class=\"text-muted\" style=\"font-size:12px\">";
                bodyModal += "<i>Diposting oleh: "+ row['nama_user'] +", "+ row['newtgl'] +"</i></p>";
            $(".modal-body").html(bodyModal);
          }
    });
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function deletePublikasi(id) {
    var dialog = confirm("Yakin akan menghapus Data Artikel/Dokumen ini?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: '../delete',
          data: {id_publikasi:id},
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
                            document.location.assign('../../publikasi');
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

