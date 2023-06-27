$(document).ready(function(){
    $('.main-form').submit(function() {
		var that = $(this);
		var data = that.serialize();
		$.ajax({
			type: 'post',
			dataType: 'html',
			url: '/ajax/get-url.php',
			data: data,
			success: function (e) {
				if(e.length > 8){
					alert(e);
				}else{
					$('.result').text('umax20ht.beget.tech/'+e);
				}
			},
			error: function(e){
				console.log('error');
			}
		});
		return false;
	});
});