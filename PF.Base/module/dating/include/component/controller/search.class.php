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
class Dating_Component_Controller_Search extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        Phpfox::isUser();
        Dating_Service_Dating::instance()->getSectionMenu();
        $sViewParam = $this->request()->get('view');
        $aSpecialPages = [
            'online',
            'featured'
        ];
        if (in_array($sViewParam, $aSpecialPages)){
            $bOldWay = true;
        } else {
            $bOldWay = false;
        }
        if (!$bOldWay && ($this->request()->get('featured') || $this->request()->get('recommend'))) {
            return function() {
                if ($this->request()->get('recommend')) {
                    //Hide users you may know if not login
                    if (Phpfox::isUser()){
                        $title = _p('users_you_may_know');
                        if (Phpfox::isModule('friend')){
                            $users = Friend_Service_Suggestion::instance()->get();
                        } else {
                            $users = false;
                        }
                        if (!$users) {
                            $users = User_Service_Featured_Featured::instance()->getOtherGender();
                        }
                    } else {
                        $title = '';
                        $users = [];
                    }
                } else{
                    $title = _p('recently_active');
                    $users = User_Service_Featured_Featured::instance()->getRecentActiveUsers();
                }

                $content = '';
                if ((is_array($users) && !$users) || $users === true) {

                } else {
                    $content .= '<div class="block_clear"><div class="title">' . $title . '</div><div class="content"><div class="wrapper-items">';
                    foreach ($users as $user) {
                        $content .= $this->template()->assign('aUser', $user)->getTemplate('user.block.rows_wide', true);
                    }
                    $content .= '</div></div></div>';
                }
                echo $content;
                http_cache()->set();
                http_cache()->run();
                exit;
            };
        }
        if ($sPlugin = Phpfox_Plugin::get('user.component_controller_browse__1')){eval($sPlugin);if (isset($aPluginReturn)){return $aPluginReturn;}}

        $aCallback = $this->getParam('aCallback', false);
        if ($aCallback !== false)
        {
            if (!Phpfox::getService('group')->hasAccess($aCallback['item'], 'can_view_members'))
            {
                return Phpfox_Error::display(_p('members_section_is_closed'));
            }
        }

        $aCheckParams = array(
            'url' => $this->url()->makeUrl('user.browse'),
            'start' => 2,
            'reqs' => array(
                '2' => array('browse')
            )
        );

        if (Phpfox::getParam('core.force_404_check') && !PHPFOX_IS_AJAX && !Core_Service_Redirect_Redirect::instance()->check404($aCheckParams))
        {
            return Phpfox_Module::instance()->setController('error.404');
        }


        $aPages = array(21, 31, 41, 51);
        $aDisplays = array();
        foreach ($aPages as $iPageCnt)
        {
            $aDisplays[$iPageCnt] = _p('per_page', array('total' => $iPageCnt));
        }

        $aSorts = array(
            'u.full_name' => _p('name'),
            'u.joined' => _p('joined'),
            'u.last_login' => _p('last_login'),
            'ufield.total_rating' => _p('rating')
        );

        $aAge = array();
        for ($i = User_Service_User::instance()->age(User_Service_User::instance()->buildAge(1, 1, Phpfox::getParam('user.date_of_birth_end'))); $i <= User_Service_User::instance()->age(User_Service_User::instance()->buildAge(1, 1, Phpfox::getParam('user.date_of_birth_start'))); $i++)
        {
            $aAge[$i] = $i;
        }

        $iYear = date('Y');
        $aUserGroups = array();
        foreach (User_Service_Group_Group::instance()->get() as $aUserGroup)
        {
            $aUserGroups[$aUserGroup['user_group_id']] = Phpfox_Locale::instance()->convert($aUserGroup['title']);
        }

        $aGenders = Core_Service_Core::instance()->getGenders();
        $aGenders[''] = (count($aGenders) == '2' ? _p('both') : _p('all'));

        if (($sPlugin = Phpfox_Plugin::get('user.component_controller_browse_genders')))
        {
            eval($sPlugin);
        }

        $sDefaultOrderName = 'RAND()';
        $sDefaultSort = '';

        $iDisplay = 1;
        $aFilters = array(
            'display' => array(
                'type' => 'select',
                'options' => $aDisplays,
                'default' => $iDisplay
            ),
            'sort' => array(
                'type' => 'select',
                'options' => $aSorts,
                'default' => $sDefaultOrderName
            ),
            'sort_by' => array(
                'type' => 'select',
                'options' => array(
                    'DESC' => _p('descending'),
                    'ASC' => _p('ascending')
                ),
                'default' => $sDefaultSort
            ),
            'keyword' => array(
                'type' => 'input:text',
                'size' => 15,
                'class' => 'txt_input'
            ),
            'type' => array(
                'type' => 'select',
                'options' => array(
                    '0' => array(_p('email_name'), 'AND ((u.full_name LIKE \'%[VALUE]%\' OR (u.email LIKE \'%[VALUE]@%\' OR u.email = \'[VALUE]\'))' . (defined('PHPFOX_IS_ADMIN_SEARCH') ? ' OR u.email LIKE \'%[VALUE]\'' : '') .')'),
                    '1' => array(_p('email'), 'AND ((u.email LIKE \'%[VALUE]@%\' OR u.email = \'[VALUE]\'' . (defined('PHPFOX_IS_ADMIN_SEARCH') ? ' OR u.email LIKE \'%[VALUE]%\'' : '') .'))'),
                    '2' => array(_p('name'), 'AND (u.full_name LIKE \'%[VALUE]%\')')
                ),
                'depend' => 'keyword'
            ),
            'group' => array(
                'type' => 'select',
                'options' => $aUserGroups,
                'add_any' => true,
                'search' => 'AND u.user_group_id = \'[VALUE]\''
            ),
            'gender' => array(
                'type' => 'input:radio',
                'options' => $aGenders,
                'default_view' => '',
                'search' => 'AND u.gender = \'[VALUE]\'',
                'suffix' => '<br />'
            ),
            'from' => array(
                'type' => 'select',
                'options' => $aAge,
                'select_value' => _p('from')
            ),
            'to' => array(
                'type' => 'select',
                'options' => $aAge,
                'select_value' => _p('to')
            ),
            'country' => array(
                'type' => 'select',
                'options' => Core_Service_Country_Country::instance()->get(),
                'search' => 'AND u.country_iso = \'[VALUE]\'',
                'add_any' => true,
                // 'style' => 'width:150px;',
                'id' => 'country_iso'
            ),
            'country_child_id' => array(
                'type' => 'select',
                'search' => 'AND ufield.country_child_id = \'[VALUE]\'',
                'clone' => true
            ),
            'status' => array(
                'type' => 'select',
                'options' => array(
                    '2' => _p('all_members'),
                    '1' => _p('featured_members'),
                    '4' => _p('online'),
                    '3' => _p('pending_verification_members'),
                    '5' => _p('pending_approval'),
                    '6' => _p('not_approved')
                ),
                'default_view' => '2',
            ),
            'city' => array(
                'type' => 'input:text',
                'size' => 15,
                'search' => 'AND ufield.city_location LIKE \'%[VALUE]%\''
            ),
            'zip' => array(
                'type' => 'input:text',
                'size' => 10,
                'search' => 'AND ufield.postal_code = \'[VALUE]\''
            ),
            'show' => array(
                'type' => 'select',
                'options' => array(
                    '1' => _p('name_and_photo_only'),
                    '2' => _p('name_photo_and_users_details')
                ),
                'default_view' => (Phpfox::getParam('user.user_browse_display_results_default') == 'name_photo_detail' ? '2' : '1')
            ),
            'ip' => array(
                'type' => 'input:text',
                'size' => 10
            )
        );

        if (!Phpfox::getUserParam('user.can_search_by_zip'))
        {
            unset ($aFilters['zip']);
        }
        if ($sPlugin = Phpfox_Plugin::get('user.component_controller_browse_filter'))
        {
            eval($sPlugin);
        }

        $aSearchParams = array(
            'type' => 'browse',
            'filters' => $aFilters,
            'search' => 'keyword',
            'custom_search' => true
        );

        if (!defined('PHPFOX_IS_ADMIN_SEARCH'))
        {
            $aSearchParams['no_session_search'] = true;
        }

        $oFilter = Phpfox_Search::instance()->set($aSearchParams);

        $sStatus = $oFilter->get('status');
        $sView = $this->request()->get('view');
        $aCustomSearch = $oFilter->getCustom();
        $bIsOnline = false;
        $bPendingMail = false;
        $mFeatured = false;
        $bIsGender = false;

        switch ((int) $sStatus)
        {
            case 1:
                $mFeatured = true;
                break;
            case 3:
                if (defined('PHPFOX_IS_ADMIN_SEARCH'))
                {
                    $oFilter->setCondition('AND u.status_id = 1');
                }
                break;
            case 4:
                $bIsOnline = true;
                break;
            case 5:
                if (defined('PHPFOX_IS_ADMIN_SEARCH'))
                {
                    $oFilter->setCondition('AND u.view_id = 1');
                }
                break;
            case 6:
                if (defined('PHPFOX_IS_ADMIN_SEARCH'))
                {
                    $oFilter->setCondition('AND u.view_id = 2');
                }
                break;
            default:

                break;
        }

        $this->template()->setTitle(_p('browse_members'))->setBreadCrumb(_p('browse_members'), ($aCallback !== false ? $this->url()->makeUrl($aCallback['url_home']) : $this->url()->makeUrl((defined('PHPFOX_IS_ADMIN_SEARCH') ? 'admincp.' : '') . 'user.browse')));

        if (($iFrom = $oFilter->get('from')) || ($iFrom = $this->request()->getInt('from')))
        {
            $oFilter->setCondition('AND u.birthday_search <= \'' . Phpfox::getLib('date')->mktime(0, 0, 0, 1, 1, $iYear - $iFrom). '\'' . ' AND ufield.dob_setting IN(0,1,2)');
            $bIsGender = true;
        }
        if (($iTo = $oFilter->get('to')) || ($iTo = $this->request()->getInt('to')))
        {
            $oFilter->setCondition('AND u.birthday_search >= \'' . Phpfox::getLib('date')->mktime(0, 0, 0, 1, 1, $iYear - $iTo) .'\'' . ' AND ufield.dob_setting IN(0,1,2)');
            $bIsGender = true;
        }

        if (($sLocation = $this->request()->get('location')))
        {
            $oFilter->setCondition('AND u.country_iso = \'' . Phpfox_Database::instance()->escape($sLocation) . '\'');
        }

        if (($sGender = $this->request()->getInt('gender')))
        {
            $oFilter->setCondition('AND u.gender = \'' . Phpfox_Database::instance()->escape($sGender) . '\'');
        }

        if (($sLocationChild = $this->request()->getInt('state')))
        {
            $oFilter->setCondition('AND ufield.country_child_id = \'' . Phpfox_Database::instance()->escape($sLocationChild) . '\'');
        }

        if (($sLocationCity = $this->request()->get('city-name')))
        {
            $oFilter->setCondition('AND ufield.city_location = \'' . Phpfox_Database::instance()->escape(Phpfox::getLib('parse.input')->convert($sLocationCity)) . '\'');
        }

        if (!defined('PHPFOX_IS_ADMIN_SEARCH'))
        {
            $oFilter->setCondition('AND u.status_id = 0 AND u.view_id = 0');
            if (Phpfox::isUser()) {
                $aBlockedUserIds = User_Service_Block_Block::instance()->get(null, true);
                if (!empty($aBlockedUserIds)) {
                    $oFilter->setCondition('AND u.user_id NOT IN (' . implode(',', $aBlockedUserIds) . ')');
                }
            }
        }
        else
        {
            $oFilter->setCondition('AND u.profile_page_id = 0');
        }

        if (defined('PHPFOX_IS_ADMIN_SEARCH') && ($sIp = $oFilter->get('ip')))
        {
            User_Service_Browse::instance()->ip($sIp);
        }

        $bExtend = (defined('PHPFOX_IS_ADMIN_SEARCH') ? true : (((($oFilter->get('show') && $oFilter->get('show') == '2') || (!$oFilter->get('show') && Phpfox::getParam('user.user_browse_display_results_default') == 'name_photo_detail')) ? true : false)));
        $iPage = $this->request()->getInt('page');
        $iPageSize = $oFilter->getDisplay();

        if (($sPlugin = Phpfox_Plugin::get('user.component_controller_browse_filter_process'))) {
            eval($sPlugin);
        }

        $iCnt = 0;
        $aUsers = [];
        $isDating = false;
        $cond = Dating_Service_Dating::instance()->getFilter();
        $userName = $this->getParam('searchtext');
        if (!empty($userName)) {
            $singleUser = User_Service_User::instance()->getByUserName($userName);
        }

        $status = array('status' => '','phrase' => '');
        $isUser = 0;

        if (!empty($singleUser["user_id"])) {
            $oFilter->clearConditions();
            $oFilter->setCondition(" AND u.user_id = ".$singleUser["user_id"]);
            $isUser =  $singleUser["user_id"];
            $status = Dating_Service_Dating::instance()->getStatus($singleUser["user_id"]);
        } elseif (!empty($cond["cond"])) {
            $oFilter->clearConditions();
            //EXCLUDE LIKES AND NEXT
            $ids = Dating_Service_Dating::instance()->getCurrentIds();
            if (!empty($ids)) {
                $cond["cond"] .= " AND u.user_id NOT IN({$ids})";
            }
            $oFilter->setCondition($cond["cond"]);
            //CHECK IF DATING CRITERIA EXISTS
            $str = implode("_", $oFilter->getConditions());
            $check = strpos($str, 'field_');
            if ($check !== false) {
                $isDating = true;
            }
        } else {
            //EXCLUDE LIKES AND NEXT
            $ids = Dating_Service_Dating::instance()->getCurrentIds();
            if (!empty($ids)) {
                $oFilter->setCondition(" AND u.user_id NOT IN({$ids})");
            }
        }

        if (empty($singleUser["user_id"])) {
            $oFilter->setCondition(" AND u.user_id<>" . Phpfox::getUserId());
        }

        //Dating participate
        if (Phpfox::getParam('dating.enableparticipation')) {
            $datingParticipate = Phpfox::getService('dating')->getDatingParticipate();
            $oFilter->setCondition(" AND u.dating_participate = 1");
            $this->template()->assign([
                'datingParticipate' => $datingParticipate
            ]);
        } else {
            $oFilter->setCondition(" AND u.exclude = 0");
        }

        list($iCnt, $aUsers) = Dating_Service_Browse::instance()->conditions($oFilter->getConditions())
            ->callback($aCallback)
            ->sort($oFilter->getSort())
            ->page($oFilter->getPage())
            ->limit($iPageSize)
            ->online($bIsOnline)
            ->isDating($isDating)
            ->extend((isset($bExtendContent) ? true : $bExtend))
            ->featured($mFeatured)
            ->pending($bPendingMail)
            ->custom($aCustomSearch)
            ->gender($bIsGender)
            ->get();

        $aNewCustomValues = array();
        if ($aCustomValues = $this->request()->get('custom'))
        {
            if (is_array($aCustomValues)) {
                foreach ($aCustomValues as $iKey => $sCustomValue) {
                    $aNewCustomValues['custom[' . $iKey . ']'] = $sCustomValue;
                }
            }
        }

            Phpfox_Pager::instance()->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));


        Phpfox_Url::instance()->setParam('page', $iPage);

        if ($this->request()->get('featured') == 1)
        {
            $this->template()->setHeader(array(
                    'drag.js' => 'static_script',
                    '<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'user.setFeaturedOrder\'}); }</script>'
                )
            )
                ->assign(array('bShowFeatured' => 1));
        }
        foreach ($aUsers as $iKey => $aUser)
        {
            if (!isset($aUser['user_group_id']) || empty($aUser['user_group_id']) ||  $aUser['user_group_id'] < 1)
            {
                $aUser['user_group_id'] = $aUsers[$iKey]['user_group_id'] = 5;
                User_Service_Process::instance()->updateUserGroup($aUser['user_id'], 5);
                $aUsers[$iKey]['user_group_title'] = _p('user_banned');
            }
            $aBanned = Ban_Service_Ban::instance()->isUserBanned($aUser);
            $aUsers[$iKey]['is_banned'] = $aBanned['is_banned'];

            //GET USER PHOTO
            $defaultPhoto = Dating_Service_Dating::instance()->getDefaultPhoto($aUser["user_id"]);
            if (!empty($defaultPhoto)) {
                $aUsers[$iKey]["dating_photo"] = $defaultPhoto["image_path"];
            } elseif (empty($aUser["user_image"])) {
                $aUsers[$iKey]["dating_photo"] = setting('core.path_actual') . "PF.Base/module/dating/static/image/nophoto.jpg";
                $aUsers[$iKey]["is_nophoto"] = 1;
            }

            //GET BADGES IF ENABLE
            if (Phpfox::isModule('badge')) {
                $userbadges = PhpFox::getService('badge.callback')->queryusers("user_id ={$aUser["user_id"]}", "RAND()", false, 100000000);
                if (!empty($userbadges[1])) {
                    foreach ($userbadges[1] as &$item) {
                        $badge = PhpFox::getService('badge.callback')->query("id={$item["badge_id"]}");
                        $item["badge"] = $badge[1][0];
                        $item["badge_html"] = PhpFox::getService('badge.callback')->geticon($badge[1][0]);
                        $item["badge_title"] = $badge[1][0]['title'];
                        $item["badge_url"] = PHPFOX::permalink('badge.badge', $badge[1][0]["id"], $badge[1][0]['title']);
                        $item["total_members"] = $badge[1][0]['total_members'];
                        $item["user_date"] = $item["time_stamp"];
                    }

                    $this->template()->assign(array(
                        'badges' => $userbadges[1]
                    ));
                }
            }

            //GET HOROSCOPE
            if (Phpfox::isModule('horosrelation')) {
                if (!empty($aUser['horoscope'])) {
                    $aUsers[$iKey]["horoscope1"] = Phpfox::getService("horosrelation.process")->updateUserHoroscope($aUser['horoscope']);
                }
            }

            //GET DATING FIELDS
            $aUsers[$iKey]['dating_fields'] = Dating_Service_Dating::instance()->getDataView($aUser["user_id"]);

            //GET DATING PHOTOS
            $aUsers[$iKey]['dating_photos'] = Dating_Service_Dating::instance()->getPhotos($aUser["user_id"]);

            //GET DATING VIDEOS
            $aUsers[$iKey]['dating_videos'] = Dating_Service_Dating::instance()->getVideos($aUser["user_id"]);

            //GET ADDITIONAL INFO
            $aUsers[$iKey]['is_poked'] = Phpfox::getService('dating')->ispoked($aUser["user_id"],PHPFOX::getUserId());
            $aUsers[$iKey]['is_online'] = Phpfox::getService('dating')->isOnline($aUser["user_id"]);

            //GET USER RATING FROM ADVANCEDMEMBER
            if (Phpfox::isModule("advancedmembers")) {
                $user_rating = Phpfox::getService('advancedmembers.browse')->getrating($aUser["user_id"], PHPFOX::getUserId());
                $aUsers[$iKey]['recommend'] = Phpfox::getService('advancedmembers.browse')->getrecommend($aUser["user_id"]);
                if (!empty($user_rating["total_votes"])) {
                    $i = 1;
                    $html = "";
                    for ($i = 1; $i <= round($user_rating["avg_rating"]); $i++) {
                        $html .= "<i class='fa fa-star gold'></i>";
                    }

                    for ($i = round($user_rating["avg_rating"]); $i <= 5; $i++) {
                        $html .= "<i class='fa fa-star-0'></i>";
                    }
                    $aUsers[$iKey]['rating_html'] = $html;
                }
            }

            //CHECK FOLLOW
            if (Phpfox::isModule('follow')) {
                $aUsers[$iKey]['is_follow'] =  Follow_Service_Follow::instance()->checkFollow($aUser["user_id"]);
            }

            $aUsers[$iKey]['is_favourite'] =  Dating_Service_Dating::instance()->checkFavourite($aUser["user_id"]);
            $oUser = User_Service_User::instance();

            if (empty($aUsers[$iKey]['dob_setting']))
            {
                switch (Phpfox::getParam('user.default_privacy_brithdate'))
                {
                    case 'month_day':
                        $aUsers[$iKey]['dob_setting'] =  '1';
                        break;
                    case 'show_age':
                        $aUsers[$iKey]['dob_setting'] =  '2';
                        break;
                    case 'hide':
                        $aUsers[$iKey]['dob_setting'] =  '3';
                        break;
                }
            }
            $aUsers[$iKey]['gender_name'] = $oUser->gender($aUsers[$iKey]['gender']);
            $aUsers[$iKey]['birthday_time_stamp'] = $aUsers[$iKey]['birthday'];
            $aUsers[$iKey]['birthday'] = $oUser->age($aUsers[$iKey]['birthday']);
            $aUsers[$iKey]['location'] = Phpfox::getPhraseT(Core_Service_Country_Country::instance()->getCountry($aUsers[$iKey]['country_iso']), 'country');
            if (isset($aUsers[$iKey]['country_child_id']) && $aUsers[$iKey]['country_child_id'] > 0)
            {
                $aUsers[$iKey]['location_child'] = Core_Service_Country_Country::instance()->getChild($aUsers[$iKey]['country_child_id']);
            }
            $aUsers[$iKey]['birthdate_display'] = User_Service_User::instance()->getProfileBirthDate($aUsers[$iKey]);
            $aUsers[$iKey]['is_user_birthday'] = ((empty($aUsers[$iKey]['birthday_time_stamp']) ? false : (int) floor(Phpfox::getLib('date')->daysToDate($aUsers[$iKey]['birthday_time_stamp'], null, false)) === 0 ? true : false));
            if (empty($aUsers[$iKey]['landing_page']))
            {
                $aUsers[$iKey]['landing_page'] = 'wall';
            }
            $aUser = $aUsers[$iKey];

            //USER DETAILS
            $aUser['bRelationshipHeader'] = true;
            $sRelationship = Custom_Service_Custom::instance()->getRelationshipPhrase($aUser);
            $aUserDetails = array();
            if (!empty($aUser['gender'])) {
                $aUserDetails[_p('gender')] = '<a href="' . $this->url()->makeUrl('user.browse', array('gender' => $aUser['gender'])) . '">' . $aUser['gender_name'] . '</a>';
            }

            $aUserDetails = array_merge($aUserDetails, $aUser['birthdate_display']);

            $sExtraLocation = '';

            if (!empty($aUser['city_location']))
            {
                $sExtraLocation .= '<div class="p_2"><a href="' . $this->url()->makeUrl('user.browse', array('location' => $aUser['country_iso'], 'state' => $aUser['country_child_id'], 'city-name' => $aUser['city_location'])) . '">' . Phpfox::getLib('parse.output')->clean($aUser['city_location']) . '</a> &raquo;</div>';
            }

            if ($aUser['country_child_id'] > 0)
            {
                $sExtraLocation .= '<div class="p_2"><a href="' . $this->url()->makeUrl('user.browse', array('location' => $aUser['country_iso'], 'state' => $aUser['country_child_id'])) . '">' . Core_Service_Country_Country::instance()->getChild($aUser['country_child_id']) . '</a> &raquo;</div>';
            }

            if (!empty($aUser['country_iso']))
            {
                $aUserDetails[_p('location')] = $sExtraLocation . '<a href="' . $this->url()->makeUrl('user.browse', array('location' => $aUser['country_iso'])) . '">' . Phpfox::getPhraseT($aUser['location'], 'country') . '</a>';
            }

            if ((int) $aUser['last_login'] > 0 && ((!$aUser['is_invisible']) || (Phpfox::getUserParam('user.can_view_if_a_user_is_invisible') && $aUser['is_invisible'])))
            {
                $aUserDetails[_p('last_login')] = Phpfox::getLib('date')->convertTime($aUser['last_login'], 'core.profile_time_stamps');
            }

            if ((int) $aUser['joined'] > 0)
            {
                $aUserDetails[_p('member_since')] = Phpfox::getLib('date')->convertTime($aUser['joined'], 'core.profile_time_stamps');
            }

            $aUserDetails[_p('profile_views')] = $aUser['total_view'];

            if (Phpfox::isModule('rss') && Phpfox::getParam('rss.display_rss_count_on_profile') && User_Service_Privacy_Privacy::instance()->hasAccess($aUser['user_id'], 'rss.display_on_profile'))
            {
                $aUserDetails[_p('rss_subscribers')] = $aUser['rss_count'];
            }
            $this->template()->assign(array(
                    'aUserDetails' => $aUserDetails,
                    'sRelationship' => $sRelationship,
                    'bShowCustomFields' => true,
                )
            );
            $this->setParam("aUser", $aUser);
        }
        $aCustomFields = Custom_Service_Custom::instance()->getForPublic('user_profile');

        $this->template()
            ->setHeader('cache', array(
                    'country.js' => 'module_core'
                )
            )
            ->assign(array(
                    'aUsers' => $aUsers,
                    'bExtend' => $bExtend,
                    'status' => $status,
                    'isUser' => $isUser,
                    'aCallback' => $aCallback,
                    'bIsSearch' => $oFilter->isSearch(),
                    'bIsInSearchMode' => ($this->request()->getInt('search-id') ? true : false),
                    'aForms' => $aCustomSearch,
                    'aCustomFields' => $aCustomFields,
                    'sView' => $sView,
                    'iCnt' => $iCnt,
                    'bOldWay' => $bOldWay,
                )
            );
        // add breadcrumb if its in the featured members page and not in admin
        if (!(defined('PHPFOX_IS_ADMIN_SEARCH')))
        {
            Phpfox::getUserParam('user.can_browse_users_in_public', true);

            $this->template()->setHeader('cache', array(
                    'browse.js' => 'module_user'
                )
            );

            if ($this->request()->get('view') == 'featured')
            {
                $this->template()->setBreadCrumb(_p('featured_members'), $this->url()->makeUrl('current'), true);

                $sTitle = _p('title_featured_members');
                if (!empty($sTitle))
                {
                    $this->template()->setTitle($sTitle);
                }
            }
            elseif($this->request()->get('view') == 'online')
            {
                $this->template()->setBreadCrumb(_p('menu_who_s_online'), $this->url()->makeUrl('current'), true);
                $sTitle = _p('title_who_s_online');
                if (!empty($sTitle))
                {
                    $this->template()->setTitle($sTitle);
                }
            }
        }

        if ($aCallback !== false)
        {
            $this->template()->rebuildMenu('user.browse', $aCallback['url'])->removeUrl('user.browse', 'user.browse.view_featured');
        }
        return null;
    }
}