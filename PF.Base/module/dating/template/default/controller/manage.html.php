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
    #page_dating_manage .pricing-table {
        display: flex;
        align-items: center;
        padding: 30px;
        margin-top:15px;
        justify-content: center;
        border: 1px solid #eee;
        background: #f8f8f8;
        flex-direction: column;
    }
    #page_dating_manage .pricing-table h2 {
        margin: 0 0 15px;
        padding: 0;
    }
    #page_dating_manage .visitor-price {
        margin-bottom: 20px;
        font-size: 18px;
    }
    #page_dating_manage .visitor-payment-text {
        font-size: 12px;
        color: #999;
        margin-top: 10px;
        text-align: center;
    }
</style>
{/literal}
{if empty($isSponsor.pay_date) and !empty($currency)}
{_p var='Select your package (click on button) and buy that your dating profile have more views. Increasing views count x10.'}
   <div class="row">
        {if Phpfox::getParam('dating.dayfeatured')}
        <div class="col-sm-4">
            <div class="pricing-table">
                <h2>
                    {_p var='Daily Access'}
                </h2>
                <div class="visitor-price">{$currency}{php}echo Phpfox::getParam('dating.dayfeatured');{/php} / {_p var='For 1 day'}</div>
                <a href="{url link='current'}?featured=1" class="button btn btn-warning">
                    {_p var='Order Now'}
                </a>
                <div class="visitor-payment-text">
                    {_p var='Purchasing this subscription your agreed our terms of services'}
                </div>
            </div>
        </div>
        {/if}
        {if Phpfox::getParam('dating.weekfeatured')}
       <div class="col-sm-4">
           <div class="pricing-table">
               <h2>
                   {_p var='Weekly Access'}
               </h2>
               <div class="visitor-price">{$currency}{php}echo Phpfox::getParam('dating.weekfeatured');{/php} / {_p var='For 1 week'}</div>
               <a href="{url link='current'}?featured=2" class="button btn btn-warning">
                   {_p var='Order Now'}
               </a>
               <div class="visitor-payment-text">
                   {_p var='Purchasing this subscription your agreed our terms of services'}
               </div>
           </div>
       </div>
        {/if}
        {if Phpfox::getParam('dating.monthfeatured')}
       <div class="col-sm-4">
           <div class="pricing-table">
               <h2>
                   {_p var='Monthly Access'}
               </h2>
               <div class="visitor-price">{$currency}{php}echo Phpfox::getParam('dating.monthfeatured');{/php} / {_p var='For 1 month'}</div>
               <a href="{url link='current'}?featured=3" class="button btn btn-warning">
                   {_p var='Order Now'}
               </a>
               <div class="visitor-payment-text">
                   {_p var='Purchasing this subscription your agreed our terms of services'}
               </div>
           </div>
       </div>
        {/if}
   </div>
{/if}

{if !empty($isSponsor.pay_date)}
    <div style="margin:0 0 10px;">
        {_p var='You have enabled sponsored. Date end:'} <b>{$isSponsor.pay_date|convert_time}</b>
    </div>
{/if}
<div class="separate"></div>
<h1>{_p var='Dating information'}</h1>
<div style="margin-bottom: 20px;">
    {_p var='Please fill dating information, that users who want to meet have enough information about you. Please be honest.'}
</div>
<form method="post" action="{url link='current'}" enctype="multipart/form-data" id="js_marketplace_form">
    {if Phpfox::getParam('dating.enableparticipation')}
        <div class="table form-group">
            <div class="table_left">
                <label for="title">{_p var='Participate in Dating'}</label>
            </div>
            <div class="table_right">
                <input  value="1" type="checkbox" name="dating_participate" {if !empty($aForms)}{if !empty($aForms.dating_participate)}checked{/if}{/if} />
            </div>
        </div>
    {else}
        <div class="table form-group">
            <div class="table_left">
                <label for="title">{_p var='Exclude my profile from dating results'}</label>
            </div>
            <div class="table_right">
                <input  value="1" type="checkbox" name="exclude" {if !empty($aForms)}{if !empty($aForms.exclude)}checked{/if}{/if} />
            </div>
        </div>
    {/if}
    {foreach from=$fields item=field}
        {if $field.type == 'text'}
            <div class="table form-group">
                <div class="table_left">
                    <label for="title">{softPhrase var=$field.title}</label>
                </div>
                <div class="table_right">
                    <input class="form-control" type="text" name="val[field_{$field.field_id}]" value="{php}if (!empty($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']])) { echo $this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']];} {/php}" />
                </div>
            </div>
        {elseif $field.type == 'textarea'}
            <div class="table form-group">
                <div class="table_left">
                    <label for="title">{softPhrase var=$field.title}</label>
                </div>
                <div class="table_right">
                    <textarea rows='5' class="form-control"name="val[field_{$field.field_id}]">{php}if (!empty($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']])) { echo $this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']];} {/php}</textarea>
                </div>
            </div>
        {elseif $field.type == 'checkbox'}
            <div class="table form-group">
                <div class="table_left">
                    <label for="title">{softPhrase var=$field.title}</label>
                </div>
                <div class="table_right">
                    <input type="hidden" name="val[field_{$field.field_id}]" value="0" />
                    <input value="1" type="checkbox" name="val[field_{$field.field_id}]" {php}if (!empty($this->_aVars['aForms']['field_'.$this->_aVars['field']['field_id']])) { echo 'checked';} {/php} />
                </div>
            </div>
        {/if}
    {/foreach}

    <div class="table_clear">
        <input type="submit" value="{_p var='Update'}" class="button btn btn-primary" />
    </div>
</form>