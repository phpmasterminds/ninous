<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 * OrthodoxMatch Dating Module - Admin Manage Fields (Hierarchical Accordion with Drag-Drop)
 * 
 * Displays sections with parent/child hierarchy in accordion format with drag-and-drop reordering
 * Structure: Parent Section > Child Subsections > Fields
 *
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Masanamuthu
 * @package  		Module_Dating
 */
?>

<style>
.dating-accordion {
    margin-bottom: 15px;
}

.accordion-item {
    margin-bottom: 10px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    overflow: hidden;
}

.accordion-header {
    margin: 0;
}

.accordion-button {
    font-weight: 600;
    padding: 14px 16px;
    background-color: #f8f9fa;
    border: none;
    color: #333;
    width: 100%;
    text-align: left;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.accordion-button:hover {
    background-color: #e7f3ff;
}

.accordion-button.active {
    background-color: #0d6efd;
    color: white;
}

.accordion-button:focus {
    outline: none;
    box-shadow: inset 0 0 0 2px rgba(13, 110, 253, 0.25);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-badge {
    display: inline-block;
    background-color: rgba(255, 255, 255, 0.3);
    color: inherit;
    border-radius: 12px;
    padding: 2px 8px;
    font-size: 12px;
    font-weight: 500;
}

.accordion-button.active .section-badge {
    background-color: rgba(0, 0, 0, 0.2);
}

.accordion-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    transition: transform 0.3s ease;
}

.accordion-button.active .accordion-icon {
    transform: rotate(180deg);
}

.accordion-body {
    padding: 0;
    background-color: #ffffff;
}

/* Child Subsections */
.subsection-container {
    border-left: 4px solid #dee2e6;
    margin-left: 0;
    padding: 0;
}

.subsection-header {
    padding: 10px 16px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    font-weight: 500;
    color: #666;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-left: 0;
    margin-bottom: 0;
}

.subsection-header:hover {
    background-color: #e7f3ff;
    color: #333;
}

.subsection-header.active {
    background-color: #e7f3ff;
    border-bottom: 2px solid #0d6efd;
}

.subsection-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    transition: transform 0.3s ease;
    color: #999;
}

.subsection-header.active .subsection-icon {
    transform: rotate(180deg);
    color: #0d6efd;
}

.subsection-fields {
    display: none;
}

.subsection-fields.show {
    display: table;
}

/* Fields Table */
.fields-table {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
    background-color: #fafbfc;
}

.fields-table thead th {
    background-color: #f1f3f5;
    border-bottom: 2px solid #dee2e6;
    padding: 10px;
    font-weight: 600;
    color: #333;
    text-align: left;
    font-size: 13px;
}

.fields-table tbody tr {
    border-bottom: 1px solid #dee2e6;
}

.fields-table tbody tr:last-child {
    border-bottom: 1px solid #dee2e6;
}

.fields-table tbody tr:hover {
    background-color: #f1f9ff;
}

.fields-table tbody tr.dragging {
    opacity: 0.5;
    background-color: #fff3cd;
}

.fields-table tbody tr.drag-over {
    background-color: #cfe2ff !important;
    border-top: 2px solid #0d6efd;
}

.fields-table td {
    padding: 10px;
    vertical-align: middle;
    font-size: 13px;
}

.drag-handle {
    width: 30px;
    text-align: center;
    cursor: move;
    color: #999;
}

.drag-handle:hover {
    color: #0d6efd;
}

.field-actions {
    width: 70px;
    display: flex;
    gap: 6px;
    justify-content: center;
}

.field-actions .dropdown {
    position: relative;
    display: inline-block;
}

.field-actions .dropdown-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 3px;
    text-decoration: none;
    color: #0d6efd;
    transition: all 0.2s ease;
    font-size: 13px;
}

.field-actions .dropdown-link:hover {
    background-color: #e7f3ff;
    color: #0a58ca;
}

.field-actions .link_menu {
    display: none;
    position: absolute;
    background-color: #fff;
    min-width: 150px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    border-radius: 4px;
    border: 1px solid #dee2e6;
    z-index: 1000;
    top: 100%;
    right: 0;
}

.field-actions .dropdown:hover .link_menu,
.field-actions .dropdown.active .link_menu {
    display: block;
}

.field-actions .link_menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.field-actions .link_menu li {
    margin: 0;
    padding: 0;
}

.field-actions .link_menu a {
    display: block;
    padding: 8px 12px;
    text-decoration: none;
    color: #0d6efd;
    border-bottom: 1px solid #f1f3f5;
}

.field-actions .link_menu a:last-child {
    border-bottom: none;
}

.field-actions .link_menu a:hover {
    background-color: #f8f9fa;
}

.field-actions .link_menu a.delete-action {
    color: #dc3545;
}

.field-actions .link_menu a.delete-action:hover {
    background-color: #f8d7da;
}

.field-name {
    font-weight: 500;
    color: #333;
}

.field-type {
    display: inline-block;
    background-color: #dbeafe;
    color: #0d6efd;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 500;
}

.field-search {
    text-align: center;
}

.badge-yes {
    display: inline-block;
    background-color: #d1e7dd;
    color: #0f5132;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 500;
}

.badge-no {
    display: inline-block;
    background-color: #e2e3e5;
    color: #383d41;
    padding: 3px 8px;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 500;
}

.empty-message {
    padding: 20px;
    text-align: center;
    color: #999;
    background-color: #f8f9fa;
    font-style: italic;
}

.section-with-subsections .accordion-body {
    padding: 0;
}

.section-without-subsections .fields-table {
    display: table;
}
</style>

<div class="table_header">
    {_p var='Manage Fields'}
</div>

{if !empty($aHierarchicalData)}

<div class="accordion dating-accordion" id="datingFieldsAccordion">
    {foreach from=$aHierarchicalData key=iParentId item=aParentData name=parents}
    
    {assign var='aParent' value=$aParentData.parent}
    {assign var='aChildren' value=$aParentData.children}
    {assign var='aParentFields' value=$aParentData.fields}
    {assign var='iHasChildren' value=$aChildren|count}
    {assign var='iParentIndex' value=$smarty.foreach.parents.iteration}
    
    <div class="accordion-item {if $iHasChildren > 0}section-with-subsections{else}section-without-subsections{/if}">
        <h2 class="accordion-header">
            <button 
                class="accordion-button {if $iParentIndex == 1}active{/if}" 
                type="button" 
                onclick="toggleSection(this, {$iParentId})">
                
                <span class="section-title">
                    <span class="section-name">{$aParent.section_name}</span>
                    {if $iHasChildren > 0}
                        <span class="section-badge">{$iHasChildren} {_p var='subsection'}</span>
                    {/if}
                    {if !empty($aParentFields)}
                        <span class="section-badge">{$aParentFields|count} {_p var='fields'}</span>
                    {/if}
                </span>
                
                <span class="accordion-icon">
                    <i class="fa fa-chevron-down"></i>
                </span>
            </button>
        </h2>
        
        <div class="accordion-body" id="section_{$iParentId}">
            
            {* Display parent section fields if no children *}
            {if $iHasChildren == 0 && !empty($aParentFields)}
            
            <table class="fields-table table table-bordered" id="_sort" data-sort-url="{url link='icons.admincp.dating.order'}">
                <thead>
                    <tr>
                        <th style="width: 30px;"></th>
                        <th style="width: 50px;"></th>
                        <th>{_p var='Name'}</th>
                        <th style="width: 100px;">{_p var='Type'}</th>
                        <th style="width: 70px;">{_p var='Is search'}</th>
                        <th style="width: 70px;">{_p var='Is required'}</th>
                    </tr>
                </thead>
                <tbody class="js_drag_drop_section" data-section-id="{$iParentId}">
                    {foreach from=$aParentFields item=aField}
                    <tr class="field-row" draggable="true" data-field-id="{$aField.field_id}" data-section-id="{$iParentId}">
                        <td class="drag-handle">
                            <input type="hidden" name="val[ordering][{$aField.field_id}]" value="{$aField.ordering}" />
                           <i class="fa fa-sort"></i>
                        </td>
                        <td class="field-actions t_center">
                            <div class="dropdown">
                                <a href="#" class="dropdown-link js_drop_down_link" title="{_p var='Manage'}">
                                    <i class="fa fa-chevron-down"></i>
                                </a>
                                <div class="link_menu">
                                    <ul>
                                        <li><a href="{url link='admincp.dating.add' id=$aField.field_id}">{_p var='edit'}</a></li>
                                        <li><a href="{url link='admincp.dating.add' delete=$aField.field_id}" class="delete-action sJsConfirm">{_p var='delete'}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                        <td class="field-name">{$aField.title}</td>
                        <td><span class="field-type">{$aField.type}</span></td>
                        <td class="field-search">
                            {if $aField.is_search == 1}
                                <span class="badge-yes">{_p var='Yes'}</span>
                            {else}
                                <span class="badge-no">{_p var='No'}</span>
                            {/if}
                        </td>
						<td class="field-required">
                            {if $aField.is_required == 1}
                                <span class="badge-yes">{_p var='Yes'}</span>
                            {else}
                                <span class="badge-no">{_p var='No'}</span>
                            {/if}
                        </td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
            
            {elseif $iHasChildren > 0}
            
            {* Display child subsections *}
            <div class="subsection-container">
                {foreach from=$aChildren key=iChildId item=aChild name=children}
                
                {assign var='aChildSection' value=$aChild.section}
                {assign var='aChildFields' value=$aChild.fields}
                
                <div class="subsection-header {if $smarty.foreach.children.first}active{/if}" onclick="toggleSubsection(this, '{$iParentId}_{$iChildId}')">
                    <span class="subsection-title">
                        {$aChildSection.section_name}
                        {if !empty($aChildFields)}
                            <span class="section-badge" style="margin-left: 8px; font-size: 11px;">
                                {$aChildFields|count} {_p var='fields'}
                            </span>
                        {/if}
                    </span>
                    <span class="subsection-icon">
                        <i class="fa fa-chevron-down"></i>
                    </span>
                </div>
                
                {if !empty($aChildFields)}
				<!--fields_{$iParentId}_{$iChildId}-->
                <table class="fields-table subsection-fields table table-bordered {if $smarty.foreach.children.first}show{/if}" id="_sort"  data-sort-url="{url link='icons.admincp.dating.order'}">
                    <thead>
                        <tr>
                            <th style="width: 30px;"></th>
                            <th style="width: 50px;"></th>
                            <th>{_p var='Name'}</th>
                            <th style="width: 100px;">{_p var='Type'}</th>
                            <th style="width: 70px;">{_p var='Is search'}</th>
                            <th style="width: 70px;">{_p var='Is required'}</th>
                        </tr>
                    </thead>
                    <tbody class="js_drag_drop_section" data-section-id="{$iChildId}">
                        {foreach from=$aChildFields item=aField}
                        <tr class="field-row" draggable="true" data-sort-id="{$aField.field_id}" data-field-id="{$aField.field_id}" data-section-id="{$iChildId}">
                            <td class="drag-handle">
                                <input type="hidden" name="val[ordering][{$aField.field_id}]" value="{$aField.ordering}" />
                                <i class="fa fa-sort"></i>
                            </td>
                            <td class="field-actions t_center">
                                <div class="dropdown">
                                    <a href="#" class="dropdown-link js_drop_down_link" title="{_p var='Manage'}">
                                        <i class="fa fa-chevron-down"></i>
                                    </a>
                                    <div class="link_menu">
                                        <ul>
                                            <li><a href="{url link='admincp.dating.add' id=$aField.field_id}">{_p var='edit'}</a></li>
                                            <li><a href="{url link='admincp.dating.add' delete=$aField.field_id}" class="delete-action sJsConfirm">{_p var='delete'}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td class="field-name">{$aField.title}</td>
                            <td><span class="field-type">{$aField.type}</span></td>
                            <td class="field-search">
                                {if $aField.is_search == 1}
                                    <span class="badge-yes">{_p var='Yes'}</span>
                                {else}
                                    <span class="badge-no">{_p var='No'}</span>
                                {/if}
                            </td>
							<td class="field-search">
                                {if $aField.is_required == 1}
                                    <span class="badge-yes">{_p var='Yes'}</span>
                                {else}
                                    <span class="badge-no">{_p var='No'}</span>
                                {/if}
                            </td>
                        </tr>
                        {/foreach}
                    </tbody>
                </table>
                {else}
                <div class="empty-message">
                    {_p var='No fields in this subsection'}
                </div>
                {/if}
                
                {/foreach}
            </div>
            
            {/if}
        </div>
    </div>
    
    {/foreach}
</div>

{else}

<div class="empty-message" style="margin: 20px 0;">
    {_p var='There are no fields for manage'}
</div>

{/if}

<script>
{literal}

// Drag and Drop functionality
let draggedElement = null;
let sourceSection = null;

document.addEventListener('dragstart', function(e) {
    if (e.target.classList.contains('field-row')) {
        draggedElement = e.target;
        sourceSection = e.target.getAttribute('data-section-id');
        e.target.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
    }
});

document.addEventListener('dragend', function(e) {
    if (e.target.classList.contains('field-row')) {
        e.target.classList.remove('dragging');
        // Remove all drag-over classes
        document.querySelectorAll('.field-row.drag-over').forEach(el => {
            el.classList.remove('drag-over');
        });
    }
});

document.addEventListener('dragover', function(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
    
    if (e.target.closest('.field-row') && draggedElement) {
        const targetRow = e.target.closest('.field-row');
        if (targetRow !== draggedElement) {
            targetRow.classList.add('drag-over');
        }
    }
});

document.addEventListener('dragleave', function(e) {
    const targetRow = e.target.closest('.field-row');
    if (targetRow) {
        targetRow.classList.remove('drag-over');
    }
});

document.addEventListener('drop', function(e) {
    e.preventDefault();
    
    if (draggedElement && e.target.closest('.field-row')) {
        const targetRow = e.target.closest('.field-row');
        
        if (targetRow !== draggedElement) {
            const tbody = targetRow.closest('tbody');
            const rows = Array.from(tbody.querySelectorAll('.field-row'));
            const draggedIndex = rows.indexOf(draggedElement);
            const targetIndex = rows.indexOf(targetRow);
            
            if (draggedIndex < targetIndex) {
                targetRow.parentNode.insertBefore(draggedElement, targetRow.nextSibling);
            } else {
                targetRow.parentNode.insertBefore(draggedElement, targetRow);
            }
            
            // Update ordering values
            updateOrdering(tbody);
        }
        
        targetRow.classList.remove('drag-over');
    }
});

// Update ordering after drag and drop
function updateOrdering(tbody) {
    const rows = tbody.querySelectorAll('.field-row');
    rows.forEach((row, index) => {
        const input = row.querySelector('input[name*="val[ordering]"]');
        if (input) {
            input.value = index + 1;
        }
    });
}

// Toggle section accordion
function toggleSection(button, sectionId) {
    button.classList.toggle('active');
    const body = document.getElementById('section_' + sectionId);
    
    if (body.style.display === 'none') {
        body.style.display = 'block';
    } else {
        body.style.display = 'none';
    }
}

// Toggle subsection
function toggleSubsection(header, subsectionId) {
    header.classList.toggle('active');
    const table = document.getElementById('fields_' + subsectionId);
    
    if (table) {
        table.classList.toggle('show');
    }
}

// Dropdown menu toggle
document.addEventListener('click', function(e) {
    if (e.target.closest('.js_drop_down_link')) {
        e.preventDefault();
        const dropdown = e.target.closest('.dropdown');
        if (dropdown) {
            dropdown.classList.toggle('active');
        }
    }
});

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown.active').forEach(d => {
            d.classList.remove('active');
        });
    }
});

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.accordion-button');
    const headers = document.querySelectorAll('.subsection-header');
    
    // Set first parent open, others closed
    buttons.forEach((btn, index) => {
        if (index !== 0) {
            btn.classList.remove('active');
            const itemDiv = btn.closest('.accordion-item');
            const body = itemDiv.querySelector('.accordion-body');
            if (body) body.style.display = 'none';
        } else {
            btn.classList.add('active');
        }
    });
    
    // Set first child subsection open for each parent
    headers.forEach((header, index) => {
        const parentSection = header.closest('.subsection-container');
        const firstInParent = parentSection.querySelector('.subsection-header');
        
        if (header === firstInParent) {
            header.classList.add('active');
            const subsectionId = header.nextElementSibling?.id.split('_').slice(1).join('_');
            if (subsectionId) {
                const table = document.getElementById('fields_' + subsectionId);
                if (table) table.classList.add('show');
            }
        } else {
            header.classList.remove('active');
            const subsectionId = header.nextElementSibling?.id.split('_').slice(1).join('_');
            if (subsectionId) {
                const table = document.getElementById('fields_' + subsectionId);
                if (table) table.classList.remove('show');
            }
        }
    });
});

{/literal}
</script>