 <div class="module">
    <h2><span>Edit Venue</span></h2>
<?php //echo '<pre>';
print_r($records); ?>
    <div class="module-body">
        <form action="" id="venueForm" enctype="multipart/form-data" method="post">
          <?php
          if(isset($msg)){?>
            <div>
              <span class="notification n-<?=$class?>"><?=$msg?></span>
            </div>
          <?php } ?>
          <p>
              <label>Region Name</label>
              <select id="region" name="region">
                <option value="">- Select Region -</option>
                <?php
                if(!empty($regionList)){
                  foreach($regionList as $region){?>
                    <option value="<?php echo $region['regionid'];?>"<?php echo ($records['regionid']==$region['regionid']) ? ' selected="selected"' :'';?>><?php echo $region['regionname'];?></option>
                  <?php
                  }
                }?>
              </select>
          </p>
          <p>
              <label>Venue Type</label>
              <select id="venueType" size="5" multiple="multiple">
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
              </select>
          </p>
          <p>
              <label>Capacity</label>
              <select id="venuecapacity" size="5" multiple="multiple" name="venuecapacity">
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
              </select>
          </p>
          <p>
              <label>Popularity</label>
              <select id="popular" name="popular">
                <option>- Select Popular Choice-</option>
                <?php
                if(!empty($popularChoiceList)){
                  foreach($popularChoiceList as $popular){?>
                    <option value="<?php echo $popular['popularchoiceid'];?>"<?php echo ($records['popular_choice']==$popular['popularchoiceid']) ? ' selected="selected"': '';?>><?php echo $popular['popularchoicename'];?></option>
                    <?php
                  }
                }?>
              </select>
          </p>
          <p>
              <label>Venue Name</label>
              <input name="venue_name" maxlength="256" type="text" class="input-short" id="venue_name" value="<?php echo $records['name'];?>" />
          </p>
          <p>
              <label>SEO Id</label>
              <input name="seo" maxlength="256" type="text" class="input-short" id="seo" value="<?php echo $records['venueid'];?>" />
          </p>
          <p>
              <label>Rank</label>
              <input name="venue_rank" maxlength="256" type="text" class="input-short" id="venue_rank" value="<?php echo $records['rank'];?>" />
          </p>
          <p>
              <label>Venue Address 1 *</label>
              <input name="address1" maxlength="256" type="text" class="input-short" id="address1" value="<?php echo $records['address1'];?>" />
          </p>
          <p>
              <label>Venue Address 2</label>
              <input name="address2" maxlength="256" type="text" class="input-short" id="address2" value="<?php echo $records['address2'];?>" />
          </p>
          <p>
              <label>Description</label>
              <textarea class="meta-des" id="description" rows="6" name="description"><?php echo $records['content'];?></textarea>
          </p>
          <p>
              <label>Google Map iFrame Code</label>
              <textarea class="meta-des" id="description" rows="6" name="description"><?php echo $records['iframe'];?></textarea>
          </p>
          <p>
              <label>Meta Title</label>
              <textarea class="meta-des" id="meta_title" rows="6" name="meta_title"><?php echo $records['title'];?></textarea>
          </p>
          <p>
              <label>Meta Description</label>
              <textarea class="meta-des" id="meta_description" rows="6" name="meta_description"><?php echo $records['meta_description'];?></textarea>
          </p>
          <p>
              <label>Meta Keywords</label>
              <textarea class="meta-des" id="meta_keyword" rows="6" name="meta_keyword"><?php echo $records['meta_keyword'];?></textarea>
          </p>
          <?php if($records['image']!="") {?>
          <p>
              <img src="<?=facile::$web_assets_url.'venues/images/'.$records['image']?>"  height="100" /> </p>
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