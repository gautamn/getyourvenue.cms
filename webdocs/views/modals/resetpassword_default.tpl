<div class="module">
  <h2><span>Reset Password</span></h2>
  <div class="module-body">
    <span id="resetpasswordfrm_notification" class="notification n-error" style="display:none;"><?=$msg?></span>
    <form name="form" method="post" id="resetpasswordfrm" autocomplete="off">
      <p>
        <label>Enter New Password:</label>
        <input type="password" class="input-medium" id="password" name="password" maxlength="30" />
      </p>
      <p>
        <label>Confirm Password:</label>
        <input type="password" class="input-medium" id="repassword" name="repassword" maxlength="30" />
      </p>
      <fieldset>
        <input class="submit-green" type="button" value="Submit" id="submIt">
        <input type="hidden" name="tokenPassword" id="tokenPassword" value="<?php echo $_GET['token'];?>">
      </fieldset>
     </form>
  </div>
</div>