function abc(){
    var val = $("#txtbox").val(); 
	alert(val);

	$.ajax({
		url : 'demo.php',
		type:'POST',
		data :{
			action:"store","vv":val},
			success:function(data){	
	         alert(data);
		 }	 
	}); 
}