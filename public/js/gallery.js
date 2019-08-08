jQuery(document).ready(function($) {
	gallery_delete = function()
	{
		$(".gallery-delete").on('click',function(){
			if($(".media-item.clicked").hasClass('media-item-modal'))
			{
				alertify.confirm("Bạn có chắc muốn xóa những hình ảnh đã chọn ?", function () {
				    var arr = [];
					$(".media-item-modal.clicked").each(function() {
						filename = $(this).find('img').attr('data-image-name');
						arr.push(filename);
					});
					$.ajax({
			            type:"POST",
			            url:"http://localhost/zflex/admin/media/loadDelete",
			            data:{data : arr},
			            dataType: 'json',
			            success: function(data){
		               		console.log(data.result);
		               		if(data.result == 'ok'){
		               			$(".box-media-"+id_media).load(location.href + " .box-media-"+id_media+">*");
		               			alertify.success("Xóa thành công !");
		               		}
		                },
		           });
				});
			}
			else if($(".media-item.clicked").hasClass('media-item-folder'))
			{
				alertify.confirm("Bạn có chắc muốn xóa thư mục đã chọn ?", function () {
					var name = $(".media-item-folder.clicked").data('name');
				    $.ajax({
			            type:"POST",
			            url:"http://localhost/zflex/admin/media/loadDeleteFolder",
			            data:{name : name},
			            dataType: 'json',
			            success: function(data){
		               		console.log(data.result);
		               		$(".box-media-"+id_media).load(location.href + " .box-media-"+id_media+">*");
		                },
		           });
				});
			}
			
		});
	}

	$(".gallery-create-folder").on('click',function(){
		var name = prompt("Tên thư mục mới : ", "");
		if (name == null || name == "") {
	    } else {
	        $.ajax({
		        type:"POST",
		        url:"http://localhost/zflex/admin/media/create-folder",
		        data:{name : name},
		        dataType: 'json',
		        success: function(data){
		       		console.log(data.result);
		       		if(data.result != '' || data.result != null){
		       			$(".box-media-"+id_media).load(location.href + " .box-media-"+id_media+">*");
		       		}
		        },
		   });
	    }
	});

	$(".gallery-rename").on('click',function(){
		var value = $(".media-item.clicked").data('name');
		var name = prompt("Tên thư mục mới : ", value);
		if (name == null || name == "") {
	    } else {
	        $.ajax({
		        type:"POST",
		        url:"http://localhost/zflex/admin/media/rename",
		        data:{old_name : value,new_name : name},
		        dataType: 'json',
		        success: function(data){
		       		console.log(data.result);
		       		if(data.result != '' || data.result != null){
		       			$(".box-media-"+id_media).load(location.href + " .box-media-"+id_media+">*");
		       		}
		        },
		   });
	    }
	});
})