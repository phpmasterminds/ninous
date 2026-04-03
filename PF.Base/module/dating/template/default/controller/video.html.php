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
    <div id="share">
        <div class="table form-group">
            <div class="table_left">
                <label for="title">{_p var='Share url'}:</label>
            </div>
            <div class="table_right">
                <input class="form-control " type="text" name="val[video_url]"  id="title"  />
            </div>
        </div>
        <a href="javascript://void(0)" style="display: table;margin-top: -5px;margin-bottom: 20px;"
           onclick="$('#upload').show();$('#upload_info').show();$('#share').hide();">{_p var='or Upload video'}</a>
    </div>
    <div id="upload" style="display: none;">
        <div class="table form-group">
            <div class="table_left">
                <label for="video_path">{_p var='Upload video'}:</label>
            </div>
            <div class="table_right">
                <input class="form-control " type="file" name="video_path" id="video_path"  />
            </div>
        </div>
        <div class="table form-group">
            <div class="table_left">
                <label for="video_title">{_p var='Video Title'}:</label>
            </div>
            <div class="table_right">
                <input class="form-control " type="text" name="val[video_title]" id="video_title"  />
            </div>
        </div>
        <a href="javascript://void(0)" style="display: table;margin-top: -5px;margin-bottom: 20px;"
           onclick="$('#upload').hide();$('#upload_info').hide();$('#share').show();">{_p var='back to Share options'}</a>
    </div>
    <div class="table_clear">
        <input type="submit" value="{_p var='Add video'}" class="button btn-primary" />
    </div>
    {if !empty($aVideos)}
    <h1 style="margin-top:20px;">{_p var='Videos'}</h1>
        <table>
            <tr>
                <th style="padding-bottom:10px;;">
                    {_p var='Title'}
                </th>
            </tr>
            {foreach from=$aVideos item=aVideo}
                <tr>
                    <td style="padding-right:40px;padding-bottom:10px;">
                        {$aVideo.title}
                    </td>
                    <td  style="padding-bottom:10px;">
                        <a href="{url link='current'}?videodelete={$aVideo.id}"><i class="fa fa-remove"></i></a>
                    </td>
                </tr>
            {/foreach}
        </table>
    {/if}
</form>