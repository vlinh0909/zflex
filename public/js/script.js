var zflex_url = 'http://localhost/zflex/';

jQuery(document).ready(function($) {
	var id_media = 0;
	alertify.logPosition("bottom right");
	function strip_tags(text)
	{
	  return text.replace(/(<([^>]+)>)/ig,"");
	}
});

jQuery(document).ready(function($) {

	htmlDropzone = function(file) {
		xhtml = '';
		xhtml += '<li class="list-inline-item align-content-stretch">';
            xhtml += '<div class="media-item">';
                xhtml += '<div class="media-thumbnail">';
                    xhtml += '<img src="'+zflex_url+'public/img/'+ file.name +'" data-image-size="' +file.size+ '" data-image-mime="'+ file.type +'" data-image-time="null" class="img-media">';
                xhtml += '</div>';
                xhtml += '<div class="media-description">';
                    xhtml += '<div class="media-title">'+ file.name +'</div>';
                xhtml += '</div>';
            xhtml +='</div>';
        xhtml +='</li>';
        return xhtml;
	}

	dropzoneZL = function()
	{
		
	}


	pageLoad = function ()
	{
		window.onload = function(){
		  setTimeout(function(){
		    var t = performance.timing;
		    $(".page-footer-inner .text-right").html("Page loaded in <font color='red'><b>" + (t.loadEventEnd - t.responseEnd)/ 1000 + "</b></font> seconds");
		  }, 0);
		}
	}

	checkCouponCode =  function()
	{
		if($(".txtCouponCode").val() > 1){
			$(".coupon-code").show();
			$(".coupon-code-1").hide();
		}else{
			$(".coupon-code").hide();
			$(".coupon-code-1").show();
		}
	}

	convertVietnamese  = function(str){
        str = str.toLowerCase();
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        return str;
    }

	convertToSlug = function(Text)
	{
    	return Text.toLowerCase().replace(/ /g,'_').replace(/[^\w-]+/g,'');
	}
});
jQuery(document).ready(function($) {
	$('.dropdown-list-group').perfectScrollbar();
	$('.side-menu').perfectScrollbar();
	
})

jQuery(document).ready(function($) {
	sidebarCollapse = function()
	{
		if($("html").width() < 576){
			$("body").addClass("sidebar-collapse");
		}
		$(window).resize(function(){
			if($("html").width() < 576){
				$("body").addClass("sidebar-collapse");
			}
		});
	}
})
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
			    	xhtml += '<img src="'+zflex_url+'public/img/media/'+value+'"/>';
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
})

jQuery(document).ready(function($) {
	console.log(document.cookie);
	sizeContent = function ()
	{
		$(".main-wrapper").css({'minHeight' : screen.height})
	}
	$('[data-toggle=tooltip]').tooltip();
	





	$('.readmore').readmore({
		collapsedHeight:0,
		moreLink: '<a href="#">Xem thêm</a>',
		lessLink: '<a href="#">Hiển thị bớt</a>'
	});

	htmlMedia = function(input,id = 0,image = null,text = 'OPEN MEDIA')
	{
		xhtml = '';
		xhtml += '<div class="review" data-review-id="'+id+'">';
        if(image != null){
            xhtml += '<div class="img-review">';
                xhtml += '<img src="'+image+'"/>';
                xhtml += '<i class="icon-bin"></i>';
                xhtml += '<div class="name">'+image+'</div>';
            xhtml += '</div>';
        }
        xhtml += '</div>';
        xhtml += '<button type="button" class="btn btn-dark btn-block btn-lg btn-open-media" data-media-id="'+id+'" data-toggle="modal" data-target="#mediaModal">';
            xhtml += text;
        xhtml += '</button>';
        xhtml += '<input type="hidden" name="'+input+'" class="image-media" data-review-id="'+id+'" value="">';
        return xhtml;
	}

	$(".btn-add-image").click(function(){
		var id = Number($("[data-media-id]").last().attr("data-media-id")) + 1;
		console.log(id);
		$(".col-image-add").append(htmlMedia('image_'+id,id));
	});

	htmlNestable = function(values,type)
	{
		xhtml = '';
		if(type == 'custom'){
			xhtml += '<li class="dd-item" data-target="_self" data-type="'+type+'" data-id="0" data-icon="'+values['icon']+'" data-title="'+values['title']+'" data-url="'+values['url']+'">';
		}else if(type == 'categories'){
			xhtml += '<li class="dd-item" data-target="_self" data-type="'+type+'" data-id="'+values['id']+'" data-icon="'+values['icon']+'" data-title="'+values['title']+'">';
		}else if(type == 'pages'){
			xhtml += '<li class="dd-item" data-target="_self" data-type="'+type+'" data-id="'+values['id']+'" data-icon="'+values['icon']+'" data-title="'+values['title']+'">';
		}
	        xhtml += '<div class="dd-handle">';
	            xhtml += '<span class="float-left">'+values['title']+'</span>';
	            xhtml += '<span class="float-right">'+type+'</span>';
	        xhtml += '</div>';
	        xhtml += '<a href="javascript:void(0)" class="show-item-details">';
	            xhtml += '<i class="fa fa-angle-down"></i>';
	        xhtml += '</a>';
	        xhtml += '<div class="clearfix"></div>';
	        xhtml += '<div class="item-details">';
	            xhtml += '<div class="fields">';
	                xhtml += '<label>';
	                    xhtml += '<span class="text">Title</span>';
	                    xhtml += '<input type="text" name="title" value="'+values['title']+'">';
	                xhtml += '</label>';
	                if(type == 'custom'){
	                xhtml += '<label>';
	                    xhtml += '<span class="text">Icon Font</span>';
	                    xhtml += '<input type="text" name="icon" value="'+values['icon']+'">';
	                xhtml += '</label>';
	            	}
	            	if(type == 'custom'){
	            	xhtml += '<label>';
	                    xhtml += '<span class="text">Url</span>';
	                    xhtml += '<input type="text" name="url" value="'+values['url']+'">';
	                xhtml += '</label>';
	            	}
	                xhtml += '<label>';
	                    xhtml += '<span class="text">Target Type</span>';
	                    xhtml += '<select class="select-target">';
	                        xhtml += '<option value="_self">By Default</option>';
	                        xhtml += '<option value="_blank">Blank</option>';
	                    xhtml += '</select>';
	                xhtml += '</label>';
	            xhtml += '</div>';
	            xhtml += '<div class="text-right">';
	                xhtml += '<button type="button" class="btn btn-danger btn-sm btn-mini btn-remove-menu">Remove</button>';
	            xhtml += '</div>';
	        xhtml += '</div>';
	    xhtml += '</li>';
	    return xhtml;
	}

	var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };

	clickAddMenu = function()
	{
		$(".dd-list").on('keypress change','input[name="title"]',function(){
			var val = $(this).val();
			$(this).parents("li").data("title",val);
			$(this).parents(".item-details").prevAll(".dd-handle").find(".float-left").html(val);			
		});
		$(".dd-list").on('keypress change','input[name="icon"]',function(){
			var val = $(this).val();
			$(this).parents("li").data("icon",val);
		});
		$(".dd-list").on('keypress change','input[name="url"]',function(){
			var val = $(this).val();
			$(this).parents("li").data("url",val);
		});
		$(".dd-list").on('change','.select-target',function(){
			val = $(this).val();
			$(this).parents("li").data("target",val);
		});
		$("#custom").on('click','.btn-add-menu',function(){
			var title = $("#custom").find('input#title').val();
			var url = $("#custom").find('input#url').val();
			var icon = $("#custom").find('input#icon').val();
			var values = [];
			values["title"] = title;
			values["url"] = url;
			values["icon"] = icon;
			values["target"] = '_self';
			if(values["title"] !== '' && values["url"] !== '')
			{
				$('#nestable > .dd-list').append(htmlNestable(values,'custom'));
			}else{
				alertify.log("Bạn chưa nhập dữ liệu !");
			}
			updateOutput($('#nestable').data('output', $('#nestable-output')));
		});

		$("#categories").on('click','.btn-add-menu',function(){
			arr = {};
			$('#categories').find(".cbx-input:checked").each(function(){        
		        var k = $(this).val();
		        var value = $(this).nextAll('label#title').html();
		        arr[k] = value;
		    });
		    $.each(arr, function(i, item) {
		    	values = {};
	    		values["id"] = i;
	    		values["title"] = item;
	    		values["icon"] = '';
	    		values["target"] = '_self';
	    		$('#nestable > .dd-list').append(htmlNestable(values,'categories'));
	    	});
	    	updateOutput($('#nestable').data('output', $('#nestable-output')));
			// var title = $("#custom").find('input#title').val();
			// var url = $("#custom").find('input#url').val();
			// var icon = $("#custom").find('input#icon').val();
			// var values = [];
			// values["title"] = title;
			// values["url"] = url;
			// values["icon"] = icon;
			// $('#nestable > .dd-list').append(htmlNestable(values,'custom'));
		});

		$("#nestable").on('click','.btn-remove-menu',function(){
			$(this).parent().parent().parent().remove();
			updateOutput($('#nestable').data('output', $('#nestable-output')));
		});
	}

	htmlImgReview = function(src,name,multi = false)
	{
		xhtml = '';
		if(multi == true)
		{
			xhtml += '<div class="img-review" data-toggle="modal" data-target="#mediaModalMulti">';
		}else{
			xhtml += '<div class="img-review" data-toggle="modal" data-target="#mediaModal">';
		}
			xhtml += '<img src="'+src+'"/>'
		if(multi == true)
		{
			xhtml += '<i class="icon-bin" data-review-id="'+id_media+'"></i>'
		}else{
			xhtml += '<i class="icon-bin icon-bin-single"></i>'
		}
			xhtml += '<div class="name">'+name+'</div>';
		xhtml += '</div>';
		return xhtml;
	}

	clickMedia = function()
	{
		// $('.box-media').on('click','.list-media-multi .media-item-modal',function(){
			
		// });
		$('.box-media').on('click','.media-item',function(){
			if ( event.ctrlKey ) {
				if(!$(this).hasClass('media-item-folder'))
				{
		    		$(this).toggleClass('clicked');
		    	}
		    } else {
		    	$('[data-media="action"]').show();
		    	$('.media-item').removeClass('clicked');
				$(this).toggleClass('clicked');
				if(!$(this).hasClass('media-item-folder'))
				{
					src = $(this).find('img').attr('src');
					filename = $(this).find('img').attr('data-image-name');
					size = $(this).find('img').attr('data-image-size');
					mime = $(this).find('img').attr('data-image-mime')
					time = $(this).find('img').attr('data-image-time')
					$('.media-url').val(src);
					$('a[data-fancybox="gallery"]').attr('href',src);
					$('[data-media="name"]').html(filename.replace(/.*(\/|\\)/, ''));
					$('[data-media="size"]').html(size + 'kb');
					$('[data-media="mime"]').html(mime);
					$('[data-media="time"]').html(time);
					$('.img-detail').attr('src',src);
				}
				
			}
		});
		
		// $('.box-media').on('click','.list-media-single .media-item-modal',function(){
		// 	$(".btn-media-actions").removeClass('disabled');
	 //    	$('[data-media="action"]').show();
	 //    	$('.media-item').removeClass('clicked');
		// 	$(this).toggleClass('clicked');
		// 	src = $(this).find('img').attr('src');
		// 	filename = $(this).find('img').attr('data-image-name');
		// 	size = $(this).find('img').attr('data-image-size');
		// 	mime = $(this).find('img').attr('data-image-mime')
		// 	time = $(this).find('img').attr('data-image-time')
		// 	$('.media-url').val(src);
		// 	$('a[data-fancybox="gallery"]').attr('href',src);
		// 	$('[data-media="name"]').html(filename.replace(/.*(\/|\\)/, ''));
		// 	$('[data-media="size"]').html(size + 'kb');
		// 	$('[data-media="mime"]').html(mime);
		// 	$('[data-media="time"]').html(time);
		// 	$('.img-detail').attr('src',src);
		// });
		$('.box-media').on('dblclick','.list-media-single .media-item-modal',function(){
			var val = $(this).find("img").attr("data-image-name");
			var src = $(this).find("img").attr("src");
			$(".image-media[data-review-id='"+id_media+"']").val(src);
			$(".review[data-review-id='"+id_media+"']").html(htmlImgReview(src,val,false));
			$('.modal').modal('hide');
		});
		$('.box-media').on('dblclick','.list-media-multi .media-item-modal',function(){
			var val = $(this).find("img").attr("data-image-name");
			var src = $(this).find("img").attr("src");
			$(".image-media[data-review-id='"+id_media+"']").val($(".image-media[data-review-id='"+id_media+"']").val() + src + ',');
			$(".review[data-review-id='"+id_media+"']").append(htmlImgReview(src,val,true));
			$('.modal').modal('hide');
		});
		$('.box-form-content').on('click','.img-review .icon-bin',function(){
			var id = $(this).data('review-id');
			id_media = id;
			var val = $(this).prev().attr("src");
			var a = $(".image-media[data-review-id='"+id_media+"']").val();
			if($(this).hasClass('icon-bin-single'))
			{
				var b = '';
			}
			else
			{
				var b = a.replace(val+',','');
			}
			$(".image-media[data-review-id='"+id_media+"']").val(b);
			$(this).parent(".img-review").remove();
			return false;
		});
		$('.box-form-content').on('click','.img-review',function(){
			id_media = $(this).parents('.review').attr('data-review-id');
			console.log(id_media);
			var name = $(this).text();
			$(".media-item-modal").removeClass("clicked");
			$("img[data-image-name='"+name+"']").parent().parent().addClass('clicked');
		});
		$(".media-select").on('click',function(e){
			$(".media-item-modal.clicked").each(function( index ) {
				var val = $(this).find("img").attr("data-image-name");
				var src= $( this ).find("img").attr("src");
				$(".image-media[data-review-id='"+id_media+"']").val($(".image-media[data-review-id='"+id_media+"']").val() + src + ',');
				$(".review[data-review-id='"+id_media+"']").append(htmlImgReview(src,val));
			});
			$(".media-item-modal").removeClass("clicked");
			$('.modal').modal('hide');
		});
		$(".box-form-content").on('click','.btn-open-media',function(){
			var id = $(this).attr('data-media-id');
			id_media = id;
			// console.log(id_media);
		});
	}

	selectJS = function()
	{
		$(".select-js").select2({
			closeOnSelect : false,
			sorter: function(data) {
			    return data.sort(function (a, b) {
			        if (a.text > b.text) {
			            return 1;
			        }
			        if (a.text < b.text) {
			            return -1;
			        }
			        return 0;
			    });
			}
		});
	}

	$(".btn-select-all").click(function(){
		var name = $(this).data('name');
    	$('select[name="'+name+'[]"] option').prop('selected',true);
    	$('select[name="'+name+'[]"]').trigger('change');
	});

	slugJS = function ()
	{
		$(".slug-js").on('keyup change keypress',function(){
			var val = $(".slug-js").val();
			$(".slug-js-convert").val(convertToSlug(convertVietnamese(val)));
		});
	}

	htmlRent = function (number)
	{
			xhtml = '';
            	xhtml += '<tr data-rent="'+number+'">';
            		xhtml += '<td>';
            			xhtml += '<i class="icon-more handle"></i>';
            		xhtml += '</td>';
            		xhtml += '<td>';
            			xhtml += '<div class="cntr"><input checked="checked" class="cbx-input isShow" id="'+number+'" name="show['+number+']" type="checkbox"><label class="cbx" for="'+number+'"></label><label class="lbl" for="'+number+'"></label></div>'
            		xhtml += '</td>';
            		xhtml += '<td>';
            			xhtml += '<input type="text" name="hours['+number+'][]" class="form-control" placeholder="giờ">';
            		xhtml += '</td>';
            		xhtml += '<td>';
            			xhtml += '<input type="text" name="price['+number+'][]" class="form-control" placeholder="tiền">';
            		xhtml += '</td>';
            		xhtml += '<td>';
            			xhtml += '<button type="button" data-rent="'+number+'" class="btn btn-secondary ml-3 rent-delete"><small>Delete</small></button>';
            		xhtml += '</td>';
            	xhtml += '</tr>';
	    
        return xhtml;
	}

	html = function (number,add = false)
	{
			xhtml = '';
			if(add == true)
			{
				xhtml += '<button type="button" class="btn btn-secondary btn-attribute-add my-3 attribute-hide"><small>Add Option</small></button>';
				xhtml += '<table class="table table-responsive attribute-hide">';
				xhtml += '<thead>';
	                xhtml += '<tr>';
	                    xhtml += '<th></th>';
	                    xhtml += '<th>Is Default</th>';
	                    xhtml += '<th>Admin</th>';
	                    xhtml += '<th>Default Store View</th>';
	                    xhtml +='<th></th>';
	                xhtml += '</tr>';
	            xhtml += '</thead>';
	            xhtml += '<tbody class="draggable attribute-tbody">';
			}
            	xhtml += '<tr data-attribute="'+number+'">';
            		xhtml += '<td>';
            			xhtml += '<i class="icon-more handle"></i>';
            		xhtml += '</td>';
            		xhtml += '<td>';
            			xhtml += '<div class="cntr"><input class="cbx-input isDefault" id="'+number+'" name="default['+number+']" type="checkbox"><label class="cbx" for="'+number+'"></label><label class="lbl" for="'+number+'"></label></div>'
            		xhtml += '</td>';
            		xhtml += '<td>';
            			xhtml += '<input type="text" name="option['+number+'][]" class="form-control" placeholder="option">';
            		xhtml += '</td>';
            		xhtml += '<td>';
            			xhtml += '<input type="text" name="value['+number+'][]" class="form-control" placeholder="value">';
            		xhtml += '</td>';
            		xhtml += '<td>';
            			xhtml += '<button type="button" data-attribute="'+number+'" class="btn btn-secondary ml-3 attribute-delete"><small>Delete</small></button>';
            		xhtml += '</td>';
            	xhtml += '</tr>';
	        if(add == true)
	        {
	            xhtml += '</tbody>';
	            xhtml += '</table>';
	        }
	    
        return xhtml;
	}

		

	rentType = function()
	{
		
	}

	clickSidebarToggle = function()
	{
		$(".sidebar-toggle a").click(function(){
			$("body").toggleClass("sidebar-collapse");
		});
	}

	autoMenuChildItem = function ()
	{
		if($(".menu-child-item").hasClass('active')){
			$(".menu-child-item.active").parent().parent().addClass('active');
		}
	}

	clickMenuChild = function ()
	{
		$(".menu-item").on('click',function(){
			if($(this).hasClass('active')){
				$(this).find('.menu-child').slideToggle();
				$(".menu-item").not(this).removeClass("show").find('.menu-child').hide();
			}else{
				$(this).toggleClass('show').find('.menu-child').slideToggle();
				$(".menu-item").not(this).removeClass("show").find('.menu-child').hide();
			}
		});
	}


	autoCouponCode = function () 
	{
		$(".coupon-code").hide();

		$(".txtCouponCode").change(function(){
			checkCouponCode();
		});

		$(".txtCouponCode").keyup(function(){
			checkCouponCode();
		});
	}

	autoBox = function () 
	{
		if($(".box-body").hasClass("d-n")){
			$(".box-body.d-n").prev(".box-heading").find(".btn-close").addClass("inverseIcon");
		}
		if($(".box-form-content").hasClass("d-n")){
			$(".box-form-content.d-n").prev(".box-form-heading").find(".box-close").addClass("inverseIcon");
		}
	}


	clickBoxFormHeading = function()
	{
		$(".box-form-heading").click(function(e){
			$(this).next().slideToggle('fast');
			$(this).find('.box-close').toggleClass('inverseIcon');
		});
	}
	autoFormControlFile = function()
	{
		$('.form-control-file').change(function(){
			var file = $('.form-control-file')[0].files[0];
			var image_name = file.name;
			$(".file-name").val(image_name);
		});
	}
	

	clickBoxHeading = function ()
	{
		$(".box-heading").click(function(){
			$(this).find(".btn-close").toggleClass("inverseIcon").parent().next(".box-body").slideToggle('fast');
			// $(this).find(".btn-close").toggleClass("inverseIcon").parent().next(".box-body").slideToggle('slow', "easeOutQuart");
		});	
	}
});
jQuery(document).ready(function($) {
	var config = {
		  axis: "y",
		  cursor: "move",
		  handle: ".handle",
		  containment: ".attribute-tbody",
		};
		$('.draggable').sortable(config);

		if($('[data-attribute]').length > 0){
			var _number = Number($('[data-attribute]').last().attr('data-attribute'));
			number = ++_number;
		}else{
			var number = 0;
		}
		

		$(".attribute-delete").click(function(){
			attribute_id = $(this).attr('data-attribute');
			$('[data-attribute="'+attribute_id+'"]').remove();
		})
		$(".attribute-type").on('change',function(){
			var val = $(this).val();
			if(val == 'multiselect'){
				$(".attribute-hide").show();
				if($(".attribute-hide").length == 0)
				{
					$(".attribute-type-html").append(html(number,true));
					$('.draggable').sortable(config);
				}
				number++;
			}else if(val == 'select'){
				$('.isDefault').attr('checked',false);
				$(".attribute-hide").show();
				if($(".attribute-hide").length == 0)
				{
					$(".attribute-type-html").append(html(number,true));
					$('.draggable').sortable(config);
				}
				number++;
			}
			else{
				$(".attribute-hide").hide();
			}
		});
		$(".attribute-type-html").on('click','.attribute-delete',function(){
			attribute_id = $(this).attr('data-attribute');
			$('[data-attribute="'+attribute_id+'"]').remove();
		})
		$(".attribute-type-html").on('click','.btn-attribute-add',function(){
			$(".attribute-tbody").append(html(number));
			number++;
		});
		$(".attribute-type-html").on('click','.isDefault',function(){
			var val = $(".attribute-type").val();
			if(val == 'multiselect'){
				$(this).next('.isDefault').attr('checked',true);
			}else{
				$('.isDefault').not(this).attr('checked',false);
			}
		});
	// Ajax.js
	ajax_delete();
	// Functions.js
	checkCouponCode();
	pageLoad();
	dropzoneZL();
	// Window.js
	sidebarCollapse();
	// Action.js
	sizeContent();
	clickAddMenu();
	clickSidebarToggle();
	clickBoxFormHeading();
	autoMenuChildItem();
	clickMenuChild();
	autoCouponCode();
	autoBox();
	autoFormControlFile();
	clickBoxHeading();
	clickMedia();
	slugJS();
	rentType();
	selectJS();	

	var config2 = {
		  axis: "y",
		  cursor: "move",
		  handle: ".handle",
		  containment: ".rent-tbody"
		};
		$('.rent-tbody').sortable(config2);

		if($('[data-rent]').length > 0){
			var _number = Number($('[data-rent]').last().attr('data-rent'));
			number = ++_number;
		}else{
			var number = 0;
		}
		

		$(".rent-delete").click(function(){
			attribute_id = $(this).attr('data-rent');
			$('[data-rent="'+attribute_id+'"]').remove();
		})
		$(".rent-type-html").on('click','.rent-delete',function(){
			attribute_id = $(this).attr('data-rent');
			$('[data-rent="'+attribute_id+'"]').remove();
		})
		$(".rent-type-html").on('click','.btn-rent-add',function(){
			$(".rent-tbody").append(htmlRent(number));
			number++;
		});
		$(".rent-type-html").on('click','.isShow',function(){
			var val = $(".rent-type").val();
			$(this).next('.isShow').attr('checked',true);
		});

	
	
	var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON && output.val()) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
    if($("#nestable").length > 0){
    	$('#nestable').nestable({
	        group: 1,
	        collapseBtnHTML:''
	    })
	    .on('change', function(){
	    	updateOutput($('#nestable').data('output', $('#nestable-output')));
	    }); 
	    updateOutput($('#nestable').data('output', $('#nestable-output')));
	    $("#nestable").on('click','.show-item-details',function(){
	    	$(this).parent().toggleClass('active');
	    });
    }
    
    if($(".list-widget").length > 0){
		var widget = document.getElementById('widget');
		var sortable = Sortable.create(widget,{
			group: {
				name:'widget',
				pull:'clone'
			},
			sort:false,
			animation: 100,
			onStart: function () {
				$("#primary-sidebar,#top-sidebar,#footer-sidebar").css({'border':'3px dashed #cccccc'});
			},
			onEnd: function (e) {
				$("#primary-sidebar,#top-sidebar,#footer-sidebar").css({'border':'3px solid transparent'});
			}
		});

		var primary = document.getElementById('primary-sidebar');
		var top = document.getElementById('top-sidebar');
		var footer = document.getElementById('footer-sidebar');

		var sortable = Sortable.create(primary,{
			group: {
				name:'primary-sidebar',
				put:['widget']

			},
			animation: 100,
			onStart: function () {

			},
			onEnd: function () {

			},
			onClone: function () {
				alert(123);
			},
			onFilter: function () {
				alert(123);
			},
			onSort: function (e) {
				console.log(e);
				console.log(this);
			},
		});

		var sortable = Sortable.create(top,{
			group: {
				name:'top-sidebar',
				put:['widget']

			},
			animation: 100,
			onStart: function () {
		
			},
			onEnd: function () {
			
			}
		});

		var sortable = Sortable.create(footer,{
			group: {
				name:'footer-sidebar',
				put:['widget']

			},
			animation: 100,
			onStart: function () {
	
			},
			onEnd: function () {
			
			}
		});

		$(".list-widget-use").on('click','.widget-handle',function(){
			$(this).find("i").toggleClass("inverseIcon");
			$(this).next(".widget-content").slideToggle();
		});
	}

	

	

/*	new Morris.Bar({
	  // ID of the element in which to draw the chart.
	  element: 'game',
	  // Chart data records -- each entry in this array corresponds to a point on
	  // the chart.
	  data: [
	    { day: '2', value: 20 },
	    { day: '3', value: 10 },
	    { day: '4', value: 5 },
	    { day: '5', value: 5 },
	    { day: '6', value: 20 },
	    { day: '7', value: 5 },
	    { day: 'CN', value: 5 }
	  ],
	  // The name of the data record attribute that contains x-values.
	  xkey: 'day',
	  // A list of names of data record attributes that contain y-values.
	  ykeys: ['value'],

	  barColors: ["#51d2b7"],
	  // Labels for the ykeys -- will be displayed when you hover over the
	  // chart.
	  labels: ['Số tài khoản'],
	});*/
	
	
	
	
	// $('.time-picker').timepicker({
	// 	'step': '15'
	// });
	
});