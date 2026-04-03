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
{literal}
<style>
    .fl{
        float:left;
    }
    .clr{
        clear:both;
    }
    @media (max-width: 768px){
        .dating_sponsor_username {
             width: calc(100% - 140px) !important;
        }
    }
</style>
{/literal}
<div class="block" id="datingsponsoredblock" style="box-shadow:0 10px 20px 0 rgba(0, 0, 0, 0.08);border-radius:6px;text-align: center;margin-bottom:20px;position:relative;background: #ffffff;padding: 0 20px 20px 20px;">
    <div class="title" style="color:#555;font-weight:bold;font-size:16px;border-bottom: 1px #eee solid;text-align:left;line-height: 50px;padding: 0 !important;">{_p var='Best Dating profiles'}</div>
    <div class="content row" style="margin-left:-10px;">
        {if !empty($top_bloggers)}
            {foreach from=$top_bloggers item=user}
                <div class="col-sm-3" style="padding:10px;">
                    <div  style="width:120px;float:left;">
                        <a href="{url link='dating'}?user={$user.user_name}" style="position:relative" >
                            {if $user.user_image}
                                 <img src="{img user=$user suffix='_120_square' max_width=200 max_height=200 return_url=true}" style="border-radius: 50%;" class="dating_image" />
                            {else}
                                 <img src="{$path}nophoto.jpg" style="border-radius: 50%;;width:120px;" class="dating_image" />
                            {/if}
                        </a>
                    </div>
                    <div class=" dating_sponsor_username" style="float:left;">
                        <a href="{url link='dating'}?user={$user.user_name}">
                            <b>{$user.full_name}</b>
                        </a>

                            <div style="margin-top:5px;">
                                {if !empty($user.field_3)}
                               {$user.field_3}
                                {/if}
                            </div>

                        <a class="btn btn-default btn-icon btn-round" role="link" href="{url link='dating'}?user={$user.user_name}" style="zoom:0.9;display:block;margin-top:10px;">
                            <span class="ico ico-heart-o"></span>
                            {_p var='like'}
                        </a>
                    </div>
                    <div class="clear"></div>
                </div>
            {/foreach}
        {/if}
    </div>
    <div  class="sponsor_link"><a style="font-size:11px;" href="{url link='dating.manage'}">{_p var='Sponsor your profile here!'}</a> </div>
</div>
{literal}
<style>
    .dating_sponsor_username{
        margin-left: 20px;width: calc(100% - 140px);text-align: left;
    }
    .sponsor_link{
        padding-top: 10px;
        text-align: right;
        position: absolute;
        right: 23px;
        top: 5px;
    }
    .sponsored_username{
        position: absolute;
        bottom:10px;
        display: block;
        width:calc(100% - 20px);
        padding:10px;
        background: rgba(51, 51, 51, 0.51);
        color:#fff;
    }
    .sponsored_username a,.sponsored_username a:visited,.sponsored_username a:hover{
        color:#eee;
    }
    .dating_image:hover{
        opacity:0.8;
    }
    @media (max-width: 768px) {
        .dating_sponsor_username{
            width:100%;
        }
        .sponsor_link{
            position: relative;
            margin:10px 0;
        }
        .display_block_sm {
            display: block;
        }
        #datingsponsoredblock{
            margin:0px -15px;
        }
        .fr,.fl{
            float:none;margin:5px 0;
        }
    }
</style>
{/literal}