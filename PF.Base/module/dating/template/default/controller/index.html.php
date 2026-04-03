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
{if Phpfox::getParam('dating.enableparticipation') and empty($datingParticipate)}
    {literal}
        <style>
            .img_div{
                width: 70%;
                margin-right: 20px;
            }
            .participate_div{
                display:flex;margin-bottom: 10px;
            }
            .dating_participate_desc{
                margin-top:60px;
            }
            @media (max-width: 780px) {
                .img_div{
                    margin-right: 0;
                    width: 100%;
                    margin-bottom: 10px;
                }
                .dating_participate_desc{
                    margin-top:0;
                }
                .participate_div{
                    display: block;
                }
            }
        </style>
    {/literal}
    <div class="participate_div">
        <div class="img_div">
            <img src="{$path}home_image.png" style="max-width: 100%;" />
        </div>
        <div class="dating_participate_desc">
            <h3 style="margin-bottom: 20px;">{_p var='Welcome to Dating Module!'}</h3>
            {_p var='To be able to see our dating profiles, you need to participate in our module, just click button below and see  thousands profiles!'}
            <div style="margin-top:20px;">
                <a href="{url link='dating'}?participate=1" class="button btn-warning btn-lg">
                    <i class="ico ico-plus" style="padding-right: 5px;"></i> {_p var='Join as Dating User'}
                </a>
            </div>
        </div>
    </div>
{else}
{if empty($searchtext)}
<div style="position: absolute;right:0;top:-50px;"><a href="{url link='dating.manage'}"><i class="fa fa-pencil" style="padding-right:4px;"></i> {_p var='update dating profile'}</a></div>
<div class="block_search" id="dating_main_filter">
    <form method="get" action="{url link='dating'}" id="dating_form">
        <div class="row filter_fields">
            <div class="col-sm-4">
                <div class="filter_info">{_p var='Search keyword:'}</div>
                {filter key='keyword'}
                <div class="spacer"></div>
                <div class="filter_info">{_p var='Location:'}</div>
                {filter key='country'}
                {module name='core.country-child' country_child_filter=true country_child_type='browse'}
            </div>
            <div class="col-sm-4 dating_gender">
                <div class="filter_info">{_p var='gender'}:</div>
                {filter key='gender'}
                <div class="clr"></div>
                <div class="spacer"></div>
                <div class="filter_info">{_p var='City:'}</div>
                {filter key='city'}
            </div>
            <div class="col-sm-4">
                <div class="filter_info">{_p var='age'}:</div>
                {filter key='from'} {filter key='to'}
                <div class="spacer"></div>
                <div class="filter_info">{_p var='Show:'}</div>
                {filter key='status'}
            </div>
            <span id="js_admincp_search_options" style="display:none;width:100%;">
                <div class="col-sm-4">
                    <div class="spacer"></div>
                    <div class="filter_info">{_p var='User Group:'}</div>
                    {filter key='group'}
                </div>
                <div class="col-sm-4">
                    <div class="spacer"></div>
                    <div class="filter_info">{_p var='Zip:'}</div>
                    {filter key='zip'}
                </div>
                {foreach from=$aCustomFields item=aCustomField}
                        {if isset($aCustomField.fields)}
                        {foreach from=$aCustomField.fields item=aField}
                        <div class="col-sm-4">
                        <div class="spacer"></div>
                        <div class="filter_info">{_p var=$aField.phrase_var_name}:</div>
                        {if $aField.var_type == 'textarea' || $aField.var_type == 'text'}
                        <input type="text" class="form-control js_custom_search" name="custom[{$aField.field_id}]" value="{value id=''$aField.field_id'' type='input'}" size="25" />
                        {elseif $aField.var_type == 'select'}
                        <!-- custom input type select -->
                        <select name="custom[{$aField.field_id}]" class="form-control js_custom_search">
                            <option value="">{_p var='any'}</option>
                            {foreach from=$aField.options item=aOption}
                            <option value="{$aOption.option_id}"{value parent=''$aField.field_id'' id=''$aOption.option_id'' type='select' default=''$aOption.option_id''}>{_p var=$aOption.phrase_var_name}</option>
                            {/foreach}
                        </select>
                        {elseif $aField.var_type == 'multiselect'}
                        <!-- custom input type multi select -->
                        <select name="custom[{$aField.field_id}][]" multiple class="form-control js_custom_search" >
                            <option value="0">{_p var='any'}</option>
                            {foreach from=$aField.options item=aOption}
                            <option value="{$aOption.option_id}"{value parent=''$aField.field_id'' id=''$aOption.option_id'' type='multiselect' default=''$aOption.option_id''}>{_p var=$aOption.phrase_var_name}</option>
                            {/foreach}
                        </select>
                        {elseif $aField.var_type == 'radio'}

                        {foreach from=$aField.options item=aOption}
                        <div class="radio">
                            <label>
                                <input type="radio" name="custom[{$aField.field_id}]" value="{$aOption.option_id}"{value id=''$aOption.option_id'' type='radio' default=''$aOption.option_id''} class="js_custom_search">{_p var=$aOption.phrase_var_name}
                            </label>
                        </div>
                        {/foreach}
                        {elseif $aField.var_type == 'checkbox'}
                        {foreach from=$aField.options item=aOption}
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="custom[{$aField.field_id}][{$aOption.option_id}]" value="{$aOption.option_id}"{value id=''$aOption.option_id'' parent=''$aField.field_id'' type='checkbox' default=''$aOption.option_id''} class="js_custom_search v_middle"> {_p var=$aOption.phrase_var_name}
                            </label>
                        </div>
                        {/foreach}
                        {/if}
                        </div>
                        {/foreach}
                        {/if}
                {/foreach}
                {if !empty($fields)}
                    {foreach from=$fields item=field}
                        <div class="col-sm-4">
                            <div class="spacer"></div>
                            <div class="filter_info">{softPhrase var=$field.title}:</div>
                            {if $field.type == 'text'}
                                <input type="text" class="form-control" name="search[field_{$field.field_id}]" value="{php}if (!empty($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']])) { echo $this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']];} {/php}"/>
                            {elseif $field.type == 'textarea'}
                                <textarea rows='5' class="form-control" name="search[field_{$field.field_id}]">{php}if (!empty($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']])) { echo $this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']];} {/php}</textarea>
                            {elseif $field.type == 'checkbox'}
                                <input type="hidden" name="search[field_{$field.field_id}]" value="0" />
                                <input value="1" type="checkbox" name="search[field_{$field.field_id}]" {php}if (!empty($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']])) { echo 'checked';} {/php} />
                            {/if}
                        </div>
                    {/foreach}
                {/if}
            </span>
        </div>
        <a href="javascript://void(0)" onclick="$('#js_admincp_search_options').slideToggle()" id="advancedfilter" style="font-size:12px;display:block;margin:8px 0;float:right;">{_p var='Advanced Filters'}</a><div class="clr"></div>
        <div style="text-align: center">
            <a href="javascript://void(0)" onclick="$('#dating_form').submit()" class="search_dating_button button btn-danger" style="margin-right: 20px;"><i class="fa fa-search" style="padding-right:3px;"></i> {_p var='Start dating'}</a>
            <a href="{url link='dating'}?clean=1" class="button btn-success"><i class="fa fa-trash-o" style="padding-right:3px;"></i> {_p var='Reset Filters'}</a>
            <input style="display:none" type="submit" />
        </div>
    </form>
</div>
<a href="javascript://void(0)" style="display:block;text-align:center;color:#555;font-size:12px;" onclick="$('#dating_main_filter').slideToggle();">
    <i class="fa fa-angle-double-up" aria-hidden="true"></i> {_p var='Toggle Filter'}
</a>
{/if}
{if defined('PHPFOX_IS_ADMIN_SEARCH')}

{if !PHPFOX_IS_AJAX}


<div class="block_content">
    {literal}
    <script>
        function process_admincp_browse() {
            $('input.button').hide();
            $('#table_hover_action_holder, .table_hover_action').prepend('<div class="t_center admincp-browse-fa"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
        }

        function delete_users(response, form, data) {
            // p(form);
            $('.admincp-browse-fa').remove();
            $('input.button').show();
            for (var i in data) {
                var e = data[i];
                // p('is delete...');
                form.find('input[type="checkbox"]').each(function() {
                    if ($(this).is(':checked')) {
                        if (e.name == 'delete') {
                            $('#js_user_' + $(this).val()).remove();
                        }
                        else {
                            $(this).prop('checked', false);
                            var thisClass = $('#js_user_' + $(this).val());
                            thisClass.removeClass('is_checked').addClass('is_processed');
                            setTimeout(function() {
                                thisClass.removeClass('is_processed');
                            }, 600);
                        }
                    }
                });
            }
        };
    </script>
    {/literal}
    <form method="post" action="{url link='admincp.dating   '}" class="ajax_post" data-include-button="true" data-callback-start="process_admincp_browse" data-callback="delete_users">
        {/if}
        {if $aUsers}
        <table cellpadding="0" cellspacing="0" {if isset($bShowFeatured) && $bShowFeatured == 1} id="js_drag_drop"{/if}>
        <tr>
            <th style="width:10px;">
                {if !PHPFOX_IS_AJAX}
                <input type="checkbox" name="val[id]" value="" id="js_check_box_all" class="main_checkbox" />
                {/if}
            </th>
            <th style="width:20px;"></th>
            <th>{_p var='user_id'}</th>
            <th>{_p var='photo'}</th>
            <th>{_p var='display_name'}</th>
            <th>{_p var='email_address'}</th>
            <th>{_p var='group'}</th>
            <th>{_p var='last_activity'}</th>
        </tr>
        {foreach from=$aUsers name=users key=iKey item=aUser}
        <tr class="checkRow{if is_int($iKey/2)} tr{else}{/if}" id="js_user_{$aUser.user_id}">
            <td>
                {if $aUser.user_group_id == ADMIN_USER_ID && Phpfox::getUserBy('user_group_id') != ADMIN_USER_ID}

                {else}
                <input type="checkbox" name="id[]" class="checkbox" value="{$aUser.user_id}" id="js_id_row{$aUser.user_id}" />

                {/if}
            </td>
            {if isset($bShowFeatured) && $bShowFeatured == 1}
            <td class="drag_handle"><input type="hidden" name="val[ordering][{$aUser.user_id}]" value="{$aUser.featured_order}" /></td>
            {/if}
            <td>
                <a href="#" class="js_drop_down_link" title="{_p var='manage'}">{img theme='misc/bullet_arrow_down.png' alt=''}</a>
                <div class="link_menu">
                    <ul>
                        {if $aUser.user_group_id == ADMIN_USER_ID && Phpfox::getUserBy('user_group_id') != ADMIN_USER_ID}

                        {else}
                        <li><a href="{url link='admincp.user.add' id=$aUser.user_id}">{_p var='edit_user'}</a></li>
                        {/if}
                        {if $aUser.view_id == '1'}
                        <li class="js_user_pending_{$aUser.user_id}">
                            <a href="#" onclick="$.ajaxCall('user.userPending', 'type=1&amp;user_id={$aUser.user_id}'); return false;">
                                {_p var='approve_user'}
                            </a>
                        </li>
                        <li class="js_user_pending_{$aUser.user_id}">
                            <a href="#" onclick="tb_show('{_p var='deny_user' phpfox_squote=true}', $.ajaxBox('user.showDenyUser', 'height=240&amp;width=400&amp;iUser={$aUser.user_id}'));return false;">
                                {_p var='deny_user'}
                            </a>
                        </li>
                        <!-- onclick="" -->
                        {/if}
                        <li><div  class="js_feature_{$aUser.user_id}">{if !isset($aUser.is_featured) || $aUser.is_featured < 0}<a href="#" onclick="$.ajaxCall('user.feature', 'user_id={$aUser.user_id}&amp;feature=1'); return false;">{_p var='feature_user'}{else}<a href="#" onclick="$.ajaxCall('user.feature', 'user_id={$aUser.user_id}&amp;feature=0'); return false;">{_p var='unfeature_user'}{/if}</a></div></li>
                        {if (isset($aUser.pendingMail) && $aUser.pendingMail != '') || (isset($aUser.unverified) && $aUser.unverified > 0)}
                        <li><div class="js_verify_email_{$aUser.user_id}"> <a href="#" onclick="$.ajaxCall('user.verifySendEmail', 'iUser={$aUser.user_id}'); return false;">{_p var='resend_verification_mail'}</a></div></li>
                        <li><div class="js_verify_email_{$aUser.user_id}"> <a href="#" onclick="$.ajaxCall('user.verifyEmail', 'iUser={$aUser.user_id}'); return false;">{_p var='verify_this_user'}</a></div></li>
                        {/if}
                        {if $aUser.user_group_id == ADMIN_USER_ID && Phpfox::getUserBy('user_group_id') != ADMIN_USER_ID}

                        {else}
                        <li id="js_ban_{$aUser.user_id}">
                            {if $aUser.is_banned}
                            <a href="#" onclick="$.ajaxCall('user.ban', 'user_id={$aUser.user_id}&amp;type=0'); return false;">
                                {_p var='un_ban_user'}
                            </a>
                            {else}
                            <a href="{url link='admincp.user.ban' user=$aUser.user_id}">
                                {_p var='ban_user'}
                            </a>
                            {/if}
                        </li>
                        {/if}
                        {if Phpfox::getUserParam('user.can_delete_others_account')}
                        {if $aUser.user_group_id == ADMIN_USER_ID && Phpfox::getUserBy('user_group_id') != ADMIN_USER_ID}

                        {else}
                        <li>
                            <div class="user_delete">
                                <a href="#" onclick="tb_show('{_p var='delete_user' phpfox_squote=true}', $.ajaxBox('user.deleteUser', 'height=240&amp;width=400&amp;iUser={$aUser.user_id}'));return false;" title="{_p var='delete_user_full_name' full_name=$aUser.full_name|clean}">{_p var='delete_user'}</a></div></li>
                        {/if}

                        {/if}
                        {if Phpfox::getUserParam('user.can_member_snoop')}
                        <li><div class="user_delete"><a href="{url link='admincp.user.snoop' user=$aUser.user_id}" >{_p var='log_in_as_this_user'}</a></div></li>
                        {/if}
                    </ul>
                </div>
            </td>
            <td>#{$aUser.user_id}</td>
            <td>{img user=$aUser suffix='_50_square' max_width=50 max_height=50}</td>
            <td>{$aUser|user}</td>
            <td><a href="mailto:{$aUser.email}">{if (isset($aUser.pendingMail) && $aUser.pendingMail != '')} {$aUser.pendingMail} {else} {$aUser.email} {/if}</a>{if isset($aUser.unverified) && $aUser.unverified > 0} <span class="js_verify_email_{$aUser.user_id}" onclick="$.ajaxCall('user.verifyEmail', 'iUser={$aUser.user_id}');">{_p var='verify'}</span>{/if}</td>
            <td>
                {if ($aUser.status_id == 1)}
                <div class="js_verify_email_{$aUser.user_id}">{_p var='pending_email_verification'}</div>
                {/if}
                {if Phpfox::getParam('user.approve_users') && $aUser.view_id == '1'}
                <span id="js_user_pending_group_{$aUser.user_id}">{_p var='pending_approval'}</span>
                {elseif $aUser.view_id == '2'}
                {_p var='not_approved'}
                {else}
                {$aUser.user_group_title|convert}
                {/if}
            </td>
            <td>
                {if $aUser.last_activity > 0}
                {$aUser.last_activity|date:'core.profile_time_stamps'}
                {/if}
                {if !empty($aUser.last_ip_address)}
                <div class="p_4">
                    (<a href="{url link='admincp.core.ip' search=$aUser.last_ip_address_search}" title="{_p var='view_all_the_activity_from_this_ip'}">{$aUser.last_ip_address}</a>)
                </div>
                {/if}
            </td>
        </tr>
        {/foreach}
        </table>


        {/if}

        {/if}
        {if !PHPFOX_IS_AJAX && defined('PHPFOX_IS_ADMIN_SEARCH')}
        <div class="table_clear table_hover_action">
            <input type="submit" name="approve" value="{_p var='approve'}" class="button sJsCheckBoxButton disabled" disabled="disabled" />
            <input type="submit" name="ban" value="{_p var='ban'}" class="sJsConfirm button sJsCheckBoxButton disabled" disabled="disabled" />
            <input type="submit" name="unban" value="{_p var='un_ban'}" class="button sJsCheckBoxButton disabled" disabled="disabled" />
            <input type="submit" name="verify" value="{_p var='verify'}" class="button sJsCheckBoxButton disabled" disabled="disabled" />
            <input type="submit" name="resend-verify" value="{_p var='resend_verification_mail'}" class="button sJsCheckBoxButton disabled" disabled="disabled" />
            <input type="submit" name="delete" value="{_p var='delete'}" class="sJsConfirm button sJsCheckBoxButton disabled" disabled="disabled" />
        </div>
    </form>
</div>
{else}
    {if $aUsers}
    <div id="datingcont" style="display:none;{if !empty($searchtext)}border:none;margin-top:0;padding-top:0;{/if}"></div>
    <div id="imagecont">
        <div style="text-align: center;margin-bottom: -20px;"><img src="{$path}/source.gif" style="width:300px;" /></div>
        <div style="text-align: center"><h1>{_p var='Your love coming soon...'}</h1></div>
    </div>
    <script>
        {literal}
        setTimeout(function(){
            $('#page_dating_index #main').addClass("empty-right");
            getDatingUser("{/literal}{$searchtext}{literal}");
        },4000);
        {/literal}
    </script>
    {elseif !PHPFOX_IS_AJAX}
        {_p var="No members found."}
    {/if}
{/if}
{literal}
<script>
    setTimeout(function(){
        var i=0;
        $("#js_admincp_search_options div.col-sm-4").each(function(){
            i++;
            if (i==3) {
                var newdiv2 = document.createElement("div");
                newdiv2.classList.add('clr');;
                this.after(newdiv2);
                i=0;
            }
        })
    }, 3000)
</script>
{/literal}
{literal}
<style type="text/css">
    #cboxOverlay{background:url({/literal}{$path}{literal}/overlay.png) repeat 0 0; opacity: 0.9; filter: alpha(opacity = 90);}
    #cboxTopLeft{width:21px; height:21px; background:url({/literal}{$path}{literal}/controls.png) no-repeat -101px 0;}
    #cboxTopRight{width:21px; height:21px; background:url({/literal}{$path}{literal}/controls.png) no-repeat -130px 0;}
    #cboxBottomLeft{width:21px; height:21px; background:url({/literal}{$path}{literal}/controls.png) no-repeat -101px -29px;}
    #cboxBottomRight{width:21px; height:21px; background:url({/literal}{$path}{literal}/controls.png) no-repeat -130px -29px;}
    #cboxMiddleLeft{width:21px; background:url({/literal}{$path}{literal}/controls.png) left top repeat-y;}
    #cboxMiddleRight{width:21px; background:url({/literal}{$path}{literal}/controls.png) right top repeat-y;}
    #cboxTopCenter{height:21px; background:url({/literal}{$path}{literal}/border.png) 0 0 repeat-x;}
    #cboxBottomCenter{height:21px; background:url({/literal}{$path}{literal}/border.png) 0 -29px repeat-x;}
    #cboxContent{background:#fff; overflow:hidden;}
    .cboxIframe{background:#fff;}
    #cboxError{padding:50px; border:1px solid #ccc;}
    #cboxLoadedContent{margin-bottom:28px;}
    #cboxTitle{position:absolute; bottom:4px; left:0; text-align:center; width:100%; color:#949494;}
    #cboxCurrent{position:absolute; bottom:4px; left:58px; color:#949494;}
    #cboxLoadingOverlay{background:url({/literal}{$path}{literal}/loading_background.png) no-repeat center center;}
    #cboxLoadingGraphic{background:url({/literal}{$path}{literal}/loading.gif) no-repeat center center;}

    /* these elements are buttons, and may need to have additional styles reset to avoid unwanted base styles */
    #cboxPrevious, #cboxNext, #cboxSlideshow, #cboxClose {border:0; padding:0; margin:0; overflow:visible; width:auto; background:none; }

    /* avoid outlines on :active (mouseclick), but preserve outlines on :focus (tabbed navigating) */
    #cboxPrevious:active, #cboxNext:active, #cboxSlideshow:active, #cboxClose:active {outline:0;}

    #cboxSlideshow{position:absolute; bottom:4px; right:30px; color:#0092ef;}
    #cboxPrevious{position:absolute; bottom:0; left:0; background:url({/literal}{$path}{literal}/controls.png) no-repeat -75px 0; width:25px; height:25px; text-indent:-9999px;}
    #cboxPrevious:hover{background-position:-75px -25px;}
    #cboxNext{position:absolute; bottom:0; left:27px; background:url({/literal}{$path}{literal}/controls.png) no-repeat -50px 0; width:25px; height:25px; text-indent:-9999px;}
    #cboxNext:hover{background-position:-50px -25px;}
    #cboxClose{position:absolute; bottom:0; right:0; background:url({/literal}{$path}{literal}/controls.png) no-repeat -25px 0; width:25px; height:25px; text-indent:-9999px;}
    #cboxClose:hover{background-position:-25px -25px;}
</style>
{/literal}
{/if}