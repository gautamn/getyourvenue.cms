	var submitFormCategory = false;
  $().ready(function() {


    $("#frmsearchcategories").validate({
        rules: {
          sh_keyword:"required"
        },
        messages: {
          sh_keyword:"required",
        },
        submitHandler: function(form) {
          ajaxloader.load('categoryBlock',[{"type":$('#sh_type').val(),"keyword":$('#sh_keyword').val()}],true);
        }
      });



    $.validator.addMethod("is_unique", function(value, element) {
      var isUnq = parseInt($('#is_unique_name').val());
      return (isUnq>0)?true : false;
    }, "");

		// validate signin form on keyup and submit
		$("#categoryForm").validate({
			rules: {
				name:{required: true, is_unique:true},
        type:"required",
        priority: {required:true, digits:true }
			},
			messages: {
				name:{is_unique:"Unique value is required."},
        priority: "number required"
			},
      submitHandler: function(form) {
        form.submit();
      }
		});

    $(document).ready(function() {
				$("#myTable")
				.tablesorter({
					// zebra coloring
					widgets: ["zebra"],
					// pass the headers argument and assing a object
					headers: {
						// assign the sixth column (we start counting zero)
						4: {
							// disable it by setting the property sorter to false
							sorter: false
						}
					}
				})
			.tablesorterPager({container: $("#pager")});

//      check_if_category_unique(0);
		}); 

	});

  searchCategory = function(){
    ajaxloader.load('categoryBlock',[{"type":$('#sh_type').val(),"parent_id":$('#sh_parent_id').val(),"keyword":$('#sh_keyword').val()}],true);
  }

  deleteCategory = function(Id){
    if(confirm("Are you sure you want to delete?")){
      ajaxloader.load('categoryBlock',[{"action":"deleteCategory","id":Id,"type":$('#sh_type').val()}],true);
    }
  }

  changeStatusCategory = function(Id, currSts){
    ajaxloader.load('categoryBlock',[{"action":"changeStatus","id":Id,"type":$('#sh_type').val()}],true);
  }

  check_if_category_unique = function(updateCategoryDDFlag) {
    var nameC = $('#name').val();
    var typeC = $('#type').val();
    var idC = $('#id').val();
    var parent_idC = $('#parent_id').val();
    if(parent_idC == ''){
      parent_idC = 0;
    }
    ajaxloader.load('categoryBlock',[{"action":"checkUniqueCategory",'name':nameC,'type':typeC,'id':idC,'parent_id':parent_idC,'updateCategoryDDFlag':updateCategoryDDFlag}],false);
  }

  setUniqueName = function(isUnq) {
    isUnq = parseInt(isUnq);          //alert(isUnq);
    $('#is_unique_name').val(isUnq);
  }

  updateCategoryDD = function(ddHtml) {
    $('#categoryDD').html(ddHtml);
  }