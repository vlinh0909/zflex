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
	// Gallery.js
	gallery_delete();
	// Ajax.js
	ajax_delete();
	ajax_product_add();
	ajax_product_edit();
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