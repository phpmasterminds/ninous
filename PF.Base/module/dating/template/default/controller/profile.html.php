{literal}
<style>
.profile-card {
    background: #fff;
    border-radius: 4px;
    padding: 8px;
}
.connection-status {
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 3px;
}
.match-percent {
    color: #28a745;
    font-size: 22px;
    font-weight: bold;
}
.profile-img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
}
.btn-disabled {
    background: #e0e0e0;
    border: none;
    color: #999;
    cursor: not-allowed;
}
.section-title {
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 10px;
}
.path-box {
    background: #fff;
    border-radius: 4px;
    padding: 8px;
}
.path-box h5 {
    color: #6f9cf3;
}
.path-link {
    display: block;
    margin-bottom: 10px;
    color: #007bff;
    text-decoration: none;
}
.path-link:hover {
    text-decoration: underline;
}
.locked {
    color: #ccc;
}
.d-flex {
    display: flex;
}
.justify-content-between {
    justify-content: space-between;
}
.justify-content-space-evenly {
    justify-content: space-evenly;
}
.align-items-center {
    align-items: center;
}
.header-background {
    background: #fff3cd;
    border: 1px solid #ffeeba;
}
</style>
{/literal}

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-3 header-background">
    <h4 style="line-height:0;padding:6px 12px;">
        {$aUser.full_name}’s Profile
    </h4>

    {if !$aOwnProfile}
        <div class="connection-status">
            <strong>Connection status:</strong> No connection yet.
        </div>
    {/if}
</div>

<div class="row">

    <!-- LEFT PROFILE -->
    <div class="col-md-7">
        <div class="profile-card">

            <div class="d-flex justify-content-space-evenly">
                {img user=$aUser suffix='_120_square' max_width=90 max_height=90 class="profile-img mr-3"}

                <div>
					{if !$aOwnProfile}
                    <div class="match-percent">
                        {$aUser.match_percent}% Match
                    </div>
					{/if}

                    <h5>
                        {$aUser.full_name}, {$aUser.birthday|age}
                        <span class="badge badge-primary">Verified</span>
                    </h5>

                    <p class="mb-1">OCA</p>
                    <p>{$aUser.city_location}, {$aUser.country_child_id|location_child}</p>
					{if !$aUser.is_poked2}
						<button class="btn btn-disabled btn-sm mr-2">
							Send Message
						</button>
					{else}
						<button class="btn btn-default" onclick="$Core.composeMessage({left_curly}user_id: {$aUser.user_id}{right_curly}); return false;">
							<i class="ico ico-user3-next-o mr-1"></i>Send Message
						</button>
					{/if}
					
                    <button class="btn btn-disabled btn-sm">
                        Video Call
                    </button>
                </div>
            </div>

            <!-- WHY YOU MATCHED / MY PROFILE -->
            {if !$aOwnProfile}
                <div class="section-title text-primary">Why you matched</div>
            {else}
                <div class="section-title text-primary">My Profile</div>
            {/if}

            {if isset($aUser.matched_details) && $aUser.matched_details|@count}
				{foreach from=$aUser.matched_details key=sSection item=aLines}
				<p>
					<strong>{$sSection}:</strong>
					{$aLines|@implode:", "}
				</p>
			{/foreach}


               
            {else}
                <p class="text-muted">
                    No matching details available.
                </p>
            {/if}

            <!-- ABOUT ME 
            <div class="section-title">About Me</div>

            {if !empty($aUser.about_me)}
                <p>{$aUser.about_me|clean}</p>
            {else}
                <p class="text-muted">No description provided.</p>
            {/if}-->

        </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="col-md-5">
        {if !$aOwnProfile}
            <div class="path-box">

                <h5>Paths to Connection</h5>

                <p class="text-muted">
                    A simple way to begin getting to know each other,
                    step by step.
                </p>

                <div class="section-title text-success">Greetings</div>
				
				
						<!--<a href="#" id="poke_{$aUser.user_id}" class="button btn-black" onclick="$Core.box('poke.poke', 400, 'user_id={$aUser.user_id}');    return false;"><i class="fa fa-angellist"></i> {_p var='poke'}</a>-->
						{foreach from=$aGreetings key=sSection item=aGret}
						<a href="javascript:void(0);" class="path-link" onclick="$Core.box('dating.greet', 400, 'user_id={$aUser.user_id}&greet_id={$aGret.greeting_id}&tier={$aGret.tier}');    return false;">{$aGret.emoji} {$aGret.title}</a>
						{/foreach}
						
					
                <hr>

                <div class="locked">
                    <div class="section-title">Expressions</div>
					
					{if !$aUser.is_poked}
                    <p class="mb-1">
                        Show genuine interest. When both share Expressions,
                        messaging unlocks.
                    </p>
					{else}
						{foreach from=$aGreeting2 key=sSection item=aGret}
						<a href="javascript:void(0);" class="path-link" onclick="$Core.box('dating.greet', 400, 'user_id={$aUser.user_id}&greet_id={$aGret.greeting_id}&tier={$aGret.tier}');    return false;">{$aGret.emoji} {$aGret.title}</a>
						{/foreach}
					{/if}
                </div>

                <hr>

                <div class="locked">
                    <strong>True Interest</strong>
                    <p>Signals serious interest.</p>
                </div>

            </div>
        {/if}
    </div>

</div>
