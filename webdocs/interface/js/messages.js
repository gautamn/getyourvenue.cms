function ShowMessage(msgid,type,title,notification){
  var showmessages = new Array();
	showmessages[0]={'title':'Rating','msg':'Thank You <div>Your Ratings Has Been Recorded.</div>','type':'star txt','timeout':'3000','width':'400','imgClass':'thankYou'};
	showmessages[1]={'title':'Registration','msg':'Congrats! Registration is successful. Activation code will be sent you shortly via email','type':'confirm txt','timeout':'3000','width':'','':''};
	showmessages[2]={'title':'Registration','msg':'Sign up ID already exist!','type':'confirm txt','timeout':'3000'};
	showmessages[3]={'title':'Registration','msg':'You Are Already Registered.<div>Please Click <a onclick="forgetPassword();" href="javascript:void(0)"><strong>Forgot Password</strong></a> To Retrieve Your Password and Log In.</div>','type':'confirm txt','timeout':'15000','width':'645','imgClass':'PasswordChanged'};
	showmessages[4]={'title':'Forgot Password','msg':'<div class="msg">Your Password Has Been Changed Successfully.</div>','type':'confirm txt','timeout':'3000','width':'588','imgClass':'PasswordChanged'};
	showmessages[5]={'title':'Social Connect','msg':'Social connect settings has updated successfully!','type':'confirm txt','timeout':'3000','width':'538','imgClass':'settingSaved'};
	showmessages[6]={'title':'Profile','msg':'Profile updated successfully!','type':'confirm txt','timeout':'3000'};
	showmessages[7]={'title':'Clip Added','msg':'<div class="msg">The clip has been added to your queue.</div>','type':'confirm txt','timeout':'3000','width':'454','imgClass':'clipAdded'};
	showmessages[8]={'title':'Review','msg':'<div class="msg"><span>To Post A Review, Please </span><a href="javascript:void(0)" onclick="register()"><strong>Register/</strong></a><a href="javascript:void(0)" onclick="login.init()"><strong>Login.</strong></a></div>','type':'confirm txt','timeout':'3000','width':'450','imgClass':'postReview'};
	showmessages[9]={'title':'Comment','msg':'<div class="msg"><span>To Post A Comment, Please </span><a href="javascript:void(0)" onclick="register()"><strong>Register/</strong></a><a href="javascript:void(0)" onclick="login.init()"><strong>Login.</strong></a></div>','type':'confirm txt','timeout':'3000','width':'470','imgClass':'postReview'};
	showmessages[10]={'title':'Clip Removed','msg':'<div class="msg">Selected Clip Removed Successfully.</div>','type':'confirm txt','timeout':'3000','width':'482','imgClass':'clipRemove'};
	showmessages[11]={'title':'Clip Rate','msg':'<div class="msg">Please <a href="javascript:void(0)" onclick="login.init()"><strong>Register/Login</strong></a> With Us To Rate This Clip.</div>','type':'confirm txt','timeout':'3000','width':'520','imgClass':'rateClip'};
	showmessages[12]={'title':'Clip Added','msg':'<form id="confirmForm" method="post" name="confirmForm">Do you want to clear <span id="qval">My Queue</span>?<br /><input type="button" onclick="javascript:clearQ();" value="Yes" name="yes"><input type="button" onclick="closeConfirm();" value="No" name="no"></form>','type':'confirm txt','timeout':'3000000','width':'475','imgClass':'clipAdded'};
	showmessages[13]={'title':'Clip Added','msg':'<form id="confirmForm" method="post" name="confirmForm">Do you want to clear <span id="qval">My History</span>?<br /><input type="button" onclick="javascript:clearQ();" value="Yes" name="yes"><input type="button" onclick="closeConfirm();" value="No" name="no"></form>','type':'confirm txt','timeout':'3000000','width':'475','imgClass':'clipAdded'};
	showmessages[14]={'title':'','msg':'Please select clip for remove','type':'confirm txt','timeout':'3000','width':'','imgClass':''};
	showmessages[15]={'title':'','msg':'Please select clip for add to queue','type':'confirm txt','timeout':'3000','width':'','':''};
	showmessages[16]={'title':'','msg':'Please select clip for add to public','type':'confirm txt','timeout':'3000','width':'','':''};
	showmessages[17]={'title':'','msg':'Please select clip for add to private','type':'confirm txt','timeout':'3000','width':'','':''};
	showmessages[18]={'title':'','msg':'Clip added to private list ','type':'confirm txt','timeout':'3000','width':'','':''};
	showmessages[19]={'title':'','msg':'Clip added to public list ','type':'confirm txt','timeout':'3000','width':'','':''};
	showmessages[20]={'title':'','msg':'Clip added to queue list ','type':'confirm txt','timeout':'3000','width':'','':''};
	showmessages[21]={'title':'Clip Added','msg':'<form id="confirmFormRem" method="post" name="confirmFormRem">Do you want to remove item from  <span id="qval">My Queue</span>?<br /><input type="hidden" name="qval" id="qval" value=""><input type="button" onclick="javascript:clipQueueDel();closeConfirm(); " value="Yes" name="yes"><input type="button" onclick="closeConfirm();" value="No" name="no"></form>','type':'confirm txt','timeout':'3000000','width':'600','imgClass':'clipAdded'};
	showmessages[22]={'title':'Clip Added','msg':'<form id="confirmFormRem" method="post" name="confirmFormRem">Do you want to remove item from  <span id="qval">My History</span>?<br /><input type="hidden" name="qval" id="qval" value=""><input type="button" onclick="javascript:clipHistoryQDel();closeConfirm();" value="Yes" name="yes"><input type="button" onclick="closeConfirm();" value="No" name="no"></form>','type':'confirm txt','timeout':'3000000','width':'600','imgClass':'clipAdded'};
	showmessages[23]={'title':'Clip Added','msg':'<form id="confirmFormRem" method="post" name="confirmFormRem">Do you want to remove item from  <span id="qval">My Queue</span>?<br /><input type="hidden" name="qval" id="qval" value=""><input type="button" onclick="javascript:removeQueueItem(document.getElementById(\'qval\').value);closeConfirm();" value="Yes" name="yes"><input type="button" onclick="closeConfirm();" value="No" name="no"></form>','type':'confirm txt','timeout':'3000000','width':'600','imgClass':'clipAdded'};
	showmessages[24]={'title':'','msg':'Account settings updated successfully','type':'confirm txt','timeout':'2000','width':'','':''};
	showmessages[25]={'title':'','msg':'Account deactivated successfully','type':'confirm txt','timeout':'3000','width':'','':''};
	showmessages[26]={'title':'','msg':'Are you sure you want to delete account? <br /><input type="button" name="yes" id="yes" value="Yes" style="margin:4px;" onclick="javascript:settings.deactivateAccount()"><input type="button" name="no" id="no" value="No" onClick="settings.closeConfirmDeactivateAccount()">','type':'confirm txt','timeout':'3000000','width':'550'};
	showmessages[27]={'title':'','msg':'Current password do not match with existing password','type':'confirm txt','timeout':'2000','width':'','':''};
	showmessages[28]={'title':'Clip Added','msg':'<form id="confirmFormRem" method="post" name="confirmFormRem">Do you want to remove item from  <span id="qval">My Queue</span>?<br /><input type="hidden" name="qval" id="qval" value=""><input type="button" onclick="javascript:removeQueuePageItem(document.getElementById(\'qval\').value,\'q\');closeConfirm();" value="Yes" name="yes"><input type="button" onclick="closeConfirm();" value="No" name="no"></form>','type':'confirm txt','timeout':'3000000','width':'600','imgClass':'clipAdded'};
	showmessages[29]={'title':'Registration','msg':'Registered successfully!','type':'confirm txt','timeout':'3000','width':'','':''};
	showmessages[30]={'title':'Invitation','msg':'Invitation will be sent by your email!','type':'confirm txt','timeout':'3000','width':'478'};
	showmessages[31]={'title':'Invitation','msg':'Invitation has been already sent!','type':'confirm txt','timeout':'3000','width':'478'};
	showmessages[32]={'title':'Favorite','msg':'<div class="msg"><span>To Favorite, Please </span><a href="javascript:void(0)" onclick="login.init()"><strong>Register/Login.</strong></a></div>','type':'confirm txt','timeout':'3000','width':'450','imgClass':'postReview'};
	showmessages[33]={'title':'Review Added','msg':'<div class="msg">Review Added Successfully.</div>','type':'confirm txt','timeout':'3000','width':'454','imgClass':'Review'};
	showmessages[34]={'title':'Comment Added','msg':'Comment Added Successfully.','type':'confirm txt','timeout':'3000','width':'454','imgClass':'Comment'};
	showmessages[35]={'title':'Favorite Added','msg':'<div class="msg">Clip added to Favorites.</div>','type':'confirm txt','timeout':'3000','width':'454','imgClass':'Favorite'};
	showmessages[36]={'title':'Favorite Removed','msg':'<div class="msg">Clip removed from Favorites.</div>','type':'confirm txt','timeout':'3000','width':'454','imgClass':'Favorite'};
	showmessages[37]={'title':'Registration','msg':'Invalid Username or Password!','type':'confirm txt','timeout':'2000'};
	showmessages[38]={'title':'Forget Password','msg':'Wrong Data Supplied!','type':'confirm txt','timeout':'5000'};
	showmessages[39]={'title':'Forget Password','msg':'Password send to registered email address.','type':'confirm txt','timeout':'5000'};
	showmessages[40]={'title':'Reset Password','msg':'Try it again...','type':'confirm txt','timeout':'2000'};
	showmessages[41]={'title':'Reset Password','msg':'Your password has been changed successfully.','type':'confirm txt','timeout':'2000'};
	showmessages[42]={'title':'Forget Password','msg':'Sorry!! an error encountered due to some technical problem, please try again later.','type':'confirm txt','timeout':'5000'};
	showmessages[43]={'title':'Please Login','msg':'Please login to browse this page.','type':'confirm txt','timeout':'2000'};
	showmessages[44]={'title':'Change Password','msg':'Try it again...','type':'confirm txt','timeout':'2000'};
	showmessages[45]={'title':'Change Password','msg':'Your password has been changed successfully.','type':'confirm txt','timeout':'2000'};
	showmessages[46]={'title':'Change Password','msg':'Current password do not match with existing password.','type':'confirm txt','timeout':'3000'};
  showmessages[47]={'title':'Set Priority','msg':'Priority has been changed.','type':'confirm txt','timeout':'3000'};
  showmessages[48]={'title':'Set Priority','msg':'Invalid data, Unable to set priority.','type':'confirm txt','timeout':'3000'};
	showmessages[49]={'title':'Home Slider','msg':'Removed from Home slider successfully.','type':'confirm txt','timeout':'3000'};
  showmessages[50]={'title':'Home Slider','msg':'Unable to process your request.','type':'confirm txt','timeout':'3000'};
  showmessages[51]={'title':'Featured Poster','msg':'Featured Poster has been updated successully.','type':'confirm txt','timeout':'3000'};
  showmessages[52]={'title':'Live Mid Roles','msg':'Record has been updated.','type':'confirm txt','timeout':'3000'};
	var _id = msgid.toString().replace(/[^0-9]/,'');

	if(notification == 'Y'){
		$('.notification').css({'display':'block'});
		$('.notification').html(showmessages[msgid]['msg']);
    if(type != ''){
      $('.notification').removeClass('n-error');
      $('.notification').removeClass('n-success');
      $('.notification').removeClass('hideSection');
      $('.notification').addClass('n-'+type);
    }

		//setTimeout("removeMessage()",showmessages[msgid]['timeout']);
	}else{
		if(_id.length){
			lightModal.messageBox(showmessages[msgid]);
		}else{
			var message = {'title':'','msg':msgid,'type': type + ' txt','timeout':'3000'};
			lightModal.messageBox(message);
		}
	}
	//alert($(showmessages[msgid]['msg']).text());
}

function removeMessage(){
	$('#notification').fadeOut(500);
}

/*
  * show alert message
  */


var INVALID_URL = "Invalid URL";
var INVALID_DATE = "Invalid date";
var INVALID_DATETIME = "Invalid date time";
var DATETIME_MASKING_PATTERN = '9999-99-99 99:99:99';
var DATE_MASKING_PATTERN ='9999-99-99';
var TIME_MASKING_PATTERN = '99:99:99';
var SERACH_VALIDATION_TEXT ='Please enter keyword to search';