function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

function strip_tags(text)
{
  if(isNumber(text))
  {
    return text;
  }else{
    return text.replace(/(<([^>]+)>)/ig,"");
    // return text;
  }
  
}


$("#dexuatgia").click(function(){
  var money = Number($("#hours_3").val());
  if(money == '')
  {
    alert('Bạn phải điền giá tiền vào khung 3 giờ !');
  }
  else
  {
    $("#hours_8").val(money * 2);
    $("#hours_20").val(money * 4);
    $("#hours_36").val(money * 6);
    $("#hours_72").val(money * 10);
  }
  
});

var is_ready = 1;
var current_game = 'home';
var page = 1;
var customer_id = $(".filter-rent-list").data("id");
var shop_id = $("#shop_info").data("shop-id");
var status_search = 0;

var htmlAjaxRent = function(value)
{
  var xhtml = '';
  xhtml += '<div class="column">';
    xhtml += '<div class="ui special cards">';
      xhtml += '<div class="card">';
        xhtml += '<div class="blurring dimmable image">';
          xhtml += '<div class="ui dimmer">';
            xhtml += '<div class="content">';
              xhtml += '<div class="center">';
                xhtml += '<p><a href="'+value.url_shop+'">'+value.shop_name+'</a></p>';
                xhtml += '<a href="'+value.url_facebook+'" target="_blank"><i class="icon facebook"></i></a>';
              xhtml += '</div>';
            xhtml += '</div>';
          xhtml += '</div>';
          xhtml += '<img src="'+value.img+'" class="img-game">';
        xhtml += '</div>';
        xhtml += '<div class="content">';
          xhtml += '<select class="ui dropdown fluid">';
            if(value.rent_time[3] == undefined)
            {
              xhtml += '<option value="3" disabled>0đ/3h</option>';
            }else{
              xhtml += '<option value="3">'+$.number(value.rent_time[3],0,'',',')+'đ/3h</option>';
            }

            if(value.rent_time[8] == undefined)
            {
              xhtml += '<option value="8" disabled>0đ/8h</option>';
            }else{
              xhtml += '<option value="8">'+$.number(value.rent_time[8],0,'',',')+'đ/8h</option>';
            }

            if(value.rent_time[20] == undefined)
            {
              xhtml += '<option value="20" disabled>0đ/20h</option>';
            }else{
              xhtml += '<option value="20">'+$.number(value.rent_time[20],0,'',',')+'đ/20h</option>';
            }

            if(value.rent_time[36] == undefined)
            {
              xhtml += '<option value="36" disabled>0đ/36h</option>';
            }else{
              xhtml += '<option value="36">'+$.number(value.rent_time[36],0,'',',')+'đ/36h</option>';
            }
            
            if(value.rent_time[72] == undefined)
            {
              xhtml += '<option value="72" disabled>0đ/72h</option>';
            }else{
              xhtml += '<option value="72">'+$.number(value.rent_time[72],0,'',',')+'đ/72h</option>';
            }
            
          xhtml += '</select>';
          xhtml += '<input style="display: none;" class="money_3" value="'+(value.rent_time[3] != undefined ? value.rent_time[3] : 0)+'">';
            xhtml += '<input style="display: none;" class="money_8" value="'+(value.rent_time[8] != undefined ? value.rent_time[8] : 0)+'">';
            xhtml += '<input style="display: none;" class="money_20" value="'+(value.rent_time[20] != undefined ? value.rent_time[20] : 0)+'">';
            xhtml += '<input style="display: none;" class="money_36" value="'+(value.rent_time[36] != undefined ? value.rent_time[36] : 0)+'">';
            xhtml += '<input style="display: none;" class="money_72" value="'+(value.rent_time[72] != undefined ? value.rent_time[72] : 0)+'">';
        xhtml += '</div>';
        xhtml += '<div class="extra content">';
          xhtml += '<div class="ui buttons fluid">';
            xhtml += '<button class="ui button black btn-rent" data-id="'+value.id+'">Thuê Ngay</button>';
            xhtml += '<div class="or" data-text="&"></div>';
            xhtml += '<button class="ui button" data-tooltip="'+value.description+'"><i class="info icon"></i></button>';
          xhtml += '</div>';
        xhtml += '</div>';
      xhtml += '</div>';
    xhtml += '</div>';
  xhtml += '</div>';
  return xhtml;
}


htmlReportRent = function(id,title = 'BÁO LỖI TÀI KHOẢN')
{
  var xhtml ='';
  xhtml += '<div id="popupR">';
  xhtml += '<h4 class="text-center" >'+title+'</h4>';
  xhtml += '<div class="hr"></div>';
  xhtml += '<h5 class="text-center"><strong>LỜI NHẮN</strong></h5>';
  xhtml += '<div class="ui input fluid mb-15">';
    xhtml +='<input type="text" class="br-0" name="msg_report_'+id+'">';
  xhtml +='</div>';
  xhtml += '<div class="text-center w-100">';
    xhtml += '<button class="ui button small black mb-15 btn-send-report" data-id="'+id+'">GỬI</button>';
  xhtml += '</div>';
  xhtml += '</div>';
  return xhtml;
}


var htmlAjaxRent2 = function(value)
{
  var xhtml = '';
  xhtml += '<div class="column">';
    xhtml += '<div class="ui special cards">';
      xhtml += '<div class="card">';
        xhtml += '<div class="blurring dimmable image">';
          xhtml += '<div class="ui dimmer">';
            xhtml += '<div class="content">';
              xhtml += '<div class="center">';
                xhtml += '<p><a href="'+value.url_shop+'">'+value.shop_name+'</a></p>';
                xhtml += '<a href="'+value.url_facebook+'" target="_blank"><i class="icon facebook"></i></a>';
              xhtml += '</div>';
            xhtml += '</div>';
          xhtml += '</div>';
          xhtml += '<img src="'+value.img+'" class="img-game">';
        xhtml += '</div>';
        xhtml += '<div class="content">';
          xhtml += '<select class="ui dropdown fluid">';
            if(value.rent_time[3] == undefined)
            {
              xhtml += '<option value="3" disabled>0đ/3h</option>';
            }else{
              xhtml += '<option value="3">'+$.number(value.rent_time[3],0,'',',')+'đ/3h</option>';
            }

            if(value.rent_time[8] == undefined)
            {
              xhtml += '<option value="8" disabled>0đ/8h</option>';
            }else{
              xhtml += '<option value="8">'+$.number(value.rent_time[8],0,'',',')+'đ/8h</option>';
            }

            if(value.rent_time[20] == undefined)
            {
              xhtml += '<option value="20" disabled>0đ/20h</option>';
            }else{
              xhtml += '<option value="20">'+$.number(value.rent_time[20],0,'',',')+'đ/20h</option>';
            }

            if(value.rent_time[36] == undefined)
            {
              xhtml += '<option value="36" disabled>0đ/36h</option>';
            }else{
              xhtml += '<option value="36">'+$.number(value.rent_time[36],0,'',',')+'đ/36h</option>';
            }
            
            if(value.rent_time[72] == undefined)
            {
              xhtml += '<option value="72" disabled>0đ/72h</option>';
            }else{
              xhtml += '<option value="72">'+$.number(value.rent_time[72],0,'',',')+'đ/72h</option>';
            }
            
          xhtml += '</select>';
          xhtml += '<input style="display: none;" class="money_3" value="'+(value.rent_time[3] != undefined ? value.rent_time[3] : 0)+'">';
            xhtml += '<input style="display: none;" class="money_8" value="'+(value.rent_time[8] != undefined ? value.rent_time[8] : 0)+'">';
            xhtml += '<input style="display: none;" class="money_20" value="'+(value.rent_time[20] != undefined ? value.rent_time[20] : 0)+'">';
            xhtml += '<input style="display: none;" class="money_36" value="'+(value.rent_time[36] != undefined ? value.rent_time[36] : 0)+'">';
            xhtml += '<input style="display: none;" class="money_72" value="'+(value.rent_time[72] != undefined ? value.rent_time[72] : 0)+'">';
        xhtml += '</div>';
        xhtml += '<div class="extra content">';
        xhtml += '<button class="btn-rent" data-id="'+value.id+'" style="display:none !important;"></button>';
          xhtml += '<div class="ui buttons fluid">';
            xhtml += '<button class="ui button black btn-time-format" data-id="'+value.id+'" data-time="'+value.time_end+'">'+value.time_end+'</button>';
            // xhtml += '<p>'+value.time_end+'</p>';
          xhtml += '</div>';
        xhtml += '</div>';
      xhtml += '</div>';
    xhtml += '</div>';
  xhtml += '</div>';
  return xhtml;
}

var htmlRentList = function(value){
  var xhtml = '';
  xhtml += '<tr>';
        xhtml += '<td>'+value.username+'</td>';
        xhtml += '<td>'+value.rent_times+'</td>';
        xhtml += '<td>'+$.number(value.sum_money,0,'',',')+' VNĐ</td>';
        xhtml += '<td>'+value.game+'</td>';
        if(value.khach_dang_thue != undefined)
        {
        xhtml += '<td>'+value.khach_dang_thue+'</td>';
        }else{
        xhtml += '<td></td>';  
        }
        xhtml += '<td>';
        if(value.status == 1){
        xhtml += '<span style="color:#00b5ad;">Sẵn sàng</span>';
        }else if(value.status == 2){
          if(value.vuot_thoi_gian == false)
          {
            xhtml += '<span style="color:#db2828;">Chờ đổi pass</span>';
          }else{
            xhtml += '<span style="color:#fbbd08;">Đang được thuê</span>';
          }
        }else if(value.status == 3){
          xhtml += '<span style="color:#db2828;">Ngưng hoạt động</span>';
        }
        xhtml += '</td>';
        xhtml += '<td class="ui center aligned"><a href="'+value.id+'" style="color:black;"><i class="signup icon m-0"></i></a></td>';
      xhtml += '</tr>';
      return xhtml;
}

/*$(".search-rent").keypress(function (e) {
 var key = e.which;
 var val = $(this).val();
 if(key == 13)  // the enter key code
  {
    $.ajax({
      type: 'POST',
      url: "http://localhost/zflex/ajax/load-rent-list-search",
      beforeSend: function() {
          $(".table-rent-list").addClass("active");
      },
      data: { search: val,status_search:status_search},
      success: function(data)
      {
        var result = data.result;
        $(".tbody-rent-list > tr").remove();
        $.each(result, function(i, value) {
          $(".tbody-rent-list").append(htmlRentList(value));
        });
      },
      complete: function() {
        $(".table-rent-list").removeClass("active");
      },
      dataType: 'json'
    });
  }
});*/


/*$(".reload-rent").click(function(){
  var id = $(this).data('id');
  var _this = this;
  var new_password = $(".input_pw_"+id).val();
  $.ajax({
    type: 'POST',
    url: "http://localhost/zflex/ajax/load-handing-rented",
    beforeSend: function() {
        $(".table-rent-list").addClass("active");
    },
    data:{id: id,password: new_password,status: 1},
    success: function(data)
    {
      var result = data.result;
      console.log(result);
      $(_this).parents("tr").fadeOut('fast');
    },
    complete: function() {
      $(".table-rent-list").removeClass("active");
    },
    dataType: 'json'
  });
});

$(".reload-rent-report").click(function(){
  var id = $(this).data('id');
  var _this = this;
  $.ajax({
    type: 'POST',
    url: "http://localhost/zflex/ajax/load-show-report-rent",
    beforeSend: function() {
        $(".table-report-list").addClass("active");
    },
    data:{id: id},
    success: function(data)
    {
      var result = data.result;
      console.log(result);
      if(result == true){
        $(_this).parents("tr").fadeOut('fast');
      }
      
    },
    complete: function() {
      $(".table-report-list").removeClass("active");
    },
    dataType: 'json'
  });
});

$(".reload-rent-block").click(function(){
  var id = $(this).data('id');
  var _this = this;
  var new_password = $(".input_pw_"+id).val();
  $.ajax({
    type: 'POST',
    url: "http://localhost/zflex/ajax/load-handing-rented",
    beforeSend: function() {
        $(".table-rent-list").addClass("active");
    },
    data:{id: id,password: new_password,status: 3},
    success: function(data)
    {
      var result = data.result;
      console.log(result);
      $(_this).parents("tr").fadeOut('fast');
    },
    complete: function() {
      $(".table-rent-list").removeClass("active");
    },
    dataType: 'json'
  });
});*/

/*$(".filter-rent-list .btn-filter-2").click(function(){
  $(".filter-rent-list .btn-filter-2").removeClass("active");
  $(this).addClass("active");
  status_search = $(this).data('status');
  $.ajax({
    type: 'POST',
    url: "http://localhost/zflex/ajax/load-rent-list",
    beforeSend: function() {
        $(".table-rent-list").addClass("active");
    },
    data: { status: status_search},
    success: function(data)
    {
      var result = data.result;
      console.log(result);
      $(".tbody-rent-list > tr").remove();
      $.each(result, function(i, value) {
        $(".tbody-rent-list").append(htmlRentList(value));
      });
    },
    complete: function() {
      $(".table-rent-list").removeClass("active");
    },
    dataType: 'json'
  });
});*/

$(".filter-shop .btn-filter").click(function(){
  location.href = $(this).attr('href');
});

$(".btn-report-rent").click(function(){
  
  var id = $(this).data("id");
  $("#popupR").remove();
  $("#popupInfo").html(htmlReportRent(id));
  $("#popupBg").show();
  move_center("#popupCenter");
});

$("#toggleSidebar").click(function(){
  $('.ui.modal')
  .modal('show')
;
});

// $(".filter-left .btn-filter-rent").click(function(){
//   page = 1;
//   $(".filter-left .btn-filter-rent").removeClass("active");
//   $(this).addClass("active");
//   var game = $(this).data('game');
//   current_game = game;
//   $.ajax({
//     type: 'POST',
//     url: "http://localhost/zflex/ajax/load-rent",
//     beforeSend: function() {
//         $(".loader-rent").addClass("active");
//     },
//     data: { game: game,ready : is_ready,page:page,customer_id: customer_id},
//     success: function(data)
//     {
//       var result = data.result;
//       console.log(result);
//       $("#count_sansang").text(data.count.rent_sansang);
//       $("#count_dathue").text(data.count.rent_dathue);
//       $(".div-rent > div:not(.loader-rent)").remove();
//       if(is_ready == 1)
//       {
//         $.each(result, function(i, value) {
//           $(".div-rent").append(htmlAjaxRent(value));
//         });
//       }else{
//         $.each(result, function(i, value) {
//           $(".div-rent").append(htmlAjaxRent2(value));
//         });
//       }
//     },
//     complete: function() {
//         $(".loader-rent").removeClass("active");
//       $('.special.cards .image').dimmer({
//       on: 'hover'
//       });
//       $('.ui.dropdown').dropdown();
//       if(is_ready == 2)
//       {
//         rent_time_format();
//       }
//     },
//     dataType: 'json'
//   });
// });

/*$(".btn-more").click(function(){
  // numer_page = parseInt($(this).data('pagination'));
  page = page + 1;
  // alert(page);

    $.ajax({
      type: 'POST',
      url: "http://localhost/zflex/ajax/load-rent",
      beforeSend: function() {
          $(".loader-rent").addClass("active");
      },
      data: { game: current_game,ready : is_ready,page:page,customer_id: customer_id},
      success: function(data)
      {
        var flag = false;
        var result = data.result;
        console.log(result);
        if(result.length == 0)
        {
          flag = true;
        }
        
        if(is_ready == 1)
        {
          $.each(result, function(i, value) {
          if($(".btn-rent[data-id="+value.id+"]").length == 1)
          {
            flag = true;
          }else{
            $(".div-rent").append(htmlAjaxRent(value));
          }
        });
        }else{
          $.each(result, function(i, value) {
          if($(".btn-rent[data-id="+value.id+"]").length == 1)
          {
            flag = true;
          }else{
            $(".div-rent").append(htmlAjaxRent2(value));
          }
        });
        }
        if(flag == true)
        {
          swal("Thông báo !", "Đã load hết tài khoản !", "warning");
        }
      },
      complete: function() {
        $(".loader-rent").removeClass("active");
        $('.special.cards .image').dimmer({
        on: 'hover'
        });
        $('.ui.dropdown').dropdown();
        if(is_ready == 2)
        {
          rent_time_format();
        }
      },
      dataType: 'json'
    });
});*/

/*$(".filter-right .btn-filter").click(function(){
  page = 1;
  $(".filter-right .btn-filter").removeClass("active");
  $(this).addClass("active");
  var ready = $(this).data('ready');
  is_ready = ready;
  $.ajax({
    type: 'POST',
    url: "http://localhost/zflex/ajax/load-rent",
    beforeSend: function() {
        $(".loader-rent").addClass("active");
    },
    data: { game: current_game,ready : ready,page:page,customer_id : customer_id},
    success: function(data)
    {
      var result = data.result;
      $("#count_sansang").text(data.count.rent_sansang);
      $("#count_dathue").text(data.count.rent_dathue);
      $(".div-rent > div:not(.loader-rent)").remove();
      if(is_ready == 1)
      {
        $.each(result, function(i, value) {
          $(".div-rent").append(htmlAjaxRent(value));
        });
      }else{
        $.each(result, function(i, value) {
          $(".div-rent").append(htmlAjaxRent2(value))
        });
      }
    },
    complete: function() {
      $(".loader-rent").removeClass("active");
      $('.special.cards .image').dimmer({
      on: 'hover'
      });
      $('.ui.dropdown').dropdown();
      if(is_ready == 2)
      {
        rent_time_format();
      }
      
    },
    dataType: 'json'
  });
});*/

function rent_time_format()
{
  $(".div-rent > .column").each(function(){
    var time = $(this).find(".btn-time-format").data("time");
    // alert(time);
    var id = $(this).find(".btn-time-format").data('id');
    $(".btn-time-format[data-id="+id+"]"+"").countdown(time, function(event) {
      if(event.offset.seconds == 0 && event.offset.minutes == 0 && event.offset.hours == 0 && event.offset.days == 0)
      {
        $(this).html("ĐỔI PASS");
      }else{
        $(this).html(event.strftime('%D ngày %H:%M:%S'));
      }
    });;
  });
}



// function countdown_timer(_time,id){
//     // Set the date we're counting down to
//   var countDownDate = new Date(_time).getTime();

//   // Update the count down every 1 second
//   var x = setInterval(function() {

//     // Get todays date and time
//     var now = new Date().getTime();

//     // Find the distance between now an the count down date
//     var distance = countDownDate - now;

//     // Time calculations for days, hours, minutes and seconds
//     var days = (Math.floor(distance / (1000 * 60 * 60 * 24)) > 0) ? Math.floor(distance / (1000 * 60 * 60 * 24)) + ' ngày ' : '';
//     var hours = (Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)) > 0 ) ? Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)) + ' giờ ' : '';
//     var minutes = (Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)) > 0) ? Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)) + ' phút ' : '';
//     var seconds = (Math.floor((distance % (1000 * 60)) / 1000) > 0) ? Math.floor((distance % (1000 * 60)) / 1000) + ' giây ' : '';

//     // Display the result in the element with id="demo"
//     // document.getElementsByClassName(".time_fomat").innerHTML = ;
//     // ;
//     $("[data-id="+id+"]"+" .time_format").text(days + hours + minutes + seconds);
//     // If the count down is finished, write some text 
//     if (distance < 0) {
//       clearInterval(x);
//       $("[data-id="+id+"]"+" .time_format").text("HẾT HẠN");
//     }
//   }, 1000);
// }
// $('#aa').countdown('2020/10/10', function(event) {
//   $(this).html(event.strftime('%D days %H:%M:%S'));
// });

$("#table_history_rent > tbody > tr").each(function(){
  var id = $(this).data('id');
  var td = $(this).find('td').find('.time_format');
  var _class = td.attr('class');
  var _time = td.data('time');
  td.countdown(_time, function(event) {
    $(this).html(event.strftime('%D ngày %H:%M:%S'));
  });;
});

function move_center(div){

  //canh giữa chiều rộng
  window_width=$(window).width();
  obj_witdh=$(div).width();
  $(div).css('left',( window_width / 2 ) - ( obj_witdh / 2));

  //canh giữa chiều cao
  // window_height=$(window).height();
  // obj_height=$(div).height();
  // $(div).css('top',( window_height/ 2 ) - ( obj_height / 2));
 
 }﻿
$('#popupInfo').css('width',($(window).width() / 5));
move_center('#popupCenter');
// $("#popupBg").hide();
/*htmlSuccess = function(title = 'THUÊ TÀI KHOẢN',value = 'THUÊ THÀNH CÔNG',is_button = 1)
{
  var xhtml ='';
  xhtml += '<div id="popupR">';
  xhtml += '<h4 class="text-center" >'+title+'</h4>';
  xhtml += '<div class="hr"></div>';
  xhtml += '<h3 class="text-center"><strong>'+value+'</strong></h3>';
  if(is_button == 1)
  {
    xhtml += '<div class="text-center w-100">';
      xhtml += '<a href="http://localhost/zflex/index.html" class="ui button large black mb-15">VÀO LỊCH SỬ GIAO DỊCH</a>';
    xhtml += '</div>';
  }else if(is_button == 'login'){
    xhtml += '<div class="text-center w-100">';
      xhtml += '<a href="/zflex/fb_login.html" class="ui button large black mb-15">ĐĂNG NHẬP</a>';
    xhtml += '</div>';
  }else if(is_button == false)
  {
    xhtml += '<div class="text-center w-100">';
      xhtml += '<button id="close" class="ui button fluid black mb-15">ĐÓNG</button>';
    xhtml += '</div>';
  }
  xhtml += '</div>';
  return xhtml;
}

htmlError = function(data = 'THUÊ TÀI KHOẢN')
{
  var xhtml ='';
  xhtml += '<div id="popupR">';
  xhtml += '<h4 class="text-center" >'+data+'</h4>';
  xhtml += '<div class="hr"></div>';
  xhtml += '<h3 class="text-center"><strong>KHÔNG ĐỦ TIỀN</strong></h3>';
  xhtml += '<div class="text-center w-100">';
    xhtml += '<a href="http://localhost/zflex/card.html" class="ui button large black mb-15">NẠP TIỀN</a>';
  xhtml += '</div>';
  xhtml += '</div>';
  return xhtml;
}*/

var htmlRent = function(data)
{
  var xhtml = '';
  xhtml += '<div id="popupR">';
  xhtml += '<h4 class="text-center" >THUÊ TÀI KHOẢN</h4>';
    xhtml += '<div class="hr"></div>';
    xhtml += '<div class="hr">';
      xhtml += '<table>';
        xhtml += '<tbody><tr>';
            xhtml += '<td style="width: 40%;">Game:</td>';
            xhtml += '<td>'+data.game+'</td>';
        xhtml += '</tr>';
        xhtml += '<tr>';
            xhtml += '<td>Từ shop:</td>';
            xhtml += '<td><a target="_blank" href="'+data.url_shop+'">'+data.shop+'</a></td>';
        xhtml += '</tr>';
        xhtml += '<tr>';
            xhtml += '<td>Thời gian thuê:</td>';
            xhtml += '<td>'+data.time+' giờ</td>';
        xhtml += '</tr>';
        xhtml += '<tr>';
            xhtml += '<td>Chi phí:</td>';
            xhtml += '<td><span>'+data.price+'đ</span></td>';
        xhtml += '</tr>';
    xhtml += '</tbody></table>';
    xhtml += '</div>';
    xhtml += '<div class="hr">';
      xhtml += '<img src="'+data.img+'" width="100%">';
    xhtml += '</div>';
    xhtml += '<div class="mt-15" style="display: flex;justify-content: space-between;align-items: center">';
      xhtml += '<button class="ui button small" id="close">Đóng</button>';
      xhtml += '<button class="ui button small black" id="accept-rent" onclick="rent_account('+data.id+','+data.time+')">Thuê</button>';
    xhtml += '</div>';
    xhtml += '</div>';
    return xhtml;
}

var htmlLoad = function()
{
  var xhtml = '';
  xhtml += '<div id="popupR">';
  xhtml += '<h4 class="text-center" >THUÊ TÀI KHOẢN</h4>';
          xhtml += '<div class="hr"></div>';
          xhtml += '<img src="http://localhost/zflex/public/blackandwhite/img/Blocks.gif" width="100%">';
  xhtml += '</div>';
  return xhtml;
}

var htmlGiaHan = function(data)
{
  var xhtml = '';
  xhtml += '<div id="popupR">';
  xhtml += '<h4 class="text-center" >GIA HẠN TÀI KHOẢN</h4>';
    xhtml += '<div class="hr"></div>';
    xhtml += '<div class="hr">';
      xhtml += '<table width="100%">';
        xhtml += '<tbody><tr>';
            xhtml += '<td style="width: 40%;">Tài khoản:</td>';
            xhtml += '<td>'+data.username+'</td>';
        xhtml += '</tr>';
        xhtml += '<tr>';
            xhtml += '<td>Từ shop:</td>';
            xhtml += '<td><a target="_blank" href="'+data.url_shop+'">'+data.shop+'</a></td>';
        xhtml += '</tr>';
        xhtml += '<tr>';
            xhtml += '<td>Gia hạn:</td>';
            xhtml += '<td><select id="sl_rent_time">';
            $.each(data.value_options, function(i, value) {
            xhtml += '<option value="'+i+'">'+value+'đ/'+i+'h</option>';
            });
            xhtml += '</select></td>';
        xhtml += '</tr>';
    xhtml += '</tbody></table>';
    xhtml += '</div>';
    xhtml += '<div class="hr">';
      xhtml += '<img src="'+data.img+'" width="100%">';
    xhtml += '</div>';
    xhtml += '<div class="mt-15" style="display: flex;justify-content: space-between;align-items: center">';
      xhtml += '<button class="ui button small" id="close">Đóng</button>';
      xhtml += '<button class="ui button small black" id="btn-giahan" data-id="'+data.id+'">Thuê</button>';
    xhtml += '</div>';
    xhtml += '</div>';
    return xhtml;
}

var htmlReport = function(data)
{
  var xhtml = '';
  xhtml += '<div id="popupR">';
  xhtml += '<h4 class="text-center" >TỐ CÁO SHOP</h4>';
    xhtml += '<div class="hr"></div>';
      xhtml += '<div class="ui input fluid mt-15">';
        xhtml += '<input type="text" id="message-report" placeholder="Lý do">';
      xhtml += '</div>';
    xhtml += '</div>';
    xhtml += '<div class="mt-15" style="display: flex;justify-content: space-between;align-items: center">';
      xhtml += '<button class="ui button small" id="close">Đóng</button>';
      xhtml += '<button class="ui button small black" id="btn-report-shop">Gửi</button>';
    xhtml += '</div>';
    xhtml += '</div>';
    return xhtml;
}

$('.rating')
  .rating({
    initialRating: 5,
    maxRating: 5
  })
;


/*$("#popupInfo").on('click','#btn-giahan',function(){
  var id = $(this).data('id');
  var time = $("#sl_rent_time").val();
  $.ajax({
    type: 'POST',
    url: "http://localhost/zflex/ajax/load-handing-gia-han",
    beforeSend: function() {
        $("#popupInfo").html(htmlLoad());
    },
    data: { id: id,time: time},
    success: function(data)
    {
      var result = data.result;
      
      if(result == 0)
      {
        $("#popupInfo").html(htmlError('GIA HẠN TÀI KHOẢN'));
      }else if(result == 1){
        $("#popupInfo").html(htmlSuccess('GIA HẠN TÀI KHOẢN','GIA HẠN TÀI KHOẢN THÀNH CÔNG !'));
      }
      move_center('#popupCenter');
    },
    dataType: 'json'
  });
});*/

function htmlComment(value,rep_id){
  var xhtml = '';
  xhtml +='<div class="comment">';
        xhtml +='<a class="avatar">';
          xhtml +='<img src="//graph.facebook.com/'+value.fb_id+'/picture">';
        xhtml +='</a>';
        xhtml +='<div class="content" data-rep-id="'+value.id+'">';
          xhtml +='<a class="author">'+value.name+'</a>';
          xhtml +='<div class="metadata">';
            xhtml +='<span class="date">'+value.time+'</span>';
            if(rep_id == 0){
            xhtml +='| <span>'+value.rating+'<i class="icon star" style="color:#ffe623;text-shadow:0 -1px 0 #ddc507,-1px 0 0 #ddc507,0 1px 0 #ddc507,1px 0 0 #ddc507!important"></i></span>';
            }
          xhtml +='</div>';
          xhtml +='<div class="text">';
            xhtml +=value.content;
          xhtml +='</div>';
          xhtml +='<div class="actions">';
            xhtml +='<a class="reply reply-click" data-rep-id="'+value.id+'">Reply</a>';
          xhtml +='</div>';
          xhtml += '<form class="ui reply form form-reply" style="display:none;">';
            xhtml += '<div class="field">';
              xhtml += '<textarea data-rep-id="'+value.id+'"></textarea>';
            xhtml += '</div>';
            xhtml += '<div class="ui small submit icon button btn-send-comment" data-rep-id="'+value.id+'">TRẢ LỜI';
            xhtml += '</div>';
          xhtml += '</form>';
        xhtml +='</div>';
  xhtml +='</div>';
  return xhtml;
}

$(".form-reply").hide();

$("#list_comments").on('click','.reply-click',function(){
  $(this).parent(".actions").next(".form-reply").slideToggle();
});

/*$(".comments").on('click','.btn-send-comment',function(){
  var _this = this;
  var val = $(this).prev().find("textarea").val();
  var rep_id = $(this).data('rep-id');
  if(rep_id == 0){
    var rating = $(".rating").rating('get rating');
  }else{
    var rating = 0;
  }
  $.ajax({
    type: 'POST',
    url: "http://localhost/zflex/ajax/load-send-comment",
    beforeSend: function() {
        $(".loader-comment").addClass("active");
    },
    data: { rep_id: rep_id,val: val,shop_id: shop_id,rating: rating},
    success: function(data)
    {
      var result = data.result;
      if(result != false && result != 'cannot' && result != 'commented' && result != '' && result != 'not_login'){
        if(rep_id == 0){
          $("#list_comments").prepend(htmlComment(result,rep_id));
        }else{
          $(".content[data-rep-id="+rep_id+"]").append(htmlComment(result,rep_id));
        }
        if($("#empty_comments")[0]){
          $("#empty_comments").remove();
        }
        
      }else if(result == 'cannot'){
        alert("Bạn không thể đánh giá shop của mình");
      }else if(result == 'commented'){
        alert("Bạn chỉ được đánh giá shop một lần !");
      }else if(result == false){
        alert("Bạn chưa từng thuê acc ở shop này nên không thể đánh giá !");
      }else if(result == 'not_login'){
        alert("Bạn chưa đăng nhập !");
      }
    },
    dataType: 'json',
    complete: function(){
      $(".loader-comment").removeClass("active");
      $(_this).prev().find("textarea").val('');
    }
  });
});*/

/*$(".btn-giahan").click(function(){
  var id = $(this).data('id');
  $.ajax({
    type: 'POST',
    url: "http://localhost/zflex/ajax/load-gia-han",
    data: { id: id},
    success: function(data)
    {
      var result = data.result;
      
      if(result == 0)
      {
        $("#popupInfo").html(htmlError('GIA HẠN TÀI KHOẢN'));
      }else if(result == 'not'){
        $("#popupInfo").html(htmlSuccess('GIA HẠN TÀI KHOẢN','TÀI KHOẢN NÀY KHÔNG CHO PHÉP GIA HẠN !'));
      }
      else if(result == 'error')
      {
        $("#popupInfo").html(htmlSuccess('GIA HẠN TÀI KHOẢN','BẠN KHÔNG THỂ GIA HẠN TÀI KHOẢN NÀY !'));
      }
      else{
        value = {username: result.username,url_shop: result.url_shop,shop: result.shop,img: result.img,value_options: result.value_options,id: id};
        $("#popupInfo").html(htmlGiaHan(value));
        
      }
      move_center('#popupCenter');
    },
    dataType: 'json'
  });
  
  $("#popupBg").show();
});*/

/*$(".div-rent").on('click','.btn-rent',function(){
  var id = $(this).data('id');
  var value = $(this).parents('.extra.content').prev('.content').find('select').val();
  var price = $(this).parents('.extra.content').prev('.content').find('.money_'+value).val();
  var img = $(this).parents('.extra.content').prevAll('.image').find('img').attr('src');
  $.post("http://localhost/zflex/ajax/load-shop", { id: id})
  .done(function(data) {
    var result = data.result;
    var data = {id: id,game: result.game,time: value,price: price,shop: result.shop,url_shop: result.url_shop,img: img};
    $("#popupInfo").html(htmlRent(data));
    move_center('#popupCenter');
  });

  $("#popupBg").show();
});*/

$("#popupCenter").on('click','.icon.close',function(){
  $("#popupR").remove();
  $("#popupBg").hide();
});

function rent_account(id,time)
{
  $.ajax({
    type: 'POST',
    url: "http://localhost/zflex/ajax/load-rent-account",
    beforeSend: function() {
        $("#popupInfo").html(htmlLoad());
    },
    data: { id: id, time: time},
    success: function(data)
    {
      var result = data.result;
      if(result == 1)
      {
        $("#popupInfo").html(htmlSuccess());
      }else if(result == 0){
        $("#popupInfo").html(htmlError());
      }else if(result == 'not_login')
      {
        $("#popupInfo").html(htmlSuccess("LỖI !","BẠN CHƯA ĐĂNG NHẬP !","login"));
      }
    },
    dataType: 'json'
  });
}

$("#popupInfo").on('click','#close',function(){
  $("#popupR").remove();
  $("#popupBg").hide();
});


/*$("#popupInfo").on('click','.btn-send-report',function(){
  var id = $(this).data('id');
  var msg = $("[name=msg_report_"+id+"]").val();
  if(msg != ''){
    $.ajax({
      type: 'POST',
      url: "http://localhost/zflex/ajax/load-report-rent",
      beforeSend: function() {
          $("#popupInfo").html(htmlLoad());
      },
      data:{id: id,msg: msg},
      success: function(data)
      {
        var result = data.result;
        console.log(result);
        if(result == true){
          $("#popupInfo").html(htmlSuccess("THÔNG BÁO !","GỬI BÁO LỖI THÀNH CÔNG !"));
        }else if(result == 'error'){
          $("#popupInfo").html(htmlSuccess("LỖI !","BẠN KHÔNG THỂ BÁO LỖI TÀI KHOẢN NÀY !"));
        }
        
      },
      dataType: 'json'
    });
  }
});*/



function copyText(id) {
  var copyText = document.getElementById(id);
  copyText.select();
  document.execCommand("Copy");
  alert("Đã Copy !");
}

function copyText2(text) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val(text).select();
  document.execCommand("copy");
  $temp.remove();
  alert("Đã Copy !");
}
  
$('.special.cards .image').dimmer({
  on: 'hover'
});
$('.ui.checkbox')
  .checkbox()
;

$("#password").change(function(event){
  event.stopPropagation();
});


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.image-review')
                .attr('src', e.target.result)
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$("#form_add").validate({
    rules: {
        username: "required",
        hours: "required"
    },
    messages: {
        username: "* Vui lòng nhập tên tài khoản !",
        hours: "* Vui lòng nhập số giờ !"
    }
});

$("#form_withdraw").validate({
    rules: {
        money: {
          required: true,
          number: true,
          min: 200000
        }
    },
    messages: {
        money: {
          required: "Bạn chưa nhập số tiền cần rút !",
          number: "Số tiền phải là số !",
          min: "Chỉ có thể rút số tiền từ 200,000đ trở lên !"
        }
    }
});

$("#form_shop").validate({
    rules: {
        url_facebook: {
          required: true,
          url: true
        },
        phone_number: {
          required: true,
          minlength: 10,
          maxlength: 11,
          number: true
        },
        bank: {
          required:true
        },
        stk_bank: "required",
        ctk_bank: "required",
        banner: "required"
    },
    messages: {
        url_facebook: {
          required: "* Vui lòng nhập địa chỉ facebook !",
          url: "* Vui lòng nhập đúng định dạng địa chỉ !"
        },
        phone_number: {
          required: "* Vui lòng nhập số điện thoại !",
          minlength: "* Số điện thoại phải từ 10 -> 11 số !",
          maxlength: "* Số điện thoại phải từ 10 -> 11 số !",
          number: "* Số điện thoại không hợp lệ !"
        },
        bank: {
          required:"* Vui lòng chọn ngân hàng !"
        },
        stk_bank: "* Vui lòng nhập số tài khoản ngân hàng !",
        ctk_bank: "* Vui lòng nhập tên chủ tài khoản ngân hàng !",
        banner: "* Vui lòng chọn ảnh bìa !"
    }
});
$(".btn-buy").click(function(){
  var id = $(this).data('id');
  swal({
      title: "Tài khoản "+ id,
      text: "Bạn có chắc chắn muốn mua tài khoản này ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Mua",
      cancelButtonText: "Không",   
  },
    function(){
      $.ajax({
        type:"POST",
        url:"http://localhost/zflex/handing/buy",
        data:{id: id},
        dataType: 'json',
        success: function(data){
          var result = data.result;
          if(result == 1)
          {
            swal({
              title: "Mua thành công !",
              text: "Mua thành công , vào lịch sử giao dịch để xem thông tin về tài khoản !",
              type: "success"
            });
          }
          else if(result == 2)
          {
            swal({
              title: "Mua thất bại !",
              text: "Bạn không đủ tiền !",
              type: "error"
            });
          }
          else if(result == 4)
          {
            swal({
              title: "Có lỗi xảy ra !",
              text: "Bạn chưa đăng nhập !",
              type: "info"
            });
          }
        },
     });
  });
});


$("#open-report").click(function(){
  $("#popupInfo").html(htmlReport());
  $("#popupBg").show();
  move_center("#popupCenter");
});
/*
$("#popupInfo").on('click','#btn-report-shop',function(){
  var val = escapeHtml($("#message-report").val());
  if(val != '')
  {
    $.ajax({
      type: 'POST',
      url: "http://localhost/zflex/ajax/load-send-report",
      beforeSend: function() {
          $("#popupInfo").html(htmlLoad());
      },
      data: { shop_id: shop_id,val: val},
      success: function(data)
      {
        var result = data.result;
        
        if(result == 'not_login')
        {
          $("#popupInfo").html(htmlSuccess('TỐ CÁO SHOP','BẠN CHƯA ĐĂNG NHẬP !','login'));
        }else if(result == false){
          $("#popupInfo").html(htmlSuccess('TỐ CÁO SHOP','BẠN CHƯA TỪNG THUÊ ACC Ở SHOP NÀY NÊN KHÔNG THỂ TỐ CÁO !',false));
        }else if(result == true){
          $("#popupInfo").html(htmlSuccess('TỐ CÁO SHOP','TỐ CÁO THÀNH CÔNG ! LÝ DO : '+val,false));
        }else if(result == 'reported'){
          $("#popupInfo").html(htmlSuccess('TỐ CÁO SHOP','BẠN KHÔNG THỂ TỐ CÁO SHOP THÊM NỮA !',false));
        }else if(result == 'cannot'){
          $("#popupInfo").html(htmlSuccess('TỐ CÁO SHOP','BẠN KHÔNG THỂ TỐ CÁO CHÍNH SHOP CỦA MÌNH !',false));
        }
        move_center('#popupCenter');
      },
      dataType: 'json'
    });
  }else{
    alert("Bạn chưa nhập nội dung !");
  }
});*/

/*$("#card").ajaxForm({
    type:"POST",
    url : "http://localhost/zflex/card-handing",
    dataType: 'json',
    beforeSubmit : function() {
        $("#card").addClass('loading');
    },
    success: function(data){
      if(data.result.code == 0)
      {
        swal({ 
            title: "Thành công !",
            text: "Nạp thành công "+data.result.info_card+ " vào tài khoản !",
            type: "success" 
        },
          function(){
            window.location.href = '/zflex/index.html';
        });
      }else{
        swal({ 
            title: "Lỗi !",
            text: data.result.msg,
            type: "error" 
        },
          function(){
            // window.location.href = '/zflex/index.html';
        });
      }
      $("#card").removeClass('loading');
    }});*/

$('.ui.dropdown').dropdown();

$('[data-content]').popup();

// $(".ad-filter").hide();
$(".btn-filter-toggle").on('click',function(){
	$('.ad-filter')
	  .transition('scale')
	;
});

$('.carousel').flickity({
  // options
  wrapAround:true,
  cellAlign: 'left',
  contain: true
});

$('.menu .item').tab();

var content = [
  { title: 'Andorra',
  	description: 'Yasuo' },
  { title: 'United Arab Emirates',
  	description: 'Yasuo' },
  { title: 'Afghanistan',
  	description: 'Yasuo' },
  { title: 'Antigua' ,
  	description: 'Yasuo'},
  { title: 'Anguilla' ,
  	description: 'Yasuo'},
  { title: 'Albania',
  	description: 'Yasuo' },
  { title: 'Armenia' ,
  	description: 'Yasuo'},
  { title: 'Netherlands Antilles' ,
  	description: 'Yasuo'},
  { title: 'Angola' ,
  	description: 'Yasuo'},
  { title: 'Argentina' ,
  	description: 'Yasuo'},
  { title: 'American Samoa',
  	description: 'Yasuo' },
  { title: 'Austria' ,
  	description: 'Yasuo'},
  { title: 'Australia' ,
  	description: 'Yasuo'},
  { title: 'Aruba',
  	description: 'Yasuo' },
  { title: 'Aland Islands' ,
  	description: 'Yasuo'},
  { title: 'Azerbaijan',
  	description: 'Yasuo' },
  { title: 'Bosnia',
  	description: 'Yasuo' },
  { title: 'Barbados' ,
  	description: 'Yasuo'},
  { title: 'Bangladesh',
  	description: 'Yasuo' },
  { title: 'Belgium' ,
  	description: 'Yasuo'},
  { title: 'Burkina Faso',
  	description: 'Yasuo' },
  { title: 'Bulgaria' ,
  	description: 'Yasuo'},
  { title: 'Bahrain',
  	description: 'Yasuo' },
  { title: 'Burundi',
  	description: 'Yasuo' }
  // etc
];


$(".filter").on("click",".result",function(event){
	event.preventDefault();
});

var htmlListSkin = function(skin , champ){
	var xhtml = '';
	xhtml += '<div class="item">';
	    xhtml += '<i class="large trash outline middle aligned icon float-r"></i>';
	    xhtml += '<div class="content">';
	      	xhtml += '<span class="header">'+skin+'</span>';
	      	xhtml += '<div class="description">'+champ+'</div>';
	    xhtml += '</div>';
	xhtml += '</div>';
	return xhtml;
}

$(".ad-search").on("click",".trash",function(){
	$(this).parent('.item').remove();
});

$('.ui.search').search({
    source: content,
    maxResults:false,
    searchOnFocus:false,
    minCharacters:2,
    onSelect(result, response){
    	$("#search").val('');
    	$('.ad-search .content .header').text().indexOf(result['title']) > -1 ? null : $(".ad-search-input .list").append(htmlListSkin(result['title'],result['description']));
    	return false
    }
});