function createAutocompleteSingle(txt, id, name, url,extval,showtxt){
	$("#"+txt).autocomplete(url, {
		width: 260, matchSubset:false, selectFirst: false,mustMatch:true,
		extraParams: {
                    extval: function() {return $('#'+showtxt).val()}
                }
	});
	$("#"+txt).result(function(event, data, formatted) {
		if(data[0] == 'No data matched'){
			$("#"+txt).val('');
      $("#"+id).val('');
		}else{
			$(this).parent().next().find("input").val(data[1]);
			$('#'+id).val(data[1]);
			if(txt=='studio_id_text'){copySubGeoFrmChannel(data[1]);}
			//$('#hidseasonInsert').val(data[0])
		}
	});
}

function createAutocompleteMultiple(txt, id, name, url){
  //'player_txt','player','player_id'
	$("#"+txt).autocomplete(url+"&field_id="+id+"&field_name="+name, {
		width: 260, matchSubset:false, selectFirst: false,mustMatch: true
	});
	$("#"+txt).result(function(event, data, formatted) {
    if(data[1]){
			UpdateItems(id,data[1],data[0],'add');
      UpdateItems(name,data[1],data[0],'add');
      $('#'+txt).val('');
      $("#"+txt).focus();
		}
	});
}

function createMask(id,flag){
	if(flag==1)
		$("#"+id).mask("99-99-9999 99:99:99");
	else if(flag==2)
		$("#"+id).mask("99-99-9999 99:99");
	else if(flag==3)
		$("#"+id).mask("99:99:99");
	else
		$("#"+id).mask("99-99-9999");
}

function UpdateItems(_type,_id,_label,_action){
	if(_action == 'add'){
		var preval = $('#'+_type).val() ? $('#'+_type).val() : '';
		var prevals = $('#'+_type).val() ? preval.split(',') : new Array();

		for(i=0; i< prevals.length; i++){
			if(prevals[i] == _id){
				alert('Selected item already added in the list');
				$('#'+_type+'_text').val('');
				return false;
			}
		}
		prevals[prevals.length] = _id;
		var newval = prevals.join(',');
		$('#'+_type).val(newval);
		var response_item = '<span class="multipletoken" myAttribute="'+_label+'~'+_id+'" id="'+_id+'">'+_label+'<span class="close" onclick="RemoveList(this)" > x </span></span>';
		$('#'+_type+'_list').append(response_item);
		$('#'+_type+'_text').val('');
	}else if(_action=='remove'){
		var preval = $('#'+_type).val() ? $('#'+_type).val() : '';
		var prevals = preval.split(',');
		var newvals = new Array();
		var j=0;
		//run through each id and remove the one which is selected
		for(i=0; i< prevals.length; i++){
			if(prevals[i] != _id){
				newvals[j] = prevals[i]; j++;
			}
		}
		var newval = newvals.join(',');
		$('#'+_type).val(newval);
	}
	$('#'+_type+'_list').addClass('scrollAuto');  // added by dshahi for autocomplete width
  $('#'+_type+'_list').parent().parent().attr('valign','top');
}

//Remove an item from the multiselect list..
function RemoveList(obj){

	var _type = $(obj).parent().parent()[0].id.replace(/_list/,'');
	var _itemid = $(obj).parent()[0].id;
	var _itemid1 = $('#'+_itemid).attr('myAttribute');
	// added for new artist list with name & ids //
	if(_type=='artist'){UpdateItems('artistsName',_itemid1, '','remove');}
	if(_type=='source'){UpdateItems('sourceName',_itemid1, '','remove');}
	if(_type=='genre'){UpdateItems('genreName',_itemid1, '','remove');}
	if(_type=='sub_genre'){UpdateItems('sub_genreName',_itemid1, '','remove');}
	UpdateItems(_type,_itemid, '','remove');
	$(obj).parent().remove();
}