jQuery(document).ready(function($) {
	ajax_delete = function()
	{
		$(".btn-delete-js").click(function(){
			var href = $(this).attr('data-ajax');
			var _this = $(this);
			alertify.confirm("Bạn có chắc muốn xóa dòng dữ liệu này ?", function () {
			    $.ajax({
			    	type:"POST",
				    url: href,
				    dataType: 'json',
				    success: function(ok){
				    	console.log(ok.result);
				      	if(ok.result == 'warning'){
				      		alertify.log("Không thể xóa !");
				      	}else if(ok.result == null){
				      		alertify.log("You do not have permission to access these resources");
				      	}else if(ok.result == 'ok'){
				      		alertify.success("Xóa thành công !");
				      		_this.parents('tr').remove();
				      	}else{
				      		alertify.success("Something Errors !");
				      	}
				    }
				});
			}, function() {
				
			});
		})
	};

	$(".withdraw").click(function(){
		var id = $(this).data('id');
		var _this = this;
		$.ajax({
            type:"POST",
            url:"http://localhost/zflex/admin/ajax/withdraw",
            data:{id:id},
            dataType: 'json',
            success: function(data){
           		result = data.result;
           		if(result == true)
           		{
           			$(_this).parent('td').html('<i class="icon-checkmark3 d-block"></i>');
           		}	
            }
       });
	});

	$(".read-report").click(function(){
		var id = $(this).data('id');
		var _this = this;
		$.ajax({
            type:"POST",
            url:"http://localhost/zflex/admin/ajax/read-report",
            data:{id:id},
            dataType: 'json',
            success: function(data){
           		result = data.result;
           		if(result == true)
           		{
           			$(_this).parent('td').html('<i class="icon-checkmark3 d-block"></i>');
           		}	
            }
       });
	});

	htmlCategory = function(label,option,is_required)
	{
		xhtml = '';
		xhtml += '<div class="col-4 col-ajax">';
		if(is_required == 1)
		{
			xhtml += '<label class="box-left-title">'+label+'</label>';
		}else{
			xhtml += '<label class="box-left-title">'+label+'</label>';
		}
	    xhtml += '</div>';
	    xhtml += '<div class="col-8 col-ajax">';
	        xhtml += option;
	    xhtml += '</div>';
	    return xhtml;
	}

	htmlLoadTypeEdit = function(type,code,value,value_options = null)
	{
		xhtml = '';
		if(value == null) value = '';
		switch(type) {
		    case 'text':
		        xhtml += '<input type="text" name="'+code+'" class="form-control" value="'+value+'">'
		        break;
		    case 'image':
			    xhtml += '<div class="review">';
			    xhtml += '<div class="img-review">';
			    	xhtml += '<img src="http://localhost/zflex/public/img/media/'+value+'"/>';
			    	xhtml += '<i class="icon-bin"></i>';
			    	xhtml += '<div class="name">'+value+'</div>';
			    xhtml += '</div>';
			    xhtml += '</div>';
	            xhtml += '<button type="button" class="btn btn-dark btn-block btn-lg" data-toggle="modal" data-target="#mediaModal">';
	                xhtml += 'OPEN MEDIA';
	            xhtml += '</button>';
		        xhtml += '<input type="hidden" name="'+code+'" class="image-media" value="'+value+'">';
		        break;
		    case 'number':
		        xhtml += '<input type="text" name="'+code+'" class="form-control" value="'+value+'">'
		        break;
		    case 'password':
		        xhtml += '<input type="password" name="'+code+'" class="form-control" value="'+value+'">'
		        break;
		    case 'textarea':
		        xhtml += '<textarea name="'+code+'" class="form-control">'+value+'</textarea>';
		        break;
		    case 'select':
		    	xhtml += '<select class="form-control" name="'+code+'">';
		    	$.each(value_options, function(i, item) {
		    		if(value_options[i].is_default == 1)
		    		{
		    			if(value == value_options[i].code){
		    				xhtml += '<option data="'+value+'" selected value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    			}else{
		    				xhtml += '<option data="'+value+'" selected value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    			}
		    		}else{
		    			if(value == value_options[i].code){
		    				xhtml += '<option data="'+value+'" selected value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    			}else{
		    				xhtml += '<option data="'+value+'" value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    			}
		    		}
		    	});
		    	xhtml += '</select>';
		    	break;
		    case 'multiselect':
		    	xhtml += '<select multiple class="form-control select-js" name="'+code+'[]">';
		    	$.each(value_options, function(i, item) {
		    		if(value_options[i].is_default == 1)
		    		{
		    			if(value[i] == value_options[i].code){
		    				xhtml += '<option data="'+value[i]+'" selected value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    			}else{
		    				xhtml += '<option data="'+value[i]+'" selected value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    			}
		    		}else{
		    			if(value[i] == value_options[i].code){
		    				xhtml += '<option data="'+value[i]+'" selected value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    			}else{
		    				xhtml += '<option data="'+value[i]+'" value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    			}
		    		}
		    	});
		    	xhtml += '</select>';
		    	break;
		    default:
		        xhtml += '<p>undefined</p>';
		        break;
		}
		return xhtml;
	}

	htmlLoadType = function(type,code,value_options = null)
	{
		xhtml = '';
		switch(type) {
		    case 'text':
		        xhtml += '<input type="text" name="'+code+'" class="form-control" >'
		        break;
		    case 'image':
			    xhtml += '<div class="review">';

			    xhtml += '</div>';
	            xhtml += '<button type="button" class="btn btn-dark btn-block btn-lg" data-toggle="modal" data-target="#mediaModal">';
	                xhtml += 'OPEN MEDIA';
	            xhtml += '</button>';
		        xhtml += '<input type="hidden" name="'+code+'" class="image-media">';
		        break;
		    case 'number':
		        xhtml += '<input type="text" name="'+code+'" class="form-control">'
		        break;
		    case 'password':
		        xhtml += '<input type="password" name="'+code+'" class="form-control">'
		        break;
		    case 'textarea':
		        xhtml += '<textarea name="'+code+'" class="form-control"></textarea>';
		        break;
		    case 'select':
		    	xhtml += '<select class="form-control" name="'+code+'">';
		    	$.each(value_options, function(i, item) {
		    		if(value_options[i].is_default == 1)
		    		{
		    			xhtml += '<option selected value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    		}else{
		    			xhtml += '<option value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    		}
		    	});
		    	xhtml += '</select>';
		    	break;
		    case 'multiselect':
		    	xhtml += '<select multiple class="form-control select-js" name="'+code+'[]">';
		    	$.each(value_options, function(i, item) {
		    		if(value_options[i].is_default == 1)
		    		{
		    			xhtml += '<option selected value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    		}else{
		    			xhtml += '<option value="'+value_options[i].code+'">' +value_options[i].label +'</option>';
		    		}
		    	});
		    	xhtml += '</select>';
		    	break;
		    default:
		        xhtml += '<p>undefined</p>';
		        break;
		}
		return xhtml;
	}

	ajax_product_edit = function()
	{
	/*	if(window.location.href.indexOf("/product/edit") > -1) {
			$(".category-js").on('click',function(){
				alert("Không thể thay đổi !");
			});
       		var val = $(".category-js").val();
       		var product_id = $("[data-product-id]").attr('data-product-id');
			if(val != ""){
				$.ajax({
		            type:"POST",
		            url:"http://localhost/zflex/admin/product/loadEdit",
		            data:{data : val,product_id:product_id},
		            dataType: 'json',
		            success: function(data){
	               		console.log(data.result);
	               		$.each(data.result, function(i, item) {
	               			var label = data.result[i].label;
	               			var type = data.result[i].type;
	               			var code = data.result[i].code;
	               			var is_required = data.result[i].is_required;
	               			var value_options = data.result[i].value_options;
	               			var value = data.result[i].value;
	               			if(typeof value_options !== 'undefined'){
	               				$(".box-form-category .row").append(htmlCategory(label,htmlLoadTypeEdit(type,code,value,value_options),is_required));
	               				selectJS();
	               			}else{
	               				$(".box-form-category .row").append(htmlCategory(label,htmlLoadTypeEdit(type,code,value),is_required));
	               			}
						    
						})
	                },
	           });
			}
    	}*/
	}

	ajax_product_add = function()
	{

		/*if(window.location.href.indexOf("/product/add") > -1) {
       		var val = $(".category-js").val();
			if(val != ""){
				$('[name="tien"]').val('aaaa');
				$.ajax({
		            type:"POST",
		            url:"http://localhost/zflex/admin/product/load",
		            data:{data : val},
		            dataType: 'json',
		            success: function(data){
	               		console.log(data.result);
	               		$.each(data.result, function(i, item) {
	               			var label = data.result[i].label;
	               			var type = data.result[i].type;
	               			var code = data.result[i].code;
	               			var is_required = data.result[i].is_required;
	               			var value_options = data.result[i].value_options;
	               			if(typeof value_options !== 'undefined'){
	               				$(".box-form-category .row").append(htmlCategory(label,htmlLoadType(type,code,value_options),is_required));
	               				selectJS();
	               			}else{
	               				$(".box-form-category .row").append(htmlCategory(label,htmlLoadType(type,code),is_required));
	               			}
						    
						})
	                },
	           });
			}
    	}*/
		$(".category-js").on('change',function(){
			$(".col-ajax").remove();
			var val = $(this).val();
			$.ajax({
	            type:"POST",
	            url:"http://localhost/zflex/admin/product/load",
	            data:{data : val},
	            dataType: 'json',
	            success: function(data){
               		console.log(data.result);
               		$.each(data.result, function(i, item) {
               			var label = data.result[i].label;
               			var type = data.result[i].type;
               			var code = data.result[i].code;
               			var is_required = data.result[i].is_required;
               			var value_options = data.result[i].value_options;
               			if(typeof value_options !== 'undefined'){
               				$(".box-form-category .row").append(htmlCategory(label,htmlLoadType(type,code,value_options),is_required));
               				selectJS();
               			}else{
               				$(".box-form-category .row").append(htmlCategory(label,htmlLoadType(type,code),is_required));
               			}
					    
					})
                },
           });
		});
	}
})
