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
class Dating_Component_Controller_Matches extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
		$aOwnProfile = false;
		$aUserId = $this->request()->get('userid');
		if(empty($aUserId)){
			$aUserId = Phpfox::getUserId();
			$aOwnProfile = true;
		}
		//$aCont[] = 'v.user_id = '.$aUserId;
		
		//list($iCnt, $aUsers) = Phpfox::getService('dating.matching')->getMatchingUsers($aCont,$iPage, $iPageSize);
		
		$this->template()->assign(array(
             
            )
        );
	}
}