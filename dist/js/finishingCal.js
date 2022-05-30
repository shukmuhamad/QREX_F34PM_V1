$('.form-group').on('input','.prc',function(){

 var totaldefect=0;
('.form-group .prc').each(function){

 var totalVal = $(this).val();
	if ($.isNumeric(inputVal)){
	
	totaldefect +=parseFloat(inputVal);
	}

});
  $('totalDefect').val(totaldefect);

};
