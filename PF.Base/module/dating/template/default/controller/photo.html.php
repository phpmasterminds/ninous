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
<form method="post" action="{url link='current'}" enctype="multipart/form-data" id="js_marketplace_form">
    <input type="hidden" name="val[send]" value="1" />
    <div id="js_marketplace_form_holder">
        <div class="table form-group-follow">
            <div class="table_left">
                {_p var='select_image_s'}:
            </div>
            <div class="table_right">
                <div id="js_progress_uploader"></div>
                <div class="extra_info">
                    {_p var='you_can_upload_a_jpg_gif_or_png_file'}
                    {if Phpfox::getParam('dating.maxphoto') !== null}
                        <br />
                        {_p var='Max size:'} {php}echo Phpfox::getParam('dating.maxphoto');{/php}{_p var='Mb'}
                    {/if}
                </div>
            </div>
        </div>
        <div class="table_clear">
            <input type="submit" value="{_p var='upload'}" class="button btn-primary" />
        </div>
    </div>
</form>

{if !empty($aImages)}
    <div class="form_extra">
        <div class="block">
            <div class="title">{_p var='Photos'}</div>
            <div class="content">
                <div style="margin-bottom: 15px"> {_p var='Manage photos, if you click on photo you will setup it as default for you dating profile'}</div>
                {foreach from=$aImages name=images item=aImage}
                <div id="js_photo_holder_{$aImage.image_id}" class="row1{if $aImage.is_default} row_focus{/if} js_mp_photo">
                    <a href="#" title="{_p var='Delete this image'}" onclick="$Core.jsConfirm({l}message:'{_p var='are_you_sure' phpfox_squote=true}'{r}, function(){l} $('#js_photo_holder_{$aImage.image_id}').remove(); $.ajaxCall('dating.deleteImage', 'id={$aImage.image_id}'); $('#js_mp_image_{$aImage.image_id}').remove(); {r}, function(){l}{r}); return false;">{img theme='misc/delete_hover.gif' alt=''}</a>
                    <a href="#" title="{_p var='click_to_set_as_default_image'}" onclick="$('.js_mp_photo').removeClass('row_focus'); $(this).parents('.js_mp_photo:first:not(\'.row_focus\')').addClass('row_focus'); $.ajaxCall('dating.setDefault', 'id={$aImage.image_id}'); return false;">
                        <img src="{$aImage.image_path}" class='js_mp_fix_width' style="max-width:120px;" />
                    </a>
                </div>
                {/foreach}
            </div>
        </div>
    </div>
{/if}