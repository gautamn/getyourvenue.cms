
  <div class="module">
   <h2><span>Add Admin User</span></h2>
      
   <div class="module-body">
      <form action="" id="adminuserForm" enctype="multipart/form-data" method="post">
         <?php 
         //extract($records);
         if($msg){?>
          <div>
              <span class="notification n-<?=$class?>"><?=$msg?></span>
          </div>
          <? } ?>   
          <div class="module-body-col1">
            <p>
                <label>Name</label>
                <input name="name" type="text" class="input-medium" id="name" value="<?=$records['name']?>" />
            </p>
            
            <p>
                <label>Username</label>
                <input name="username" type="text" class="input-medium" id="username" value="<?=$records['username']?>" onBlur="javascript:check_if_username_unique();"/>
                <input type="hidden" name="is_unique_username" id="is_unique_username" value="1" />
            </p>
            
            <p>
                <label>Password</label>
                <input name="password" type="password" class="input-medium" id="password" value="" />
            </p>
            
            <p>
                <label>Email</label>
                <input name="email" type="text" class="input-medium" id="email" value="<?=$records['email']?>" />
            </p>
            
            <p>
                <label>Role</label>
                <?=get_dropdown ($arr_adminrole,'role_id',$records['role_id'],array("onChange"=>"showhideAdminUserInfo()"))?>
            </p>
            <p>
                <label>Landing URL</label>
                <input name="landing_url" type="text" class="input-short" id="landing_url" value="<?=$records['landing_url']?>" />
            </p>
            <fieldset class="field_set">
              <legend>Profile Picture</legend>
              <p>
                <input type="hidden" name="tempurl" id="tempurl" value="<?php echo facile::$web_tempfile_url;?>" />
                <input type="hidden" name="auser_photo" id="auser_photo" value="" />
                <input type="hidden" name="auser_photo_hidden" id="auser_photo_hidden" value="<?php echo $records['image'];?>" />
                <?if(!empty($records['image'])){
                  $clipArtwork = getArtworkURL('auser',$records['image'],'small');
                }
                if(!empty($auserArtwork)) {
                  $style="display :none;";
                ?>
                  <span id="container">
                    <span id="image"><img src="<?php echo $auserArtwork?>" width="60px" /></span>
                    <span><a href="javascript:void(0);" id="delete">delete</a></span>
                  </span>
                <?php
                }
                else {
                  $style="display :block;";
                }?>
                <span id="image_upload" style="<?=$style?>">
                   <a href="javascript:uploadImage('<?php echo facile::$web_url;?>action/upload_crop?type=auser&aspect_ratio=468x379','Upload Image');" title="Upload Image" id="uploadModal">Upload Image</a>
                </span>
                <span id="uploadedId"></span>
              </p>
            </fieldset>

          </div>

          <div class="module-body-col2 hideSection" id="adminUserInfo">
            <p>
                <label>Designation</label>
                <input name="designation" type="text" class="input-medium" id="designation" value="<?=$records['designation']?>" />
            </p>
      
            <p>
                <label>Facebook URL</label>
                <input name="fb_url" type="text" class="input-medium" id="fb_url" value="<?=$records['fb_url']?>" />
            </p>

      
            <p>
                <label>Twitter URL</label>
                <input name="twitter_url" type="text" class="input-medium" id="twitter_url" value="<?=$records['twitter_url']?>" />
            </p>
      
            <p>
                <label>Google Plus URL</label>
                <input name="google_plus_url" type="text" class="input-medium" id="google_plus_url" value="<?=$records['google_plus_url']?>" />
            </p>
      
            <p>
                <label>Office Phone</label>
                <input name="office_phone" type="text" class="input-medium" id="office_phone" value="<?=$records['office_phone']?>" />
            </p>

      
            <p>
                <label>Home Phone</label>
                <input name="home_phone" type="text" class="input-medium" id="home_phone" value="<?=$records['home_phone']?>" />
            </p>
      
            <p>
                <label>Mobile</label>
                <input name="mobile" type="text" class="input-medium" id="mobile" value="<?=$records['mobile']?>" />
            </p>

      
            <p>
                <label>Alternate Mobile</label>
                <input name="alternate_mobile" type="text" class="input-medium" id="alternate_mobile" value="<?php echo $records['alternate_mobile']?>" />
            </p>

            <p>
            <fieldset>
                <label>About</label>
                <textarea name="about" id="about" rows="11" cols="42"><?php echo $records['about']?></textarea> 
            </fieldset>
            </p>
          </div>
          <div style="clear:both"> </div>
          <div class="module-body-col1">
          <fieldset>
            <input type="hidden" name="action" id="adminuser_action" value="saveAdminUser" />
            
            <input class="submit-green" type="submit" value="Submit" /> 
            <input class="submit-gray" type="button" value="Cancel" onClick="javascript:window.location='<?php echo facile::$web_url;?>adminusers'"/>
          </fieldset>
          </div>
      </form>
   </div> <!-- End .module-body -->

</div>  <!-- End .module -->
<div style="clear:both;"></div>