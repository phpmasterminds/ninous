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
{if !empty($aUsers)}
{foreach from=$aUsers name=users item=aUser}
<div class="dating_left">
    {if empty($aUser.is_nophoto)}<a class="group1 no_ajax dating_hover" title="{$aUser.full_name}" href="{if !empty($aUser.dating_photo)}{$aUser.dating_photo}{else}{img user=$aUser suffix='' return_url=true}{/if}">{/if}
        <img class="dating_hover" src="{if !empty($aUser.dating_photo)}{$aUser.dating_photo}{else}{img user=$aUser suffix='' max_width=200 max_height=200 return_url=true}{/if}" />
    {if empty($aUser.is_nophoto)}
        <div class="dating_overlay"><i class="fa fa-search-plus" aria-hidden="true"></i></div>
        </a>
        {literal}
            <script>
                $(".group1").colorbox({rel:'group1'});
            </script>
        {/literal}
    {/if}
    <h1 >{$aUser.full_name}</h1>
    {if $aUser.is_online==1}<div class="dating_mail_green" style="font-size:12px;">{_p var='Active Now'}</div>{else}<div class="dating_mail_grey" style="font-size:12px;">{_p var="Active"} {$aUser.last_activity|convert_time}</div>{/if}
    {if !empty($aUser.rating_html)}
        <div class='browse_rating' style="font-size:18px;">{$aUser.rating_html}</div>
    {/if}
    <div class="datingprofile_action">
        {if Phpfox::isModule('friend')}
            {if Phpfox::isUser() && Phpfox::isModule('friend') && !$aUser.is_friend && $aUser.is_friend_request}
                 <div style="margin-bottom: 10px;">{_p var='profile.pending_friend_request'}</div>
            {else}
                {if Phpfox::isUser() && Phpfox::isModule('friend') && !$aUser.is_friend && Phpfox::getUserId() != $aUser.user_id && (!isset($aUser.user_is_blocked) )}
                <a href="#"  class="button btn-black" onclick="return $Core.addAsFriend('{$aUser.user_id}');"><i class="fa fa-user"></i> {_p var='user.add_friend'}</a>
                {/if}
            {/if}
        {/if}
        {if Phpfox::isModule('follow')}
            <a href="javascript://void(0)" id="fav_text_{$aUser.user_id}" class="button btn-black" onclick="$.ajaxCall('follow.follow', 'user_id={$aUser.user_id}');">
                {if $aUser.is_follow}
                    <span style="color:#297fc7;"><i class="fa fa-rss"></i> {_p var='Following'}</span>
                {else}
                     <i class="fa fa-rss"></i> {_p var='Follow'}
                {/if}
            </a>
        {/if}
        {if Phpfox::isModule('poke')}
            {if !$aUser.is_poked}
                <a href="#" id="poke_{$aUser.user_id}" class="button btn-black" onclick="$Core.box('poke.poke', 400, 'user_id={$aUser.user_id}');    return false;"><i class="fa fa-angellist"></i> {_p var='poke'}</a>
            {/if}
        {/if}
        <a href="javascript://void(0)" id="dating_text_{$aUser.user_id}" class="button btn-black" onclick="$.ajaxCall('dating.favourite', 'user_id={$aUser.user_id}');">
            {if $aUser.is_favourite}
                 <span style="color:#297fc7;"><i class="fa fa-star"></i> {_p var='Remove favourite'}</span>
            {else}
                <i class="fa fa-star-o"></i> {_p var='Add favourite'}
            {/if}
        </a>
    </div>
</div>
<div class="dating_right">
    <div class="dating_action">
        <div class="fl">
            <h1>{_p var='What do you think?'}</h1>
        </div>
        <div class="fl what">
            <a href="javascript://void(0)" class="ok {if $status.status == 'mutual'}mutual_disable{/if}" {if $status.status != 'mutual'}onclick="like({$aUser.user_id},{$isUser})"{/if}><i class="fa fa-check"></i></a>
            <a href="javascript://void(0)" class="next {if $status.status == 'mutual'}mutual_disable{/if}" {if $status.status != 'mutual'}onclick="next({$aUser.user_id},{$isUser})"{/if}><i class="fa fa-times"></i></a>
        </div>
        <div class="fr" style="font-weight: bold;margin-top:14px;font-size:13px;">
            {if !empty($isUser)}
                <div id="single_action">
                    {if $status.status == 'like'}
                       {$status.phrase}
                    {elseif $status.status == 'mutual'}
                         {$status.phrase}
                    {elseif $status.status == 'skip'}
                         {$status.phrase}
                    {elseif $status.status == 'user_sent'}
                        {$status.phrase}
                    {/if}
                </div>
            {else}
                {_p var='Awaiting:'} {$iCnt} {_p var='users'}
            {/if}
        </div>
        <div class="clr"></div>
    </div>
    <div class="datingtabs">
        <a id='a_tab' href="javascript://void(0)" onclick="changeDatingTab('tab', this)" class="datingtab active_dating">{_p var='Profile Info'}</a>
        <a id='a_dating' href="javascript://void(0)" onclick="changeDatingTab('dating', this)" class="datingtab">{_p var='Dating Info'}</a>
        <a id='a_photo' href="javascript://void(0)" onclick="changeDatingTab('photo', this)" class="datingtab"> {_p var='Photos'}</a>
        <a id='a_video' href="javascript://void(0)" onclick="changeDatingTab('video', this)" class="datingtab">  {_p var='Videos'}</a>
        {if Phpfox::isModule('badge')}
            <a id='a_badge' href="javascript://void(0)" onclick="changeDatingTab('badge', this)" class="datingtab">  {_p var='Badges'}</a>
        {/if}
    </div>
    <div id="dating_tab">
        {if Phpfox::isModule('horosrelation') and !empty($aUser.horoscope)}
            <div class="info">
                <div class="info_left">
                    {'Zodiac sign'}:
                </div>
                <div class="info_right">
                    {$aUser.horoscope1.horoscope_name} (<a target="_blank" class="no_ajax" href="{permalink module='horosrelation.horoscope' id=$aUser.horoscope}">{_p var='Read today horoscope'}</a>)
                </div>
            </div>
        {/if}
        {if Phpfox::getParam('user.enable_relationship_status') && $sRelationship != ''}
        <div class="info">
            <div class="info_left">
                {_p var='relationship_status'}:
            </div>
            <div class="info_right">
                {$sRelationship}
            </div>
        </div>
        {/if}
        {foreach from=$aUserDetails key=sKey item=sValue}
            {if !empty($sValue)}
            <div class="info">
                <div class="info_left">
                    {$sKey}:
                </div>
                <div class="info_right">
                    {$sValue}
                </div>
            </div>
            {/if}
        {/foreach}
        {plugin call='profile.template_block_info'}
    </div>
    <div id="dating_dating" style="display:none;">
        {if !empty($aUser.dating_fields)}
            {foreach from=$aUser.dating_fields item=field}
                {if !empty($field.value)}
                <div class="info">
                    <div class="info_left">
                        {$field.name}:
                    </div>
                    <div class="info_right">
                        {$field.value}
                    </div>
                </div>
                {/if}
            {/foreach}
        {else}
            {_p var='User have not provide dating information.'}
        {/if}
    </div>
    <div id="dating_photo" style="display:none">
        {if !empty($aUser.dating_photos)}
            <ul id="waterfall">
                {foreach from=$aUser.dating_photos name=images item=aImage}
                    <li >
                        <div style="position: relative">
                            <a class="no_ajax group1" title="{$aUser.full_name}" href="{$aImage.image_path}">
                                <img src="{$aImage.image_path}" style="width: 100%;" title="{$aUser.full_name}" />
                            </a>
                        </div>
                    </li>
                {/foreach}
            </ul>
            {literal}
            <script type="text/javascript">
                $('#waterfall').NewWaterfall({
                    width: 270,
                    delay: 100
                });
                $(".group1").colorbox({rel:'group1'});
            </script>
            {/literal}
        {else}
            {_p var='Sorry but user not uploaded any images.'}
        {/if}
    </div>
    <div id="dating_video" style="display:none;">
        {if !empty($aUser.dating_videos)}
            {foreach from=$aUser.dating_videos item=aVideo name=videoAr}
            {if $phpfox.iteration.videoAr%3==0}<div class="clr"></div> {/if}
            <div class="col-sm-12" >
                <div style="margin:0 0 10px;font-size:12px;font-weight: 600;">{$aVideo.title}</div>
                <div class="store_video_cont">
                    {if !empty($aVideo.video_path)}
                    <video id="my-video" class="video-js" controls="" width="100%" data-setup="">
                        <source src="{$aVideo.video_path}">
                    </video>
                    {else}
                        {$aVideo.embed_code}
                    {/if}
                </div>
            </div>
            {/foreach}
        {else}
             {_p var='Sorry but user not uploaded any videos.'}
        {/if}
    </div>
    <div id="dating_badge" style="display:none;">
        {if !empty($badges)}
        <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        {literal}
        <style type='text/css'>
            .badge_cont
            {
                background: #313;
                border-radius: 50%;
                color: #fff;
                padding: 10px;
                font-family: Lobster;
                font-weight: 300;
                font-size: 20px;
                text-align: center;
                width: 120px;
                overflow:hidden;
                line-height:21px;
                height: 120px;
                margin:auto;
                margin-bottom:5px;
                zoom: 100% !important;
            }
            .badge_cont i
            {
                display:block;
                padding:8px;
                margin:auto;
                text-align:center;
                font-size:30px;
            }
            .title_block a:hover, .b_user a:hover
            {
                text-decoration:none;
            }
            .title_block
            {
                margin-bottom:20px;
                text-align:center;
                line-height:17px;
            }
            .b_view
            {
                float:right;
                font-weight:bold;
            }
            .title_block:last-child
            {
                border:none;
            }

        </style>
        {/literal}
        {foreach from=$badges item=badge name=userbadge}
        <div style="margin-bottom: 10px;padding-bottom: 10px;border-bottom: 1px solid #eee;" class="col-sm-6">
            <div style="width:100px;float:left;height:100px;overflow: hidden">
                <span class="main_badge" style="zoom:0.8;"><a href="{$badge.badge_url}">{$badge.badge_html}</a></span>
            </div>
            <div class='title_block' style="float:left;text-align:left;margin-left:10px;width:53%;overflow: hidden;">
                <div>
                    <a href="{$badge.badge_url}"><b>{$badge.badge_title}</b></a>
                </div>
                <div style='text-align:left;padding: 10px 0;'>
                    <i class="fa fa-arrow-right" aria-hidden="true"></i> &nbsp; {$aUser|user}
                </div>
                <div style="font-size:12px;">
                    <i class="fa fa-clock-o"></i> &nbsp;{$badge.user_date|convert_time}
                </div>
            </div>
            <div class="clear"></div>
        </div>
        {if $phpfox.iteration.userbadge%2==0}<div class="clr"></div> {/if}
        {/foreach}
        <div class='clear'></div>
        {else}
         {_p var='User not got any badges yet.'}
        {/if}
    </div>
</div>
{/foreach}
{else}
    {_p var='There are no users by your criteria, please simplify them.'}
{/if}
{literal}
<style>
    .datingprofile_action a i{
        padding-right:7px;
    }
</style>
{/literal}