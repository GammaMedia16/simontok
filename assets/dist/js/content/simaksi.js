$(document).ready(function () {
    
    $('#step1RegSIMAKSI')
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
                        message: 'Nama Lengkap tidak boleh kosong.'
                    }
                }
            },
            no_identitas: {
                validators: {
                    notEmpty: {
                        message: 'No Identitas tidak boleh kosong.'
                    },
                    digits: {
                        message: 'No Identitas harus diisi angka'
                    }
                }
            },
            jabatan: {
                validators: {
                    notEmpty: {
                        message: 'Jabatan tidak boleh kosong.'
                    }
                }
            },
            instansi: {
                validators: {
                    notEmpty: {
                        message: 'Instansi Surat tidak boleh kosong.'
                    }
                }
            },
            alamat: {
                validators: {
                    notEmpty: {
                        message: 'Alamat tidak boleh kosong.'
                    }
                }
            },
            no_telp: {
                validators: {
                    notEmpty: {
                        message: 'No Telp Surat tidak boleh kosong.'
                    },
                    digits: {
                        message: 'No Telp harus diisi angka'
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
            fileidentitas: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,pdf',
                        type: 'image/jpeg,application/pdf',
                        maxSize: 800*1024,
                        message: 'File scan identitas harus berformat JPEG/PDF dengan ukuran maksimal 800KB'
                    },
                    notEmpty: {
                        message: 'File scan identitas tidak boleh kosong.'
                    }
                }
            }
        }
    });

    $('#step2RegSIMAKSI')
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
                        message: 'Judul Kegiatan tidak boleh kosong.'
                    }
                }
            },
            txtsampel: {
                validators: {
                    notEmpty: {
                        message: 'Sample tidak boleh kosong.'
                    }
                }
            },
            dari: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Mulai tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            sampai: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Selesai tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            pengikut: {
                validators: {
                    notEmpty: {
                        message: 'Pengikut tidak boleh kosong.'
                    }
                }
            },
            filepengantar: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,pdf',
                        type: 'image/jpeg,application/pdf',
                        maxSize: 1024*1024,
                        message: 'File scan identitas harus berformat JPEG/PDF dengan ukuran maksimal 1MB'
                    },
                    notEmpty: {
                        message: 'File Surat Pengantar tidak boleh kosong.'
                    }
                }
            },
            fileproposal: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File scan identitas harus berformat PDF dengan ukuran maksimal 2MB'
                    },
                    notEmpty: {
                        message: 'File Proposal tidak boleh kosong.'
                    }
                }
            },
            filepengikut: {
                validators: {
                    file: {
                        extension: 'doc,docx,pdf',
                        type: 'application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/pdf',
                        maxSize: 2*1024*1024,
                        message: 'File Pengikut harus berformat DOC,DOCX,PDF dengan ukuran maksimal 2MB'
                    },
                    notEmpty: {
                        message: 'File Pengikut tidak boleh kosong.'
                    }
                }
            }
        }
    });

    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

       var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });


    $("#step1Btn").click(function (e) {
        var dialog = confirm("Anda yakin untuk melanjutkan proses? Pastikan Data Pribadi sudah benar karena tidak dapat dirubah kembali.");
        if (dialog == true) {
            $('#step1RegSIMAKSI').formValidation('validate');
            var isValidForm = $('#step1RegSIMAKSI').data('formValidation').isValid();
            if (isValidForm) {
                var data = new FormData($("#step1RegSIMAKSI")[0]);
                $.ajax({
                      type: 'POST',
                      url: 'step1',
                      data: data,
                      processData: false,
                      contentType: false,
                      success: function(data) {
                        var status = JSON.parse(data).status;
                        var message = JSON.parse(data).message;
                        if (status == 'success')
                        {
                            var new_id = JSON.parse(data).new_id_simaksi;
                            $('#id_simaksi').val(new_id);
                            var new_reg = JSON.parse(data).no_registrasi;
                            $('#no_registrasi').val(new_reg);
                            var $active = $('.wizard .nav-tabs li.active');
                            $active.next().removeClass('disabled');
                            nextTab($active);
                            $("#pre1").toggleClass('disabled');
                        }
                        else if (status == 'error')
                        {
                            $('.alert').removeClass('alert-success');
                            $('.alert').addClass('alert-warning');
                            $form.find('.alert').html(message).show();
                            setTimeout(function() {
                                $form.find('.alert').hide();
                            }, 3000);
                        }
                      }
                  });  
            };
        }
    });

    $("#step2Btn").click(function (e) {
        var dialog = confirm("Anda yakin untuk melanjutkan proses? Pastikan Data Kegiatan sudah benar karena tidak dapat dirubah kembali.");
        if (dialog == true) {
            $('#step2RegSIMAKSI').formValidation('validate');
            var isValidForm = $('#step2RegSIMAKSI').data('formValidation').isValid();
            if (isValidForm) {
                var data = new FormData($("#step2RegSIMAKSI")[0]);
                $.ajax({
                      type: 'POST',
                      url: 'step2',
                      data: data,
                      processData: false,
                      contentType: false,
                      success: function(data) {
                        var status = JSON.parse(data).status;
                        var message = JSON.parse(data).message;
                        if (status == 'success')
                        {
                            var $active = $('.wizard .nav-tabs li.active');
                            $active.next().removeClass('disabled');
                            nextTab($active);
                            $("#pre2").toggleClass('disabled');
                            var new_reg = JSON.parse(data).no_registrasi;
                            $('#no_registrasi').val(new_reg);
                        }
                        else if (status == 'error')
                        {
                            $('.alert').removeClass('alert-success');
                            $('.alert').addClass('alert-warning');
                            $form.find('.alert').html(message).show();
                            setTimeout(function() {
                                $form.find('.alert').hide();
                            }, 3000);
                        }
                      }
                  });
            };
        }
        

    });

    $("#stepFinishReg").click(function (e) {
    	var dialog = confirm("Anda yakin untuk menyetujui Pernyataan ini?");
        if (dialog == true) {
            var data = new FormData($("#step2RegSIMAKSI")[0]);
            $.ajax({
                  type: 'POST',
                  url: 'step3',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled');
                        nextTab($active);
                        $("#pre3").toggleClass('disabled');
                        var new_reg = JSON.parse(data).no_registrasi;
                        $("#success_no_reg").html(new_reg);
                    }
                    else if (status == 'error')
                    {
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-warning');
                        $form.find('.alert').html(message).show();
                        setTimeout(function() {
                            $form.find('.alert').hide();
                        }, 3000);
                    }
                  }
            });
            
        };
    });

    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });

    $('#verifikasiSIMAKSI')
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
                        message: 'Nama Lengkap tidak boleh kosong.'
                    }
                }
            },
            no_identitas: {
                validators: {
                    notEmpty: {
                        message: 'No Identitas tidak boleh kosong.'
                    },
                    digits: {
                        message: 'No Identitas harus diisi angka'
                    }
                }
            },
            jabatan: {
                validators: {
                    notEmpty: {
                        message: 'Jabatan tidak boleh kosong.'
                    }
                }
            },
            instansi: {
                validators: {
                    notEmpty: {
                        message: 'Instansi Surat tidak boleh kosong.'
                    }
                }
            },
            alamat: {
                validators: {
                    notEmpty: {
                        message: 'Alamat tidak boleh kosong.'
                    }
                }
            },
            no_telp: {
                validators: {
                    notEmpty: {
                        message: 'No Telp Surat tidak boleh kosong.'
                    },
                    digits: {
                        message: 'No Telp harus diisi angka'
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
            fileidentitas: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,pdf',
                        type: 'image/jpeg,application/pdf',
                        maxSize: 800*1024,
                        message: 'File scan identitas harus berformat JPEG/PDF dengan ukuran maksimal 800KB'
                    }
                }
            },
            judul_kegiatan: {
                validators: {
                    notEmpty: {
                        message: 'Judul Kegiatan tidak boleh kosong.'
                    }
                }
            },
            dari: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Mulai tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            sampai: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Selesai tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            tgl_surat_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Surat Pengantar tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            pengikut: {
                validators: {
                    notEmpty: {
                        message: 'Pengikut tidak boleh kosong.'
                    }
                }
            },
            perihal_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'Perihal Surat Pengantar tidak boleh kosong.'
                    }
                }
            },
            ttd_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'Penandatangan Surat Pengantar tidak boleh kosong.'
                    }
                }
            },
            no_surat_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'No Surat Pengantar tidak boleh kosong.'
                    }
                }
            },
            filepengantar: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,pdf',
                        type: 'image/jpeg,application/pdf',
                        maxSize: 800*1024,
                        message: 'File scan identitas harus berformat JPEG/PDF dengan ukuran maksimal 800KB'
                    }
                }
            },
            fileproposal: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 1024*1024,
                        message: 'File scan identitas harus berformat PDF dengan ukuran maksimal 1MB'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#verifikasiSIMAKSI")[0]);
        $.ajax({
              type: 'POST',
              url: '../updateverif',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id = JSON.parse(data).id_simaksi;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#verifikasiSIMAKSI').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.reload();
                        window.scrollTo(0,0);
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
                    $("#verifikasiSIMAKSI").data('formValidation').resetForm();
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
                    $("#verifikasiSIMAKSI").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#finishSIMAKSI')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_lengkap: {
                validators: {
                    notEmpty: {
                        message: 'Nama Lengkap tidak boleh kosong.'
                    }
                }
            },
            no_identitas: {
                validators: {
                    notEmpty: {
                        message: 'No Identitas tidak boleh kosong.'
                    },
                    digits: {
                        message: 'No Identitas harus diisi angka'
                    }
                }
            },
            jabatan: {
                validators: {
                    notEmpty: {
                        message: 'Jabatan tidak boleh kosong.'
                    }
                }
            },
            instansi: {
                validators: {
                    notEmpty: {
                        message: 'Instansi Surat tidak boleh kosong.'
                    }
                }
            },
            alamat: {
                validators: {
                    notEmpty: {
                        message: 'Alamat tidak boleh kosong.'
                    }
                }
            },
            no_telp: {
                validators: {
                    notEmpty: {
                        message: 'No Telp Surat tidak boleh kosong.'
                    },
                    digits: {
                        message: 'No Telp harus diisi angka'
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
            fileidentitas: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,pdf',
                        type: 'image/jpeg,application/pdf',
                        maxSize: 800*1024,
                        message: 'File scan identitas harus berformat JPEG/PDF dengan ukuran maksimal 800KB'
                    }
                }
            },
            judul_kegiatan: {
                validators: {
                    notEmpty: {
                        message: 'Judul Kegiatan tidak boleh kosong.'
                    }
                }
            },
            dari: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Mulai tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            sampai: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Selesai tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            tgl_surat_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Surat Pengantar tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            pengikut: {
                validators: {
                    notEmpty: {
                        message: 'Pengikut tidak boleh kosong.'
                    }
                }
            },
            perihal_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'Perihal Surat Pengantar tidak boleh kosong.'
                    }
                }
            },
            ttd_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'Penandatangan Surat Pengantar tidak boleh kosong.'
                    }
                }
            },
            no_surat_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'No Surat Pengantar tidak boleh kosong.'
                    }
                }
            },
            filepengantar: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,pdf',
                        type: 'image/jpeg,application/pdf',
                        maxSize: 800*1024,
                        message: 'File scan identitas harus berformat JPEG/PDF dengan ukuran maksimal 800KB'
                    }
                }
            },
            fileproposal: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 1024*1024,
                        message: 'File scan identitas harus berformat PDF dengan ukuran maksimal 1MB'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#finishSIMAKSI")[0]);
        $.ajax({
              type: 'POST',
              url: '../updatefinish',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id = JSON.parse(data).id_simaksi;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#finishSIMAKSI').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.reload();
                        window.scrollTo(0,0);
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
                    $("#finishSIMAKSI").data('formValidation').resetForm();
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
                    $("#finishSIMAKSI").data('formValidation').resetForm();
                }
              }
          });
    });
    
    $('#formRegistrasiSIMAKSIadmin')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_lengkap: {
                validators: {
                    notEmpty: {
                        message: 'Nama Lengkap tidak boleh kosong.'
                    }
                }
            },
            no_identitas: {
                validators: {
                    notEmpty: {
                        message: 'No Identitas tidak boleh kosong.'
                    },
                    digits: {
                        message: 'No Identitas harus diisi angka'
                    }
                }
            },
            jabatan: {
                validators: {
                    notEmpty: {
                        message: 'Jabatan tidak boleh kosong.'
                    }
                }
            },
            instansi: {
                validators: {
                    notEmpty: {
                        message: 'Instansi Surat tidak boleh kosong.'
                    }
                }
            },
            alamat: {
                validators: {
                    notEmpty: {
                        message: 'Alamat tidak boleh kosong.'
                    }
                }
            },
            no_telp: {
                validators: {
                    notEmpty: {
                        message: 'No Telp Surat tidak boleh kosong.'
                    },
                    digits: {
                        message: 'No Telp harus diisi angka'
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
            tujuan: {
                validators: {
                    notEmpty: {
                        message: 'Tujuan Kegiatan tidak boleh kosong.'
                    }
                }
            },
            judul_kegiatan: {
                validators: {
                    notEmpty: {
                        message: 'Judul Kegiatan tidak boleh kosong.'
                    }
                }
            },
            dari: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Mulai tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            sampai: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Selesai tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            no_surat_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'No Surat Pengantar tidak boleh kosong.'
                    }
                }
            },
            hal_surat_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'No Surat Pengantar tidak boleh kosong.'
                    }
                }
            },
            tgl_surat_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Surat Pengantar tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            tgl_presentasi: {
                validators: {
                    notEmpty: {
                        message: 'Tanggal Presentasi tidak boleh kosong.'
                    },
                    date: {
                        format: 'YYYY-MM-DD'
                    }
                }
            },
            pengikut: {
                validators: {
                    notEmpty: {
                        message: 'Pengikut tidak boleh kosong.'
                    }
                }
            },
            ttd_surat_pengantar: {
                validators: {
                    notEmpty: {
                        message: 'Penandatangan Surat Pengantar tidak boleh kosong.'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#formRegistrasiSIMAKSIadmin")[0]);
        $.ajax({
              type: 'POST',
              url: './createadmin',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id = JSON.parse(data).new_id_simaksi;
                    var no_reg = JSON.parse(data).no_registrasi;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#formRegistrasiSIMAKSIadmin').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('./finish/' + id);
                        window.scrollTo(0,0);
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
                    $("#formRegistrasiSIMAKSIadmin").data('formValidation').resetForm();
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
                    $("#formRegistrasiSIMAKSIadmin").data('formValidation').resetForm();
                }
              }
          });
    });


    $('#myModal').on('shown.bs.modal', function() {
        $('#inputTglIns4').datepicker({
            parentEl: '#myModal',
            format: 'yyyy-mm-dd'
        }).on('changeDate', function(e) {
            // Revalidate the date field
            $('#eventForm').formValidation('revalidateField', 'eventDate');
            //$('.datepicker').css({cursor: pointer});
        });

        $('#updateNoSIMAKSIform')
        .formValidation({
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                no_surat_simaksi: {
                    validators: {
                        notEmpty: {
                            message: 'No Surat SIMAKSI tidak boleh kosong.'
                        }
                    }
                },
                tgl_simaksi: {
                    validators: {
                        notEmpty: {
                            message: 'Tanggal SIMAKSI tidak boleh kosong.'
                        },
                        date: {
                            format: 'YYYY-MM-DD'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#updateNoSIMAKSIform")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../updatenosimaksi',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    console.log(data);
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        $('#myModal').modal('hide');
                        var id = JSON.parse(data).id_simaksi;
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $('#finishSIMAKSI').find('.alert').html(message).show();
                        $('#updateNoSIMAKSIform').formValidation('resetForm', true);
                        setTimeout(function() {
                            $('#finishSIMAKSI').find('.alert').hide();
                            var win = window.open('../printsimaksi/' + id, '_blank');
                            document.location.reload();
                            window.scrollTo(0,0);
                            win.focus();
                        }, 4000);
                    }
                    else if (status == 'error')
                    {
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-success');
                        $('.alert').addClass('alert-danger');
                        $('#finishSIMAKSI').find('.alert').html(message).show();
                        setTimeout(function() {
                            $('#finishSIMAKSI').find('.alert').hide();
                        }, 3000);
                        $("#updateNoSIMAKSIform").data('formValidation').resetForm();
                    }
                  }
              });
        });


        $('#tolakSIMAKSIform')
        .formValidation({
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                alasan: {
                    validators: {
                        notEmpty: {
                            message: 'Alasan Penolakan tidak boleh kosong.'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#tolakSIMAKSIform")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../tolak',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    console.log(data);
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        $('#myModal').modal('hide');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $('.alert').html(message).show();
                        setTimeout(function() {
                            $('.alert').hide();
                            document.location.assign('../data');
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
        });
    });

});

function cetakSuratPernyataan(id) {
    var docprint=window.open("../printsuratpernyataan/" + id,"_blank");
     docprint.focus(); 
}

function cetakSPLingkungan(id) {
    var docprint=window.open("../printsplingk/" + id,"_blank");
     docprint.focus(); 
}

function cetakSPBaratan(id) {
    var docprint=window.open("../printspbrtn/" + id,"_blank");
     docprint.focus(); 
}

function cetakSIMAKSI(id){
    var d = new Date();
    var bodyModal = "";
    $.ajax({
          type: 'GET',
          url: '../cetaksimaksi',
          data: {id_simaksi:id},
          success: function(data) {
            //console.log(data);
            var row = JSON.parse(data).row;
            var no_surat_simaksi = "";
            var tgl_simaksi = "";
            if (row['no_surat_simaksi'] == null) {
                no_surat_simaksi = "";
            } else {
                no_surat_simaksi = row['no_surat_simaksi'];
            }
            if (row['tgl_simaksi'] == null) {
                tgl_simaksi = d.getFullYear() + '-' + (( (d.getMonth() + 1) < 10) ? '0' + (d.getMonth() + 1) : d.getMonth() + 1) + '-' + (( d.getDate() < 10) ? '0' + d.getDate() : d.getDate());
            } else {
                tgl_simaksi = row['tgl_simaksi'];
            }
            $(".modal-title").html("Cetak Surat Ijin Masuk Kawasan Konservasi: No. " + no_surat_simaksi);
                bodyModal += "<form id=\"updateNoSIMAKSIform\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
                bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Nomor Surat SIMAKSI</label><div class=\"col-lg-6\">";
                bodyModal += "<input type=\"text\" class=\"form-control\" name=\"no_surat_simaksi\" id=\"no_surat_simaksi\"";
                bodyModal += " value=\"" + no_surat_simaksi + "\"/>";
                bodyModal += "<input type=\"hidden\" name=\"id_simaksi\" id=\"id_simaksi\"";
                bodyModal += " value=\"" + id + "\"/>";
                bodyModal += "</div></div>";
                bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Tanggal Surat SIMAKSI</label><div class=\"col-lg-4\">";
                bodyModal += "<div class=\"inputGroupContainer date\"><div class=\"input-group input-append date\">";
                bodyModal += "<input type=\"text\" class=\"form-control\" id=\"inputTglIns4\" name=\"tgl_simaksi\" style=\"cursor: pointer\"";
                bodyModal += " value=\"" + tgl_simaksi + "\" placeholder=\"YYYY-MM-DD\"/>";
                bodyModal += "<span class=\"input-group-addon add-on\"><span class=\"glyphicon glyphicon-calendar\"></span></span></div></div></div></div>";
                bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">TTD Surat SIMAKSI</label><div class=\"col-lg-4\">";
                bodyModal += "<select name=\"ttd_simaksi\" id=\"ttd_simaksi\" class=\"form-control\" style=\"width: 100%;\">";
                bodyModal += "<option value=\"1\" selected>Kepala Balai</option>";
                bodyModal += "<option value=\"2\">Kasubbag Tata Usaha</option>";
                bodyModal += "<option value=\"3\">Plh. Kepala Balai</option>";
                bodyModal += "</select></div></div>";
                bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
                bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;Simpan & Cetak</button>";
                bodyModal += "</div></div>";
                bodyModal += "</form>";
            $(".modal-body").html(bodyModal);
            var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
            $(".modal-footer").html(btnClose);
            $('#myModal').modal('show');
          }
    });        
}

function cetakSIMAKSIadmin(id){
    var win = window.open('printsimaksi/' + id, '_blank');
    win.focus();       
}

function cetakSIMAKSIUser(id){
    var win = window.open('../printsimaksiuser/' + id, '_blank');
    win.focus();        
}

$("#cekBoxPerny").click(function(e){
    
    var checkbox = document.getElementById("cekBoxPerny");
    if (checkbox.checked == 1) {
        $("#stepFinishReg").removeAttr("disabled");
    } else if (checkbox.checked == 0) {
        $("#stepFinishReg").attr("disabled", "disabled");
    }
});

$("#cekBoxSample").click(function(e){
    
    var checkbox = document.getElementById("cekBoxSample");
    if (checkbox.checked == 1) {
        $("#txtsampel").removeAttr("disabled");
    } else if (checkbox.checked == 0) {
        $("#txtsampel").attr("disabled", "disabled");
    }
});

function cekRegistrasiSIMAKSI() {
    var no_reg = $('#no_registrasi').val();
    document.location.assign('./' + encodeURIComponent(no_reg));
}

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

function setujuSIMAKSI(id){
    var dialog = confirm("Anda yakin akan melanjutkan Proses Permohonan Penerbitan SIMAKSI ini?");
    if (dialog == true) {
        var tgl_old = $('#tgl_presentasi_old').val();
        var tgl_new = $('#inputTglIns3').val();
        if (tgl_new == tgl_old) {
            var dialog2 = confirm("Apakah waktu presentasi sama dengan waktu yang diusulkan oleh pemohon?");        
            if (dialog2 == true) {
                $.ajax({
                      type: 'POST',
                      url: '../setuju',
                      data: {id_simaksi:id,tgl_presentasi:tgl_new},
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
                                document.location.assign('../finish');
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
        } else {
            $.ajax({
                      type: 'POST',
                      url: '../setuju',
                      data: {id_simaksi:id,tgl_presentasi:tgl_new},
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
                                document.location.assign('../finish');
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
        }
        
    } else {
        return false;
    }
}

function tolakSIMAKSI(id){
    var dialog = confirm("Anda yakin akan menolak Permohonan Penerbitan SIMAKSI ini?");
    if (dialog == true) {
        var bodyModal = "";
        $(".modal-title").html("Tolak Permohonan Penerbitan SIMAKSI Taman Nasional Wakatobi");
                    bodyModal += "<form id=\"tolakSIMAKSIform\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
                    bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Alasan Ditolak</label><div class=\"col-lg-8\">";
                    bodyModal += "<input type=\"text\" class=\"form-control\" name=\"alasan\" id=\"alasan\"";
                    bodyModal += " value=\"\"/>";
                    bodyModal += "<input type=\"hidden\" name=\"id_simaksi\" id=\"id_simaksi\"";
                    bodyModal += " value=\"" + id + "\"/>";
                    bodyModal += "</div></div>";
                    bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
                    bodyModal += "<button type=\"submit\" class=\"btn btn-danger\"><i class=\"fa fa-close\"></i>&nbsp;Tolak</button>";
                    bodyModal += "</div></div>";
                    bodyModal += "</form>";
                $(".modal-body").html(bodyModal);
        var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
        $(".modal-footer").html(btnClose);
        $('#myModal').modal('show');
    } else {
        return false;
    }
}

function ubahDataSIMAKSI(){
    $("#verifikasiSIMAKSI input:text").removeAttr('readonly');
    $("#verifikasiSIMAKSI input:text").removeAttr('disabled');
    $("#verifikasiSIMAKSI input:file").removeAttr('disabled');
    $("#verifikasiSIMAKSI button:submit").removeAttr('disabled');
    $("#cancelUbahVerifikasibtn").removeAttr('disabled');
    $("#verifikasiSIMAKSI select").removeAttr('disabled');
    window.scrollTo(0,340);
}

function cancelUbahVerifikasi(){
    $("#verifikasiSIMAKSI input:text").attr('readonly','');
    $("#verifikasiSIMAKSI input:text").attr('disabled','');
    $("#verifikasiSIMAKSI input:file").attr('disabled','');
    $("#verifikasiSIMAKSI button:submit").attr('disabled','');
    $("#cancelUbahVerifikasibtn").attr('disabled','');
    $("#verifikasiSIMAKSI select").attr('disabled','');
    window.scrollTo(0,0);
}

function ubahDataSIMAKSIfinish(){
    $("#finishSIMAKSI input:text").removeAttr('readonly');
    $("#finishSIMAKSI input:text").removeAttr('disabled');
    $("#finishSIMAKSI input:file").removeAttr('disabled');
    $("#finishSIMAKSI button:submit").removeAttr('disabled');
    $("#cancelUbahVerifikasibtnfinish").removeAttr('disabled');
    $("#finishSIMAKSI select").removeAttr('disabled');
    window.scrollTo(0,340);
}

function cancelUbahVerifikasifinish(){
    $("#finishSIMAKSI input:text").attr('readonly','');
    $("#finishSIMAKSI input:text").attr('disabled','');
    $("#finishSIMAKSI input:file").attr('disabled','');
    $("#finishSIMAKSI button:submit").attr('disabled','');
    $("#cancelUbahVerifikasibtnfinish").attr('disabled','');
    $("#finishSIMAKSI select").attr('disabled','');
    window.scrollTo(0,0);
}

function detailSIMAKSI(id,thn){
    $.ajax({
          type: 'GET',
          url: 'detail',
          data: {id_simaksi:id, tahun:thn},
          success: function(data) {
            //console.log(data);
            var row = JSON.parse(data).row;
            $(".modal-title").html("Detail Data SIMAKSI: No. " + row['no_registrasi']);
            var bodyModal = "<div class=\"table-responsive\">";
                bodyModal += "<table class=\"table\">";
            var d = new Date();
            $.each(row, function(i, r) {
                var field = i.replace(/_/g , " ");
                var titik2 = ":";
                if (i == "tujuan") {
                    switch(row[i]){
                        case "1": row[i] = "Penelitian"; break;
                        case "2": row[i] = "Pendidikan"; break;
                        case "3": row[i] = "Dokumentasi (Film, Video, Foto)"; break;
                        case "4": row[i] = "Lain-lain"; break;
                    } 
                }
                if (i == "file_identitas") {
                    row[i] = "<a  target=\"_blank\" href=\"../../assets/filesimaksi/identitas/" + row[i] +"\">" + row[i] + "</a>";
                }
                if (i == "file_pengantar") {
                    row[i] = "<a  target=\"_blank\" href=\"../../assets/filesimaksi/pengantar/" + row[i] +"\">" + row[i] + "</a>";
                }
                if (i == "file_proposal") {
                    row[i] = "<a  target=\"_blank\" href=\"../../assets/filesimaksi/proposal/" + row[i] +"\">" + row[i] + "</a>";
                }
                if (i == "user_input") {
                    field = "Operator";
                    if (row[i] == 0) {
                        row[i] = 'Pemohon';
                    } else {
                        row[i] = row['nama_user']; 
                    }
                    
                }
                if (i == "id_status") {
                    field = "";
                    row[i] = "";
                    titik2 = "";
                }
                if (i == "status_id") {
                    field = "";
                    row[i] = "";
                    titik2 = "";
                }
                if (i == "nama_user") {
                    field = "";
                    row[i] = "";
                    titik2 = "";
                }
                if (i == "id_user") {
                    field = "";
                    row[i] = "";
                    titik2 = "";
                }
                if (i == "id") {
                    field = "";
                    row[i] = "";
                    titik2 = "";
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

function hapusSIMAKSI(id){
    var dialog = confirm("Anda yakin akan menghapus Data SIMAKSI ini?");
    if (dialog == true) {
        $.ajax({
              type: 'POST',
              url: './hapus',
              data: {id_simaksi:id},
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
                        document.location.assign('./data');
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