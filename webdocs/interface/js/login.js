/*@desc login
 */
$(document).ready(function (){
  /* Event of document */
    $('input[id=username],input[id=password]','#signinform').live({
    keypress:function (e){
      if(e.which == 13){
        e.preventDefault();
        loginValidate();
      }
    },
    click : function (e){
      removeErrors();
    }
  });

  $('input[id=signIn]','#signinform').live('click',function (e){
    loginValidate();
  });

  $('input[id=submIt]','#frmforgotpassword').live('click',function (e){
    forgetPasswordValidate();
  });

  $('input[id=useremail]','#frmforgotpassword').live('keypress',function (e){
    if(e.which == 13){
      e.preventDefault();
      forgetPasswordValidate();
    }
  });

  $('#forgetpassword').live('click',function (e){
    forgetPassword();
  });

  $('input[id=submIt]','#resetpasswordfrm').live('click',function (e){
    resetPasswordValidate();
  });

  $('input[id=password],input[id=repassword]','#resetpasswordfrm').live('keypress',function (e){
    if(e.which == 13){
      e.preventDefault();
      resetPasswordValidate();
    }
  });

  $('input[id=submIt]','#changepasswordfrm').live('click',function (e){
    changePasswordValidate();
  });

  $('input[id=oldpassword],input[id=password],input[id=repassword]','#changepasswordfrm').live('keypress',function (e){
    if(e.which == 13){
      e.preventDefault();
      changePasswordValidate();
    }
  });
  /* Eof  events*/


});

$('#logout').live('click',function(){
    window.location.href = JSWebURL+'action/logout';
  });

/* redirect to page */
forgetPassword = function (){
  window.location.href = 	JSWebURL+'forgotpassword';
}

resetPassword = function (){
  window.location.href = 	JSWebURL+'resetpassword';
}

changePassword = function (){
  window.location.href = 	JSWebURL+'changepassword';
}
/* Eof redirect*/

/* Ajax loadURL*/
$('a[id=submit]','#frmregistrationactivitation').live('click',function (e){
  if($.trim($('#activationcode').val()) == ''){
    removeErrors();
    msg = $("<div class='errorPopup spacing' generated='true' id='remove'>Varification code id required.</div>")
    msg.appendTo($('#frmregistrationactivitation #activationcode').parent("div"));
  }
  else
    ajaxloader.loadURL(JSWebURL+'action/registrationactivitation',[$('#frmregistrationactivitation').serializeJSON()]);
});

function sendRequest(){
  ajaxloader.loadURL(JSWebURL+'action/login',[$('#signinform').serializeJSON()]);
}

function sendForgetPasswordRequest(){
  ajaxloader.loadURL(JSWebURL+'action/forgotpassword',[$('#frmforgotpassword').serializeJSON()]);
}

function sendResetPasswordRequest(){
  ajaxloader.loadURL(JSWebURL+'action/resetpassword',[$('#resetpasswordfrm').serialize()]);
}

function sendChangePasswordRequest(){
  ajaxloader.loadURL(JSWebURL+'action/changepassword',[$('#changepasswordfrm').serializeJSON()]);
}
/* Execute Ajax loadURL*/

/* Modular function validation and sendrequest */
loginValidate = function (){
  var loginfrm = {};
  loginfrm.Arrmessage=new Array();
  loginfrm.Arrid=new Array();
  username = $.trim($('#signinform #username').val());
  password = $.trim($('#signinform #password').val());
  var clientValidation=true;
  removeErrors();
  if(username==""){
    loginfrm.Arrmessage[0]='Username is required. ';
    loginfrm.Arrid[0]='username';
    clientValidation=false;
  }
  if(password=="") {
    loginfrm.Arrmessage[1]='Password is required. ';
    loginfrm.Arrid[1]='password';
    clientValidation=false;
  }
  else if(password.length<8){
    loginfrm.Arrmessage[1]='Please enter at least 8 characters. ';
    loginfrm.Arrid[1]='password';
    clientValidation=false;
  }
  $('.error').each(function (){
    $(this).remove();
  });
  if(clientValidation){
    sendRequest();
  }
  else
  {
    for(var i=0; i<2; i++){
      msg = $('<span class="error" htmlfor="'+loginfrm.Arrid[i]+'" generated="true" style="display: inline;" id="remove">'+loginfrm.Arrmessage[i]+'</span>');
      msg.appendTo($('#signinform #'+loginfrm.Arrid[i]).parent("p"));
    }
  }
};

function forgetPasswordValidate(){
  var form = 'frmforgotpassword';
  var forgetpassword = {};
  forgetpassword.Arrmessage=new Array();
  forgetpassword.Arrid=new Array();
  useremail = $.trim($('#'+form+' #useremail').val());
  var clientValidation=true;
  removeErrors();
  if (!useremail){
    forgetpassword.Arrmessage[0]='Email is required. ';
    forgetpassword.Arrid[0]='useremail';
    clientValidation=false;
  }
  else
  {
    if (!validateEmail(useremail)) {
      forgetpassword.Arrmessage[0]='Please enter a valid email. ';
      forgetpassword.Arrid[0]='useremail';
      clientValidation=false;
    }
  }
  $('.error').each(function (){
    $(this).remove();
  });
  if(clientValidation){
    sendForgetPasswordRequest();
  }
  else
  {
    for(var i=0; i<1; i++){
      //msg = $("<div class='errorPopup spacing' generated='true' id='remove'>"+forgetpassword.Arrmessage[i]+"</div>")
      //msg.appendTo($('#'+form+' #'+forgetpassword.Arrid[i]).parent("div"));
      msg = $('<span class="error" htmlfor="'+forgetpassword.Arrid[i]+'" generated="true" style="display: inline;" id="remove">'+forgetpassword.Arrmessage[i]+'</span>');
      msg.appendTo($('#'+form+' #'+forgetpassword.Arrid[i]).parent("p"));
    }
  }
}

function resetPasswordValidate(){
  var form = 'resetpasswordfrm';
  var resetpassword = {};
  resetpassword.Arrmessage=new Array();
  resetpassword.Arrid=new Array();
  password = $.trim($('#'+form+' #password').val());
  repassword = $.trim($('#'+form+' #repassword').val());
  var clientValidation=true;
  removeErrors();
  if (!password) {
    resetpassword.Arrmessage[0]='New Password is required. ';
    resetpassword.Arrid[0]='password';
    clientValidation=false;
  }
  else if(password.length<8){
    resetpassword.Arrmessage[0]='Please enter at least 8 characters. ';
    resetpassword.Arrid[0]='password';
    clientValidation=false;
  }
  if (!repassword) {
    resetpassword.Arrmessage[1]='Confirm Password is required. ';
    resetpassword.Arrid[1]='repassword';
    clientValidation=false;
  }
  else if(repassword.length<8){
    resetpassword.Arrmessage[1]='Please enter at least 8 characters. ';
    resetpassword.Arrid[1]='repassword';
    clientValidation=false;
  }
  if(password != '' && repassword !='' && password != repassword){
    resetpassword.Arrmessage[1]='Password mismatch.';
    resetpassword.Arrid[1]='repassword';
    clientValidation=false;
    $('#'+form+' #repassword').val("");
    $('#'+form+' #repassword').focus();
  }
  if(clientValidation){
    sendResetPasswordRequest();
  }
  else
  {
    for(var i=0; i<2; i++){
      //msg = $("<div class='errorPopup spacing' generated='true' id='remove'>"+resetpassword.Arrmessage[i]+"</div>")
      //msg.appendTo($('#'+form+' #'+resetpassword.Arrid[i]).parent("div"));
      showMessage('error',resetpassword.Arrmessage[i],'resetpasswordfrm');
    }
  }
}

function changePasswordValidate(){
  var form = 'changepasswordfrm';
  var changepassword = {};
  changepassword.Arrmessage=new Array();
  changepassword.Arrid=new Array();
  oldpassword = $.trim($('#'+form+' #oldpassword').val());
  password = $.trim($('#'+form+' #password').val());
  repassword = $.trim($('#'+form+' #repassword').val());
  var clientValidation=true;
  removeErrors();
  if (!oldpassword) {
    changepassword.Arrmessage[0]='Old Password is required. ';
    changepassword.Arrid[0]='oldpassword';
    clientValidation=false;
  }
  else if(oldpassword.length<8){
    changepassword.Arrmessage[0]='Please enter at least 8 characters. ';
    changepassword.Arrid[0]='oldpassword';
    clientValidation=false;
  }
  if (!password) {
    changepassword.Arrmessage[1]='New Password is required. ';
    changepassword.Arrid[1]='password';
    clientValidation=false;
  }
  else if(password.length<8){
    changepassword.Arrmessage[1]='Please enter at least 8 characters. ';
    changepassword.Arrid[1]='password';
    clientValidation=false;
  }
  if (!repassword) {
    changepassword.Arrmessage[2]='Confirm Password is required. ';
    changepassword.Arrid[2]='repassword';
    clientValidation=false;
  }
  else if(repassword.length<8){
    changepassword.Arrmessage[2]='Please enter at least 8 characters. ';
    changepassword.Arrid[2]='repassword';
    clientValidation=false;
  }
  if(oldpassword!="" && password!="" && repassword!="" && password != repassword){
    changepassword.Arrmessage[2]='Password mismatch.';
    changepassword.Arrid[2]='repassword';
    clientValidation=false;
    $('#'+form+' #repassword').val("");
    $('#'+form+' #repassword').focus();
  }
  $('.error').each(function (){
    $(this).remove();
  });

  if(clientValidation){
    sendChangePasswordRequest();
  }
  else
  {
    for(var i=0; i<3; i++){
      //msg = $("<div class='errorPopup spacing' generated='true' id='remove'>"+changepassword.Arrmessage[i]+"</div>")
      //msg.appendTo($('#'+form+' #'+changepassword.Arrid[i]).parent("div"));
      msg = $('<span class="error" htmlfor="'+changepassword.Arrid[i]+'" generated="true" style="display: inline;" id="remove">'+changepassword.Arrmessage[i]+'</span>');
      msg.appendTo($('#'+form+' #'+changepassword.Arrid[i]).parent("p"));
    }
  }
}

logout = function (){
  var href = window.location.href;
  var ref = document.location.hash.substr(1);
  var str = $.trim(href.substr(href.lastIndexOf('/')+1));
  /*
  if((str == 'friendsactivity') || (str == 'history')){
    href = JSWebURL;
  }else if(ref == 'play'){
    var loc = window.location.href;
    var index = loc.indexOf('#');
    if (index > 0) {
      href = loc.substring(0, index);
    }
  }
  */
  ajaxloader.loadURL(JSWebURL+'action/logout', [{
    "opt":"logout",
    "url":href
  }]);
}


changeHtml = function (params){
  try
  {
    var parms = eval('('+params+')');
    parent.isLoggedIn = true;
    parent.LoggedInUserId = parms.user_id;
    $('#SignInLink').hide();
    $('#myPage').show();
    $('#username').html(parms.username);
    $('#fname').html(parms.username);
    fillDetails(parms['username']);
    var lu = '';

    if(parms['landing_url']){
      lu = parms['landing_url'];
    }
    window.location.href = JSWebURL+lu;
  }catch (ex){}
}


fillDetails = function (username){
  try
  {
    if(typeof $('#Name').attr('id') != 'undefined')
      $('#Name').val(username);

    /*if(typeof $('#Email').attr('id') != 'undefined')
      $('#Email').val(email);
    */
    $('#Location').focus();
  }
  catch (ex)	{}
}
/* Eof Modual function */

//Remove all the error of page
function removeErrors(){
  $('.errorPopup').each(function (){
    $(this).remove();
  });
}


