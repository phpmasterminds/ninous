<div class="profile-sidebar">
    <ul class="profile-menu">
        <li><a href="#">Dashboard</a></li>
        <li {if $aCurrent =='profile' && $aOwnProfile}class="active"{/if}><a href="{url link='dating.profile'}">My Profile</a></li>
        <li {if $aCurrent =='question'}class="active"{/if}><a href="{url link='dating.question'}">Questionnaire</a></li>
        <li {if $aCurrent =='matches'}class="active"{/if}><a href="{url link='dating.matches'}">Matches</a></li>
        <li><a href="#">Mutual Likes</a></li>
        <li><a href="#">Pray &amp; Discern</a></li>
        <li><a href="#">Settings</a></li>
    </ul>
</div>
<div class="clear"></div>
{literal}
<style>
.profile-sidebar {
    background: #f7f7f7;
    border: 1px solid #ddd;
    padding: 15px 0;
}

.profile-menu {
    list-style: none;
    margin: 0;
    padding: 0;
}

.profile-menu li {
    margin: 0;
}

.profile-menu li a {
    display: block;
    padding: 10px 20px;
    color: #333;
    text-decoration: none;
    font-size: 14px;
}

.profile-menu li a:hover {
    background: #ececec;
}

.profile-menu li.active a {
    font-weight: bold;
    background: #ffffff;
    border-left: 3px solid #000;
}

</style>
{/literal}