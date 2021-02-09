$(document).ready(function () {
    
    /*$("#lat_aksesibilitas").inputmask({
        mask: "-[9].999999",
        isNumeric: true,
    });
    $("#lon_aksesibilitas").inputmask({
        mask: "[999].999999",
        isNumeric: true,
        digits: "10"
    });*/

    $('#myModal').on('shown.bs.modal', function() {
        $('#formCreatePotensi')
        .formValidation({
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nama_potensi: {
                    validators: {
                        notEmpty: {
                            message: 'Potensi tidak boleh kosong.'
                        }
                    }
                },
                filegambar: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 500*1024,
                            message: 'File Gambar harus berformat JPEG/PNG dengan ukuran maksimal 500KB'
                        }
                    }
                },
                filekmlpotensi: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png,kml',
                            type: 'image/jpeg,image/png,application/vnd.google-earth.kml+xml',
                            maxSize: 300*1024,
                            message: 'File harus berformat KML dengan ukuran maksimal 300 KB'
                        }
                    }
                },
                tahun: {
                    validators: {
                        notEmpty: {
                            message: 'Tahun tidak boleh kosong.'
                        },
                        digits: {
                            message: 'Tahun harus diisi angka'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#formCreatePotensi")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../createpotensi',
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
                            document.location.assign('./');
                            
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
                        $("#formCreatePotensi").data('formValidation').resetForm();
                    }
                  }
              });
        });

        $('#formEditPotensi')
        .formValidation({
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nama_potensi: {
                    validators: {
                        notEmpty: {
                            message: 'Potensi tidak boleh kosong.'
                        }
                    }
                },
                filekmlpotensi: {
                    validators: {
                        file: {
                            extension: 'kml',
                            type: 'application/vnd.google-earth.kml+xml',
                            maxSize: 300*1024,
                            message: 'File harus berformat KML dengan ukuran maksimal 300 KB'
                        }
                    }
                },
                filegambar: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 500*1024,
                            message: 'File Gambar harus berformat JPEG/PNG dengan ukuran maksimal 500KB'
                        }
                    }
                },
                tahun: {
                    validators: {
                        notEmpty: {
                            message: 'Tahun tidak boleh kosong.'
                        },
                        digits: {
                            message: 'Tahun harus diisi angka'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#formEditPotensi")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../updatepotensi',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        var id = JSON.parse(data).id_resort;
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $form.find('.alert').html(message).show();
                        setTimeout(function() {
                            $form.find('.alert').hide();
                            $('#myModal').modal('hide');
                            document.location.assign('./' + id);
                            
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
                        $("#formEditPotensi").data('formValidation').resetForm();
                    }
                  }
              });
        });

        $('#formCreatePermasalahan')
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
                            message: 'Judul tidak boleh kosong.'
                        }
                    }
                },
                isi: {
                    validators: {
                        notEmpty: {
                            message: 'Isi tidak boleh kosong.'
                        }
                    }
                },
                filekmlmasalah: {
                    validators: {
                        file: {
                            extension: 'kml',
                            type: 'application/vnd.google-earth.kml+xml',
                            maxSize: 5*1024*1024,
                            message: 'File harus berformat KML dengan ukuran maksimal 5MB'
                        }
                    }
                },
                filegambar: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 500*1024,
                            message: 'File Gambar harus berformat JPEG/PNG dengan ukuran maksimal 500KB'
                        }
                    }
                },
                tahun: {
                    validators: {
                        notEmpty: {
                            message: 'Tahun tidak boleh kosong.'
                        },
                        digits: {
                            message: 'Tahun harus diisi angka'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#formCreatePermasalahan")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../createmasalah',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        var id = JSON.parse(data).id_resort;
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $form.find('.alert').html(message).show();
                        setTimeout(function() {
                            $form.find('.alert').hide();
                            $('#myModal').modal('hide');
                            document.location.assign('./' + id);
                            
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
                        $("#formCreatePermasalahan").data('formValidation').resetForm();
                    }
                  }
              });
        });
        
        $('#formEditPermasalahan')
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
                            message: 'Judul tidak boleh kosong.'
                        }
                    }
                },
                isi: {
                    validators: {
                        notEmpty: {
                            message: 'Isi tidak boleh kosong.'
                        }
                    }
                },
                filekmlmasalah: {
                    validators: {
                        file: {
                            extension: 'kml',
                            type: 'application/vnd.google-earth.kml+xml',
                            maxSize: 5*1024*1024,
                            message: 'File harus berformat KML dengan ukuran maksimal 5MB'
                        }
                    }
                },
                filegambar: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 500*1024,
                            message: 'File Gambar harus berformat JPEG/PNG dengan ukuran maksimal 500KB'
                        }
                    }
                },
                tahun: {
                    validators: {
                        notEmpty: {
                            message: 'Tahun tidak boleh kosong.'
                        },
                        digits: {
                            message: 'Tahun harus diisi angka'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#formEditPermasalahan")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../updatemasalah',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        var id = JSON.parse(data).id_resort;
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $form.find('.alert').html(message).show();
                        setTimeout(function() {
                            $form.find('.alert').hide();
                            $('#myModal').modal('hide');
                            document.location.assign('./' + id);
                            
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
                        $("#formEditPermasalahan").data('formValidation').resetForm();
                    }
                  }
              });
        });

        $('#formCreateSarpras')
        .formValidation({
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nama_sarpras: {
                    validators: {
                        notEmpty: {
                            message: 'Sarpras tidak boleh kosong.'
                        }
                    }
                },
                lat: {
                    validators: {
                        regexp: {
                            regexp: /^[-.0-9]+$/,
                            message: 'Longitude hanya bisa diisi dengan karakter dot(.), stripes(-) dan angka'
                        },
                        notEmpty: {
                            message: 'Lattidude tidak boleh kosong'
                        }
                    }
                },
                lon: {
                    validators: {
                        regexp: {
                            regexp: /^[-.0-9]+$/,
                            message: 'Longitude hanya bisa diisi dengan karakter dot(.), stripes(-) dan angka'
                        },
                        notEmpty: {
                            message: 'Longitude tidak boleh kosong'
                        }
                    }
                },
                filegambar: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 500*1024,
                            message: 'File Gambar harus berformat JPEG/PNG dengan ukuran maksimal 500KB'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#formCreateSarpras")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../createsarpras',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        var id = JSON.parse(data).id_resort;
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $form.find('.alert').html(message).show();
                        setTimeout(function() {
                            $form.find('.alert').hide();
                            $('#myModal').modal('hide');
                            document.location.assign('./' + id);
                            
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
                        $("#formCreateSarpras").data('formValidation').resetForm();
                    }
                  }
              });
        });

        $('#formEditSarpras')
        .formValidation({
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nama_sarpras: {
                    validators: {
                        notEmpty: {
                            message: 'Sarpras tidak boleh kosong.'
                        }
                    }
                },
                lat: {
                    validators: {
                        regexp: {
                            regexp: /^[-.0-9]+$/,
                            message: 'Longitude hanya bisa diisi dengan karakter dot(.), stripes(-) dan angka'
                        },
                        notEmpty: {
                            message: 'Lattidude tidak boleh kosong'
                        }
                    }
                },
                lon: {
                    validators: {
                        regexp: {
                            regexp: /^[-.0-9]+$/,
                            message: 'Longitude hanya bisa diisi dengan karakter dot(.), stripes(-) dan angka'
                        },
                        notEmpty: {
                            message: 'Longitude tidak boleh kosong'
                        }
                    }
                },
                filegambar: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 500*1024,
                            message: 'File Gambar harus berformat JPEG/PNG dengan ukuran maksimal 500KB'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#formEditSarpras")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../updatesarpras',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        var id = JSON.parse(data).id_resort;
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $form.find('.alert').html(message).show();
                        setTimeout(function() {
                            $form.find('.alert').hide();
                            $('#myModal').modal('hide');
                            document.location.assign('./' + id);
                            
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
                        $("#formEditSarpras").data('formValidation').resetForm();
                    }
                  }
              });
        });

        $('#formCreateDivespot')
        .formValidation({
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nama_sarpras: {
                    validators: {
                        notEmpty: {
                            message: 'Sarpras tidak boleh kosong.'
                        }
                    }
                },
                lat: {
                    validators: {
                        regexp: {
                            regexp: /^[-.0-9]+$/,
                            message: 'Longitude hanya bisa diisi dengan karakter dot(.), stripes(-) dan angka'
                        },
                        notEmpty: {
                            message: 'Lattidude tidak boleh kosong'
                        }
                    }
                },
                lon: {
                    validators: {
                        regexp: {
                            regexp: /^[-.0-9]+$/,
                            message: 'Longitude hanya bisa diisi dengan karakter dot(.), stripes(-) dan angka'
                        },
                        notEmpty: {
                            message: 'Longitude tidak boleh kosong'
                        }
                    }
                },
                filegambar: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 500*1024,
                            message: 'File Gambar harus berformat JPEG/PNG dengan ukuran maksimal 500KB'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#formCreateDivespot")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../createdivespot',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        var id = JSON.parse(data).id_resort;
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $form.find('.alert').html(message).show();
                        setTimeout(function() {
                            $form.find('.alert').hide();
                            $('#myModal').modal('hide');
                            document.location.assign('./' + id);
                            
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
                        $("#formCreateDivespot").data('formValidation').resetForm();
                    }
                  }
              });
        });

        $('#formEditDivespot')
        .formValidation({
            message: 'This value is not valid',
            //live: 'submitted',
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nama_sarpras: {
                    validators: {
                        notEmpty: {
                            message: 'Sarpras tidak boleh kosong.'
                        }
                    }
                },
                lat: {
                    validators: {
                        regexp: {
                            regexp: /^[-.0-9]+$/,
                            message: 'Longitude hanya bisa diisi dengan karakter dot(.), stripes(-) dan angka'
                        },
                        notEmpty: {
                            message: 'Lattidude tidak boleh kosong'
                        }
                    }
                },
                lon: {
                    validators: {
                        regexp: {
                            regexp: /^[-.0-9]+$/,
                            message: 'Longitude hanya bisa diisi dengan karakter dot(.), stripes(-) dan angka'
                        },
                        notEmpty: {
                            message: 'Longitude tidak boleh kosong'
                        }
                    }
                },
                filegambar: {
                    validators: {
                        file: {
                            extension: 'jpg,jpeg,png',
                            type: 'image/jpeg,image/png',
                            maxSize: 500*1024,
                            message: 'File Gambar harus berformat JPEG/PNG dengan ukuran maksimal 500KB'
                        }
                    }
                }
            }
        }).on('success.form.fv', function(e) {
            e.preventDefault();
            var $form     = $(e.target),
            validator = $form.data('formValidation');
            var data = new FormData($("#formEditDivespot")[0]);
            $.ajax({
                  type: 'POST',
                  url: '../updatedivespot',
                  data: data,
                  processData: false,
                  contentType: false,
                  success: function(data) {
                    var status = JSON.parse(data).status;
                    var message = JSON.parse(data).message;
                    if (status == 'success')
                    {
                        var id = JSON.parse(data).id_resort;
                        $('.alert').removeClass('alert-warning');
                        $('.alert').removeClass('alert-danger');
                        $('.alert').addClass('alert-success');
                        $form.find('.alert').html(message).show();
                        setTimeout(function() {
                            $form.find('.alert').hide();
                            $('#myModal').modal('hide');
                            document.location.assign('./' + id);
                            
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
                        $("#formEditDivespot").data('formValidation').resetForm();
                    }
                  }
              });
        });

    });

    //var fotoIndex = 5;
    $('#formProfilKK')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_resort: {
                validators: {
                    notEmpty: {
                        message: 'Nama KK tidak boleh kosong.'
                    }
                }
            },
            luas_resort: {
                validators: {
                    notEmpty: {
                        message: 'Luas KK tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Luas KK harus diisi angka',
                        thousandsSeparator: '',
                        decimalSeparator: '.'
                    }

                }
            },
            isi_profil: {
                group: '.textarea',
                validators: {
                    notEmpty: {
                        message: 'Isi Profil KK tidak boleh kosong.'
                    }
                }
            },
            sejarah_kawasan: {
                group: '.textarea',
                validators: {
                    notEmpty: {
                        message: 'Sejarah Kawasan tidak boleh kosong.'
                    }
                }
            },
            filekml: {
                validators: {
                    file: {
                        extension: 'kml',
                        type: 'application/vnd.google-earth.kml+xml',
                        maxSize: 300*1024,
                        message: 'File harus berformat KML dengan ukuran maksimal 300 KB'
                    }
                }
            },
            filegambar: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 800*1024,
                        message: 'File berformat JPG/JPEG/PNG dengan ukuran maksimal 800 KB'
                    }
                }
            },
            fileskpenunjukan: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 20*1024*1024,
                        message: 'File berformat PDF dengan ukuran maksimal 20 MB'
                    }
                }
            },
            filebatatabatas: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 20*1024*1024,
                        message: 'File berformat PDF dengan ukuran maksimal 20 MB'
                    }
                }
            },
            fileskpenetapan: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 20*1024*1024,
                        message: 'File berformat PDF dengan ukuran maksimal 20 MB'
                    }
                }
            },
            filepenataanblok: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 20*1024*1024,
                        message: 'File berformat PDF dengan ukuran maksimal 20 MB'
                    }
                }
            },
            filerp: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        maxSize: 20*1024*1024,
                        message: 'File berformat PDF dengan ukuran maksimal 20 MB'
                    }
                }
            },
            filedesapenyangga: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 800*1024,
                        message: 'File berformat JPG/JPEG/PNG dengan ukuran maksimal 800 KB'
                    }
                }
            },
            filepeta: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 800*1024,
                        message: 'File berformat JPG/JPEG/PNG dengan ukuran maksimal 800 KB'
                    }
                }
            },
            lat_aksesibilitas: {
                validators: {
                    notEmpty: {
                        message: 'Latitude tidak boleh kosong.'
                    }
                }
            },
            lon_aksesibilitas: {
                validators: {
                    notEmpty: {
                        message: 'Longitude tidak boleh kosong.'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var editorText1 = CKEDITOR.instances.isi_profil.getData();
        var editorText2 = CKEDITOR.instances.sejarah_kawasan.getData();
        var editorText3 = CKEDITOR.instances.desa_penyangga.getData();
        var data = new FormData($("#formProfilKK")[0]);
        data.append('isi_profil_value', editorText1);
        data.append('sejarah_kawasan_value', editorText2);
        data.append('desa_penyangga_value', editorText3);
        $.ajax({
              type: 'POST',
              url: '../saveprofil',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id_resort = JSON.parse(data).id_resort;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#formProfilKK').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../profil/' + id_resort);
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
                    $("#formProfilKK").data('formValidation').resetForm();
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
                    $("#formProfilKK").data('formValidation').resetForm();
                }
              }
          });
    });
    
    $('#formProfilResort')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_resort: {
                validators: {
                    notEmpty: {
                        message: 'Nama Resort tidak boleh kosong.'
                    }
                }
            },
            luas: {
                validators: {
                    notEmpty: {
                        message: 'Luas tidak boleh kosong.'
                    },
                    numeric: {
                        message: 'Luas harus diisi angka',
                        thousandsSeparator: '',
                        decimalSeparator: '.'
                    }

                }
            },
            isi_profil: {
                group: '.textarea',
                validators: {
                    notEmpty: {
                        message: 'Isi Profil KK tidak boleh kosong.'
                    }
                }
            },
            zonasi: {
                group: '.textarea',
                validators: {
                    notEmpty: {
                        message: 'Zonasi tidak boleh kosong.'
                    }
                }
            },
            desa_penyangga: {
                group: '.textarea',
                validators: {
                    notEmpty: {
                        message: 'Desa Penyangga tidak boleh kosong.'
                    }
                }
            },
            struktur_organisasi: {
                group: '.textarea',
                validators: {
                    notEmpty: {
                        message: 'Struktur Organisasi tidak boleh kosong.'
                    }
                }
            },
            filekml: {
                validators: {
                    file: {
                        extension: 'kml,kmz',
                        type: 'application/vnd.google-earth.kml+xml',
                        maxSize: 300*1024,
                        message: 'File harus berformat KML/KMZ dengan ukuran maksimal 300 KB'
                    }
                }
            },
            filegambar: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 800*1024,
                        message: 'File berformat JPG/JPEG/PNG dengan ukuran maksimal 800 KB'
                    }
                }
            },
            filezonasi: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 800*1024,
                        message: 'File berformat JPG/JPEG/PNG dengan ukuran maksimal 800 KB'
                    }
                }
            },
            filedesapenyangga: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 800*1024,
                        message: 'File berformat JPG/JPEG/PNG dengan ukuran maksimal 800 KB'
                    }
                }
            },
            filewilayahkerja: {
                validators: {
                    file: {
                        extension: 'jpg,jpeg,png',
                        type: 'image/jpeg,image/png',
                        maxSize: 800*1024,
                        message: 'File berformat JPG/JPEG/PNG dengan ukuran maksimal 800 KB'
                    }
                }
            }
        }
    }).on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var editorText1 = CKEDITOR.instances.isi_profil.getData();
        var editorText2 = CKEDITOR.instances.zonasi.getData();
        var editorText3 = CKEDITOR.instances.struktur_organisasi.getData();
        var editorText4 = CKEDITOR.instances.desa_penyangga.getData();
        var data = new FormData($("#formProfilResort")[0]);
        data.append('isi_profil_value', editorText1);
        data.append('zonasi_value', editorText2);
        data.append('struktur_organisasi_value', editorText3);
        data.append('desa_penyangga_value', editorText4);
        $.ajax({
              type: 'POST',
              url: '../saveprofil',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id_resort = JSON.parse(data).id_resort;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#formProfilResort').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../profil/' + id_resort);
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
                    $("#formProfilResort").data('formValidation').resetForm();
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
                    $("#formProfilResort").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#createFormPrioritas')
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
        var data = new FormData($("#createFormPrioritas")[0]);
        data.append('isivalue', editorText);

        $.ajax({
              type: 'POST',
              url: 'createprioritas',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id_resort = JSON.parse(data).id_resort;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#createFormPrioritas').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('./prioritas/'+id_resort);
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
                    $("#createFormPrioritas").data('formValidation').resetForm();
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
                    $("#createFormPrioritas").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#editFormPrioritas')
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
        var data = new FormData($("#editFormPrioritas")[0]);
        data.append('isivalue', editorText);

        $.ajax({
              type: 'POST',
              url: '../updateprioritas',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id_resort = JSON.parse(data).id_resort;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#editFormPrioritas').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../prioritas/'+id_resort);
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
                    $("#editFormPrioritas").data('formValidation').resetForm();
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
                    $("#editFormPrioritas").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#createFormKemitraan')
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
        var data = new FormData($("#createFormKemitraan")[0]);
        data.append('isivalue', editorText);

        $.ajax({
              type: 'POST',
              url: 'createkemitraan',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id_resort = JSON.parse(data).id_resort;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#createFormKemitraan').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../profil/kemitraan');
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
                    $("#createFormKemitraan").data('formValidation').resetForm();
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
                    $("#createFormKemitraan").data('formValidation').resetForm();
                }
              }
          });
    });

    $('#editFormKemitraan')
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
        var data = new FormData($("#editFormKemitraan")[0]);
        data.append('isivalue', editorText);

        $.ajax({
              type: 'POST',
              url: '../updatekemitraan',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id_resort = JSON.parse(data).id_resort;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#editFormKemitraan').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../kemitraan');
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
                    $("#editFormKemitraan").data('formValidation').resetForm();
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
                    $("#editFormKemitraan").data('formValidation').resetForm();
                }
              }
          });
    });
    

    $('#editProfilForm')
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
        var data = new FormData($("#editProfilForm")[0]);
        data.append('isivalue', editorText);

        $.ajax({
              type: 'POST',
              url: '../updateprofilbalai',
              data: data,
              processData: false,
              contentType: false,
              success: function(data) {
                var status = JSON.parse(data).status;
                var message = JSON.parse(data).message;
                if (status == 'success')
                {
                    var id_resort = JSON.parse(data).id_resort;
                    $('.alert').removeClass('alert-warning');
                    $('.alert').removeClass('alert-danger');
                    $('.alert').addClass('alert-success');
                    $form.find('.alert').html(message).show();
                    $('#editProfilForm').formValidation('resetForm', true);
                    setTimeout(function() {
                        $form.find('.alert').hide();
                        document.location.assign('../');
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
                    $("#editProfilForm").data('formValidation').resetForm();
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
                    $("#editProfilForm").data('formValidation').resetForm();
                }
              }
          });
    });

});

function addPotensiKawasan(nama_resort){
    var baseUrl = $('#base_url').val();
    var bodyModal = "";
    $(".modal-title").html("Form Tambah Data Potensi Kawasan di " + nama_resort);
        bodyModal += "<form id=\"formCreatePotensi\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Nama Potensi</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"nama_potensi\" id=\"nama_potensi\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Kategori</label><div class=\"col-lg-4\">";
        bodyModal += "<select name=\"kategori\" id=\"role_id\" class=\"form-control\" style=\"width: 100%;\">";
        bodyModal += "<option value=\"1\">Flora</option><option value=\"2\">Fauna</option><option value=\"3\">Jasling</option>";
        bodyModal += "</select>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Tahun</label><div class=\"col-lg-3\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"tahun\" id=\"tahun\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div style=\"display: none;\" class=\"form-group\"><label class=\"col-lg-3 control-label\">Gambar</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filegambar\" name=\"filegambar\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">File KML Potensi</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filekmlpotensi\" name=\"filekmlpotensi\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function editPotensi(nama_resort,id,potensi,file,kategori,filekml,tahun){
    var baseUrl = $('#base_url').val();
    var bodyModal = "";
    (kategori == 1) ? selected1 = "selected" : selected1 = "";
    (kategori == 2) ? selected2 = "selected" : selected2 = "";
    (kategori == 3) ? selected3 = "selected" : selected3 = ""; 
    $(".modal-title").html("Form Tambah Data Potensi Kawasan di " + nama_resort);
        bodyModal += "<form id=\"formEditPotensi\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Nama Potensi</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"nama_potensi\" id=\"nama_potensi\" value=\""+ potensi +"\"/>";
        bodyModal += "<input type=\"hidden\" class=\"form-control\" name=\"id_potensi\" id=\"id_potensi\" value=\""+ id +"\"/>";
        bodyModal += "<input type=\"hidden\" class=\"form-control\" name=\"file_old\" id=\"file_old\" value=\""+ file +"\"/>";
        bodyModal += "<input type=\"hidden\" class=\"form-control\" name=\"file_old_kml\" id=\"file_old_kml\" value=\""+ filekml +"\"/>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Kategori</label><div class=\"col-lg-4\">";
        bodyModal += "<select name=\"kategori\" id=\"role_id\" class=\"form-control\" style=\"width: 100%;\">";
        bodyModal += "<option "+ selected1 +" value=\"1\">Flora</option><option "+ selected2 +" value=\"2\">Fauna</option><option "+ selected3 +" value=\"3\">Jasling</option>";
        bodyModal += "</select>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Tahun</label><div class=\"col-lg-3\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"tahun\" id=\"tahun\" value=\""+ tahun +"\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div style=\"display:none;\" class=\"form-group\"><label class=\"col-lg-3 control-label\">Gambar</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filegambar\" name=\"filegambar\" />";
        bodyModal += "<p class=\"text-muted\">*) Apabila Gambar tidak diubah, dikosongkan saja.</p>";
        bodyModal += "File Gambar: <a target=\"_blank\" href=\""+ baseUrl +"assets/kontensitroom/" + file + "\">";
        bodyModal += file + "</a>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">File KML Potensi</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filekmlpotensi\" name=\"filekmlpotensi\" />";
        bodyModal += "<p class=\"text-muted\">*) Apabila File KML tidak diubah, dikosongkan saja.</p>";
        bodyModal += "File KML Potensi: <a target=\"_blank\" href=\""+ baseUrl +"assets/kontensitroom/" + filekml + "\">";
        bodyModal += filekml + "</a>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan</button>";
        bodyModal += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" onclick=\"deletePotensi("+ id +",'"+ file +"','"+ filekml +"')\" class=\"btn btn-danger\"><i class=\"fa fa-close\"></i>&nbsp;&nbsp;Hapus</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function deletePotensi(id,file,filekml) {
    var dialog = confirm("Apakah anda yakin akan menghapus data ini?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: '../hapuspotensi',
          data: {id_potensi:id,file_gambar:file,file_kml:filekml},
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

function showDetailPrioritas(id,judul,file) {
    var isi = $('#isi_prioritas'+id).val();
    var bodyModal = "";
    var baseUrl = $('#base_url').val() + 'assets/fileprofil/' + file;
    $(".modal-title").html(judul);
    bodyModal += "<center><img style=\"padding-top:10px;max-width:300px\"";
    bodyModal += "class=\"img-responsive img-thumbnail\" src=\"" + baseUrl + "\"";
    bodyModal += "alt=\"" + judul + "\"></center>";
    bodyModal += "<div align=\"justify\">" + isi + "</div>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');
}
$('.img-link').on('click', function(e) {
    document.getElementById("a_link").click();
});
function deletePrioritas(id,file) {
    var dialog = confirm("Apakah anda yakin akan menghapus data ini?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: 'hapusprioritas',
          data: {id_prioritas:id,file_gambar:file},
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

function showDetailKemitraan(id,judul,file) {
    var isi = $('#isi_kemitraan'+id).val();
    var bodyModal = "";
    if (file != "") {
        var baseUrl = $('#base_url').val() + 'assets/fileprofil/' + file;
    } else {
        var baseUrl = $('#base_url').val() + 'assets/fileprofil/none.jpg';
    }
    
    $(".modal-title").html(judul);
    bodyModal += "<center><img style=\"padding-top:10px;max-width:300px\"";
    bodyModal += "class=\"img-responsive img-thumbnail\" src=\"" + baseUrl + "\"";
    bodyModal += "alt=\"" + judul + "\"></center>";
    bodyModal += "<div align=\"justify\">" + isi + "</div>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');
}

function deleteKemitraan(id,file) {
    var dialog = confirm("Apakah anda yakin akan menghapus data ini?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: 'hapuskemitraan',
          data: {id_kemitraan:id,file_gambar:file},
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

function detailDataMonitoring(id) {
    var baseUrl = $('#base_url').val();
        $.ajax({
              type: 'GET',
              url: baseUrl + 'kawasan/detailkawasan',
              data: {id_data_monitoring:id,},
              success: function(data) {
                console.log(data);
                var row = JSON.parse(data).row;
                $(".modal-title").html("Detail Data Monitoring");
                var bodyModal = "<div class=\"table-responsive\">";
                    bodyModal += "<table class=\"table\">";
                var d = new Date();
                var fileURL = $("#base_url").val() + 'assets/filemonitoring/' + row['file_foto'];
                bodyModal += "<tr>";
                bodyModal += "<td width=\"20%\">Jenis Kegiatan</td>";
                bodyModal += "<td width=\"5%\">:</td>";
                bodyModal += "<td width=\"75%\" style=\"font-weight:bold;text-transform:capitalize;\">" + row['name'] + "</td>";
                bodyModal += "</tr>";
                bodyModal += "<tr>";
                bodyModal += "<td width=\"20%\">Lokasi</td>";
                bodyModal += "<td width=\"5%\">:</td>";
                bodyModal += "<td width=\"75%\">" + row['nama_resort'] + " (" + row['lat'] + "," + row['lon'] + ")";
                bodyModal += " <a target=\"blank\" href=\"https://www.google.com/maps/?q=" + row['lat'] + "," + row['lon'] + "\"><b>[ Lihat Lokasi ]<b></a>";
                bodyModal += " <a target=\"blank\" href=\"" + fileURL + "\"><b>[ Lihat Foto ]<b></a></td>";
                bodyModal += "</tr>";
                bodyModal += "<tr>";
                bodyModal += "<td width=\"20%\">Waktu</td>";
                bodyModal += "<td width=\"5%\">:</td>";
                bodyModal += "<td width=\"75%\">" + dateFormat(row['date_time']) +"</td>";
                bodyModal += "</tr>";
                bodyModal += "<tr>";
                bodyModal += "<td width=\"20%\">Nama Petugas</td>";
                bodyModal += "<td width=\"5%\">:</td>";
                bodyModal += "<td width=\"75%\">" + getPetugasDetail(row['petugas_id']) +"</td>";
                bodyModal += "</tr>";
                bodyModal += "<tr>";
                if (row['reference_column_tallysheet'] != "") {
                    var arr_reff = row['reference_column_tallysheet'].split(';');
                    var val_reff = row['reference_column'].split(';');
                    for (x in arr_reff ) {
                        var label_reff = arr_reff[x].replace("_"," ");
                        bodyModal += "<td width=\"20%\">" + toTitleCase(label_reff) +"</td>";
                        bodyModal += "<td width=\"5%\">:</td>";
                        bodyModal += "<td width=\"75%\">" + getReffDetail(arr_reff[x],val_reff[x]) +"</td>";
                        bodyModal += "</tr>";
                    }
                };
                if (row['description_tallysheet'] != "") {
                    var arr_des = row['description_tallysheet'].split(';');
                    var val_des = row['description'].split(';');
                    for (x in arr_des ) {
                        var label_des = arr_des[x].replace("_"," ");
                        bodyModal += "<td width=\"20%\">" + toTitleCase(label_des) +"</td>";
                        bodyModal += "<td width=\"5%\">:</td>";
                        bodyModal += "<td width=\"75%\">" + val_des[x] +"</td>";
                        bodyModal += "</tr>";
                    }
                };
                bodyModal += "<tr>";
                bodyModal += "<td width=\"20%\">Diinput oleh</td>";
                bodyModal += "<td width=\"5%\">:</td>";
                bodyModal += "<td width=\"75%\">" + row['nama_user_input'] +" pada " + dateFormat(row['date_input']) + "</td>";
                bodyModal += "</tr>";
                if (row['user_verifikasi'] != 0) {
                    bodyModal += "<tr>";
                    bodyModal += "<td width=\"20%\">Divalidasi oleh:</td>";
                    bodyModal += "<td width=\"5%\">:</td>";
                    bodyModal += "<td width=\"75%\">" + row['nama_user_verifikasi'] +" pada " + dateFormat(row['date_verifikasi']) + "</td>";
                    bodyModal += "</tr>";
                };
                bodyModal += "<tr>";
                bodyModal += "<td width=\"20%\">Status</td>";
                bodyModal += "<td width=\"5%\">:</td>";
                bodyModal += "<td width=\"75%\">";
                if (row['flag_id'] == 1) {
                    bodyModal += "<div class=\"label bg-green\" align=\"center\">" + row['status'] + "</div>";
                } else if (row['flag_id'] == 2) {
                    bodyModal += "<div class=\"label bg-blue\" align=\"center\">" + row['status'] + "</div>";
                } else if (row['flag_id'] == 3) {
                    bodyModal += "<div class=\"label bg-red\" align=\"center\">" + row['status'] + "</div>";
                };
                bodyModal += "</td>";
                bodyModal += "</tr>";
                bodyModal += "</table></div>";

                $(".modal-body").html(bodyModal);
              }
        });
    
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function getPetugasDetail(value) {
    var value_petugas;
    var baseUrl = $('#base_url').val();
    $.ajax({
        type: 'GET',
        url: baseUrl + 'kawasan/getdatapetugas',
        async: false,
        data: {data_petugas:value},
        success: function(data) {
            //Get Data Data Referensi
            var val_petugas = JSON.parse(data).value_petugas;
            value_petugas = val_petugas;
        }
    });
    return value_petugas;
}

function getReffDetail(nama,value) {
    var value_data;
    var baseUrl = $('#base_url').val();
    $.ajax({
        type: 'GET',
        url: baseUrl + 'kawasan/getdatareferensi',
        async: false,
        data: {tabel:nama,val:value},
        success: function(data) {
            //Get Data Data Referensi
            var val_data = JSON.parse(data).value_data;
            value_data = val_data;
        }
    });
    return value_data;
}

function addPermasalahanKawasan(nama_resort){
    var bodyModal = "";
    $(".modal-title").html("Form Tambah Data Permasalahan di " + nama_resort);
        bodyModal += "<form id=\"formCreatePermasalahan\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Judul</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"judul\" id=\"judul\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Isi</label><div class=\"col-lg-6\">";
        bodyModal += "<textarea name=\"isi\" class=\"form-control\" style=\"width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;\" data-fv-notempty-message=\"not empty\"></textarea>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Kategori</label><div class=\"col-lg-4\">";
        bodyModal += "<select name=\"kategori\" id=\"role_id\" class=\"form-control\" style=\"width: 100%;\">";
        bodyModal += "<option value=\"1\">Konflik TSL</option><option value=\"2\">Perambahan</option><option value=\"3\">Sengketa Lahan</option><option value=\"4\">Pemukiman Permanen</option>";
        bodyModal += "</select>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">File KML Permasalahan</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filekmlmasalah\" name=\"filekmlmasalah\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div style=\"display:none;\" class=\"form-group\"><label class=\"col-lg-3 control-label\">Gambar</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filegambar\" name=\"filegambar\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Tahun</label><div class=\"col-lg-3\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"tahun\" id=\"tahun\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function editPermasalahan(nama_resort,id,judul,isi,kategori,file,filekml,tahun){
    var baseUrl = $('#base_url').val();
    var bodyModal = "";
    (kategori == 1) ? selected1 = "selected" : selected1 = "";
    (kategori == 2) ? selected2 = "selected" : selected2 = "";
    (kategori == 3) ? selected3 = "selected" : selected3 = ""; 
    (kategori == 4) ? selected4 = "selected" : selected4 = ""; 
    $(".modal-title").html("Form Ubah Data Permasalahan di " + nama_resort);
        bodyModal += "<form id=\"formEditPermasalahan\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Judul</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"judul\" id=\"judul\" value=\""+ judul +"\"/>";
        bodyModal += "<input type=\"hidden\" class=\"form-control\" name=\"id_masalah\" id=\"id_masalah\" value=\""+ id +"\"/>";
        bodyModal += "<input type=\"hidden\" class=\"form-control\" name=\"file_old\" id=\"file_old\" value=\""+ file +"\"/>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Isi</label><div class=\"col-lg-6\">";
        bodyModal += "<textarea name=\"isi\" class=\"form-control\" style=\"width: 100%; height: 150px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;\" data-fv-notempty-message=\"not empty\">"+ isi +"</textarea>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Kategori</label><div class=\"col-lg-4\">";
        bodyModal += "<select name=\"kategori\" id=\"role_id\" class=\"form-control\" style=\"width: 100%;\">";
        bodyModal += "<option "+ selected1 +" value=\"1\">Konflik TSL</option><option "+ selected2 +" value=\"2\">Perambahan</option><option "+ selected3 +" value=\"3\">Sengketa Lahan</option><option "+ selected4 +" value=\"4\">Pemukiman Permanen</option>";
        bodyModal += "</select>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">File KML Permasalahan</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filekmlmasalah\" name=\"filekmlmasalah\" />";
        bodyModal += "<p class=\"text-muted\">*) Apabila File KML tidak diubah, dikosongkan saja.</p>";
        bodyModal += "File KML Permasalahan: <a target=\"_blank\" href=\""+ baseUrl +"assets/kontensitroom/" + filekml + "\">";
        bodyModal += filekml + "</a>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Tahun</label><div class=\"col-lg-3\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"tahun\" id=\"tahun\" value=\""+ tahun +"\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div style=\"display:none;\" class=\"form-group\"><label class=\"col-lg-3 control-label\">Gambar</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filegambar\" name=\"filegambar\" />";
        bodyModal += "<p class=\"text-muted\">*) Apabila Gambar tidak diubah, dikosongkan saja.</p>";
        bodyModal += "File : <a target=\"_blank\" href=\""+ baseUrl +"assets/kontensitroom/" + file + "\">";
        bodyModal += file + "</a>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan</button>";
        bodyModal += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" onclick=\"deletePermasalahan("+ id +",'"+ file +"','"+ filekml +"')\" class=\"btn btn-danger\"><i class=\"fa fa-close\"></i>&nbsp;&nbsp;Hapus</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function deletePermasalahan(id,file,filekml) {
    var dialog = confirm("Apakah anda yakin akan menghapus data ini?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: '../hapusmasalah',
          data: {id_masalah:id,file_gambar:file,file_kml:filekml},
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

function addSarpras(nama_resort){
    var baseUrl = $('#base_url').val();
    var bodyModal = "";
    $(".modal-title").html("Form Tambah Data Sarpras Kawasan di " + nama_resort);
        bodyModal += "<form id=\"formCreateSarpras\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Nama Sarpras</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"nama_sarpras\" id=\"nama_sarpras\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Kategori</label><div class=\"col-lg-4\">";
        bodyModal += "<select name=\"kategori_sarpras\" id=\"role_id\" class=\"form-control\" style=\"width: 100%;\">";
        bodyModal += "<option selected value=\"1\">Bangunan</option><option value=\"2\">Subtopic</option><option value=\"3\">Kendaraan</option>";
        bodyModal += "</select>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\"><u>Lokasi (Lat,Lon)</u></label></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Lattitude</label><div class=\"col-lg-4\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" placeholder=\"Contoh : -6.6603625\" name=\"lat\" id=\"lat\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Longitude</label><div class=\"col-lg-4\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" placeholder=\"Contoh : 121.1270684\" name=\"lon\" id=\"lon\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Gambar</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filegambar\" name=\"filegambar\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function editSarpras(nama_resort,id,sarpras,file,lat,lon,kategori){
    var baseUrl = $('#base_url').val();
    (kategori == 1) ? selected1 = "selected" : selected1 = "";
    (kategori == 2) ? selected2 = "selected" : selected2 = "";
    (kategori == 3) ? selected3 = "selected" : selected3 = ""; 
    var bodyModal = "";
    $(".modal-title").html("Form Ubah Data Sarpras Kawasan di " + nama_resort);
        bodyModal += "<form id=\"formEditSarpras\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Nama Sarpras</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"nama_sarpras\" id=\"nama_sarpras\" value=\""+ sarpras +"\"/>";
        bodyModal += "<input type=\"hidden\" class=\"form-control\" name=\"id_sarpras\" id=\"id_sarpras\" value=\""+ id +"\"/>";
        bodyModal += "<input type=\"hidden\" class=\"form-control\" name=\"file_old\" id=\"file_old\" value=\""+ file +"\"/>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Kategori</label><div class=\"col-lg-4\">";
        bodyModal += "<select name=\"kategori_sarpras\" id=\"role_id\" class=\"form-control\" style=\"width: 100%;\">";
        bodyModal += "<option "+ selected1 +" value=\"1\">Bangunan</option><option "+ selected2 +" value=\"2\">Subtopic</option><option "+ selected3 +" value=\"3\">Kendaraan</option>";
        bodyModal += "</select>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\"><u>Lokasi (Lat,Lon)</u></label></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Lattitude</label><div class=\"col-lg-4\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" placeholder=\"Contoh : -6.6603625\" name=\"lat\" id=\"lat\" value=\""+ lat +"\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Longitude</label><div class=\"col-lg-4\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" placeholder=\"Contoh : 121.1270684\" name=\"lon\" id=\"lon\" value=\""+ lon +"\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Gambar</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filegambar\" name=\"filegambar\" />";
        bodyModal += "<p class=\"text-muted\">*) Apabila Gambar tidak diubah, dikosongkan saja.</p>";
        bodyModal += "File : <a target=\"_blank\" href=\""+ baseUrl +"assets/kontensitroom/" + file + "\">";
        bodyModal += file + "</a>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan</button>";
        bodyModal += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" onclick=\"deleteSarpras("+ id +",'"+ file +"')\" class=\"btn btn-danger\"><i class=\"fa fa-close\"></i>&nbsp;&nbsp;Hapus</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function deleteSarpras(id,file) {
    var dialog = confirm("Apakah anda yakin akan menghapus data ini?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: '../hapussarpras',
          data: {id_sarpras:id,file_gambar:file},
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

function addDivespot(nama_resort){
    var baseUrl = $('#base_url').val();
    var bodyModal = "";
    $(".modal-title").html("Form Tambah Data Dive Spot di " + nama_resort);
        bodyModal += "<form id=\"formCreateDivespot\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Nama Dive Spot</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"nama_sarpras\" id=\"nama_sarpras\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\"><u>Lokasi (Lat,Lon)</u></label></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Lattitude</label><div class=\"col-lg-4\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" placeholder=\"Contoh : -6.6603625\" name=\"lat\" id=\"lat\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Longitude</label><div class=\"col-lg-4\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" placeholder=\"Contoh : 121.1270684\" name=\"lon\" id=\"lon\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Gambar</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filegambar\" name=\"filegambar\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function editDivespot(nama_resort,id,sarpras,file,lat,lon,kategori){
    var baseUrl = $('#base_url').val();
    (kategori == 1) ? selected1 = "selected" : selected1 = "";
    (kategori == 2) ? selected2 = "selected" : selected2 = "";
    (kategori == 3) ? selected3 = "selected" : selected3 = ""; 
    var bodyModal = "";
    $(".modal-title").html("Form Ubah Data Dive Spot di " + nama_resort);
        bodyModal += "<form id=\"formEditDivespot\" method=\"post\" enctype=\"multipart/form-data\" class=\"form-horizontal\">";
        bodyModal += "<div class=\"alert alert-success\" style=\"display: none;\"></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Nama Dive Spot</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" name=\"nama_sarpras\" id=\"nama_sarpras\" value=\""+ sarpras +"\"/>";
        bodyModal += "<input type=\"hidden\" class=\"form-control\" name=\"id_sarpras\" id=\"id_sarpras\" value=\""+ id +"\"/>";
        bodyModal += "<input type=\"hidden\" class=\"form-control\" name=\"file_old\" id=\"file_old\" value=\""+ file +"\"/>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\"><u>Lokasi (Lat,Lon)</u></label></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Lattitude</label><div class=\"col-lg-4\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" placeholder=\"Contoh : -6.6603625\" name=\"lat\" id=\"lat\" value=\""+ lat +"\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Longitude</label><div class=\"col-lg-4\">";
        bodyModal += "<input type=\"text\" class=\"form-control\" placeholder=\"Contoh : 121.1270684\" name=\"lon\" id=\"lon\" value=\""+ lon +"\" />";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><label class=\"col-lg-3 control-label\">Gambar</label><div class=\"col-lg-6\">";
        bodyModal += "<input type=\"file\" class=\"form-control\" id=\"filegambar\" name=\"filegambar\" />";
        bodyModal += "<p class=\"text-muted\">*) Apabila Gambar tidak diubah, dikosongkan saja.</p>";
        bodyModal += "File : <a target=\"_blank\" href=\""+ baseUrl +"assets/kontensitroom/" + file + "\">";
        bodyModal += file + "</a>";
        bodyModal += "</div></div>";
        bodyModal += "<div class=\"form-group\"><div class=\"col-lg-9 col-lg-offset-3\">";
        bodyModal += "<button type=\"submit\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;&nbsp;Simpan</button>";
        bodyModal += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type=\"button\" onclick=\"deleteSarpras("+ id +",'"+ file +"')\" class=\"btn btn-danger\"><i class=\"fa fa-close\"></i>&nbsp;&nbsp;Hapus</button>";
        bodyModal += "</div></div>";
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function deleteDivespot(id,file) {
    var dialog = confirm("Apakah anda yakin akan menghapus data ini?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: '../hapusdivespot',
          data: {id_sarpras:id,file_gambar:file},
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

function showPDFSKPenunjukan(id,nama_resort,file) {
    var bodyModal = "";
    var baseUrl = $('#base_url').val() + 'assets/fileresort/' + file;
    $(".modal-title").html("SK Penunjukan : " + nama_resort);
    bodyModal += "<center>";
    bodyModal += "<embed src=\'" + baseUrl + "\' ";
    bodyModal += "quality=\'high\' ";
    bodyModal += "allowScriptAccess=\'always\' ";
    bodyModal += "allowFullScreen=\'false\' ";
    bodyModal += "pluginspage=\'http://www.adobe.com/go/getreader\' ";
    bodyModal += "type=\'application/pdf\' ";
    bodyModal += "width=\'80%\' ";
    bodyModal += "height=\'720\'>";
    bodyModal += "</embed></center>";
        
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');
}

function showPDFBATataBatas(id,nama_resort,file) {
    var bodyModal = "";
    var baseUrl = $('#base_url').val() + 'assets/fileresort/' + file;
    $(".modal-title").html("Berita Acara Tata Batas : " + nama_resort);
    bodyModal += "<center>";
    bodyModal += "<embed src=\'" + baseUrl + "\' ";
    bodyModal += "quality=\'high\' ";
    bodyModal += "allowScriptAccess=\'always\' ";
    bodyModal += "allowFullScreen=\'false\' ";
    bodyModal += "pluginspage=\'http://www.adobe.com/go/getreader\' ";
    bodyModal += "type=\'application/pdf\' ";
    bodyModal += "width=\'80%\' ";
    bodyModal += "height=\'720\'>";
    bodyModal += "</embed></center>";
        
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');
}

function showPDFSKPenetapan(id,nama_resort,file) {
    var bodyModal = "";
    var baseUrl = $('#base_url').val() + 'assets/fileresort/' + file;
    $(".modal-title").html("SK Penetapan : " + nama_resort);
    bodyModal += "<center>";
    bodyModal += "<embed src=\'" + baseUrl + "\' ";
    bodyModal += "quality=\'high\' ";
    bodyModal += "allowScriptAccess=\'always\' ";
    bodyModal += "allowFullScreen=\'false\' ";
    bodyModal += "pluginspage=\'http://www.adobe.com/go/getreader\' ";
    bodyModal += "type=\'application/pdf\' ";
    bodyModal += "width=\'80%\' ";
    bodyModal += "height=\'720\'>";
    bodyModal += "</embed></center>";
        
        bodyModal += "</form>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');
}