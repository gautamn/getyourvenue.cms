 <div class="module">
    <h2><span>Edit Venue</span></h2>
    <div class="module-body">
        <form action="" id="venueForm" enctype="multipart/form-data" method="post">
          <?php
          if(isset($msg)){?>
            <div>
              <span class="notification n-<?=$class?>"><?=$msg?></span>
            </div>
          <?php } ?>
          <div class="widthper fl">
            <div class="add-clip">
                <label>Region Name <span class="star">*</span></label>
                <p><select id="region" name="region">
                <option value="">- Select Region -</option>
                <?php
                if(!empty($regionList)){
                  foreach($regionList as $region){?>
                    <option value="<?php echo $region['regionid'];?>"<?php echo ($records['regionid']==$region['regionid']) ? ' selected="selected"' :'';?>><?php echo $region['regionname'];?></option>
                  <?php }
                  }?>
                </select></p>
                <div class="cl"></div>
            </div>
            <div class="add-clip">
                <label>Venue Type <span class="star">*</span></label>
                <p><select id="venueType" name="venueType" size="5" multiple="multiple">
                <option>- Select Venue Type -</option>
                <?php
                $arrayTempVenue = array();
                if(!empty($records['venueType'])){
                  foreach($records['venueType'] as $vType){
                    $arrayTempVenue[] = $vType['venuetypeid'];
                  }
                }
                if(!empty($typeList)){
                  foreach($typeList as $type){?>
                    <option value="<?php echo $type['venuetypeid'];?>"<?php echo (in_array($type['venuetypeid'], $arrayTempVenue)) ? ' selected="selected"':'';?>><?php echo $type['type'];?></option>
                    <?php
                  }
                }?>
                </select></p>
                <div class="cl"></div>
            </div>
            <div class="add-clip">
                <label>Capacity <span class="star">*</span></label>
                <p><select id="venuecapacity" size="5" multiple="multiple" name="venuecapacity">
                <option>- Select Venue Capacity -</option>
                <?php
                $arrayTempCapacity = array();
                if(!empty($records['venueCapcity'])){
                  foreach($records['venueCapcity'] as $vCap){
                    $arrayTempCapacity[] = $vCap['capacityid'];
                  }
                }
                if(!empty($capacityList)){
                  foreach($capacityList as $capacity){?>
                    <option value="<?php echo $capacity['capacityid'];?>"<?php echo (in_array($capacity['capacityid'], $arrayTempCapacity))? ' selected="selected"':'';?>><?php echo $capacity['range'];?></option>
                    <?php
                  }
                }?>
                </select></p>
                <div class="cl"></div>
            </div>
            <div class="add-clip">
                <label>Popularity <span class="star">*</span></label>
                <p><select id="popular" name="popular">
                <option>- Select Popular Choice-</option>
                <?php
                if(!empty($popularChoiceList)){
                  foreach($popularChoiceList as $popular){?>
                    <option value="<?php echo $popular['popularchoiceid'];?>"<?php echo ($records['popular_choice']==$popular['popularchoiceid']) ? ' selected="selected"': '';?>><?php echo $popular['popularchoicename'];?></option>
                    <?php
                  }
                }?>
                </select></p>
                <div class="cl"></div>
            </div>

            <div class="add-clip">
              <label>Meta Title <span class="star">*</span></label>
              <p><textarea class="meta-desshort" id="meta_title" rows="4" name="meta_title"><?php echo $records['title'];?></textarea></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Meta Description <span class="star">*</span></label>
              <p><textarea class="meta-desshort" id="meta_description" rows="4" name="meta_description"><?php echo $records['meta_description'];?></textarea></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Meta Keywords</label>
              <p><textarea class="meta-desshort" id="meta_keyword" rows="4" name="meta_keyword"><?php echo $records['meta_keyword'];?></textarea></p>
              <div class="cl"></div>
            </div>
          </div>
          <div class="widthper fr">
            <div class="add-clip">
              <label>Venue Name <span class="star">*</span></label>
              <p><input name="venue_name" maxlength="256" type="text" class="input-short" id="venue_name" value="<?php echo $records['name'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>SEO Id <span class="star">*</span></label>
              <p><input name="seo_title" maxlength="256" type="text" class="input-short" id="seo_title" value="<?php echo $records['venueid'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Rank <span class="star">*</span></label>
              <p><input name="venue_rank" maxlength="256" type="text" class="input-short" id="venue_rank" value="<?php echo $records['rank'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Venue Address 1 <span class="star">*</span></label>
              <p><input name="address1" maxlength="256" type="text" class="input-short" id="address1" value="<?php echo $records['address1'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Venue Address 2</label>
              <p><input name="address2" maxlength="256" type="text" class="input-short" id="address2" value="<?php echo $records['address2'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Image Alt Tag <span class="star">*</span></label>
              <p><input name="image_alt" maxlength="256" type="text" class="input-short" id="image_alt" value="<?php echo $records['image_alt_tag'];?>" /></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Description <span class="star">*</span></label>
              <p><textarea class="meta-desshort" id="description" rows="6" style="height:300px !important;" name="description"><?php echo $records['content'];?></textarea></p>
              <div class="cl"></div>
            </div>
            <div class="add-clip">
              <label>Google Map Code</label>
              <p><textarea class="meta-desshort" id="iframe_code" rows="6" name="iframe_code"><?php echo $records['iframe'];?></textarea></p>
              <div class="cl"></div>
            </div>
          </div>
          <div class="cl"></div>

          <?php if($records['image']!="") {?>
          <p>
              <img src="<?php echo facile::$web_assets_url.'venues/images/'.$records['image']?>" height="100" /> </p>
          <p>
          <?php } ?>
          <fieldset>
            <input type="hidden" name="venue_id" value="<?php echo ($records['venue_id'])?$records['venue_id']:$records['id'];?>" />
            <input type="hidden" name="id"  value="<?php echo $records['id'];?>" />
            <input type="hidden" name="action"  value="updateVenue" />
            <input  class="submit-green" type="submit" value="Update" />
            <input  id="btn_cancel" class="submit-gray" type="button" value="Cancel" />
          </fieldset>
        </form>
     </div> <!-- End .module-body -->
  </div>  <!-- End .module -->
<div style="clear:both;"></div>