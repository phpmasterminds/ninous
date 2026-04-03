function getDatingUser(searchText)
{
    $.ajaxCall('dating.getDatingUser','searchtext=' + searchText);
}

function like(userId, isuser)
{
    $.ajaxCall('dating.like','isuser=' + isuser + '&user_id=' + userId);
}

function next(userId, isuser)
{
    $.ajaxCall('dating.next','isuser=' + isuser + '&user_id=' + userId);
}

var activeTab = 'tab';
function changeDatingTab(tab, object)
{
    if (activeTab == tab) {
        return false;
    }
    $("#a_" + activeTab).removeClass("active_dating");
    activeTab = tab;

    $("#a_" + tab).addClass("active_dating");
    $("#dating_tab").hide();
    $("#dating_dating").hide();
    $("#dating_badge").hide();
    $("#dating_photo").hide();
    $("#dating_video").hide();
    $("#dating_" + tab).fadeIn();

}

