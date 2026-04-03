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
class Dating_Service_Dating extends Phpfox_Service
{
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('dating');
    }

    public function getAdminStats()
    {
        //TOTAL LIKE
        $earn = $this->database()->select('COUNT(like_id) as total_like')
            ->from(Phpfox::getT('dating_likes'))
            ->where("mutual=0 AND is_own=1")
            ->execute('getSlaveRow');

        if (empty($earn["total_like"])) {
            $earn["total_like"] = 0;
        }
        $row["total_like"] =  $earn["total_like"];


        //TOTAL MUTUAL LIKES
        $earn = $this->database()->select('COUNT(like_id) as total_mutual')
            ->from(Phpfox::getT('dating_likes'))
            ->where("mutual=1 AND is_own=1")
            ->execute('getSlaveRow');

        if (empty($earn["total_mutual"])) {
            $earn["total_mutual"] = 0;
        }
        $row["total_mutual"] =  $earn["total_mutual"];

        //TOTAL SKIPPED
        $earn = $this->database()->select('COUNT(action_id) as total_skip')
            ->from(Phpfox::getT('dating_actions'))
            ->where("action='next'")
            ->execute('getSlaveRow');

        if (empty($earn["total_skip"])) {
            $earn["total_skip"] = 0;
        }
        $row["total_skip"] =  $earn["total_skip"];

        //TOTAL FAVOURITE
        $earn = $this->database()->select('COUNT(id) as total_favourite')
            ->from(Phpfox::getT('dating_favourite'))
            ->execute('getSlaveRow');

        if (empty($earn["total_favourite"])) {
            $earn["total_favourite"] = 0;
        }
        $row["total_favourite"] =  $earn["total_favourite"];

        //TOTAL SPONSOR
        if (Phpfox::isModule('phpfoxexpertemoney')) {
            $earn = $this->database()->select('COUNT(paid_id) as total_sponsor')
                ->from(Phpfox::getT('emoney_paid_product_history'))
                ->where('product_type="dating"')
                ->execute('getSlaveRow');

            if (empty($earn["total_sponsor"])) {
                $earn["total_sponsor"] = 0;
            }
            $row["total_sponsor"] =  $earn["total_sponsor"];
        } else {
            $row["total_sponsor"] =  0;
        }

        //TOTAL EXCLUDE
        $earn = $this->database()->select('COUNT(user_id) as total_exclude')
            ->from(Phpfox::getT('user'))
            ->where("exclude=1")
            ->execute('getSlaveRow');

        if (empty($earn["total_exclude"])) {
            $earn["total_exclude"] = 0;
        }
        $row["total_exclude"] =  $earn["total_exclude"];

        //TOTAL FILLED
        $earn = $this->database()->select('COUNT(user_id) as total_field')
            ->from(Phpfox::getT('dating_values'))
            ->execute('getSlaveRow');

        if (empty($earn["total_field"])) {
            $earn["total_field"] = 0;
        }
        $row["total_field"] =  $earn["total_field"];

        //TOTAL PHOTOS
        $earn = $this->database()->select('COUNT(image_id) as total_photo')
            ->from(Phpfox::getT('dating_image'))
            ->execute('getSlaveRow');

        if (empty($earn["total_photo"])) {
            $earn["total_photo"] = 0;
        }
        $row["total_photo"] =  $earn["total_photo"];

        //TOTAL VIDEOS
        $earn = $this->database()->select('COUNT(id) as total_video')
            ->from(Phpfox::getT('dating_videos'))
            ->execute('getSlaveRow');

        if (empty($earn["total_video"])) {
            $earn["total_video"] = 0;
        }
        $row["total_video"] =  $earn["total_video"];

        return $row;
    }

    public function query($where="", $order="l.image_id DESC", $page=1, $limit="")
    {
        $num = $this->database()->select('count(l.image_id)')
            ->from(Phpfox::getT("dating_image"), 'l')
            ->join(Phpfox::getT('user'), 'u', 'l.user_id =  u.user_id')
            ->where($where)
            ->order($order)
            ->execute('getSlaveField');

        $fetchs = $this->database()->select('u.*,l.*')
            ->from(Phpfox::getT("dating_image"), 'l')
            ->join(Phpfox::getT('user'), 'u', 'l.user_id =  u.user_id')
            ->where($where)
            ->order($order)
            ->limit($page, $limit, $num)
            ->execute('getSlaveRows');

        return array($num, $fetchs);
    }

    public function getCurrentIds()
    {
        $ids = "";
        //EXCLUDE IDS
        $aRows = $this->database()->select('user_id')
            ->from(Phpfox::getT("dating_actions"))
            ->where('owner_id = '.Phpfox::getUserId())
            ->execute('getSlaveRows');

        if (!empty($aRows)) {
            foreach ($aRows as $item) {
                if (!empty($ids)) {
                    $ids .= ",".$item["user_id"];
                } else {
                    $ids = $item["user_id"];
                }
            }
        }

        return $ids;
    }

    public function getStatus($userId)
    {
        //GET FULL NAME OF REVIEWING USER
        $fullName = $this->database()->select('full_name')
            ->from(Phpfox::getT("user"))
            ->where('user_id = '.$userId)
            ->execute('getSlaveField');

        //CHECK MUTUAL
        $aRow = $this->database()->select('user_id')
            ->from(Phpfox::getT("dating_likes"))
            ->where('mutual = 1 AND owner_id = '.$userId.' AND user_id = '.Phpfox::getUserId())
            ->execute('getSlaveRow');
        if (!empty($aRow)) {
            return array('phrase' => _p("Mutual Like"),'status' => 'mutual');
        }

        //CHECK SKIP
        $aRow = $this->database()->select('user_id')
            ->from(Phpfox::getT("dating_actions"))
            ->where('user_id = '.$userId.' AND owner_id = '.Phpfox::getUserId().' AND action="next"')
            ->execute('getSlaveRow');
        if (!empty($aRow)) {
            return array('phrase' => _p("Skipped"),'status' => 'skip');
        }

        //CHECK MY LIKE
        $aRow = $this->database()->select('user_id')
            ->from(Phpfox::getT("dating_likes"))
            ->where('is_own = 1 AND owner_id = '.Phpfox::getUserId().' AND user_id = '.$userId)
            ->execute('getSlaveRow');
        if (!empty($aRow)) {
            return array('phrase' => _p("Sent Like"),'status' => 'like');
        }

        //CHECK USER LIKE
        $aRow = $this->database()->select('user_id')
            ->from(Phpfox::getT("dating_likes"))
            ->where('is_own = 1 AND owner_id = '.$userId.' AND user_id = '.Phpfox::getUserId())
            ->execute('getSlaveRow');
        if (!empty($aRow)) {
            return array('phrase' =>$fullName." "._p("sent your like"),'status' => 'user_sent');
        }
    }

    public function cleanFilter()
    {
        $this->database()->delete(Phpfox::getT("dating_filter"),"user_id = ".Phpfox::getUserId());
    }

    public function addNext($userId)
    {
        //CHECK IF USER SKIPED THIS USER
        $this->database()->delete(Phpfox::getT("dating_actions"),"user_id = ".$userId.' AND owner_id = '.Phpfox::getUserId());

        //ADD TO ACTION TABLE
        $this->database()->insert(Phpfox::getT("dating_actions"), array(
            'user_id' => $userId,
            'owner_id' => Phpfox::getUserId(),
            'action' => 'next',
            'time_stamp' => time()
        ));

    }

    public function addLike($userId)
    {
        //ADD TO LIKE TABLE
        $aRow = $this->database()->select('*')
            ->from(Phpfox::getT("dating_likes"))
            ->where('owner_id = '.Phpfox::getUserId().' AND user_id = '.$userId)
            ->execute('getSlaveRow');

        if (empty($aRow)) {
            //NEW LIKE
            $this->database()->insert(Phpfox::getT("dating_likes"),array(
                'user_id' => $userId,
                'owner_id' => Phpfox::getUserId(),
                'time_stamp' => time(),
                'mutual' => 0,
                'is_viewed' => 1,
                'is_own' => 1
            ));

            $iId = $this->database()->insert(Phpfox::getT("dating_likes"),array(
                'user_id' => Phpfox::getUserId(),
                'owner_id' => $userId,
                'time_stamp' => time(),
                'mutual' => 0,
                'is_viewed' => 0,
                'is_own' => 0
            ));

            //ADD NOTIFICATION
            if (Phpfox::isModule('notification')) {
                Notification_Service_Process::instance()->add('dating_like', Phpfox::getUserId(), $userId);
            }
        } else {
            if ($aRow["is_own"] == 0) {
                //MUTUAL LIKE
                $this->database()->update(Phpfox::getT("dating_likes"), array(
                    'mutual' => 1,
                    'is_viewed' => 0
                ), 'user_id = ' . Phpfox::getUserId() . " AND owner_id = " . $userId);

                $this->database()->update(Phpfox::getT("dating_likes"), array(
                    'mutual' => 1,
                    'is_viewed' => 1
                ), 'user_id = ' . $userId . " AND owner_id = " . Phpfox::getUserId());

                //ADD NOTIFICATION
                if (Phpfox::isModule('notification')) {
                    Notification_Service_Process::instance()->add('dating_mutual', Phpfox::getUserId(), $userId);
                }
            }
        }

        //CHECK IF USER SKIPED THIS USER
        $this->database()->delete(Phpfox::getT("dating_actions"),"user_id = ".$userId.' AND owner_id = '.Phpfox::getUserId());

        //ADD TO ACTION TABLE
        $this->database()->insert(Phpfox::getT("dating_actions"),array(
            'user_id' => $userId,
            'owner_id' => Phpfox::getUserId(),
            'action' => 'like',
            'time_stamp' => time()
        ));
    }

    public function saveFilter($query, $cond)
    {
        $num = $this->database()->select('user_id')
            ->from(Phpfox::getT("dating_filter"))
            ->where('user_id = '.Phpfox::getUserId())
            ->execute('getSlaveRow');

        if (!empty($num["user_id"])) {
            $this->database()->update(Phpfox::getT("dating_filter"),array(
                'cond' => $cond,
                'query' => $query
            ),'user_id = '.Phpfox::getUserId());
        } else {
            $this->database()->insert(Phpfox::getT("dating_filter"),array(
                'cond' => $cond,
                'query' => $query,
                'user_id' => Phpfox::getUserId()
            ));
        }
    }

    public function getFilter()
    {
        $aRow = $this->database()->select('*')
            ->from(Phpfox::getT("dating_filter"))
            ->where('user_id = '.Phpfox::getUserId())
            ->execute('getSlaveRow');

        return $aRow;
    }

    public function queryVideos($where="", $order="l.id DESC", $page=1, $limit="")
    {
        $num = $this->database()->select('count(l.id)')
            ->from(Phpfox::getT("dating_videos"), 'l')
            ->join(Phpfox::getT('user'), 'u', 'l.user_id =  u.user_id')
            ->where($where)
            ->order($order)
            ->execute('getSlaveField');

        $fetchs = $this->database()->select('u.*,l.*')
            ->from(Phpfox::getT("dating_videos"), 'l')
            ->join(Phpfox::getT('user'), 'u', 'l.user_id =  u.user_id')
            ->where($where)
            ->order($order)
            ->limit($page, $limit, $num)
            ->execute('getSlaveRows');

        return array($num, $fetchs);
    }

    public function getSectionMenu()
    {
        if (!db()->isField(Phpfox::getT('user'), 'dating_participate')) {
            db()->query("ALTER TABLE  `" . Phpfox::getT('user') . "` ADD `dating_participate` INT");
        }

        $aFilterMenu = array(
            _p('Dating') => ''
        );
        if (Phpfox::getUserId()) {
            $aFilterMenu[_p('My Profile')] = Phpfox_Url::instance()->makeUrl('dating',[
                'user' => Phpfox::getUserBy('user_name')
            ]);
            $aFilterMenu[_p('Manage Profile')] = 'dating.manage';
        }

        if (Phpfox::getParam('dating.enablephoto')) {
            $aFilterMenu[_p('Manage Photos')] = 'dating.photo';
        }
        if (Phpfox::getParam('dating.enablevideo')) {
            $aFilterMenu[_p('Manage Videos')] = 'dating.video';
        }
        $aFilterMenu[_p('I Like')] = 'dating.mylike';

        $notifications = $this->getNotification();
        if ($notifications[0]) {
            $aFilterMenu[_p('Who Likes me'). '<span class="pending">+' . $notifications[0] . '</span>'] = 'dating.wholike';
        } else {
            $aFilterMenu[_p('Who Likes me')] = 'dating.wholike';
        }

        if ($notifications[1]) {
            $aFilterMenu[_p('Mutual Likes'). '<span class="pending">+' . $notifications[1] . '</span>'] = 'dating.mutual';
        } else {
            $aFilterMenu[_p('Mutual Likes')] = 'dating.mutual';
        }
        $aFilterMenu[_p('Already viewed')] = 'dating.already';
        $aFilterMenu[_p('My Favourite Users')] = 'dating.favourite';


        Phpfox_Template::instance()->buildSectionMenu('dating', $aFilterMenu);
    }

    public function getNotification()
    {
        $isLike = $this->database()->select('COUNT(like_id)')
            ->from(Phpfox::getT("dating_likes"))
            ->where("mutual = 0 AND owner_id = ".Phpfox::getUserId()." AND is_viewed = 0")
            ->execute('getSlaveField');

        $mutual = $this->database()->select('COUNT(like_id)')
            ->from(Phpfox::getT("dating_likes"))
            ->where("mutual = 1 AND owner_id = ".Phpfox::getUserId()." AND is_viewed = 0")
            ->execute('getSlaveField');

        return array($isLike, $mutual);
    }

    public function hideLikes()
    {
        $this->database()->update(Phpfox::getT("dating_likes"),array(
           'is_viewed' => 1
        ), "mutual=0 AND owner_id = ".Phpfox::getUserId()." AND is_viewed=0");
    }

    public function hideMutual()
    {
        $this->database()->update(Phpfox::getT("dating_likes"),array(
            'is_viewed' => 1
        ), "mutual=1 AND owner_id = ".Phpfox::getUserId()." AND is_viewed=0");
    }

    public function sponsor($userId)
    {
        if (!Phpfox::isAdmin()) {
            return false;
        }

        $check = $this->database()->select('is_sponsor')
            ->from(Phpfox::getT("user"))
            ->where("user_id = ".$userId)
            ->execute('getSlaveField');

        if ($check == 1) {
            $this->database()->update(Phpfox::getT("user"),[
                'is_sponsor' => 0,
            ], 'user_id = '.$userId);

            return "un";
        }
        else {
            $this->database()->update(Phpfox::getT("user"),[
                'is_sponsor' => 1,
            ], 'user_id = '.$userId);

            return "on";
        }
    }

    public function getNewMembers()
    {
        $where = '';
        if (Phpfox::getParam('dating.enableparticipation')) {
            $where = ' AND dating_participate = 1';
        }

        $aRows = $this->database()->select('*')
            ->from(Phpfox::getT('user'))
            ->where("exclude = 0 AND profile_page_id = 0 AND user_id != ".Phpfox::getUserId()." AND user_image != ''".$where)
            ->order("user_id DESC")
            ->limit(32)
            ->execute('getSlaveRows');

        return $aRows;
    }

    public function getSponsorMembers()
    {
        return $this->database()->select('u.*, v.field_3')
            ->from(Phpfox::getT('user'), "u")
            ->leftJoin(Phpfox::getT("dating_values"),"v","u.user_id = v.user_id")
            ->where("is_sponsor = 1 AND profile_page_id=0")
            ->order("RAND()")
            ->limit(4)
            ->execute('getSlaveRows');
    }

    public function getDatingParticipate($userId = false)
    {
        if ($userId == false) $userId = Phpfox::getUserId();
        $aField = $this->database()->select('dating_participate')
            ->from(Phpfox::getT('user'))
            ->where("user_id = ".$userId)
            ->execute('getSlaveField');

        return $aField;
    }

    public function isSponsored($userId)
    {
        $aField = $this->database()->select('is_sponsor')
            ->from(Phpfox::getT('user'))
            ->where("user_id = ".$userId)
            ->execute('getSlaveField');

        return $aField;
    }

    public function participate()
    {
        $this->database()->update(Phpfox::getT('user'),[
            'dating_participate' => 1
        ], 'user_id = '.Phpfox::getUserId());

        return true;
    }

    public function addPhoto()
    {
        if (!empty($_FILES['image'])) {
            foreach ($_FILES['image']['error'] as $iKey => $sError) {
                if ($sError == UPLOAD_ERR_OK) {
                    $file_info = pathinfo($_FILES['image']['name'][$iKey]);
                    Phpfox::getLib('file')->load('image[' . $iKey . ']', array('jpg', 'gif', 'png'));
                    $sName  = Phpfox::getLib('parse.input')->cleanFileName(uniqid());

                    $sFileName = setting('core.path_actual') . "PF.Base/file/pic/photo/" .$sName.".".$file_info["extension"];
                    Phpfox::getLib('file')->upload('image[' . $iKey . ']', "PF.Base/file/pic/photo/", $sName, false, 0644, false);
                    $this->database()->insert(Phpfox::getT('dating_image'), array('user_id' => Phpfox::getUserId(), 'image_path' => $sFileName));
                }
            }
        }
    }

    public function getDefaultPhoto($userId)
    {
        $photo = $this->database()->select('*')
            ->from(Phpfox::getT("dating_image"))
            ->where("user_id = ".$userId." AND is_default = 1")
            ->execute('getSlaveRow');

        return $photo;
    }

    public function getPhotos($userId)
    {
        $aRows = $this->database()->select('*')
            ->from(Phpfox::getT("dating_image"))
            ->where("user_id = ".$userId)
            ->execute('getSlaveRows');

        return $aRows;
    }

    public function ispoked($owner_id,$user_id,$aTier = 'tier1')
    {
        /*return $this->database()->select('u.user_id')
            ->from(Phpfox::getT('user'), 'u')
            ->join(Phpfox::getT('dating_greeting_users'), 'p', 'p.to_user_id = u.user_id')
            ->where("p.user_id={$user_id} AND p.to_user_id={$owner_id}")
            ->limit(1)
            ->execute('getSlaveRows');*/
		$count = $this->database()->select('COUNT(*)')
			->from(Phpfox::getT('dating_greeting_users'))
			->where("
				tier = '".$aTier."' AND 
				((user_id = {$user_id} AND to_user_id = {$owner_id})
				OR
				(user_id = {$owner_id} AND to_user_id = {$user_id}))
			")
			->execute('getSlaveField');
			
		return ($count > 2);

    }

    public function checkFavourite($userId)
    {
        $check = $this->database()->select('user_id')
            ->from(Phpfox::getT("dating_favourite"))
            ->where("owner_id=".PHPFOX::getUserId()." AND user_id={$userId}")
            ->execute('getSlaveRow');

        return $check;
    }

    public function addFavourite($userId)
    {
        $check = $this->database()->select('user_id')
            ->from(Phpfox::getT("dating_favourite"))
            ->where("owner_id=".PHPFOX::getUserId()." AND user_id={$userId}")
            ->execute('getSlaveRow');

        if ($check) {
            $this->database()->delete(Phpfox::getT("dating_favourite"), 'owner_id = '.PHPFOX::getUserId().' AND user_id = ' . (int)$userId);
            return "un";
        } else {
            $this->database()->insert(Phpfox::getT("dating_favourite"), array(
                    'user_id' => $userId,
                    'owner_id' => PHPFOX::getUserId()
                )
            );
            return "on";
        }
    }

    public function isOnline($id = null){
        $aRows = $this->database()->select('*')->from(Phpfox::getT('log_session'))->
        where('user_id = ' . $id . ' AND last_activity > \'' . Phpfox::getService('log.session')->getActiveTime() . '\' ')->execute('getRow');
        if (!empty($aRows)) {
            return true;
        } else {
            return false;
        }
    }

    public function addPaid($userId, $dateEnd)
    {
        //UPDATE FEATURED FIELD
        $this->database()->update(Phpfox::getT("user"), array(
            'is_sponsor' => 1,
        ), 'user_id = ' . $userId
        );

        //ADD INTO PRODUCT PAID HISTRORY
        $this->database()->insert(Phpfox::getT("emoney_paid_product_history"), array(
                'pay_date' => $dateEnd,
                'product_type' => 'dating',
                'product_id' => $userId,
                'user_id' => PHPFOX::getUserId()
            )
        );

        return false;
    }

    public function checkOldFeatured()
    {
        //CHECK FEATURED SONGS
        $users = $this->database()->select('*')
            ->from(Phpfox::getT("emoney_paid_product_history"))
            ->where("product_type='dating' AND pay_date < ".time())
            ->execute('getSlaveRows');

        foreach ($users as $paidHistory) {
            //SET UNFEATURED OLD
            $this->database()->update(Phpfox::getT("user"), array(
                    'is_sponsor' => 0,
                ), 'user_id = ' . $paidHistory["product_id"]
            );

            //DELETE CURRENT ENTRY
            $this->database()->delete(Phpfox::getT('emoney_paid_product_history'), 'paid_id = ' . $paidHistory["paid_id"]);
        }
    }

    public function isSponsor()
    {
        $aRow = $this->database()->select('*')
            ->from(Phpfox::getT("emoney_paid_product_history"))
            ->where("product_type='dating' AND product_id = ".Phpfox::getUserId()."   AND pay_date > ".time())
            ->execute('getSlaveRow');

        return $aRow;
    }

    public function saveData($aVals, $exclude)
    {
        //EXCLUDE PROFILE
        $this->database()->update(Phpfox::getT("user"),array(
            'exclude' => $exclude,
        ), 'user_id = '.Phpfox::getUserId());

        $this->database()->update(Phpfox::getT("user"),array(
            'dating_participate' => $aVals['dating_participate'],
        ), 'user_id = '.Phpfox::getUserId());

        $oFilter = Phpfox::getLib('parse.input');
        if (!empty($aVals)) {
            foreach ($aVals as $key => $val) {
                //PREPARE VALUE
                //$val = $oFilter->clean($val);
                //$key = $oFilter->clean($key);
				
				// CLEAN KEY
				$key = $oFilter->clean($key);

				// HANDLE ARRAY VALUES (IMPORTANT)
				if (is_array($val)) {
					$val = json_encode(array_map([$oFilter, 'clean'], $val));
				} else {
					$val = $oFilter->clean($val);
				}

                //CHECK IF SETTING EXISTS
                $aField = $this->database()->select('*')
                    ->from(Phpfox::getT("dating_values"))
                    ->where("user_id = ".Phpfox::getUserId())
                    ->execute('getSlaveRow');

                //SAVE OR UPDATE DATA
                if (!empty($aField)) {
                    $this->database()->update(Phpfox::getT('dating_values'),array(
                        $key => $val
                    ),"user_id = ".Phpfox::getUserId());
                } else {
                    $this->database()->insert(Phpfox::getT("dating_values"),array(
                        "user_id" => Phpfox::getUserId(),
                        $key => $val
                    ));
                }
            }
        }
    }

    public function getData($userId)
    {
        $aRow = $this->database()->select('*')
            ->from(Phpfox::getT("dating_values"))
            ->where("user_id = ".$userId)
            ->execute('getSlaveRow');

        //CHECK EXCLUDE
        $aRow["exclude"] = $this->database()->select('exclude')
            ->from(Phpfox::getT("user"))
            ->where("user_id = ".$userId)
            ->execute('getSlaveField');

        $aRow["dating_participate"] = $this->database()->select('dating_participate')
            ->from(Phpfox::getT("user"))
            ->where("user_id = ".$userId)
            ->execute('getSlaveField');

        return $aRow;
    }

    public function getDataView($userId)
    {
        $aRow = $this->database()->select('*')
            ->from(Phpfox::getT("dating_values"))
            ->where("user_id = ".$userId)
            ->execute('getSlaveRow');

        $newArr = array();
        if (!empty($aRow)) {
            foreach ($aRow as $key=>$item) {
                $value = strpos(strval($key), 'field');
                if ($value !== false) {
                    $str = explode("_",$key);
                    $field = Dating_Service_Field::instance()->getForEdit($str[1]);
                    $newItem = array();

                    //HACK FOR CHECKBOX
                    if ($field["type"] == 'checkbox') {
                        if ($item == 1) {
                            $item = _p("Yes");
                        } else {
                            $item = _p("No");
                        }
                        $newItem["name"] = $field["title"];
                        $newItem["value"] = $item;
                        $newArr[] = $newItem;
                    } else {
                        $newItem["name"] = $field["title"];
                        $newItem["value"] = $item;
                        $newArr[] = $newItem;
                    }
                }
            }
        }

        return $newArr;
    }

    public  function getVideos($userId)
    {
        $fetchs = $this->database()->select('*')
            ->from(Phpfox::getT('dating_videos'))
            ->where("user_id={$userId}")
            ->order("id DESC")
            ->execute('getSlaveRows');

        return $fetchs;
    }

    public function deleteVideo($videoId)
    {
        $aRow = $this->database()->select('*')
            ->from(Phpfox::getT('dating_videos'))
            ->where("id={$videoId} AND user_id=".Phpfox::getUserId())
            ->execute('getSlaveRow');

        if (!empty($aRow)) {
            $this->database()->delete(Phpfox::getT('dating_videos'),"id = ".$videoId);
        }
    }

    public function deleteVideoAdmin($videoId)
    {
        $aRow = $this->database()->select('*')
            ->from(Phpfox::getT('dating_videos'))
            ->where("id={$videoId} ")
            ->execute('getSlaveRow');

        if (!empty($aRow)) {
            $this->database()->delete(Phpfox::getT('dating_videos'),"id = ".$videoId);
        }

        return true;
    }


    public function setDefault($iImageId)
    {
        $aListing = $this->database()->select('*')
            ->from(Phpfox::getT('dating_image'), 'mi')
            ->where('mi.image_id = ' . (int) $iImageId)
            ->execute('getSlaveRow');

        if (!isset($aListing['user_id'])) {
            return Phpfox_Error::set(_p('unable_to_find_the_image_dot'));
        }

        $this->database()->update(Phpfox::getT('dating_image'), array('is_default' => 0), 'user_id = ' . Phpfox::getUserId());
        $this->database()->update(Phpfox::getT('dating_image'), array('is_default' => 1), 'image_id = ' . $iImageId);

        return true;
    }

    public function getImages($iId, $iLimit = null, $exclude_image_path = null)
    {
        $select = $this->database()->select('*')
            ->from(Phpfox::getT('dating_image'))
            ->where('user_id = '.$iId)
            ->order('image_id DESC')
            ->limit($iLimit);

        return $select->execute('getSlaveRows');
    }

    public function deleteImage($iImageId)
    {
        $aListing = $this->database()->select('*')
            ->from(Phpfox::getT('dating_image'), 'mi')
            ->where('mi.image_id = ' . (int) $iImageId.' AND mi.user_id='.Phpfox::getUserId())
            ->execute('getSlaveRow');

        if (!isset($aListing['user_id'])) {
            return Phpfox_Error::set(_p('unable_to_find_the_image_dot'));
        }


        $this->database()->delete(Phpfox::getT('dating_image'), 'image_id = ' . $aListing['image_id']);

        return true;
    }

    public function addVideo($aVals)
    {
        //ADD VIDEOS
        if (!empty($aVals['video_url']) || !empty($_FILES["video_path"]["tmp_name"])) {
            if (!empty($aVals['video_url'])) {
                $url = trim($aVals['video_url']);
                if (substr($url, 0, 7) != 'http://' && substr($url, 0, 8) != 'https://') {
                    return Phpfox_Error::set(_p('Please provide a valid URL.'));
                }

                $parsed = Link_Service_Link::instance()->getLink($url);
                $parsed['embed_code'] = str_replace('http://player.vimeo.com/', 'https://player.vimeo.com/', $parsed['embed_code']);
                $aVideoSql = array(
                    "user_id" => Phpfox::getUserId(),
                    "embed_code" => $parsed["embed_code"],
                    'title' => $parsed["title"],
                    "time_stamp" => time()
                );
            }
            elseif (!empty($_FILES["video_path"]["tmp_name"])) {
                if (empty($aVals["video_title"])) {
                    $aVals["video_title"] = _p("Video of user")." ".$aVals["title"];
                }

                $file_info = pathinfo($_FILES['video_path']['name']);
                $aImage = Phpfox::getLib('file')->load('video_path', array('mp4', 'flv', 'ogg', 'avi'));
                $sName = Phpfox::getLib('parse.input')->cleanFileName(uniqid());
                $aVals["video_path"] = setting('core.path_actual') . "PF.Base/file/music/" .$sName.".".$file_info["extension"];
                Phpfox::getLib('file')->upload('video_path', "PF.Base/file/music/", $sName, false, 0644, false);
                $aVideoSql = array(
                    "user_id" => Phpfox::getUserId(),
                    "video_path" =>  $aVals["video_path"],
                    'title' => $aVals["video_title"],
                    "time_stamp" => time()
                );
            }

            if  (!empty($aVideoSql)) {
                //ADD VIDEOS INTO TABLE
                $this->database()->insert(Phpfox::getT('dating_videos'), $aVideoSql);
            }
        }
    }

}
