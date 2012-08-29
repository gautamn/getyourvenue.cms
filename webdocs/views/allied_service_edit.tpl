<div class="module">
    <h2><span>Edit Allied Service</span></h2>

    <div class="module-body">
        <form action="" id="alliedServiceForm" enctype="multipart/form-data" method="post">
          <?php
          if(isset($msg)){?>
            <div>
              <span class="notification n-<?=$class?>"><?=$msg?></span>
            </div>
          <?php } ?>
          <div class="widthper fl">
            <div class="add-clip">
              <label>Service Name <span class="star">*</span></label>
              <p><input name="service_name" maxlength="256" type="text" class="input-short" id="service_name" value="<?php echo $records['HEADING'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Meta Title <span class="star">*</span></label>
              <p><textarea class="meta-desshort" id="meta_title" rows="4" name="meta_title"><?php echo $records['TITLE'];?></textarea></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Meta Description <span class="star">*</span></label>
              <p><textarea class="meta-desshort" id="meta_description" rows="4" name="meta_description"><?php echo $records['META_DESCRIPTION'];?></textarea></p>
              <div class="cl"></div>
            </div>
          </div>
          <div class="widthper fr">
            <div class="add-clip">
              <label>SEO ID <span class="star">*</span></label>
              <p><input name="seo_title" maxlength="256" type="text" class="input-short" id="seo_title" value="<?php echo $records['SEO_ID'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Banner Path <span class="star">*</span></label>
              <p><input name="banner_path" maxlength="256" type="text" class="input-short" id="banner_path" value="<?php echo $records['BANNER_PATH'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Jcarousel Image Path <span class="star">*</span></label>
              <p><input name="jcarousel_path" maxlength="256" type="text" class="input-short" id="jcarousel_path" value="<?php echo $records['JCAROUSEL_IMAGES_FOLDER_PATH'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Themes Url Path </label>
              <p><input name="themes_path" maxlength="256" type="text" class="input-short" id="themes_path" value="<?php echo $records['THEMES_URLS'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Meta Keywords <span class="star">*</span></label>
              <p><textarea class="meta-desshort" id="meta_keyword" rows="4" name="meta_keyword"><?php echo $records['META_KEYWORD'];?></textarea></p>
              <div class="cl"></div>
            </div>
          </div>
          <div class="cl"></div>
          <div class="">
            <label>Description <br>(HTML Content) <span class="star">*</span></label>
            <p><textarea class="meta-desshort" id="description" rows="6" style="height:300px !important;" name="description"><?php echo $records['HTML_CONTENT'];?></textarea></p>
            <div class="cl"></div>
          </div>
          <fieldset>
              <input type="hidden" name="id" value="<?php echo $records['SEO_ID'];?>" />
              <input type="hidden" name="action" value="updateAlService" />
              <input class="submit-green" type="submit" value="Update" />
              <input id="btn_cancel" class="submit-gray" type="button" value="Cancel" />
          </fieldset>
        </form>
    </div> <!-- End .module-body -->

</div>  <!-- End .module -->
<div style="clear:both;"></div>