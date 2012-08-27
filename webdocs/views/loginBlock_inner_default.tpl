  <div class="module">
    <h2><span>Admin Login</span></h2>
    <div class="module-body">
       <?php $msgClass = !empty($msg)?'':'hideSection'; ?>
       <span id="msg" class="notification n-error <?=$msgClass?>"><?=$msg?></span>
      <form enctype="text/plain" action="" id="signinform" method="post" name="signIn" autocomplete="off">
         <p>
          <label>User Name:</label>
          <input type="text" name="username" id="username" class="input-medium">
         </p>
         <p>
          <label>Password:</label>
          <input type="password" name="password" id="password" class="input-medium" value="">
         </p>
         <fieldset>
          <input class="submit-green" type="button" value="Login" id="signIn">
          <input class="submit-gray" type="reset" value="Reset">
          <a href="javascript:void(0)" onclick="forgetPassword()">Forgot password?</a>
         </fieldset>
      </form>

    </div> <!-- End .module-body -->
  </div>