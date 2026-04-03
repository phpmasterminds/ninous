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
<div class="block">
    <div class="title ">{_p var='New Users'}</div>
    <div class="content">
        {foreach from=$top_bloggers item=user}
            <div class='fla' style="margin-right:2px;margin-bottom:2px;height:50px;">
                <a href="{url link='dating'}?user={$user.user_name}" class="js_hover_title">
                    {if $user.user_image}
                        <img src="{img user=$user suffix='_50_square' max_width=50 max_height=50 return_url=true}" width="50" />
                    {else}
                        <img src="{$path}nophoto.jpg" style="width:50px;height:50px;" />
                    {/if}
                    <span class="js_hover_info">{$user.full_name}</span>
                </a>
            </div>
        {/foreach}
        <div class='clr'></div>
    </div>
</div>
