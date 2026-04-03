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
{if Phpfox::isAdmin()}
    <a href="javascript://void(0)" id="dating_text_{$aUser.user_id}" class="btn btn-default btn-icon btn-round" onclick="$.ajaxCall('dating.sponsor', 'user_id={$aUser.user_id}');">
        {if $isSponsored}
             <span style="color:#297fc7;"><i class="ico ico-sponsor mr-1"></i> {_p var='Dating Sponsored'}</span>
        {else}
                <i class="ico ico-sponsor mr-1"></i> {_p var='Dating Sponsor'}
        {/if}
    </a>
{/if}
<a href="{url link='dating'}?user={$aUser.user_name}" class="btn btn-default btn-icon btn-round" >
    <i class="ico ico-heart-o"></i> {_p var='Dating Profile'}
</a>