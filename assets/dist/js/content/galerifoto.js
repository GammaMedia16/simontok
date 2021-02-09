
$(function () {
  'use strict'
  var id_album = $("#id_album").val();
  var user_id = $("#user_id").val();

  var datafoto = $.parseJSON($.ajax({
      url:  '../getgaleri',
      type: 'GET',
      data: {id_album_galeri:id_album},
      dataType: "json", 
      async: false
  }).responseText);

  var carouselLinks = [];
    var linksContainer = $('#links');
    var baseUrl
    var imageBox
    var imageBtn
    

  $.each(datafoto, function(i, row) {
      baseUrl = $('#base_url').val() + 'assets/filegaleri/' + datafoto[i].file_name_foto;
      imageBox = '<img class=\"\" style=\"padding:5px 10px 10px 10px;max-width:200px\">';
      imageBox += '</img>';
      imageBtn = '<a data-toggle=\"tooltip\" title=\"Hapus Foto\" href=\"javascript:deleteFoto('+ datafoto[i].id_photo_galeri +')\"';
      imageBtn += '<i style=\"color:red\" class=\"fa fa-close\"></i></a>';
      imageBtn += '&nbsp;&nbsp;&nbsp;&nbsp;';
      imageBtn += '<a style=\"color:green\" data-toggle=\"tooltip\" title=\"Default Album\" href=\"javascript:makeDefault('+ datafoto[i].album_galeri_id +',\''+ datafoto[i].file_name_foto +'\')\"';
      imageBtn += '<i class=\"fa fa-star\"></i></a>';

      
      $('<a/>')
        .append($(imageBox).prop('src', baseUrl))
        .prop('href', baseUrl)
        .prop('title', datafoto[i].caption)
        .prop('style', "padding-right: 20px;")
        .attr('data-gallery', '')
        .appendTo(linksContainer);
      if (datafoto[i].user_input == user_id) {
        $('<span/>')
        .append($(imageBtn))
        .prop('class', 'folio-overview')
        .appendTo(linksContainer);
      };
      carouselLinks.push({
        href: baseUrl,
        title: datafoto[i].caption
      })
  })
  
})

function deleteFoto(id) {
    var dialog = confirm("Yakin akan menghapus foto ini?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: '../hapusfoto',
          data: {id_photo_galeri:id},
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
    }
}

function makeDefault(id_album,file) {
    var dialog = confirm("Yakin akan menjadikan foto ini sebagai default album?");
    if (dialog == true) {
    $.ajax({
          type: 'POST',
          url: '../makedefaultfoto',
          data: {id_album_galeri:id_album,file_photo:file},
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
    }
}