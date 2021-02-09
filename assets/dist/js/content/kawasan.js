$(document).ready(function () {
	
	$('#createKawasanForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_kk: {
                validators: {
                    notEmpty: {
                        message: 'Nama Kawasan tidak boleh kosong.'
                    }
                }
            },
            reg_kk: {
                validators: {
                    notEmpty: {
                        message: 'Register Kawasan tidak boleh kosong.'
                    },
                    digits: {
                        message: 'Register Kawasan harus diisi angka'
                    }
                }
            },
            wdpa_id: {
                validators: {
                    digits: {
                        message: 'ID WDPA harus diisi angka'
                    }
                }
            },
            prov_id: {
                validators: {
                    notEmpty: {
                        message: 'Provinsi tidak boleh kosong.'
                    }
                }
            },
            petugas_id: {
                validators: {
                    notEmpty: {
                        message: 'Nama Pegawai tidak boleh kosong.'
                    }
                }
            },
            luas_kk: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Luas harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            luas_zona: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Luas harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            luas_open_area: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Luas harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#createKawasanForm")[0]);
	    Pace.track(function(){
	    $.ajax({
	        type: 'POST',
	        url: 'insert',
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
                            document.location.assign('../kawasan');
                        }
                        else if (status == 'error')
                        {
                            $("#createKawasanForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

	$('#updateKawasanForm')
    .formValidation({
        message: 'This value is not valid',
        //live: 'submitted',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nama_kk: {
                validators: {
                    notEmpty: {
                        message: 'Nama Kawasan tidak boleh kosong.'
                    }
                }
            },
            reg_kk: {
                validators: {
                    notEmpty: {
                        message: 'Register Kawasan tidak boleh kosong.'
                    },
                    digits: {
                        message: 'Register Kawasan harus diisi angka'
                    }
                }
            },
            wdpa_id: {
                validators: {
                    digits: {
                        message: 'ID WDPA harus diisi angka'
                    }
                }
            },
            prov_id: {
                validators: {
                    notEmpty: {
                        message: 'Provinsi tidak boleh kosong.'
                    }
                }
            },
            petugas_id: {
                validators: {
                    notEmpty: {
                        message: 'Nama Pegawai tidak boleh kosong.'
                    }
                }
            },
            luas_kk: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Luas harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            luas_zona: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Luas harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            },
            luas_open_area: {
                validators: {
                    numeric: {
                        decimalSeparator: '.',
                        message: 'Luas harus diisi angka, apabila angka desimal menggunakan pemisah (.) dot'
                    }
                }
            }
        }
    })
	.on('success.form.fv', function(e) {
        e.preventDefault();
        var $form     = $(e.target),
        validator = $form.data('formValidation');
        var data = new FormData($("#updateKawasanForm")[0]);
	    Pace.track(function(){
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
                            document.location.assign('../../kawasan');
                        }
                        else if (status == 'error')
                        {
                            $("#updateKawasanForm").data('formValidation').resetForm();
                            document.location.reload();
                        }

                        
                      }
                })
	        }
	    });
		});
    });

	


});


$("#tallysheet_id").on("change", function () {
	var tallysheet_id = $(this).val();
  	if (tallysheet_id != 0) {
		$("#btnSimpan").removeAttr("disabled");
		$.ajax({
	        type: 'GET',
	        url: 'getmastertallysheet',
	        data: {id_tallysheet:tallysheet_id},
	        success: function(data) {
	            //console.log(data);
	            //Get Data Tallysheet

	            var row = JSON.parse(data).row;

	            //Create Form Deskripsi
	            var field_deskripsi = row['description'];
	            var arr_deskripsi = new Array();
	            arr_deskripsi = field_deskripsi.split(";");
	            var add_form_deskripsi = "";
	            for (x in arr_deskripsi ) {
	            	var label_view = arr_deskripsi[x].replace("_"," ");
				    add_form_deskripsi += "<div class=\"form-group\">";
	                add_form_deskripsi += "<label class=\"col-lg-2 control-label\">" + toTitleCase(label_view) + "</label>";
	                add_form_deskripsi += "<div class=\"col-lg-6\">";
	                if (arr_deskripsi[x] == 'keterangan') {
	                	add_form_deskripsi += "<textarea id=\"" + arr_deskripsi[x] + "\" name=\"" + arr_deskripsi[x] + "\" class=\"form-control textarea fieldTallysheet\" rows=\"10\"></textarea>";
	                } else {
	                	add_form_deskripsi += "<input type=\"text\" id=\"" + arr_deskripsi[x] + "\" name=\"" + arr_deskripsi[x] + "\" class=\"form-control fieldTallysheet\">";
	                };
	                
	                
	                add_form_deskripsi += "</div></div>"; 
				}
				$("#add_deskripsi").html(add_form_deskripsi);

				//Create Form Referensi
				var field_reff = row['reference_column'];
				if (field_reff != "") {
					var arr_reff = new Array();
		            arr_reff = field_reff.split(";");
		            var add_form_reff = "";
		            for (y in arr_reff ) {
		            	var label_view_reff = arr_reff[y].replace("_"," ");
					    add_form_reff += "<div class=\"form-group\">";
		                add_form_reff += "<label class=\"col-lg-2 control-label\">" + toTitleCase(label_view_reff) + "</label>";
		                add_form_reff += "<div class=\"col-lg-6\">";
		                add_form_reff += "<select name=\"" + arr_reff[y] + "\" id=\"" + arr_reff[y] + "\" class=\"form-control reff-col\" style=\"width: 100%;\">";
		                
		                add_form_reff += "<option value=\"0\">-- Pilih " + toTitleCase(label_view_reff) + " --</option>";
		                
	                    //Reference Column
	                    getRefenceValue(arr_reff[y]);

	                    add_form_reff += "</select>";
		                add_form_reff += "</div></div>"; 
					}
					$("#add_referensi").html(add_form_reff);
					$(".reff-col").select2();
					$(".reff-col").on("change", function () {
						var reff_val = $(this).val();
						//alert(reff_val);
						if (reff_val != 0) {

							$("#btnSimpan").removeAttr("disabled");
						} else {
							$("#btnSimpan").attr('disabled','');
						};	
					});
				} else { 
					$("#add_referensi").empty(); 
				};
				
	        }
	    });

	} else {
		$("#btnSimpan").attr('disabled','');
		$("#add_referensi").empty();
		$("#add_deskripsi").empty();
	};
	
});



function getRefenceValue(field) {
	$.ajax({
        type: 'GET',
        url: 'getreferencetallysheet',
        data: {table_name:field},
        success: function(data) {
            //Get Data Data Referensi
            var row_reff = JSON.parse(data).row_reff;
            var c_field = JSON.parse(data).c_field;
            var x = c_field - 1;
            var option = "";
            $.each(row_reff, function(i, row) {
            	switch(x) {
				    case 1:
				        var detail_view = row_reff[i].detail_1;
				        break;
				    case 2:
				        var detail_view = row_reff[i].detail_1 + " / " + row_reff[i].detail_2;
				        break;
				    case 3:
				        var detail_view = row_reff[i].detail_1 + " / " + row_reff[i].detail_2 + " / " + row_reff[i].detail_3;
				        break;
				}
            	option = "<option value=\"" + row_reff[i].id_reference + "\">" + detail_view + "</option>";
            	$("#"+field).append(option); 
            })
    	}
    });
}





function viewFotoTallysheet(file) {
	var fileURL = $("#base_url").val() + 'assets/filemonitoring/' + file;
    var bodyModal = "";
    $(".modal-title").html("Lihat Foto : " + file);
        bodyModal += "<center><img style=\"padding-top:10px;max-width:100%\"";
	    bodyModal += "class=\"img-responsive\" src=\"" + fileURL + "\"";
	    bodyModal += "alt=\"" + file + "\"></center>";
    $(".modal-body").html(bodyModal);
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');
}

function getPetugasDetail(value) {
	var value_petugas;
	$.ajax({
        type: 'GET',
        url: 'getdatapetugas',
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
	$.ajax({
        type: 'GET',
        url: 'getdatareferensi',
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

function gagalValidasi(id_data) {
	var dialog = confirm("Apakah yakin Anda tidak memvalidasi Data Monitoring ini?");
    if (dialog == true) {
	    $.ajax({
	        type: 'POST',
	        url: '../gagalvalidation',
	        data: {id_data_monitoring:id_data},
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
	                    document.location.assign('../baru');
	                }, 4000);
	            }
	            else if (status == 'error')
	            {
	                $('.alert').removeClass('alert-warning');
	                $('.alert').removeClass('alert-success');
	                $('.alert').addClass('alert-danger');
	                $('.alert').html(message).show();
	                setTimeout(function() {
	                   $form.find('.alert').hide();
	                }, 3000);
	                $("#editTallysheetForm").data('formValidation').resetForm();
	            }
	        }
	    });
	}
}

function detailDataMonitoring(id) {
	
	Pace.track(function(){
	    $.ajax({
	          type: 'GET',
	          url: 'detail',
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
	});
	
    var btnClose = "<button type=\"button\" class=\"btn btn-default pull-left\" data-dismiss=\"modal\">Close</button>";
    $(".modal-footer").html(btnClose);
    $('#myModal').modal('show');    
}

function importData() {
	
}

$('#btnSaveImport').on('click', function(e) {
	var dialog = confirm("Apakah Anda yakin akan Import Data Monitoring ini?");
	if (dialog == true) {
	    Pace.track(function(){
	    	$.ajax({
	        type: 'POST',
	        url: 'importdata',
	        data: $("#formImportData").serialize() + '&' + $("#formImportView").serialize(),
	        success: function(data) {
	        	console.log(data);
	        	var status = JSON.parse(data).status;
	        	var message = JSON.parse(data).message;
	        	if (status == 'success')
	            {
	                $('.alert').removeClass('alert-warning');
	                $('.alert').removeClass('alert-danger');
	                $('.alert').addClass('alert-success');
	                $('.alert').html(message).show();
	                setTimeout(function() {
	                    document.location.assign('baru');
	                }, 4000);
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
		});
	}
});

