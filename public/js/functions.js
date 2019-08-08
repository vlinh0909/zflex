jQuery(document).ready(function($) {

	htmlDropzone = function(file)
	{
		xhtml = '';
		xhtml += '<li class="list-inline-item align-content-stretch">';
            xhtml += '<div class="media-item">';
                xhtml += '<div class="media-thumbnail">';
                    xhtml += '<img src="http://localhost/zflex/public/img/'+ file.name +'" data-image-size="' +file.size+ '" data-image-mime="'+ file.type +'" data-image-time="null" class="img-media">';
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
		$(".js-dropzone-upload").dropzone({ 
			url: "/zflex/admin/media/add",
			acceptedFiles:'image/*',
			success: function (file, response) {
			   this.removeFile(file);
			   $(".box-media").load(location.href + " .box-media>*");
			   alertify.success("Thêm thành công ảnh : '" +file.name + "'");
			}
		});
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