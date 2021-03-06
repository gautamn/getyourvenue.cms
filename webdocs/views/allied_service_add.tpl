<div class="module">
    <h2><span>Add Allied Service</span></h2>

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
              <p><input name="service_name" maxlength="100" type="text" class="input-short" id="service_name" value="" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Meta Title </label>
              <p><textarea class="meta-desshort" id="meta_title" rows="4" name="meta_title"></textarea></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Meta Description </label>
              <p><textarea class="meta-desshort" id="meta_description" rows="4" name="meta_description"></textarea></p>
              <div class="cl"></div>
            </div>
          </div>
          <div class="widthper fr">
            <div class="add-clip">
              <label>SEO ID <span class="star">*</span></label>
              <p><input name="seo_title" maxlength="100" type="text" class="input-short" id="seo_title" value="" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Banner Path </label>
              <p><input name="banner_path" maxlength="100" type="text" class="input-short" id="banner_path" value="" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Jcarousel Image Path</label>
              <p><input name="jcarousel_path" maxlength="100" type="text" class="input-short" id="jcarousel_path" value="" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Themes Url Path </label>
              <p><input name="themes_path" maxlength="450" type="text" class="input-short" id="themes_path" value="" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Meta Keywords </label>
              <p><textarea class="meta-desshort" id="meta_keyword" rows="4" name="meta_keyword"><?php echo $records['META_KEYWORD'];?></textarea></p>
              <div class="cl"></div>
            </div>
          </div>
          <div class="cl"></div>

          <div class="">
            <label>Description <br>(HTML Content) <span class="star">*</span></label>
            <p><textarea class="meta-desshort" id="description" rows="6" style="height:300px !important;" name="description"></textarea></p>
            <div class="cl"></div>
          </div>
          <fieldset>
              <input type="hidden" name="id" value="" />
              <input type="hidden" name="action" value="saveAlService" />
              <input class="submit-green" type="submit" value="Save" />
              <input id="btn_cancel" class="submit-gray" type="button" value="Cancel" />
          </fieldset>
        </form>
    </div> <!-- End .module-body -->

</div>  <!-- End .module -->
<div style="clear:both;"></div>