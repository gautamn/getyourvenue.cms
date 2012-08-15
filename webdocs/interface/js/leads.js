//JS - Leads
function searchLeads(currPage) {  // called when search form is submitted on page
  currPage = typeof currPage !== 'undefined' ? currPage : 1;
  var sh_keyword = $('#sh_keyword').val();
  ajaxloader.load('leadsBlock', [{"currPage":currPage,"sh_keyword":sh_keyword}],true);
}

function showPage(currPage){//for pagination
  searchLeads(currPage);
}

$('#btn_cancel').click(function(){
  window.location = JSWebURL + 'leads';
});

$('#btn_search').click(function(){
  if(IsValidSubmit()){
    //$('#searchLeads').submit();
  }
});

$('#searchLeads').submit(function(){
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