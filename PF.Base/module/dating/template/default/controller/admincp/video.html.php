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
<div class="table_header">
    {_p var='Manage Videos'}
</div>
<form method="post" action="{url link='admincp.dating.video'}">
    <div class="table">
        <div class="table_left">
            {_p var='Display'}:
        </div>
        <div class="table_right">
            {$aFilters.display}
        </div>
        <div class="clear"></div>
    </div>
    <div class="table">
        <div class="table_left">
            {_p var='Sort'}:
        </div>
        <div class="table_right">
            {$aFilters.sort} {$aFilters.sort_by}
        </div>
        <div class="clear"></div>
    </div>
    <div class="table_clear">
        <input type="submit" name="search[submit]" value="{_p var='submit'}" class="button" />
        <input type="submit" name="search[reset]" value="{_p var='reset'}" class="button" />
    </div>
    <br />
</form>
{if !empty($aVideos)}
    <table  cellpadding="0" cellspacing="0">
        <tr>
            <th style="width:20px;"></th>
            <th>{_p var='Title'}</th>
            <th>{_p var='User'}</th>
        </tr>
        {foreach from=$aVideos key = iKey item=aVideo}
        <tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}" >
            <td class="t_center">
                <a href="#" class="js_drop_down_link" title="{_p var='Manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
                <div class="link_menu">
                    <ul>
                        <li><a href="{url link='admincp.dating.video' delete=$aVideo.id}" class="sJsConfirm">{_p var='delete'}</a></li>
                    </ul>
                </div>
            </td>
            <td>
                {$aVideo.title}
            </td>
            <td>
                {$aVideo|user}
            </td>
        </tr>
        {/foreach}
    </table>
    <div class="t_right">
        {pager}
    </div>
{/if}
