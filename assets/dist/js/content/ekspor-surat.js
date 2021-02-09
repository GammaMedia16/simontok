









$('#lingkupsm').on('change', function() {
    var val = $(this).val();
    if (val == 4) { 
    	$('#kategorism').removeAttr('disabled');
    } else {
    	$('#kategorism').attr('disabled','disabled');
    }
})

$('#lingkupsk').on('change', function() {
    var val = $(this).val();
    if (val == 4) { 
    	$('#kategorisk').removeAttr('disabled');
    } else {
    	$('#kategorisk').attr('disabled','disabled');
    }
})