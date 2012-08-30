// JavaScript Document
	$().ready(function() {
    $.validator.addMethod("checkMetaKeyword", function(value, element) {
      var metaW =  $.trim(value);
      metaW = metaW.split(" ");
      return (metaW.length<3) ? false : true;
    }, "");

		// validate signin form on keyup and submit
		$("#alliedServiceForm").validate({
			rules: {
				'service_name': {required: true},
				'meta_title': {required: true, checkMetaKeyword:true},
				'meta_description': {required: true, checkMetaKeyword:true},
				'seo_title': {required: true},
        'banner_path': {required: true},
				'jcarousel_path': {required: true},
        //'themes_path': {required: true},
				'meta_keyword': {required: true, checkMetaKeyword:true},
        'description': {required: true}
			},
			messages: {
				'service_name': {required:"Please select Allied Serivce Name."},
        'meta_title': {required:"Please enter Meta Title.", checkMetaKeyword:"Please enter more than 2 Meta Title"},
        'meta_description': {required:"Please enter Meta Description.", checkMetaKeyword:"Please enter more than 2 Meta Description"},
        'seo_title': {required:"Please enter SEO Id."},
        'banner_path': {required:"Please enter banner path."},
				'jcarousel_path': {required:"Please enter jcarousel path."},
        //'themes_path': {required: "Please enter themes path."},
        'meta_keyword': {required:"Please enter Meta Keywords.", checkMetaKeyword:"Please enter more than 2 Meta Keyword"},
        'description': {required: "Please enter description."}
			}
		});
	});

function changeStatus(Id){
    var sh_keyword = $.trim($('#sh_keyword').val());
    var sh_status = $.trim($('#sh_status').val());
    ajaxloader.load('alliedServicesBlock',[{"sh_keyword":sh_keyword,"sh_status":sh_status,action:"changeStatus",id:Id}],true);
}

function showPage(currPage){//for pagination
    searchAllied(currPage);
}

function searchAllied(currPage) {  // called when search form is submitted on page
    currPage = typeof currPage !== 'undefined' ? currPage : 1;
    var sh_keyword = $('#sh_keyword').val();
    var sh_status = $('#sh_status').val();
    ajaxloader.load('alliedServicesBlock', [{"currPage":currPage,"sh_keyword":sh_keyword,"sh_status":sh_status}],true);
}

$('#btn_cancel').click(function(){
    window.location = JSWebURL + 'alliedservices';
});

$('#btn_search').click(function(){
  if(IsValidSubmit()){
   // $('#searchAlliedServices').submit();
  }
});

$('#searchAlliedServices').submit(function(){
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

function showAlliedServiceDetail(Id){
  lightModal.load(JSWebURL+'modal/allied-service-detail?Id='+Id,false,true,380,500,'Allied Service Detail');
}

$('#service_name').live('blur',function(){
  if($('#meta_title').val().length<1){
    $('#meta_title').val(this.value);
  }
  if($('#seo_title').val().length<1){
    var seo = cleanUPSEO(this.value);
    $('#seo_title').val(seo);
  }
});

function cleanUPSEO(entity_name){
  var seo = $.trim(entity_name.toLowerCase());
  seo = seo.replace(/\s/g, "-");
  return seo;
}