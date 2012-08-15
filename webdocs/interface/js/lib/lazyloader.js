var lazyloader = {
	page:1, numpages:[], config:null, inprocess:false, blocks:[], brepeat:[], blockids:[],
	loadmargin:300, ajax_vars:null, showingmore:false, autpagecount: 4,
	init:function(config){
    lazyloader.config = config;
    var _blocks = new Array();
		$(config.blocks).each(function(i){
			var rpt = lazyloader.brepeat[config.blocks[i]]?lazyloader.brepeat[config.blocks[i]] : 0;
			rpt++; lazyloader.brepeat[config.blocks[i]] = rpt;
      var bid = config.blocks[i] + ((rpt > 1) ? rpt : '' );
      if(typeof config.config[bid] == 'undefined' || config.config[bid] != '0'){
        //process pagination info for each of the block as per config here..
        lazyloader.blockids.push(bid);
        _blocks.push(config.blocks[i]);
        /*
        var modconf = config.config[bid].split('|');
        if(modconf[0] != 0){
          lazyloader.numpages[bid] = modconf[1];
        } */       
      }
		});//lazyloader.config.config.fullpageloader
    lazyloader.config.blocks = _blocks;
		$(window).scroll(function(){
				var st = $(window).scrollTop();
				var dh = $(document).height();
				var wh = $(window).height();
				var hl = dh - (wh + st);
				if(hl<lazyloader.loadmargin){ 				
					lazyloader.trigger();					
				}
			}
		);
	},
	trigger:function(){
		if(lazyloader.page > lazyloader.autpagecount && !lazyloader.inprocess){
			return;
		}
		var _blocks = new Array();
		$(lazyloader.config.blocks).each(function(i){
			if($('#'+lazyloader.config.blocks[i]).is(":visible"))_blocks.push(lazyloader.config.blocks[i]);		
      //
		});	
		lazyloader.blocks = _blocks;
		if(_blocks.length){
			lazyloader.showloader();
			lazyloader.load();				
		}
	},
	load:function(page,config){
		if(lazyloader.inprocess) return false;
		lazyloader.inprocess = true;
		lazyloader.page++;
    if(typeof ajax_vars == 'undefined') ajax_vars = null;
      //fclog(ajax_vars);
		  $.post(location.href,{'blocks':lazyloader.blocks,'page':lazyloader.page,'vars':ajax_vars,'requesttype':'lazyloading'},function(response){
			var jsonres = eval('('+response+')');
      eval(jsonres['script']);
			var bresponse = '';
    	for(blockname in jsonres['blockscontent']){
				$('#'+blockname).append(jsonres['blockscontent'][blockname]);
				bresponse = ($.trim(bresponse) == '') ? jsonres['blockscontent'][blockname] : bresponse;
			}
			lazyloader.inprocess = false;			
			lazyloader.hideloader();
			if(lazyloader.page > lazyloader.autpagecount && bresponse.length > 200)lazyloader.showmorelink();
		})
	},	
	loadnextpage:function(){
		$('.pageloader').html('loading..').addClass('link');
		lazyloader.load();
	},
	showloader:function(){
		if(lazyloader.inprocess) return false;		
		var $loaderContainer = null;
		if(lazyloader.config.config.fullpageloader){
			$loaderContainer = $('.OuterMostWrapper');
		}else{
			$loaderContainer = $('.Lft_3ColmnWrapper');
		}
		if($loaderContainer.length && lazyloader.blockids.length > 1){
			$loaderContainer.append("<div class='loaderouter'><div class='pageloader link'>loading..</div></div>");
		}else{
			$(lazyloader.blockids).each(function(j){			
				$loaderContainer = $('#'+lazyloader.blockids[j]);			
				$loaderContainer.append("<div class='loaderouter'><div class='pageloader link'>loading..</div></div>");
			});
		}
	},
	showmorelink:function(){
		if(lazyloader.config.config.fullpageloader){
			var $loaderContainer = $('.OuterMostWrapper');
		}else{
			var $loaderContainer = $('.Lft_3ColmnWrapper');
		}
		if($loaderContainer.length && lazyloader.blockids.length > 1){
				$loaderContainer.append("<div class='loaderouter'><div class='pageloader link'>show more..</div></div>").click(lazyloader.loadnextpage);
		}else{
			$(lazyloader.blockids).each(function(j){			
				$o = $('#'+lazyloader.blockids[j]);			
				$o.append("<div class='loaderouter'><div class='pageloader link'>show more..</div></div>").click(lazyloader.loadnextpage);
			});
		}
	},
	hideloader:function(){ 
		$('.loaderouter').remove();
	}
}
