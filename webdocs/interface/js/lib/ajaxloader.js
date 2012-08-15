var ajaxloader = {
	config:null, inprocess:[], reload:true, responseContainer:null, callback:null, callbackparms:null,
	load:function(config, vars, reload, callback, callbackparms,ignoremerge){
		if(ajaxloader.inprocess[config]) 
			return false;
		ajaxloader.inprocess[config] = true;
		var block = $('#'+config);
		loader.init(block);
    //fclog(vars);
    //fclog(ajax_vars);
    if(ignoremerge === undefined) vars = json_merge(ajax_vars,vars);
    //fclog(vars);
		$.post(location.href,{'blocks':config, 'vars':vars, 'requesttype':'ajaxloading'},function(response){
			var jsonres = eval('('+response+')');
      if(reload){
        for(blockname in jsonres['blockscontent']){        
          if (typeof lazyloader === 'undefined') {
          }else{
            lazyloader.page = 1;
          }
          $('#'+blockname).empty().html(jsonres['blockscontent'][blockname]);
        }
      }
	  loader.remove(block);
		if (callback && typeof(callback) === "function") {
			callback(callbackparms);
		}
	  eval(jsonres['script']);
			ajaxloader.inprocess[config] = false;
		})
	},
  
	loadURL:function(url, vars,  callback, callbackparms, responseContainer,valueReturn){
		if(ajaxloader.inprocess[url]) return false;
		ajaxloader.inprocess[url] = true;
    //loader.init();
		$.post(url,{'vars':vars},function(response){
			loader.remove();
			var jsonres = eval(response);
      if(responseContainer){
        $('#'+responseContainer).empty().html(jsonres);		
      }
	  if (callback && typeof(callback) === "function") {
        if(valueReturn === 'undefined')
            callback(callbackparms);
        else
          callback(callbackparms,jsonres);
    }
			ajaxloader.inprocess[url] = false;
		});
	}  
}
