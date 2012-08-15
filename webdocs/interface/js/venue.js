			// JavaScript Document
	$().ready(function() {

		// validate signin form on keyup and submit
		$("#gutterForm").validate({
			rules: {
				title:"required",
				impression_url: "required",
				click_url: "required"

			},
			messages: {
				title:"required",
				impression_url: "required",
				click_url: "required"

			}
		});



	});

function SaveForm(){

}


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