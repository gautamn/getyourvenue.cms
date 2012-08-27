<div class="module">
    <h2><span>Add Venue</span></h2>

    <div class="module-body">
        <form action="" id="venueTypeForm" enctype="multipart/form-data" method="post">
          <?php
          if(!empty($msg)){?>
            <div>
              <span class="notification n-<?=$class?>"><?=$msg?></span>
            </div>
          <?php } ?>
          <div class="widthper fl">
            <div class="add-clip">
              <label>Venue Type Name<span class="star">*</span></label>
              <p><input name="venue_type" maxlength="256" type="text" class="input-short" id="venue_type" value="" /></p>
              <div class="cl"></div>
            </div>
          </div>
          <div class="widthper fr">
            <div class="add-clip">
              <label>Seo Title <span class="star">*</span></label>
              <p><input name="seo_title" maxlength="256" type="text" class="input-short" id="seo_title" value="" /></p>
              <div class="cl"></div>
            </div>
          </div>
          <div class="cl"></div>
          <fieldset>
              <input type="hidden" name="id" value="" />
              <input type="hidden" name="action" value="saveVenueType" />
              <input class="submit-green" type="submit" value="Save" />
              <input id="btn_cancel" class="submit-gray" type="button" value="Cancel" />
          </fieldset>
        </form>
    </div> <!-- End .module-body -->

</div>  <!-- End .module -->
<div style="clear:both;"></div>