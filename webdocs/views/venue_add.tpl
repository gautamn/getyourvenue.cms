<div class="module">
    <h2><span>Add Venue</span></h2>

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
                  foreach($regionList as $region){
                    echo "<option value='".$region['regionid']."'>".$region['regionname']."</option>";
                  }
                }?>
              </select>
          </p>
          <p>
              <label>Venue Type</label>
              <select id="venueType" size="5" multiple="multiple">
                <option>- Select Venue Type -</option>
                <?php
                if(!empty($typeList)){
                  foreach($typeList as $type){
                    echo "<option value='".$type['venuetypeid']."'>".$type['type']."</option>";
                  }
                }?>
              </select>
          </p>
          <p>
              <label>Capacity</label>
              <select id="venuecapacity" size="5" multiple="multiple" name="venuecapacity">
                <option>- Select Venue Capacity -</option>
                <?php
                if(!empty($capacityList)){
                  foreach($capacityList as $capacity){
                    echo "<option value='".$capacity['capacityid']."'>".$capacity['range']."</option>";
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
                  foreach($popularChoiceList as $popular){
                    echo "<option value='".$popular['popularchoiceid']."'>".$popular['popularchoicename']."</option>";
                  }
                }?>
              </select>
          </p>
          <p>
              <label>Venue Name</label>
              <input name="venue_name" maxlength="256" type="text" class="input-short" id="venue_name" value="" />
          </p>
          <p>
              <label>SEO Id</label>
              <input name="seo" maxlength="256" type="text" class="input-short" id="seo" value="" />
          </p>
          <p>
              <label>Rank</label>
              <input name="venue_rank" maxlength="256" type="text" class="input-short" id="venue_rank" value="" />
          </p>
          <p>
              <label>Venue Address 1 *</label>
              <input name="address1" maxlength="256" type="text" class="input-short" id="address1" value="" />
          </p>
          <p>
              <label>Venue Address 2</label>
              <input name="address2" maxlength="256" type="text" class="input-short" id="address2" value="" />
          </p>
          <p>
              <label>Description</label>
              <textarea class="meta-des" id="description" rows="6" name="description"></textarea>
          </p>
          <?php if($records['image']!="") {?>
          <p>
              <img src="<?=facile::$web_assets_url.'venues/images/'.$records['image']?>"  height="100" /> </p>
          <p>
          <?php } ?>
          <fieldset>
              <input type="hidden" name="id" value="<?=$records['id']?>" />
              <input type="hidden" name="action"  value="saveVenue" />
              <input name="venue_image" type="hidden"  value="<?=$records['image']?>"/>
              <input class="submit-green" type="submit" value="Submit" />
              <input id="btn_cancel"  class="submit-gray" type="button" value="Cancel" />
          </fieldset>
        </form>
    </div> <!-- End .module-body -->

</div>  <!-- End .module -->
<div style="clear:both;"></div>