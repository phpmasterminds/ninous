<?php
defined('PHPFOX') or exit('NO DICE!');
?>

{if count($aPages)}
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">{_p var='Sections'}</div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" data-sort-url="{url link='egift.admincp.category.order-egifts'}" id="{if $iCategoryId}_sort{/if}">
            <thead>
                <tr>
                    
                    <th class="w30"></th>
                    <th>{_p var='Title'}</th>
						{if $aParentId <= 0}
                    <th>{_p var='Background Color'}</th>{/if}
                    <th>{_p var='Text Color'}</th>
						
                </tr>
            </thead>
            <tbody>
                {foreach from=$aPages key=iKey item=aGift}
                    <tr class="tr" data-sort-id="{$aGift.section_id}">
                        <td>
                            <a href="javascript:void(0)" class="js_drop_down_link" title="{_p var='manage'}"></a>
                            <div class="link_menu">
                                <ul>
                                    <li><a class="popup" href="{url link='admincp.dating.sectionadd' id=$aGift.section_id}">{_p var='edit'}</a></li>
                                    <li>
                                        <a href="{url link='admincp.dating.sec' delete=$aGift.section_id}" class="sJsConfirm" data-message="{_p var='Are you sure want to delete?'}">{_p var='delete'}</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
						
							{if $aGift.parent_id <= 0}
								<a href="{url link='admincp.dating.sec' parent_id=$aGift.section_id}">{$aGift.section_name}</a>
							{else}
								{$aGift.section_name}
							{/if}
                        </td>
						{if $aParentId <= 0}
						<td>
                            {$aGift.background_color}
                        </td>
						{/if}
						<td>
                            {$aGift.color}
                        </td>
						
                        
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
</div>
{pager}
{else}
<div class="alert alert-empty">
    {_p var='No sections'}
</div>
{/if}
{literal}
<script>
    $Behavior.core_egifts_init_managegift = function () {
        $('.apps_menu > ul > li:nth-child(3) a').addClass('active');
    }
</script>
{/literal}