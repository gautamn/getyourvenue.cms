

  <div class="module">
  <h2><span>Add Category</span></h2>
      
   <div class="module-body">
      <form action="" id="categoryForm" method="post">
      
          <?php 
          //extract($records);
          $msgClass = ($msg)?'':'hideSection'; 
          ?>
          <div>
              <span class="notification n-<?=$class?> <?=$msgClass?>"><?=$msg?></span> 
          </div>
             
          <p>
              <label>Category Name</label>
              <input name="name" type="text" class="input-short" id="name" value="<?=$records['name']?>" onBlur="javascript: if($('#type').val()){check_if_category_unique(0);}"/>
              <input type="hidden" name="is_unique_name" id="is_unique_name" value="1" />
              <?php
              view::$jsInPage .= " check_if_category_unique(0); ";
              ?>
          </p>
          
          <p>
              <label>Type</label>
              <?=get_dropdown ($arr_types,'type',$records['type'],array("onChange"=>"check_if_category_unique(1)"))?> 
          </p>

          <p>
              <label>Parent Category</label>
              <span id="categoryDD"><?=get_dropdown ($arr_categories,'parent_id',$records['parent_id'],array("onChange"=>"check_if_category_unique(0)"),"None")?></span>
          </p>
          
          <p>
              <label>Priority</label>
              <input name="priority" type="text" class="input-short" id="priority" value="<?=$records['priority']?>" />
          </p>

          <p>
              <label>Meta Title</label>
              <input type="text" class="input-short" name="meta_title" id="meta_title" value="<?=$records['meta_title']?>" />
          </p>

          <p>
              <label>Meta Description</label>
              <input type="text" class="input-short" name="meta_description" id="meta_description" value="<?=$records['meta_description']?>" />
          </p>

          <p>
              <label>Meta Keyword</label>
              <input type="text" class="input-short" name="meta_keyword" id="meta_keyword" value="<?=$records['meta_keyword']?>" />
          </p>

          <div style="clear:both;"></div>
          <fieldset>
            <input type="hidden" name="action"  value="saveCategory" />
            
            <input class="submit-green" type="submit" value="Save" /> 
            <input class="submit-gray" type="button" value="Cancel" onClick="javascript:window.location='<?php echo facile::$web_url;?>categories'" /> 
          </fieldset>
      </form>
   </div> <!-- End .module-body -->

</div>  <!-- End .module -->
<div style="clear:both;"></div>