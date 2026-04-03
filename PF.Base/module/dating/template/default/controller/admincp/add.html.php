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
<form method="post" action="{url link='admincp.dating.add' id=$iEditId}" enctype="multipart/form-data">
	<div><input type="hidden" name="val[edit_id]" value="{$iEditId}" /></div>
	<div><input type="hidden" name="val[title]" value="{$aForms.title}" /></div>
{else}
<form method="post" action="{url link='admincp.dating.add'}" enctype="multipart/form-data">
{/if}

    <div class="table form-group">
        <div class="table_left">
            {_p var='Field name'}:
        </div>
        <div class="table_right">
            <input type="text" name="val[title]" value="{if !empty($aForms.title)}{$aForms.title}{/if}"  maxlength="100"/>
        </div>
        <div class="clear"></div>
    </div>


    <div class="table form-group">
        <div class="table_left">
            {_p var='Type'}:
        </div>
        <div class="table_right">
            <select name="val[type]" id="field_type">
                <option value="text" {if !empty($aForms.type)}{if $aForms.type=='text'}selected{/if}{/if}>Text</option>
                <option value="textarea" {if !empty($aForms.type)}{if $aForms.type=='textarea'}selected{/if}{/if}>Textarea</option>
                <option value="checkbox" {if !empty($aForms.type)}{if $aForms.type=='checkbox'}selected{/if}{/if}>Checkbox</option>
                <option value="radio" {if !empty($aForms.type)}{if $aForms.type=='radio'}selected{/if}{/if}>Radio Button</option>
                <option value="multiple" {if !empty($aForms.type)}{if $aForms.type=='multiple'}selected{/if}{/if}>Multiple Choice</option>
            </select>
        </div>
        <div class="clear"></div>
    </div>

    <div class="table form-group">
        <div class="table_left">
            {_p var='Include in search'}:
        </div>
        <div class="table_right">
            <input type="checkbox" name="val[is_search]" {if !empty($aForms.is_search)} checked{/if}/>
        </div>
        <div class="clear"></div>
    </div>
	
	<div class="table form-group">
        <div class="table_left">
            {_p var='Is required'}:
        </div>
        <div class="table_right">
            <input type="checkbox" name="val[is_required]" {if !empty($aForms.is_required)} checked{/if}/>
        </div>
        <div class="clear"></div>
    </div>
	
	<div class="form-group">
		<label>{_p var='Category'}</label>

		<select id="category_select" name="val[category_id]" class="form-control">
			<option value="">Select Category</option>
			{foreach from=$aSections item=section}
				<option value="{$section.section_id}"
					{if !empty($aForms.category_id) && $aForms.category_id == $section.section_id}
						selected
					{/if}
				>
					{$section.section_name}
				</option>
			{/foreach}
		</select>
	</div>


	<div class="form-group" id="subcategory_wrapper" style="display:none;">
		<label>{_p var='Sub Category'}</label>
		<select name="val[sub_section_id]" id="subcategory_select" class="form-control">
			<option value="">Select Sub Category</option>
		</select>
	</div>

	<!-- Options Container for Radio Button and Multiple Choice -->
	<div id="options_wrapper" style="display:none;">
		<div class="form-group">
			<label>Options</label>
			<div id="options_container">
				<!-- Options will be dynamically added here -->
			</div>
			<button type="button" id="add_option_btn" class="button btn-secondary" style="margin-top: 10px;">Add More Option</button>
		</div>
	</div>

	<!-- Hidden input to store options as JSON -->
	<input type="hidden" name="val[options]" id="options_json" value="{if !empty($aForms.options)}{$aForms.options|clean:'html'}{/if}"/>

	<div class="table_clear">
		<input type="submit" value="{_p var='submit'}" class="button btn-primary" />
	</div>
</form>

{literal}
<script>
var sections = {/literal}{$aSections|json_encode}{literal};
var selectedCategory = "{/literal}{$aForms.category_id:''}{literal}";
var selectedSub = "{/literal}{$aForms.sub_section_id:''}{literal}";
var existingOptions = {/literal}{if !empty($aForms.options)}{$aForms.options|json_encode}{else}[]{/if}{literal};
var optionCounter = 0;

function loadSubCategories(categoryId) {
    var subSelect = document.getElementById('subcategory_select');
    var wrapper = document.getElementById('subcategory_wrapper');

    subSelect.innerHTML = '<option value="">Select Sub Category</option>';
    wrapper.style.display = 'none';

    if (!categoryId) return;

    sections.forEach(function (section) {
        if (section.section_id == categoryId && section.sub_sections.length > 0) {
            section.sub_sections.forEach(function (sub) {
                var option = document.createElement('option');
                option.value = sub.section_id;
                option.textContent = sub.section_name;

                if (sub.section_id == selectedSub) {
                    option.selected = true;
                }

                subSelect.appendChild(option);
            });
            wrapper.style.display = 'block';
        }
    });
}

// Toggle options wrapper based on field type
function toggleOptionsWrapper() {
    var fieldType = document.getElementById('field_type').value;
    var wrapper = document.getElementById('options_wrapper');
    var container = document.getElementById('options_container');

    if (fieldType === 'radio' || fieldType === 'multiple') {
        wrapper.style.display = 'block';
        
        // Parse existingOptions if it's a string (JSON)
        var parsedOptions = [];
        if (typeof existingOptions === 'string') {
            try {
                parsedOptions = JSON.parse(existingOptions);
            } catch (e) {
                parsedOptions = [];
            }
        } else if (Array.isArray(existingOptions)) {
            parsedOptions = existingOptions;
        }
        
        if (parsedOptions.length > 0) {
            optionCounter = 0;
            container.innerHTML = '';
            parsedOptions.forEach(function(opt) {
                if (opt && opt.trim()) {
                    addOptionField(opt.trim());
                }
            });
        } else if (container.innerHTML.trim() === '') {
            // Add default options only if container is empty
            if (fieldType === 'radio') {
                addOptionField('Option 1');
                addOptionField('Option 2');
            } else {
                addOptionField('');
            }
        }
    } else {
        wrapper.style.display = 'none';
        container.innerHTML = '';
        optionCounter = 0;
    }
}

function addOptionField(value) {
    var container = document.getElementById('options_container');
    var optionId = 'option_' + (++optionCounter);
    
    var optionDiv = document.createElement('div');
    optionDiv.id = optionId;
    optionDiv.style.marginBottom = '10px';
    optionDiv.style.display = 'flex';
    optionDiv.style.gap = '10px';
    optionDiv.style.alignItems = 'center';
    
    var input = document.createElement('input');
    input.type = 'text';
    input.class = 'form-control option-input';
    input.name = 'val[option_' + optionCounter + ']';
    input.placeholder = 'Enter option';
    input.value = value || '';
    input.style.flex = '1';
    
    var removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.innerHTML = 'Remove';
    removeBtn.className = 'button btn-danger';
    removeBtn.onclick = function(e) {
        e.preventDefault();
        document.getElementById(optionId).remove();
        updateOptionsJson();
    };
    
    optionDiv.appendChild(input);
    optionDiv.appendChild(removeBtn);
    container.appendChild(optionDiv);
}

function updateOptionsJson() {
    var inputs = document.querySelectorAll('.option-input');
    var options = [];
    inputs.forEach(function(input) {
        if (input.value.trim() !== '') {
            options.push(input.value.trim());
        }
    });
    document.getElementById('options_json').value = JSON.stringify(options);
}

document.getElementById('category_select').addEventListener('change', function () {
    selectedSub = '';
    loadSubCategories(this.value);
});

document.getElementById('field_type').addEventListener('change', function () {
    toggleOptionsWrapper();
});

document.getElementById('add_option_btn').addEventListener('click', function(e) {
    e.preventDefault();
    addOptionField('');
    updateOptionsJson();
});

// Update options JSON before form submission
document.querySelector('form').addEventListener('submit', function() {
    updateOptionsJson();
});

// Auto-load on page load
document.addEventListener('DOMContentLoaded', function () {
    if (selectedCategory) {
        loadSubCategories(selectedCategory);
    }
    toggleOptionsWrapper();
});
</script>
{/literal}