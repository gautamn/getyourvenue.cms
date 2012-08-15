	$(function()
  {
    $('#about').wysiwyg(
    {
      controls : {
      separator01 : { visible : true },
      separator03 : { visible : true },
      separator04 : { visible : true },
      separator00 : { visible : true },
      separator07 : { visible : false },
      separator02 : { visible : false },
      separator08 : { visible : false },
      insertOrderedList : { visible : true },
      insertUnorderedList : { visible : true },
      undo: { visible : true },
      redo: { visible : true },
      justifyLeft: { visible : true },
      justifyCenter: { visible : true },
      justifyRight: { visible : true },
      justifyFull: { visible : true },
      subscript: { visible : true },
      superscript: { visible : true },
      underline: { visible : true },
      increaseFontSize : { visible : false },
      decreaseFontSize : { visible : false }
    }
    } );
  });

  $().ready(function() {

    $("#frmsearchadminusers").validate({
      rules: {
        sh_keyword:"required"
      },
      messages: {
        sh_keyword:"required"
      },
      submitHandler: function(form) {
        ajaxloader.load('adminuserBlock',[{"keyword":$('#sh_keyword').val()}],true);
      }
    });

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

    $.validator.addMethod("is_unique_username", function(value, element) {
      var isUnq = parseInt($('#is_unique_username').val());
      return (isUnq>0)?true : false;
    }, "");
    var is_password_required = function() {
      return ($('#adminuser_action').val() == 'saveAdminUser') ? true : false;
    };
		// validate signin form on keyup and submit
		$("#adminuserForm").validate({
			rules: {
        name:"required",
				username:{required: true, is_unique_username:true},
        password:{required: {depends:is_password_required}},
        fb_url: {url:true},
        twitter_url: {url:true},
        google_plus_url: {url:true},
        email: {required: true, email:true}
			},
			messages: {
        username:{is_unique_username:"required unique"}
			},
      submitHandler: function(form) {
        form.submit();
      }
		});

	});

  deleteUser = function(Id){
    if(confirm("Are you sure you want to delete?")){
      ajaxloader.load('adminuserBlock',[{"action":"deleteAdminUser","id":Id}],true);
    }
  }

  changeStatusAdminUser = function(Id, currSts){
    ajaxloader.load('adminuserBlock',[{"action":"changeStatusAdminUser","id":Id}],true);
  }

  check_if_username_unique = function() {
    var usernameC = $('#username').val();
    var idC = $('#id').val();
    ajaxloader.load('adminuserBlock',[{"action":"checkUniqueAdminUsername",'username':usernameC,'id':idC}],false);
  }

  setUniqueUserName = function(isUnq) {
    isUnq = parseInt(isUnq);          //alert(isUnq);
    $('#is_unique_username').val(isUnq);
  }

  showhideAdminUserInfo = function() {
    if($('#role_id').val()==2){
      $('#adminUserInfo').removeClass('hideSection');
    }else{
      $('#adminUserInfo').addClass('hideSection');
    }
  }

  function uploadImage(url, title){
  lightModal.load(url,true,true,500,700,title,function (){
    });
  }

  function getArtwork(imageName,flag){
    var tempurl=$('#tempurl').val();
    imageHtml = '<img src="'+tempurl+'/'+imageName+'" width="60px">';
    /*var keydata = new Array();
    keydata = flag.split('_');
    if(keydata[0]=='cue'){
      $('#photo_upload_'+keydata[1]).val(imageName);
      $('#uploadedId_'+keydata[1]).html(imageHtml);
      $('#cuepoint_thumb_'+keydata[1]).attr('style','display:none;');
    }else{
      if(keydata[0]==1){
        $("#clip_photo_120").val(imageName);
        $("#uploadedId_120").html(imageHtml);
        $('#image_upload_120').attr('style','display:none;');
      }else if(keydata[0]==2){
        $("#photo_clip_player_thumb").val(imageName);
        $("#uploadedId_player").html(imageHtml);
        $('#image_upload_player').attr('style','display:none;');
      }else{*/
        $("#auser_photo").val(imageName);
        $("#uploadedId").html(imageHtml);
        $('#photo_upload').attr('style','display:none;');
      /*}
    }*/
  }


  $('#delete').click( function()    //click to delete the image by DShahi
  {
    var con=confirm("Are you sure you want to delete image!");
    if(con){
      var id=$('#cid').val();
      var image=$('#image').val();
      $('#clip_photo').val('');
      $('#clip_photo_flag').val('1');
      $('#container').html('');
      $('#image_upload').attr('style','display:block;');
    }
  });
