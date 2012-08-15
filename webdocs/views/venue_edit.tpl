 <div class="module">
                     <h2><span>Update Venue</span></h2>
                        
                     <div class="module-body">
                       <form action="" id="venueForm" enctype="multipart/form-data" method="post">
                        
                            <?php 
                             extract($records);
                            if($msg){?>
                            <div>
                                <span class="notification n-<?=$class?>"><?=$msg?></span>
                            </div>
                        <? } ?>   
                            
                          <p>
                                <label>Venue Name</label>
                                <input name="venue_name" maxlength="256" type="text" class="input-short" id="venue_name" value="<?=$venue_name?>" />
                            </p>
                            
                            <p>
                                <label>Place</label>
                               
                                 <input name="place" maxlength="256" type="text" class="input-short" id="place" value="<?=$place?>" />
                            </p>
                         
                            
                            <p>
                            <fieldset>
                                <label>Description</label>
                                <textarea id="description" rows="11" cols="90" name="description"><?=$description?></textarea> 
                            </fieldset>
                            </p>
                 
                                                   
                            <p>
                                <label>Venue Poster</label>
                                <input name="image" type="file" />
                            </p>
                          <?php if($records['image']!="") {?>   
                           <p>
                              <img src="<?=facile::$web_assets_url.'venues/images/'.$records['image']?>"  height="100" /> </p>
                  				 <p>
                          <?php } ?>  
                            <fieldset>
                             <input type="hidden" name="venue_id"  value="<?=($records['venue_id'])?$records['venue_id']:$records['id']?>" />
                             <input type="hidden" name="id"  value="<?=$records['id']?>" />
                            <input type="hidden" name="action"  value="updateVenue" />
                            <input name="venue_poser" type="hidden"  value="<?=$records['poster']?>"/>
                            <input name="venue_image" type="hidden"  value="<?=$records['image']?>"/>
                                <input  class="submit-green" type="submit" value="Update" /> 
                                <input  id="btn_cancel" class="submit-gray" type="button" value="Cancel" />
                            </fieldset>
                        </form>
                     </div> <!-- End .module-body -->

                </div>  <!-- End .module -->
        		<div style="clear:both;"></div>