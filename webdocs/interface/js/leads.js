//JS - Leads
function searchLeads(currPage) {  // called when search form is submitted on page
  currPage = typeof currPage !== 'undefined' ? currPage : 1;
  var sh_keyword = $('#sh_keyword').val();
  var seacrhDateFrom = $.trim($('#seacrhDateFrom').val());
  var seacrhDateTo = $.trim($('#seacrhDateTo').val());
  ajaxloader.load('leadsBlock', [{"currPage":currPage,"sh_keyword":sh_keyword,"seacrhDateFrom":seacrhDateFrom,"seacrhDateTo":seacrhDateTo}],true);
}

function showPage(currPage){//for pagination
  searchLeads(currPage);
}

$('#btn_cancel').click(function(){
  window.location = JSWebURL + 'leads';
});

$('#btn_search').click(function(){
  if(IsValidSubmit()){
    searchLeads();//$('#searchLeadsForm').submit();
  }
});
/*
$('#searchLeads').submit(function(){
   return IsValidSubmit();
});
*/

function IsValidSubmit(){
  var sh_keyword = $('#sh_keyword').val();
  var seacrhDateFrom = $.trim($('#seacrhDateFrom').val());
  var seacrhDateTo = $.trim($('#seacrhDateTo').val());
  /*$("span").remove(":contains("+SERACH_VALIDATION_TEXT+")");
  if(sh_keyword=="" || (seacrhDateFrom=="" && seacrhDateTo=="")){
    var div = $('<span/>');
    div.append(SERACH_VALIDATION_TEXT)
    .attr({ 'class' : 'error','for':this.id});
    $('#sh_keyword').after(div);
    return false;
  }
  return true;*/
  if(sh_keyword=="" && (seacrhDateFrom=="" && seacrhDateTo=="")){
    alert(SERACH_VALIDATION_TEXT);
    return false;
  }
  return true;
}

function showDates(){
		$("#seacrhDateFrom, #seacrhDateTo").datepicker({
			defaultDate: "+1w",
			changeMonth: false,
      changeYear: false,
      dateFormat: 'yy-mm-dd',
      minDate: "-1m",
      maxDate: new Date(),
      showButtonPanel: false,
      closeText: 'X',
			numberOfMonths: 1,
			onSelect: function(selectedDate) {
				if(this.id == "seacrhDateFrom") {
          $("#seacrhDateTo").datepicker("option", "minDate", selectedDate);
        }
        else {
          $("#seacrhDateFrom").datepicker("option", "maxDate", selectedDate);
        }
			}
		});
}
