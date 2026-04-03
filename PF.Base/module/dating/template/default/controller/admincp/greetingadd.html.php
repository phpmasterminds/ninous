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
<script>
$Ready(function () {

   var emojis = [
		// 👋 Greetings / Hello
		"👋","🤝","🙏","😊","🙂","😄","😃","😉",

		// ❤️ Love / Appreciation
		"❤️","🤍","💖","💗","💘","💝","😍","🥰","😘","💋",

		// 👍 Positivity / Respect
		"👍","👏","🙌","🤗","😇","😎",

		// ✝️ Faith / Tradition (important for your app)
		"✝️","🕊️","🙏🏻","📿","⛪","🕯️",

		// ⭐ Premium / Special
		"⭐","🌟","✨","💫","🔥","⚡","💎","👑",

		// 🌸 Soft / Friendly
		"🌹","🌸","🌺","🍀","🌷",

		// 🎉 Expression / Action
		"🎉","🎊","🎯","💌","📩"
	];


    var popup = document.getElementById('emoji_popup');
    var btn   = document.getElementById('emoji_btn');
    var input = document.getElementById('emoji_input');

    emojis.forEach(function (e) {
        var span = document.createElement('span');
        span.textContent = e;
        span.style.fontSize = '22px';
        span.style.cursor = 'pointer';
        span.style.margin = '5px';
        span.onclick = function () {
            input.value = e;
            popup.style.display = 'none';
        };
        popup.appendChild(span);
    });

    btn.onclick = function () {
        popup.style.display =
            popup.style.display === 'none' ? 'block' : 'none';
    };

    document.addEventListener('click', function (e) {
        if (!popup.contains(e.target) && e.target !== btn) {
            popup.style.display = 'none';
        }
    });
});
</script>
{/literal}

{if $bIsEdit}
<form method="post" action="{url link='admincp.dating.greetingadd' id=$iEditId}" enctype="multipart/form-data">
	<div><input type="hidden" name="val[edit_id]" value="{$iEditId}" /></div>
	<div><input type="hidden" name="val[title]" value="{$aForms.title}" /></div>
{else}
<form method="post" action="{url link='admincp.dating.greetingadd'}" enctype="multipart/form-data">
{/if}

    <div class="table form-group">
        <div class="table_left">
            {_p var='Title'}:
        </div>
        <div class="table_right">
            <input type="text" class="form-control" name="val[title]" value="{if !empty($aForms.title)}{$aForms.title}{/if}"  maxlength="100"/>
        </div>
        <div class="clear"></div>
    </div>
	
	<div class="table form-group">
        <div class="table_left">
            {_p var='Tier'}:
        </div>
        <div class="table_right">
            <select name='val[tier]' class="form-control">
				<option value="">Select</option>
				<option value="tier1" {if  $aForms.tier == 'tier1'} selected{/if}>Tier 1</option>
				<option value="tier2" {if  $aForms.tier == 'tier2'} selected{/if}>Tier 2</option>
				<option value="tier3" {if  $aForms.tier == 'tier3'} selected{/if}>Tier 3</option>
			</select>
        </div>
        <div class="clear"></div>
    </div>
	
	
	<div class="table form-group">
    <div class="table_left">
        {_p var='Emoji'}:
    </div>
    <div class="table_right" style="position:relative;">
        <input type="text"
               id="emoji_input"
               name="val[emoji]"
               value="{if !empty($aForms.emoji)}{$aForms.emoji}{/if}"
               class="form-control"
               style="width:80px;font-size:24px;display:inline-block;"
               readonly />

        <button type="button"
                id="emoji_btn"
                class="btn btn-primary"
                style="margin-left:10px;">
            😀 Choose
        </button>

        <div id="emoji_popup"
             style="display:none;
                    position:absolute;
                    z-index:9999;
                    background:#fff;
                    border:1px solid #ddd;
                    padding:10px;
                    border-radius:6px;
                    box-shadow:0 4px 10px rgba(0,0,0,.15);
                    width:260px;
                    margin-top:8px;">
        </div>
    </div>
    <div class="clear"></div>
</div>

	
	
	<div class="table_clear">
		<input type="submit" value="{_p var='submit'}" class="button btn-primary" />
	</div>
</form>