<div class="module">
  <h2><span>Change Password</span></h2>  
  <div class="module-body">
    <form name="form" method="post" id="changepasswordfrm" autocomplete="off">
      <p>
        <label>Enter Old Password</label>
        <input type="password" class="input-medium" id="oldpassword" name="oldpassword" maxlength="30" />
      </p>
      <p>
        <label>Enter New Password</label>
        <input type="password" class="input-medium" id="password" name="password" maxlength="30" />
      </p>
      <p>
        <label>Confirm Password</label>
        <input type="password" class="input-medium" id="repassword" name="repassword" maxlength="30" />
      </p>
      <fieldset>
        <input class="submit-green" type="button" value="Submit" id="submIt">
        <input class="submit-gray" type="button" value="Cancel" id="cancel" onClick="javascript:window.location='<?php echo facile::$web_url;?>'">
      </fieldset>
    </form>
  </div>
</div>