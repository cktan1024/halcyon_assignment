		function showMessage(type,message){
          	// html = '<div class="alert alert-'+type+' alert-dismissible transparent" role="alert">'+message+'<button type="button" class="close"><span aria-hidden="true">&times;</span></div>';
          	html='<div class="alert alert-'+type+' alert-dismissible transparent" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>'+message+'</div>';          		
  			$('.message-box').append(html);
  			setTimeout("$('.message-box .alert').removeClass('transparent');", 1);
		}