<?php
defined('PHPFOX') or exit('NO DICE!');
?>

{if count($aPages)}
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">{_p var='Greetings'}</div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" >
            <thead>
                <tr>
                    
                    <th class="w30"></th>
                    <th>{_p var='Title'}</th>
						
                    <th>{_p var='Emoji'}</th>
						
                </tr>
            </thead>
            <tbody>
                {foreach from=$aPages key=iKey item=aGift}
                    <tr class="tr" data-sort-id="{$aGift.greeting_id}">
                        <td>
                            <a href="javascript:void(0)" class="js_drop_down_link" title="{_p var='manage'}"></a>
                            <div class="link_menu">
                                <ul>
                                    <li><a class="popup" href="{url link='admincp.dating.greetingadd' id=$aGift.greeting_id}">{_p var='edit'}</a></li>
                                    <li>
                                        <a href="{url link='admincp.dating.greeting' delete=$aGift.greeting_id}" class="sJsConfirm" data-message="{_p var='Are you sure want to delete?'}">{_p var='delete'}</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <td>
						
							{$aGift.title}
                        </td>
						
						<td>
                            {$aGift.emoji}
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
    {_p var='No Greetings'}
</div>
{/if}
{literal}
<script>
    $Behavior.core_egifts_init_managegift = function () {
        $('.apps_menu > ul > li:nth-child(3) a').addClass('active');
    }
</script>
{/literal}