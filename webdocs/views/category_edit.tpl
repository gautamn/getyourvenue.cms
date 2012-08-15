  <div class="module">
  <h2><span>Update Category</span></h2>
      
   <div class="module-body">
      <form action="" id="categoryForm" method="post">
      
          <?php 
          //extract($records);
          $msgClass = ($msg)?'':'hideSection'; 
          ?>
          <div>
              <span class="notification n-<?=$class?> <?=$msgClass?>"><?=$msg?></span> 
          </div>
             
          <div class="add-clip">
              <label>Category Name</label>
              <p><input name="name" type="text" class="input-short" id="name" value="<?=$records['name']?>"  onBlur="javascript: if($('#type').val()){check_if_category_unique(0);}" />
              <input type="hidden" name="is_unique_name" id="is_unique_name" value="1" />
              <?php
              view::$jsInPage .= " check_if_category_unique(0); ";
              ?></p>
              <div class="cl"></div>
          </div>
          
          <div class="add-clip">
              <label>Type</label>
              <p><?=get_dropdown ($arr_types,'type',$records['type'],array("onChange"=>"check_if_category_unique(1)"))?>
          </p>
          <div class="cl"></div>
          </div>

          <div class="add-clip">
              <label>Parent Category</label>
              <p><span id="categoryDD"><?=get_dropdown ($arr_categories,'parent_id',$records['parent_id'],array("onChange"=>"check_if_category_unique(1)"),"None")?></span>
          </p>
              <div class="cl"></div>
          </div>
          
          <div class="add-clip">
              <label>Priority</label>
              <p><input name="priority" type="text" class="input-short" id="priority" value="<?=$records['priority']?>" /></p>
              <div class="cl"></div>
          </div>
          
          <div class="add-clip">
              <label>Seo Key</label>
              <p><input type="text" class="input-sort" name="seokey" id="seokey" value="<?=$records['seokey']?>" /></p>
              <div class="cl"></div>
          </div>
          
          <div class="add-clip">
              <label>Meta Title</label>
              <p><input type="text" class="input-short" name="meta_title" id="meta_title" value="<?=$records['meta_title']?>" /></p>
              <div class="cl"></div>
          </div>

          <div class="add-clip">
              <label>Meta Description</label>
              <p><input type="text" class="input-short" name="meta_description" id="meta_description" value="<?=$records['meta_description']?>" /></p>
              <div class="cl"></div>
          </div>

          <div class="add-clip">
              <label>Meta Keyword</label>
              <p><input type="text" class="input-short" name="meta_keyword" id="meta_keyword" value="<?=$records['meta_keyword']?>" /></p>
              <div class="cl"></div>
          </div>

          <div style="clear:both;"></div>
          <fieldset>
            <input type="hidden" name="action"  value="updateCategory" />
            <input type="hidden" name="id" id="id" value="<?=$records['id']?>" />
            
            <input class="submit-green" type="submit" value="Update" /> 
            <input class="submit-gray" type="button" value="Cancel" onClick="javascript:window.location='<?php echo facile::$web_url;?>categories'" /> 
          </fieldset>
      </form>
   </div> <!-- End .module-body -->

</div>  <!-- End .module -->
<div style="clear:both;"></div>