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
    <div class="title ">{_p var='Welcome to Dating'}</div>
    <div class="content">
        <div style="margin-bottom: 10px;">
            <img src="{$datingpath}home_image.png" style="max-width: 100%;" />
        </div>
        {_p var='To be able to see our dating profiles, you need to participate in our module, just click button below and see  thousands profiles!'}
        <div style="margin-top:20px;text-align: center;">
            <a href="{url link='dating'}?participate=1" class="button btn-warning">
                <i class="ico ico-plus" style="padding-right: 5px;"></i> {_p var='Join as Dating User'}
            </a>
        </div>
        <div class='clr'></div>
    </div>
</div>
