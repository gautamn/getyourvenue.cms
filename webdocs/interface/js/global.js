var selectedCaItem = 0;
var dynaTabs = {
	activateTabs:function(c,tab,tabcontent){
	$('.'+tab).each(function(i){
		try{
		var obj = $(this).children('a');		
		obj.addClass('bg');
		obj.click(function(e){
			e.preventDefault();
			dynaTabs.loadTabContent(this,tab,tabcontent);
		});
		if(typeof c != 'undefined' && c == i) dynaTabs.loadTabContent(obj[0],tab,tabcontent) 
		}catch(e){ 
		
		}
	});
	$('#activateTabs').remove();
},
loadTabContent:function(obj,tab,tabcontent){
	var id_ = obj.id;
	$('.'+tabcontent).hide();
	$('.'+tab).removeClass('selected');
	$(obj).parent().addClass('selected');
	$('#'+id_+'_content').fadeIn(400);
}
}

var tooltip = {
	initialized:false, block:null, mode:'json', hoverTooltip: 0,
	init:function(){
	},
	initshow:function(){
		setTimeout(tooltip.show,500);
	},
	show:function(){


	},
	inithide:function(){


	},
	hide:function(){


	},
	gethtml:function(info){


	},
	getposition:function(e){
		alert(e.target);

	},
	setposition:function(e){


	}
}


var ajax_vars = [{"ajax":"1"}];
var headings = null;

function fclog(msg){
  //console.log(msg);
}

function json_merge(){
	var obj1 = arguments[0];
	for(a=1; a < arguments.length; a++){
		var obj2 = arguments[a];
		obj1 = merge_obj(obj1, obj2);
	}
	return obj1;
}
function merge_obj(obj1, obj2){
  if(!obj1 || typeof obj1 == 'undefined')
    return obj2;
	for(i in obj2){
		if(Object.prototype.toString.call(obj2[i]) === '[object Array]' || Object.prototype.toString.call(obj2[i]) === '[object Object]'){
				obj1[i] = merge_obj(obj1[i],obj2[i]);
		}else{
			obj1[i] = obj2[i];
		}
	}
	return obj1;
}

$(document).click(function (e){
var tar = e.target;
if(tar.tagName == 'A'){
  //console.log(tar.id);
  //console.log(tar.href);
}
});

$(document).ready(function (){
  $('.sorting').click(function(e){
    ajaxloader.load('clipListingBlock',[{"block_number":"1","sort_by":this.id}],true);
  });
 /* $('#keywordsearch').click(function(e){
    $('#keywordsearch').val("");
    $('#keywordsearch').removeClass('inputblank').addClass('inputfilled');
  });
  $('#keywordsearch').focusout(function(e){
    if($('#keywordsearch').val() == ''){
      $('#keywordsearch').val("Search..");
      $('#keywordsearch').addClass('inputblank').removeClass('inputfilled');
    }
  });*/
  //studio mouse hover tooltip
  $('ul.Tabs >li ').click(function(e){
    $('.content').hide();
    $('#'+this.id+'_content').show();
    $('.selected').removeClass('selected');
    $('#'+this.id).addClass('selected');
  });

    $('#studioslogo').hide();
    $('#studios').hover(function (){
      $('#studioslogo').show();
    },function (){
      $('#studioslogo').hide();
    });
    scrollFix();
});

//headeer stick on scroll...
var scrollFix = function(){
  headings = $('.scrollfix');
  $(headings).each(function(i){
      var obj = headings[i];
      var _t = $(obj).position().top - 50;
      var _w = $(obj).outerWidth(true);
      obj.setAttribute('data-inittop',_t);
      $(obj).width(_w);
   });
  $(document).bind('scroll',headerFix);
  $(window).resize(resezHandler);
  resezHandler();
  ////headeer stick on scroll... -- ends here
  //OuterMostWrapper
}

//handle the resize event on the page
var resezHandler = function(){
  try{
    var wh = $(window).height();
    var dh = parseFloat(document.documentElement.scrollHeight);
    if(wh > dh){
      var oh = $('#HeaderWrapper').height() + $('#OuterSubMenu').height() + $('#FooterBG').height();
      $('.OuterMostWrapper').height(wh-oh);
    }
  }catch(e){

  }
  headerFix();
}

var headerFix = function(){
      var st = $(window).scrollTop();
      $(headings).each(function(i){
        var obj = headings[i];
        var _t = obj.getAttribute('data-inittop');
        var cpos = $(obj).css('position');
        if(st > _t){
          $(obj).css({'position':'fixed','top':49,'z-index':900});
					$content = $(obj).children('.scrollfixContent').children('.scBody');
          if($content.length){
            var ch = $content.height;
            var offset = 80;
            var cct = $content.position().top;
            var visH = $(window).height() - cct - offset;
            if($content.css('overflow') != 'auto'){
              $content.parent().css({'overflow-x':'hidden'});
              $content.css({height:visH,'overflow':'auto'});
              //scroller($(obj).children('.scrollfixContent')[0]);
            }else{
              $content.css({height:visH});
            }
          }

        }else{
          $(obj).css({'position':'static','top':0});
        }
      });
    };

$(".Drop").click(function (e) {
	if($(".DropDown").css('display') != 'block'){
		$(".DropDown").slideDown(100);
		var tmr = setTimeout(function(){$(document).bind('click',hidePopup)},100);
	}
	e.preventDefault();
});


$('.SubMenu-ddItem,.SubMenu-channel').hover(
    function () {
		hidePopup();
        var target = $(this).children('ul');
        target.slideDown(400);
    },
    function () {
        var target = $(this).children('ul')
        target.hide();
    }
);
$('#myPage').hover(
    function () {
		hidePopup();
        var ctarget = $(this).children('div.settingdrop');
		var target = $(ctarget).children('ul');
        target.slideDown(400);
    },
    function () {
		 var ctarget = $(this).children('div.settingdrop');
        var target = $(ctarget).children('ul')
        target.hide();
    }
);
$('.SubMenu-studio').hover(
    function () {
		hidePopup();
        var target = $(this).children('div');
        target.fadeIn('slow');
    },
    function () {
        var target = $(this).children('div')
        target.fadeOut('slow');
    }
);

var hidePopup = function(e){
	if($(".DropDown").css('display') == 'block'){
		$(".DropDown").slideUp(100)
		$(document).unbind('click');
	}
}

function createCookie(name, value, hours){
  try{
  if (hours) {
	var date = new Date();
    date.setTime(date.getTime()+(hours*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  } else var expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
  }catch(e){
		errorLog(e.message,'createCookie');
  }
}

function readCookie(name){
	 try{
		var ca = document.cookie.split(';');
		var nameEQ = name + "=";

		for(var i=0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1, c.length); //delete spaces
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
		}
		return null;
   }catch(e){
		errorLog(e.message,'readCookie');
   }
}

//Reset the cookie by supplied name
function eraseCookie(name){
	try{
		createCookie(name, "", -1);
	}catch(e){
		errorLog(e.message,'eraseCookie');
	}
}

$('Div.DropDown >ul.languagelist >li >a').click(function(e){
  //createCookie("langid",this.rel);
  //createCookie("language",$(this).html());
	window.location.reload();
});


function sethourCookie(name,value,hour){
		if(hour){
			var date=new Date()
				date.setTime(date.getTime()+(hour*1*60*60*1000))
			var expires="; expires="+date.toGMTString()
		}else var expires=""
		document.cookie=name+"="+value+expires+"; path=/"
}
function f_scrollTop() {
	return f_filterResults (
		window.pageYOffset ? window.pageYOffset : 0,
		document.documentElement ? document.documentElement.scrollTop : 0,
		document.body ? document.body.scrollTop : 0
	);
}
function f_filterResults(n_win, n_docel, n_body) {
	var n_result = n_win ? n_win : 0;
	if (n_docel && (!n_result || (n_result > n_docel)))
		n_result = n_docel;
	return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
}


function findPosX(obj){
	var curleft = 0;
    if(obj.offsetParent){
        while(1){
			curleft += obj.offsetLeft;
			if(!obj.offsetParent)
				break;
			obj = obj.offsetParent;
        }
    }else if(obj.x){
        curleft += obj.x;
	}
    return curleft;
}

function findPosY(obj){
    var curtop = 0;
    if(obj.offsetParent){
        while(1){
			curtop += obj.offsetTop;
			if(!obj.offsetParent)
				break;
			obj = obj.offsetParent;
        }
    }else if(obj.y){
        curtop += obj.y;
	}
    return curtop;
}

function chop_smart( txt, sze , ln ) {
	//Break on Word
	var mstr = txt;
	if ( txt.length > 0 ) {
		if (txt.length > sze ){
			txt = txt.substring(0, sze );
			lastSpace = strrpos(txt, " " );
			if (lastSpace !== false )
				txt =txt.substring(0, lastSpace );
			}
	}

	//Break on line
	c = 0;final_str = '';
	count=txt.split("\n");
	if(count.length > ln){ //the choped string has more line breaks than it should have
		strarr = txt.split("\n");
		for(c = 0; c < ln; c++){
			if(c == ln -1){ //Now Check if the break is performed on just less than three words in the last line
				strarr[c].split(" ");
				if(strarr[c].split(" ").length > 3){
					final_str += "\n"+ strarr[c];
				}
			}else{
				final_str += "\n"+ strarr[c];
			}
		}
		txt = final_str;
	}
	if(mstr.length>txt.length) {
		return txt;
	}else{
		return txt;
	}
}

function strrpos (haystack, needle, offset) {
	var i = -1;
	if (offset) {
		i = (haystack + '').slice(offset).lastIndexOf(needle); // strrpos' offset indicates starting point of range till end, // while lastIndexOf's optional 2nd argument indicates ending point of range from the beginning
		if (i !== -1) {
			i += offset;
		}
	} else {
		i = (haystack + '').lastIndexOf(needle);
	}
	return i >= 0 ? i : false;
}

function errorLog(error,block){
	//callAjax(TMUrl+'common/ajax/errorLog.php',{"error":error,"block":block},'post');
}

 (function ($){
	   $.fn.serializeJSON = function (){
		   var json = {};
		   $.map($(this).serializeArray(), function (ele, i){
			   json[ele['name']] = ele['value'];
		   });
		   return json;
		};
   })(jQuery);

    var login = {
	init:function (type)
		 {
				if(typeof type == 'undefined' || type == '' || type == 'null'){
					//var url=TMUrl+'userlogin.php';
					//lightModal.load(url,false,true,390,590);
				}
				else
				{
					type = $.trim(type);
					switch (type)
					{
					   case 'RateClip':
						 ShowMessage(11);
						 break;
					}
				}
      }
   }

 //Remove the encoding
function stripslashes(str) {
  try{
  str = str.replace(/~%~/g,'>');
  str = str.replace(/~|~/g,'<');
  str=str.replace(/lqts/g,"'");
  str=str.replace(/quott/g,'"');
  str=str.replace(/\\/g,'');
  return str;
  }catch(e){
		errorLog(e.message,'stripslashes');
  }
}


validateEmail=function (email) {
	var at = email.lastIndexOf("@");
	// Make sure the at (@) sybmol exists and
	// it is not the first or last character
	if (at < 1 || (at + 1) === email.length)
		return false;
	// Make sure there aren't multiple periods together
	if (/(\.{2,})/.test(email))
		return false;
	// Break up the local and domain portions
	var local = email.substring(0, at);
	var domain = email.substring(at + 1);

	// Check lengths
	if (local.length < 1 || local.length > 64 || domain.length < 4 || domain.length > 255)
		return false;

	// Make sure local and domain don't start with or end with a period
	if (/(^\.|\.$)/.test(local) || /(^\.|\.$)/.test(domain))
		return false;

	// Check for quoted-string addresses
	// Since almost anything is allowed in a quoted-string address,
	// we're just going to let them go through
	if (!/^"(.+)"$/.test(local)) {
		// It's a dot-string address...check for valid characters
		if (!/^[-a-zA-Z0-9!#$%*\/?|^{}`~&'+=_\.]*$/.test(local))
			return false;
	}

	// Make sure domain contains only valid characters and at least one period
	if (!/^[-a-zA-Z0-9\.]*$/.test(domain) || domain.indexOf(".") === -1)
	return false;

	return true;
 }
function  submitpoll(){
	var data=$("input:radio[name=polloption]:checked").val();
	if(!(data)){
		$('#error').html('Please Select an option');
		$('#error').show();
		setTimeout("$('#error').hide().html('')",8000);
	}else{
	$('#error').hide().html('');
	$.post(JSWebURL+'services/poll.php',{data:data},function(data){
		$('#submit').hide();
		$('#pollresult').html(data);
		});

	}


	}
 function changeFriendsActivity(){
	ajaxloader.inprocess = false;
	ajaxloader.load('usersActivity','',true);
 }

function selectTab(fadein_tab_id, fadeout_tab_id){
	$('#'+fadeout_tab_id).removeClass('selected');
	$('#'+fadeout_tab_id+'_content').attr('style','display:none');
	$('#'+fadein_tab_id).addClass('selected');
	$('#'+fadein_tab_id+'_content').attr('style','display:block');
}

chkFavorite = function (){
	ajaxloader.loadURL(JSWebURL+'action/favorite' , [{"a":"reload","id":$('#hidMovieClipId').val(),"category":"movie"}]);
}

function sortListing(){
	ajaxloader.load('clipListingBlock',[{"block_number":"1","sort_by":$('#sort_by').val(),"clip_id":$('#filter_clip_id').val()}],true);
  //,"season_id":"'+$('#filter_season_id').val()+'","show_id":"'+$('#filter_show_id').val()+'"
}

function ObjectPosition(obj) {
    var curleft = 0;
      var curtop = 0;
      if (obj.offsetParent) {
            do {
                  curleft += obj.offsetLeft;
                  curtop += obj.offsetTop;
            } while (obj = obj.offsetParent);
      }
      return {left:curleft,top:curtop};
}

function getInitLoginUrl(){
    var url = '';
	  var initiatesignupurl=  readCookie('initiatesignupurl');
	  //var initrefpageurl=  readCookie('ref_plus_page');
	  //eraseCookie('ref_plus_page');
	  eraseCookie('initiatesignupurl');
	  /*if(initrefpageurl == 'plus')
		  url = JSWebURL+'order';
 	  else
		  url = initiatesignupurl
    */
	  if(url == '')
		  url = JSWebURL;
	  return url;
}

function getInitRefPageUrl(){
	  var initrefpageurl=  readCookie('ref_plus_page');
	  return initrefpageurl;
}



function isUnique(cur,tblName){
     $("span").remove(":contains('This must be unique.')");
     $('.submit-green').attr("disabled",false);
     if(cur.value!=""){
        $.ajax({
        type: "POST",
        url: "action/unique",
        data: "val="+cur.value+"&tblName="+tblName+"&fieldName="+cur.name+"&ID="+$('input[name="id"]').val()
        }).done(function( msg )
        {
          if(msg!=0) {
                var div = $('<span/>');
                div.append('This must be unique.')
                .attr({ 'class' : 'error','for':cur.id});
                $('#'+cur.id).after(div);
                $('.submit-green').attr("disabled",true);
          }
        });
    }
}




function removeRow(parent_div_id, remove_div_id){
	var parDiv = document.getElementById(parent_div_id)
	var chDiv = parent.document.getElementById(remove_div_id);
	parDiv.removeChild(chDiv);
}
function createAutocompleteBox(txt, id, url, wdth){
	$("#"+txt).autocomplete(url, {
		width: wdth,   /* 260 */
		matchContains: true,
		mustMatch:true
	});
	$("#"+txt).result(function(event, data, formatted){
		if(data){
			if(data[1] && !isNaN(data[1])){
				$('#'+id).val(data[1]);
			}else{
				$("#"+txt).val('');
			}
		}
	});
}

showMessage = function(msgType,msg,formId) {
  $('#'+formId+'_notification').removeClass('n-error');
  $('#'+formId+'_notification').removeClass('n-success');
  $('#'+formId+'_notification').addClass('n-'+msgType);
  $('#'+formId+'_notification').html(msg);
  $('#'+formId+'_notification').css({'display':'block'});
}

createUploader = function(block){
  var uploader = new qq.FileUploader({
    element: document.getElementById(block),
    action: JSWebURL+'action/jq_fileupload',
    debug: false
  });
}


function IsValidDateTime(curdate){
  curdate= curdate.replace(/-/g, " ");
  curdate= curdate.replace(/:/g, " ");
  var arrDate  = curdate.split(" ");
  var Yr  = arrDate[0];
  var Mn  = arrDate[1];
  var Day = arrDate[2];
  var DateVal = Mn + "/" + Day + "/" + Yr;

  var dt = new Date(DateVal);
  if(dt.getDate()!=Day){
    return(false);
  }else if(dt.getMonth()!=Mn-1){
    return(false);
  }else if(dt.getFullYear()!=Yr){
   return(false);
  }
  else if(parseInt(arrDate[3])>23){
   return(false);
  }
  else if(parseInt(arrDate[4])>59 || parseInt(arrDate[5])>59){
   return(false);
  }
  return(true);

}

// JSLIB_DATETIMEPICKERUI // JSLIB_DATETIMEPICKER // CSS_UICUSTOM
//$(function(){ $('.date').datetimepicker({dateFormat: 'yy-mm-dd', timeFormat:'', showTime:false, showHour:false, showMinute:false, showSecond:false });	});
//$(function(){ $('.datetime').datetimepicker({dateFormat: 'yy-mm-dd', showSecond: true, timeFormat: 'hh:mm:ss'});	});

$(document).ready(function() {
     $('.custom_required').each(function(){
        var Initial=$(this).text();
        $(this).html(Initial + "<span style='color:red'>*</span>")
     });
});

jQuery('.numbersOnly').keyup(function () {
    this.value = this.value.replace(/[^0-9\.]/g,'');
});

function cleanCacheLogEntry(entityId,entityType,idHtmlStatusContainer){
  ajaxloader.loadURL(JSWebURL+'action/cleancachelog',[{'entityType':entityType,'entityId':entityId,'idHtmlStatusContainer':idHtmlStatusContainer}]);
}

/************************************ akamai ************************************/
var akamai = {};

akamai.isFileUploaded = function(txtFieldId,idHtmlStatusContainer,btnId){
  var params = '';
  /*
  try{
    var params = eval('('+params+')');
  }catch(ex){}
  */
  $('#'+txtFieldId).removeClass('error');
  $('#'+idHtmlStatusContainer).removeClass('error');
  $('#'+idHtmlStatusContainer).html('');
  $('#'+btnId).attr("disabled", true);

  evtId = $('#event_id').val();
  file = $('#'+txtFieldId).val();
  
  ajaxloader.loadURL(JSWebURL+'action/akamai', [{'act':'isSourceFileUploaded','file':file,'evtId':evtId,'idHtmlStatusContainer':idHtmlStatusContainer,'txtFieldId':txtFieldId,'btnId':btnId}]);
}

akamai.showStatusCallback = function(ret,msg,txtFieldId,idHtmlStatusContainer,btnId){
  var cls = '';
  $('#'+btnId).attr("disabled", false);

  if(ret == '0'){  
    $('#'+txtFieldId).addClass('error');
    //$('#'+idHtmlStatusContainer).addClass('error');
    cls = 'error';
    msg = '<span for="'+txtFieldId+'" generated="true" class="'+cls+'">'+msg+'</span>';
  }
  $('#'+idHtmlStatusContainer).html(msg);    
}
