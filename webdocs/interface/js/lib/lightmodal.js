var $=jQuery.noConflict();
var lightModal = lightModal || {} ;

lightModal = function(){
	var baseurl;var imgurl;var modalvars; var defaults; var overlayclose;var settings;
}

lightModal.init = function(){
	lightModal.baseurl = JSWebURL;
	lightModal.imgurl = JSThemeURL  + '/images/';
	lightModal.modalvars = 'iframe,title,icon,height,width,ismodal'; 
	lightModal.defaults = {'iframe':false,'title':'&nbsp;&nbsp;&nbsp;','icon':'','height':null,'width':null,'ismodal':true}; 
	lightModal.overlayclose = false;	
	lightModal.fadeinduration = 100;	
	$(window).bind('resize',lightModal.setposition);	
}

lightModal.bind = function(_selector,prop){
	_atr = prop ? prop : 'href';
	$(_selector).each(function(i){
		var PARAMS = new Array();	
		var _servervars = '?';			
		var _href = $(this).attr(_atr);
		var param = _href.split('?');		
		if(param[1]){
			var params = param[1].split('&');		
			for( i in params){
				var _var = params[i].split('=');
				if(lightModal.modalvars.indexOf(_var[0]) != -1){
					PARAMS[_var[0]] = _var[1];
				} else {
					_servervars += '&' + params[i];
				}
			}
		} else {
			
		}
		this._url = param[0];this._servervars = _servervars;
		this.config = lightModal.setconf(PARAMS);this.binded = true;
		$(this).click(function(event){
			event.preventDefault();
			var href = this._servervars.length > 1 ? this._url + this._servervars : this._url;
			lightModal.load(href,this.config['iframe'],this.config['ismodal'],this.config['height'],this.config['width'],this.config['title'],this.config['icon']);
			
			return false; //terminate the further processing..
		});
	});
}
lightModal.setconf=function(PARAMS){
	var config = new Array();
	var $vars = lightModal.modalvars.split(',');
	for ( i in $vars){
		config[$vars[i]] = PARAMS[$vars[i]] != undefined ? PARAMS[$vars[i]] : lightModal.defaults[$vars[i]];
	}
	return config;
}
//
lightModal.load = function(_href,_iframe,_ismodal,_height,_width,_title,callback,callbackparms){
	lightModal.settings = {'_href': _href,'_iframe':_iframe};
	lightModal.modal = _ismodal;
	var CSS = lightModal.getCSS(_height,_width);
	_title = _title != undefined ? _title : '&nbsp;&nbsp;&nbsp;';
	//MODALCONTENT = 'Test content Test content ';
	if(_iframe){
		lightModal.loaderBox();
		MODALCONTENT = '<div id="lightModaliframeContainer" style="height:100%;"><iframe id="modaliframe" src="'+_href+'" frameBorder="0" style="height:100%;width:100%;"></iframe></div>';
		lightModal._show(_title,MODALCONTENT,CSS.blockcss,CSS.containercss);
		$('#modaliframe').bind('keyup',lightModal.handleEscape);
		document.getElementById('modaliframe').onload = lightModal.loaderBoxClose;
	}else{
		lightModal.loaderBox();
		$.get(_href,function(data){
		lightModal._show(_title,data,CSS.blockcss,CSS.containercss);
		if(typeof callback != 'undefined'){
			callback(callbackparms);
		}
		lightModal.loaderBoxClose();
		});
	}

}
//reload the content in lightmodal..
lightModal.reload = function(_url){
	if(_url==null){
		_url = lightModal.settings._href;
	}
	lightModal.loaderBox();
	$.get(_url,function(newHTML){		
		$('#lightmodalContent').html(newHTML);
		lightModal.loaderBoxClose();
	});	
}

lightModal.getCSS=function(_height,_width){
	_height = _height != undefined ? _height - 50 : _height;
	var _STYLE = 'style="';_STYLE += _height != undefined ? "height:"+_height+"px;" : "" ;
	_STYLE += _width != undefined ? "width:"+_width+"px;" : "" ;_STYLE += '"';
	
	var INNERCSS = 'Style="'; INNERCSS += _height != undefined ? "height:"+(parseFloat(_height) - 32 )+"px;" : "" ;;
	INNERCSS += '"'; 
	var returnval = {'blockcss':_STYLE,'containercss':INNERCSS};
	return returnval;
}
//load a specified HTML content in the block
lightModal.loadhtml = function(_html,_title,_height,_width){
	var CSS = lightModal.getCSS(_height,_width);
	lightModal._show(_title,_html,CSS.blockcss,CSS.containercss);
}

lightModal._show=function(_title,MODALCONTENT,_STYLE,INNERCSS){
	lightModal.close();
	_title = unescape(_title);
	$modal = $(lightModal.createwindow(_title,MODALCONTENT,_STYLE,INNERCSS));
	if(lightModal.modal){
		lightModal.overlay(lightModal.overlayclose);
	}
	$modal.hide();
	$('body').append($modal);	
	lightModal.setposition();	
	$modal.fadeIn(lightModal.fadeinduration,function(){
		$('#username').focus();
	});	
	$(document).bind('keyup',lightModal.handleEscape);
}

//handle the escape key press by user..
lightModal.handleEscape = function(e){
	if(e.keyCode == 27){
		lightModal.close();
	}
}

lightModal.setposition = function(){
	if($('#lightModal').length){
		var _nl = ($(window).width() - $('#lightModal').width()) / 2;
		var _nt = ($(window).height() - $('#lightModal').height()) / 2;
		$('#lightModal').css({'left':_nl,'top':_nt})
	}
}

lightModal.createwindow = function(MODALTITLE,MODALCONTENT,STYLE,INNERCSS){
	var _container='<div id="lightModal" class="divPop"><div class="inner"><div align="right" class="closeBtn"><a href="javascript:void(0);" class="closeBtn"><img src="'+lightModal.imgurl+'spacer.gif" alt="Close" onclick="lightModal.close()" width="24px" height="24px"/></a></div><div class="ttl mrgLR"><div class="txt18 B">'+MODALTITLE+'</div></div><div id="lightmodalContent" '+STYLE+' >'+MODALCONTENT+'</div></div></div>';
	return _container;
}

lightModal.close = function(){
$('#lightModalOverlay').hide();
$('#lightModal').hide().remove();
lightModal.loaderBoxClose();
//$('#lightModal').remove();
$('#lightModalOverlay').remove();
$(document).unbind('keyup',lightModal.handleEscape);
$('#modaliframe').unbind('keyup',lightModal.handleEscape);
}
lightModal.overlay = function(x){
	var overlay = x ? $('<div id="lightModalOverlay"></div>').click(lightModal.close) : '<div id="lightModalOverlay"></div>';
	$('body').append(overlay);
	var _close=function(){
		$('#lightModalOverlay').remove();
	}
}

//show message in the page..
lightModal.messageBox = function(msgobj){
	$('#messageBox').remove();
	var _close = function(){
		$('#messageBox').fadeOut(lightModal.fadeinduration,function(){$('#messageBox').remove(); clearInterval(autoclose);});
	}
	var createMsg = function(msgobj){
		var _message=unescape(msgobj.msg);
		var _type=msgobj.type;
		var _title=msgobj.title;
		var _url = lightModal.imgurl;
		var _imgClass = msgobj.imgClass;
		var _width = msgobj.width;
		_width = (typeof _width=='undefined' ? '400' : _width);
		/*var _baseMSG ='<div class="actionNotify abs" id="messageBox" style="background-color:#eee;">';
			_baseMSG +='<table width="100%" cellspacing="0" cellpadding="0" border="0">';
			_baseMSG +='<tbody><tr><td valign="middle" class="icons '+_type+'">';
			_baseMSG +=_message+'</td><td valign="top" width="40px">';
			_baseMSG +='<a class="closeBtn" href="javascript:void(0);" id="closeMsgBox">';
			_baseMSG +='<img src="'+TMStaticUrl+'media/images/spacer.gif"></a></td>';
			_baseMSG +='</tr></tbody></table></div>'*/
		var _baseMSG = '<div class="popup" style="width:'+_width+'px; position:fixed;" id="messageBox">';
		_baseMSG += '<div class="top"><span class="rght"></span><span class="lft"></span><span></span></div>';
		_baseMSG += '<div class="mid"><div class="grayBg"><div class="notification pstatic"><img src="'+_url+'spacer.gif" alt="" class="notifyImg '+_imgClass+'" />';
		_baseMSG += '<div class="msg twoLine">'+_message+'</div><div class="clear"></div></div>';
        _baseMSG += '</div></div>';
		_baseMSG += '<div class="bot"><span class="rght"></span><span class="lft"></span><span></span></div>'
		_baseMSG += '</div>';
		return _baseMSG;

	}
	$msg = $(createMsg(msgobj)).hide();//.click(function(){ $(this).remove();});
	$('body').append($msg);
	_t = 300;
	_l = ($('body').width()  - $msg.width()) / 2;	
	$msg.css({'top':_t,'left':_l,'margin':'0 !important','margin':0});
	$msg.fadeIn(lightModal.fadeinduration);
	$('#closeMsgBox').click(_close);
	var _timeout = msgobj.timeout != undefined ? msgobj.timeout : 5000;
	var autoclose = setTimeout(_close,_timeout);
}

lightModal.loaderBox = function(){
	$('#loaderBox').remove();
	var _close = function(){
		$('#loaderBox').fadeOut(lightModal.fadeinduration,function(){$('#loaderBox').remove(); clearInterval(autoclose);});
	}	
	var createMsg = function(){
		var _baseMSG ='<div class="actionNotify abs" id="loaderLox" style="width:200px;position:fixed;">';
			_baseMSG +='<img src="'+lightModal.imgurl+'loader.gif" style="margin:20px 30px;" /></td>';
			_baseMSG +='</div>'
		return _baseMSG;
	}
	$msg = $(createMsg()).hide();//.click(function(){ $(this).remove();});
	$('body').append($msg);
	//_t = ($('body').height()  - $msg.height()) / 2;
	_t = 200;
	_l = ($('body').width()  - $msg.width()) / 2;	
	$msg.css({'top':_t,'left':_l,'margin':'0 !important','margin':0});	
	$msg.show();
}
lightModal.loaderBoxClose = function(){
	$('#loaderLox').remove();
	$('#messageBox').remove();
}

lightModal.closeBtn=function(){$('#lightModalCloseBtn').hide();}
	
lightModal.init();
