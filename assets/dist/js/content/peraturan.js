$(document).ready(function () {
    
    $('#createPeraturanForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            fileperaturan: {
                validators: {
                    notEmpty: {
                        message: 'File Peraturan tidak boleh kosong.'
                    },
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File Foto harus berformat PDF dengan ukuran maksimal 2 MB'
                    }
                }
            },
            judul_peraturan: {
                validators: {
                    notEmpty: {
                        message: 'Judul Peraturan tidak boleh kosong.'
                    }
                }
            },
            isi_peraturan: {
                validators: {
                    notEmpty: {
                        message: 'Isi Ringkas Peraturan tidak boleh kosong.'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createPeraturanForm")[0]);
        $.ajax({
              type: 'POST',
              url: 'createperaturan',
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
                            document.location.assign('../peraturan');
                        }
                        else if (status == 'error')
                        {
                            $("#createPeraturanForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
              }
          });
    });

    $('#updatePeraturanForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            fileperaturan: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File Foto harus berformat PDF dengan ukuran maksimal 2 MB'
                    }
                }
            },
            judul_peraturan: {
                validators: {
                    notEmpty: {
                        message: 'Judul Peraturan tidak boleh kosong.'
                    }
                }
            },
            isi_peraturan: {
                validators: {
                    notEmpty: {
                        message: 'Isi Ringkas Peraturan tidak boleh kosong.'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#updatePeraturanForm")[0]);
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
                            document.location.assign('../../peraturan');
                        }
                        else if (status == 'error')
                        {
                            $("#updatePeraturanForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
              }
          });
    });

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
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;Simpan</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');
}


function detailPeraturan(id){
    $.ajax({
          type: 'GET',
          url: 'peraturan/detail',
          data: {id_peraturan:id,},
          success: function(data) {
            //console.log(data);
            var row = JSON.parse(data).row;
            $(".modal-title").html("Detail Peraturan Perundangan");
            var bodyModal = "<div class=\"table-responsive\">";
                bodyModal += "<table class=\"table\">";
            var d = new Date();
            $.each(row, function(i, r) {
                var field = i.replace(/_/g , " ");
                var titik2 = ":";
                if (i == "file_peraturan") {
                    row[i] = "<a  target=\"_blank\" href=\"../assets/fileperaturan/" + row[i] +"\">" + row[i] + "</a>";
                }
                if (i == "user_input") {
                    field = "Operator";
                    row[i] = row['nama_user'];
                    
                }
                if (i == "nama_ref_peraturan") {
                    field = "Kategori";   
                }
                if (i == "tahun_peraturan") {
                    field = "Tahun";   
                }

                bodyModal += "<tr>";
                bodyModal += "<td width=\"20%\" style=\"text-transform:capitalize;\">" + field + "</td>";
                bodyModal += "<td width=\"5%\">" + titik2 + "</td>";
                bodyModal += "<td width=\"75%\">" + row[i] + "</td>";
                bodyModal += "<tr>";
            })
                bodyModal += "</table></div>";
            $(".modal-body").html(bodyModal);
          }
    });
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function deletePeraturan(id) {
    var dialog = confirm("Yakin akan menghapus Data Peraturan Perundangan ini?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: '../delete',
          data: {id_peraturan:id},
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
                            document.location.assign('../../peraturan');
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
