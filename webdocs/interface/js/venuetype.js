// JavaScript Document
	$().ready(function() {
    // validate signin form on keyup and submit
		$("#venueTypeForm").validate({
			rules: {
				'venue_type': {required: true},
        'seo_title': {required: true}
			},
			messages: {
				'venue_type': {required: "Please enter venue type name."},
        'seo_title': {required: "Please enter SEO Title."}
			}
		});
	});

function showPage(currPage){//for pagination
    searchVenueType(currPage);
}

function searchVenueType(currPage) {  // called when search form is submitted on page
    currPage = typeof currPage !== 'undefined' ? currPage : 1;
    var sh_keyword = $('#sh_keyword').val();
    ajaxloader.load('venueTypeBlock', [{"currPage":currPage,"sh_keyword":sh_keyword}],true);
}

$('#btn_cancel').click(function(){
    window.location = JSWebURL + 'venuetype';
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
  if(sh_keyword==""){
             var div = $('<span/>');
                div.append(SERACH_VALIDATION_TEXT)
                .attr({ 'class' : 'error','for':this.id});
                $('#sh_keyword').after(div);
                return false;
  }
  return true;
}

$('#venue_type').live('blur',function(){
  if($('#seo_title').val().length<1){
    var seo = $.trim(this.value.toLowerCase());
    seo = seo.replace(/\s/g, "-");
    $('#seo_title').val(seo);
  }
});