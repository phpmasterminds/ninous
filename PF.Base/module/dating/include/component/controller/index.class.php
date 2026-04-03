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
class Dating_Component_Controller_Index extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        Phpfox::isUser(true);

        Dating_Service_Dating::instance()->getSectionMenu();

        //Participate in module
        if ($this->request()->get('participate') > 0) {
            Phpfox::getService('dating')->participate();
            $this->url()->send('dating.manage',[], _p('Successfully Joined, now Please fill your Dating Profile'));
        }

        //RESET FILTERS
        if ($this->request()->get("clean")) {
            Dating_Service_Dating::instance()->cleanFilter();
            $this->url()->send("dating.index", false, _p("Filters was cleaned."));
        }

        //CHECK DIRECT
        $cond = Dating_Service_Dating::instance()->getFilter();
        $query = $_SERVER["QUERY_STRING"];
        if (empty($query) and !empty($cond["query"]) and $cond['query'] != 'participate=1') {
            if (Phpfox::getParam('dating.enableparticipation')) {
                $datingParticipate = Phpfox::getService('dating')->getDatingParticipate();
                if (!empty($datingParticipate)) {
                    $this->url()->forward(Phpfox_Url::instance()->makeUrl("dating") . "?" . $cond["query"], false);
                }
            } else {
                $this->url()->forward(Phpfox_Url::instance()->makeUrl("dating") . "?" . $cond["query"], false);
            }
        }

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

        if (defined('PHPFOX_IS_ADMIN_SEARCH'))
        {
            if (($aIds = $this->request()->getArray('id')) && count((array) $aIds))
            {
                Phpfox::getUserParam('user.can_delete_others_account', true);

                if ($this->request()->get('delete'))
                {
                    foreach ($aIds as $iId)
                    {
                        if (User_Service_User::instance()->isAdminUser($iId))
                        {
                            $this->url()->send('current', null, _p('you_are_unable_to_delete_a_site_administrator'));
                        }

                        User_Service_Auth::instance()->setUserId($iId);
                        Phpfox::massCallback('onDeleteUser', $iId);
                        User_Service_Auth::instance()->setUserId(null);
                    }

                    $this->url()->send('current', null, _p('user_s_successfully_deleted'));
                }
                elseif ($this->request()->get('ban') || $this->request()->get('unban'))
                {
                    foreach ($aIds as $iId)
                    {
                        if (User_Service_User::instance()->isAdminUser($iId))
                        {
                            $this->url()->send('current', null, _p('you_are_unable_to_ban_a_site_administrator'));
                        }

                        User_Service_Process::instance()->ban($iId, ($this->request()->get('ban') ? 1 : 0));
                    }

                    $this->url()->send('current', null, ($this->request()->get('ban') ? _p('user_s_successfully_banned') : _p('user_s_successfully_un_banned')));
                }
                elseif ($this->request()->get('resend-verify'))
                {
                    foreach ($aIds as $iId)
                    {
                        User_Service_Verify_Process::instance()->sendMail($iId);
                    }

                    $this->url()->send('current', null, _p('email_verification_s_sent'));
                }
                elseif ($this->request()->get('verify'))
                {
                    foreach ($aIds as $iId)
                    {
                        User_Service_Verify_Process::instance()->adminVerify($iId);
                    }

                    $this->url()->send('current', null, _p('user_s_verified'));
                }
                elseif ($this->request()->get('approve'))
                {
                    foreach ($aIds as $iId)
                    {
                        User_Service_Process::instance()->userPending($iId, '1');
                    }

                    $this->url()->send('current', null, _p('user_s_successfully_approved'));
                }
            }
        }
        else // is not admincp
        {
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
                'class' => 'txt_input',
                'placeholder' => _p("Search in name or email")
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
                'type' => 'select',
                'options' => $aGenders,
                'search' => 'AND u.gender = \'[VALUE]\'',
                'add_any' => true,
            ),
            'from' => array(
                'type' => 'select',
                'style' => 'width: 48%;float: left;margin-right: 4%;',
                'options' => $aAge,
                'select_value' => _p('from')
            ),
            'to' => array(
                'type' => 'select',
                'style' => 'width:48%;',
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
                    '4' => _p('online')
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

        $this->template()->setTitle(_p('Dating'))->setBreadCrumb(_p("Dating"),$this->url()->makeUrl("dating"));

        if (!empty($sView)) {
            switch ($sView) {
                case 'online':
                    $bIsOnline = true;
                    break;
                case 'featured':
                    $mFeatured = true;
                    break;
                case 'spam':
                    $oFilter->setCondition('u.total_spam > ' . (int) Phpfox::getParam('core.auto_deny_items'));
                    break;
                case 'pending':
                    if (defined('PHPFOX_IS_ADMIN_SEARCH'))
                    {
                        $oFilter->setCondition('u.view_id = 1');
                    }
                    break;
                case 'top':
                    $bExtendContent = true;
                    $oFilter->setSort('ufield.total_rating');
                    $oFilter->setCondition('AND ufield.total_rating > ' . Phpfox::getParam('user.min_count_for_top_rating'));
                    if (($iUserGenderTop = $this->request()->getInt('topgender')))
                    {
                        $oFilter->setCondition('AND u.gender = ' . (int) $iUserGenderTop);
                    }

                    $iFilterCount = 0;
                    $aFilterMenuCache = array();

                    $aFilterMenu = array(
                        _p('all') => '',
                        _p('male') => '1',
                        _p('female') => '2'
                    );

                    if ($sPlugin = Phpfox_Plugin::get('user.component_controller_browse_genders_top_users'))
                    {
                        eval($sPlugin);
                    }

                    $this->template()->setTitle(_p('top_rated_members'))
                        ->setBreadCrumb(_p('top_rated_members'), $this->url()->makeUrl('user.browse', array('view' => 'top')));

                    foreach ($aFilterMenu as $sMenuName => $sMenuLink)
                    {
                        $iFilterCount++;
                        $aFilterMenuCache[] = array(
                            'name' => $sMenuName,
                            'link' => $this->url()->makeUrl('user.browse', array('view' => 'top', 'topgender' => $sMenuLink)),
                            'active' => ($this->request()->get('topgender') == $sMenuLink ? true : false),
                            'last' => (count($aFilterMenu) === $iFilterCount ? true : false)
                        );

                        if ($this->request()->get('topgender') == $sMenuLink)
                        {
                            $this->template()->setTitle($sMenuName)->setBreadCrumb($sMenuName, null, true);
                        }
                    }

                    $this->template()->assign(array(
                            'aFilterMenus' => $aFilterMenuCache
                        )
                    );

                    break;
                default:

                    break;
            }
        }

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

        if (defined('PHPFOX_IS_ADMIN_SEARCH') && ($sIp = $oFilter->get('ip'))) {
            User_Service_Browse::instance()->ip($sIp);
        }

        //DATING FIELDS + EXCLUDE PROFILES
        $search = $this->request()->get("search");
        $isDating = false;
        $datingParam = array();
        if (!empty($search)) {
            foreach ($search as $key=>$param) {
                $str = explode("_",$key);
                if (!empty($str[0])) {
                    if ($str[0] == "field") {
                        if (!empty($param)) {
                            $isDating = true;
                            $datingParam[$key] = $param;
                            $oFilter->setCondition(" AND (d.field_".$str[1]." LIKE '%{$param}%')");
                        }
                    }
                }
            }
        }

        //Dating participate
        if (Phpfox::getParam('dating.enableparticipation')) {
            $datingParticipate = Phpfox::getService('dating')->getDatingParticipate();
            $oFilter->setCondition(" AND u.dating_participate = 1");
            $this->template()->assign([
                'datingParticipate' => $datingParticipate
            ]);
        } else {
            $oFilter->setCondition(" AND u.exclude = 0 AND u.user_id<>".Phpfox::getUserId());
        }

        $bExtend = (defined('PHPFOX_IS_ADMIN_SEARCH') ? true : (((($oFilter->get('show') && $oFilter->get('show') == '2') || (!$oFilter->get('show') && Phpfox::getParam('user.user_browse_display_results_default') == 'name_photo_detail')) ? true : false)));
        $iPage = $this->request()->getInt('page');
        $iPageSize = $oFilter->getDisplay();

        if (($sPlugin = Phpfox_Plugin::get('user.component_controller_browse_filter_process')))
        {
            eval($sPlugin);
        }

        $iCnt = 0;
        $aUsers = [];
        if ($oFilter->isSearch()) {
            list($iCnt, $aUsers) = Phpfox::getService('dating.browse')->conditions($oFilter->getConditions())
                ->callback($aCallback)
                ->sort($oFilter->getSort())
                ->page($oFilter->getPage())
                ->limit($iPageSize)
                ->online($bIsOnline)
                ->extend((isset($bExtendContent) ? true : $bExtend))
                ->featured($mFeatured)
                ->pending($bPendingMail)
                ->isDating($isDating)
                ->custom($aCustomSearch)
                ->gender($bIsGender)
                ->get();
        }
        else {
                list($iCnt, $aUsers) = Dating_Service_Browse::instance()->conditions($oFilter->getConditions())
                    ->callback($aCallback)
                    ->sort($oFilter->getSort())
                    ->page($oFilter->getPage())
                    ->limit($iPageSize)
                    ->online($bIsOnline)
                    ->extend((isset($bExtendContent) ? true : $bExtend))
                    ->featured($mFeatured)
                    ->pending($bPendingMail)
                    ->isDating($isDating)
                    ->custom($aCustomSearch)
                    ->gender($bIsGender)
                    ->get();

            $this->template()->assign([
                'highlightUsers' => 1
            ]);
        }

        $iCnt = $oFilter->getSearchTotal($iCnt);
        $aNewCustomValues = array();
        if ($aCustomValues = $this->request()->get('custom'))
        {
            if (is_array($aCustomValues)) {
                foreach ($aCustomValues as $iKey => $sCustomValue) {
                    $aNewCustomValues['custom[' . $iKey . ']'] = $sCustomValue;
                }
            }
        }
        if (!(defined('PHPFOX_IS_ADMIN_SEARCH'))) {
            Phpfox_Pager::instance()->set(array(
                'page' => $iPage,
                'size' => $iPageSize,
                'count' => $iCnt,
                'ajax' => 'user.mainBrowse',
                'aParams' => $aNewCustomValues
            ));
        } else {
            Phpfox_Pager::instance()->set(array('page' => $iPage, 'size' => $iPageSize, 'count' => $iCnt));
        }

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
        }
        $aCustomFields = Custom_Service_Custom::instance()->getForPublic('user_profile');

        //MERGE DATING FIELS
        if (!empty($datingParam)) {
            $aCustomSearch = array_merge($aCustomSearch, $datingParam);
        }

        //SAVE QUERY AND COND
        $query = $_SERVER["QUERY_STRING"];
        $cond = implode($oFilter->getConditions());
        $userName = "";
        if (!empty($query) and !$this->request()->get("user")) {
            Dating_Service_Dating::instance()->saveFilter($query, $cond);
        } elseif ($this->request()->get("user")) {
            $userName = $this->request()->get("user");
            $singleUser = User_Service_User::instance()->getByUserName($userName);
            if (!empty($singleUser["full_name"])) {
                $this->template()->setBreadCrumb($singleUser["full_name"]);
            }
        }

        if (Phpfox::isModule("advancedmembers")) {
            $this->template()->setHeader('cache', array(
             //   'index.css' => 'module_advancedmembers'
            ));
        }



        $this->template()
            ->setHeader('cache', array(
                    'country.js' => 'module_core',
                    'main.js' => 'module_dating',
                    'main.css' => 'module_dating',
                    'jquery.colorbox.js' => 'module_dating',
                    'newWaterfall.js' => 'module_dating',
                    'jquery.bxslider.min.js' => 'module_dating'
                )
            )
            ->assign(array(
                    'searchtext' =>  $userName,
                    'aUsers' => $aUsers,
                    'path' =>  setting('core.path_actual') . "PF.Base/module/dating/static/image/",
                    'bExtend' => $bExtend,
                    'aCallback' => $aCallback,
                    'fields' => Dating_Service_Field::instance()->getForManage(),
                    'bIsSearch' => $oFilter->isSearch(),
                    'bIsInSearchMode' => ($this->request()->getInt('search-id') ? true : false),
                    'aForms' => $aCustomSearch,
                    'aCustomFields' => $aCustomFields,
                    'sView' => $sView,
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