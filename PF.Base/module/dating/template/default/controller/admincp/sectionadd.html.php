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
{literal}
<script>
function toggleSubSection(value) {
    const elements = document.querySelectorAll('.not_for_subsection');

    elements.forEach(el => {
        if (value) {
            el.style.display = 'none';
        } else {
            el.style.display = '';
        }
    });
}

const select = document.querySelector('select[name="val[parent_id]"]');
    if (select) {
        toggleSubSection(select.value);
    }
	
// 🔁 Run on page load (important for edit form)
document.addEventListener('DOMContentLoaded', function () {
    const select = document.querySelector('select[name="val[parent_id]"]');
    if (select) {
        toggleSubSection(select.value);
    }
});
</script>

{/literal}
{if $bIsEdit}
<form method="post" action="{url link='admincp.dating.sectionadd' id=$iEditId}" enctype="multipart/form-data">
	<div><input type="hidden" name="val[edit_id]" value="{$iEditId}" /></div>
	<div><input type="hidden" name="val[title]" value="{$aForms.title}" /></div>
{else}
<form method="post" action="{url link='admincp.dating.sectionadd'}" enctype="multipart/form-data">
{/if}

    <div class="table form-group">
        <div class="table_left">
            {_p var='Title'}:
        </div>
        <div class="table_right">
            <input type="text" class="form-control" name="val[section_name]" value="{if !empty($aForms.section_name)}{$aForms.section_name}{/if}"  maxlength="100"/>
        </div>
        <div class="clear"></div>
    </div>
	
	<div class="table form-group">
        <div class="table_left">
            {_p var='Parent Section'}:
        </div>
        <div class="table_right">
            <select name='val[parent_id]' class="form-control"  onchange="toggleSubSection(this.value)">
				<option value="">Select</option>
				{foreach from=$aSections item=section key=iKey}
					<option value="{$section.section_id}" {if !empty($aForms.parent_id) && $aForms.parent_id == $section.section_id} selected{/if}>{$section.section_name}</option>
				{/foreach}
			</select>
        </div>
        <div class="clear"></div>
    </div>
	<div class="table form-group not_for_subsection">
        <div class="table_left">
            {_p var='Backgroud Color'}:
        </div>
        <div class="table_right">
            <input
            type="color"
            id="bg_picker"
            value="{if !empty($aForms.background_color)}{$aForms.background_color}{else}#ffffff{/if}"
            oninput="document.getElementById('bg_color').value=this.value"
			/>
			<input
				type="text"
				id="bg_color"
				class="form-control"
				name="val[background_color]"
				value="{if !empty($aForms.background_color)}{$aForms.background_color}{/if}"
				maxlength="7"
				style="width:100px;margin-left:10px;"
			/>
        </div>
        <div class="clear"></div>
    </div>
	
	<div class="table form-group">
        <div class="table_left">
            {_p var='Color'}:
        </div>
        <div class="table_right">
             <input
            type="color"
            id="text_picker"
            value="{if !empty($aForms.color)}{$aForms.color}{else}#000000{/if}"
            oninput="document.getElementById('text_color').value=this.value"
			/>
			<input
				type="text"
				class="form-control"
				id="text_color"
				name="val[color]"
				value="{if !empty($aForms.color)}{$aForms.color}{/if}"
				maxlength="7"
				style="width:100px;margin-left:10px;"
			/>
        </div>
        <div class="clear"></div>
    </div>
	
	<div class="form-group not_for_subsection">
		<label>{_p var='meta_description'}:</label>
		<textarea class="form-control" cols="35" rows="6" name="val[description]" id="description">{value type='textarea' id='description'}</textarea>
		<div class="help-block"></div>
	</div>


   

	<div class="table_clear">
		<input type="submit" value="{_p var='submit'}" class="button btn-primary" />
	</div>
</form>