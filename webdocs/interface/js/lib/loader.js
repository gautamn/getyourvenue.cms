var loader ={ loaderblock:'',
  init:function(block){
		if(typeof block == 'undefined') 
      block = $('body');
    var _w = block.width();
    var _h = block.height();		
    var _p = ObjectPosition(block[0]);
		var pfooter = $(document).scrollTop()+$(window).height();
		if(_h > (pfooter - _p.top)){
			_h = pfooter - _p.top;
		}
		loader.loaderblock = $('<table id="ajaxloader"><tr><td id="loadertd" valign="middle" align="center"><img class="loaderimg" src="'+JSThemeURL+'images/loader.gif" width="120px" height="24px" /></td></tr></table>').css({'opacity':'0.8','height':_h,'width':_w,'vertical-align':'middle','position':'absolute','left':_p.left,top:_p.top,'z-index':1000}).appendTo(block);
    $('#loadertd').css({'height':_h,'width':_w});
  },
  remove:function(){
		$('#ajaxloader').remove();
   // loader.loaderblock.remove()
  }
}