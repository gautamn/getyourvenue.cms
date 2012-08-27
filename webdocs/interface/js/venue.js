// JavaScript Document
	$().ready(function() {
    $.validator.addMethod("checkMetaKeyword", function(value, element) {
      var metaW =  $.trim(value);
      metaW = metaW.split(" ");
      return (metaW.length<3) ? false : true;
    }, "");

		// validate signin form on keyup and submit
		$("#venueForm").validate({
			rules: {
				'region': {required: true},
				'venueType': {required: true},
				'venuecapacity': {required: true},
				'popular': {required: true},
				'meta_title': {required: true, checkMetaKeyword:true},
				'meta_description': {required: true, checkMetaKeyword:true},
				'iframe_code': {required: true},
        'venue_name': {required: true},
        'seo_title': {required: true},
        'venue_rank': {required: true},
        'address1': {required: true},
        //'address2': {required: true},
        'image_alt': {required: true},
        'description': {required: true},
        'meta_keyword': {required: true, checkMetaKeyword:true}
			},
			messages: {
				'region': {required:"Please select Region Name."},
        'venueType': {required:"Please select Venue Type."},
        'venuecapacity': {required:"Please select venue capacity."},
				'popular': {required:"Please select popularity."},
        'meta_title': {required:"Please enter Meta Keyword", checkMetaKeyword:"Please enter more than 2 Meta Title"},
        'meta_description': {required:"Please enter Meta Keyword", checkMetaKeyword:"Please enter more than 2 Meta Keyword"},
				'iframe_code': {required:"Please enter Google Map code."},
				'venue_name': {required: "Please enter venue name."},
        'seo_title': {required: "Please enter SEO Id."},
        'venue_rank': {required: "Please enter venue rank."},
        'address1': {required: "Please enter address."},
        //'address2': {required: "Please enter address."},
        'image_alt': {required: "Please enter image text for seo."},
        'description': {required: "Please enter description"},
        'meta_keyword': {required:"Please enter Meta Keyword", checkMetaKeyword:"Please enter more than 2 Meta Title"}
			}
		});
	});

function changeStatus(Id,type){
    var sh_keyword = $('#sh_keyword').val();
    var sh_status = $('#sh_status').val();
    ajaxloader.load('venueBlock',[{"sh_keyword":sh_keyword,"sh_status":sh_status,action:"changeStatus",id:Id,type:type}],true);
}

function showPage(currPage){//for pagination
    searchVenues(currPage);
}

function searchVenues(currPage) {  // called when search form is submitted on page
    currPage = typeof currPage !== 'undefined' ? currPage : 1;
    var sh_keyword = $('#sh_keyword').val();
    var sh_status = $('#sh_status').val();
    ajaxloader.load('venueBlock', [{"currPage":currPage,"sh_keyword":sh_keyword,"sh_status":sh_status}],true);
}

$('#btn_cancel').click(function(){
    window.location = JSWebURL + 'venue';
});

$('#btn_search').click(function(){
  if(IsValidSubmit()){
    //$('#searchVenue').submit();
  }
});

$('#searchVenue').submit(function(){
    return IsValidSubmit();
});

function IsValidSubmit(){
  $("span").remove(":contains("+SERACH_VALIDATION_TEXT+")");
  var sh_keyword = $('#sh_keyword').val();
  var sh_status = $('#sh_status').val();
  if(sh_keyword=="" && sh_status==""){
             var div = $('<span/>');
                div.append(SERACH_VALIDATION_TEXT)
                .attr({ 'class' : 'error','for':this.id});
                $('#sh_keyword').after(div);
                return false;
  }
  return true;
}

function showVenueDetail(Id){
  lightModal.load(JSWebURL+'modal/venue-detail?Id='+Id,false,true,380,500,'Venue Detail',function (){
    $('#Action').focus();
  });
}

$('#venue_name').live('blur',function(){
  if($('#meta_title').val().length<1){
    $('#meta_title').val(this.value);
  }
  if($('#image_alt').val().length<1){
    $('#image_alt').val(this.value);
  }
  if($('#seo_title').val().length<1){
    var seo = $.trim(this.value.toLowerCase());
    seo = seo.replace(/\s/g, "-");
    $('#seo_title').val(seo);
  }
});