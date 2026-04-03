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
class Dating_Service_Callback extends Phpfox_Service{

	public function __construct()
	{

	}
	
	public function getNotification($aItem)
    {
        $wallUserId = $aItem['item_user_id']; // go to your wall
       /* if (!Phpfox::getService('poke')->getActivityFeed($aItem['item_id'])) {
            $aParams = array();
            $wallUserId = $aItem['owner_user_id']; // go to owner wall
        } else {
            $aParams = array('poke-id' => $aItem['item_id']);
        }*/
		$aParams = array('userid' => $aItem['user_id']);
		
		$aItemCon = db()->select('g.title')
            ->from(Phpfox::getT('dating_greeting_users'),'gu')
			->join(Phpfox::getT('dating_greetings'), 'g', 'g.greeting_id = gu.greeting_id')
            ->where('gu.greet_id = ' . $aItem['item_id'])
            ->execute('getSlaveField');
		
		if(!empty($aItemCon)){
			$aMsg = _p('notificaiton_greet_msg', array('full_name' => '<span class="drop_data_user">' . $aItem['full_name'] . '</span>','title'=>$aItemCon));
		}else{
			$aMsg = _p('full_name_has_poked_you', array('full_name' => '<span class="drop_data_user">' . $aItem['full_name'] . '</span>'));
		}

        $aWallUser = Phpfox::getService('user')->getUser($wallUserId);
        return array(
            'link' => Phpfox::getLib('url')->makeUrl('dating.profile', $aParams),
            'message' => $aMsg
        );
    }

    public function getNotificationLike($aNotification)
    {
        $aRow = $this->database()->select('*')
            ->from((Phpfox::getT('user')))
            ->where('user_id = ' . (int)$aNotification['item_id'])->execute('getSlaveRow');

        if (!isset($aRow['user_id'])) {
            return false;
        }

        $sPhrase = _p('dating_like_text', array(
            'title' => $aRow["full_name"]
        ));

        return [
            'link'             => Phpfox_Url::instance()->makeUrl("dating")."?user=".$aRow["user_name"],
            'message'          => $sPhrase
        ];
    }

    public function getNotificationMutual($aNotification)
    {
        $aRow = $this->database()->select('*')
            ->from((Phpfox::getT('user')))
            ->where('user_id = ' . (int)$aNotification['item_id'])->execute('getSlaveRow');

        if (!isset($aRow['user_id'])) {
            return false;
        }

        $sPhrase = _p('dating_mutual_text', array(
            'title' => $aRow["full_name"]
        ));

        return [
            'link'             => Phpfox_Url::instance()->makeUrl("dating")."?user=".$aRow["user_name"],
            'message'          => $sPhrase
        ];
    }
}