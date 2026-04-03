<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		Module_Dating
 */
?>
{if $bIsEdit}
<form method="post" action="{url link='admincp.dating.join' id=$iEditId}" enctype="multipart/form-data">
	<div><input type="hidden" name="val[edit_id]" value="{$iEditId}" /></div>
	<div><input type="hidden" name="val[join_title]" value="{$aForms.join_title}" /></div>
{else}
<form method="post" action="{url link='admincp.dating.join'}" enctype="multipart/form-data">
{/if}

    <div class="table form-group">
        <div class="table_left">
            {_p var='Join Title'}:
        </div>
        <div class="table_right">
            <input type="text" name="val[join_title]" value="{if !empty($aForms.join_title)}{$aForms.join_title}{/if}"  maxlength="100"/>
        </div>
        <div class="clear"></div>
    </div>
	
	
	<div class="table form-group">
        <div class="table_left">
            {_p var='Join Description'}:
        </div>
        <div class="table_right">
            <input type="text" name="val[join_text_description]" value="{if !empty($aForms.join_text_description)}{$aForms.join_text_description}{/if}"  maxlength="1000"/>
        </div>
        <div class="clear"></div>
    </div>
	
	<div class="table form-group">
        <div class="table_left">
            {_p var='Join Button Text'}:
        </div>
        <div class="table_right">
            <input type="text" name="val[join_button_text]" value="{if !empty($aForms.join_button_text)}{$aForms.join_button_text}{/if}"  maxlength="100"/>
        </div>
        <div class="clear"></div>
    </div>
	
	<div class="table form-group">
        <div class="table_left">
            {_p var='Image'}:
        </div>
        <div class="table_right">
		
			{if $aForms.image_path}
			<img src="{$aForms.image_path}" width="250px" />
			<input type="hidden" name="val[image_path]" value="{if !empty($aForms.image_path)}{$aForms.image_path}{/if}"  />
				{/if}
				<br/>
           <input 
			  type="file" 
			  name="product_image" 
			  accept="image/*"
			/>
        </div>
        <div class="clear"></div>
    </div>


	<div class="table_clear">
		<input type="submit" value="{_p var='submit'}" class="button btn-primary" />
	</div>
</form>