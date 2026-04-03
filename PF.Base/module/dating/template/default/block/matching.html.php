{literal}
<style>
  .matches-wrapper {}

  .item-event-member-block {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
  }

  .item-event-member-block .col-md-6 {
    flex: 0 0 calc(50% - 8px);
    display: flex;           /* <-- key: makes child stretch */
  }

  .match-card {
    border: 1px solid #e5e5e5;
    border-radius: 6px;
    padding: 20px;
    cursor: pointer;
    transition: box-shadow 0.2s ease;
    width: 100%;
    display: flex;           /* <-- key: fills the col height */
    flex-direction: column;
  }

  .match-card > a {
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .match-card > a > .d-flex {
    flex: 1;
  }

  .match-card:hover {
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  }
  .match-percent {
    color: #6aa84f;
    font-weight: 600;
  }
  .verified-badge {
    color: #3b82f6;
    font-size: 14px;
    margin-left: 6px;
  }
  .profile-img {
    width: 72px;
    height: 72px;
    object-fit: cover;
    border-radius: 50%;
  }
  .match-link {
    font-size: 14px;
    text-decoration: none;
  }
  .d-flex {
    display: flex;
  }
  .justify-content-between {
    justify-content: space-between;
    align-items: flex-end;
  }
</style>
{/literal}

<div class="matches-wrapper">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-start mb-4">
    <div>
      <h4 class="fw-bold">Your Matches!</h4>
      <p class="help-block mb-0">
        These matches are based on your faith, lifestyle, and values.
        Take time to pray, reflect, and reach out respectfully.
      </p>
    </div>
    <a href="{url link='dating.question'}" class="text-decoration-none">Back to Questionnaire</a>
  </div>

  <!-- Matches Grid row g-4-->
  <div class="item-event-member-block">

    <!-- Match Card -->
	{foreach from=$aUsers name=friends item=aUser}
    <div class="col-md-6">
      <div class="match-card">
		<a href="{url link='dating.profile' userid=$aUser.user_id}" class="match-link">
        <div class="d-flex justify-content-between">
          <div>
            <div class="match-percent">
				{$aUser.match_percent}% Match
              <span class="verified-badge">✔ Verified</span>
            </div>
            <h5 class="mb-1">{$aUser.full_name}</h5>
            <div class="help-block">OCA</div>
            <div class="help-block mb-2">
				{$aUser.city_location}{if $aUser.country_child_id}, {$aUser.country_child_id|location_child}{/if}
			</div>
            <a href="{url link='dating.profile' userid=$aUser.user_id}" class="match-link">{_p var='see_why_yu_and_match' full_name=$aUser.full_name}</a>
          </div>
          {img user=$aUser suffix='_120_square' max_width=50 max_height=50 no_link=true}
        </div>
		</a>
      </div>
    </div>
	{/foreach}
    {pager}
 

  </div>
</div>