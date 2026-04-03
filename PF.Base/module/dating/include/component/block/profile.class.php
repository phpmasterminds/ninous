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
class Dating_Component_Block_Profile extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        $aUser = $this->getParam("aUser");

        if (Phpfox::getParam('dating.enableparticipation')) {
            $datingParticipate = Phpfox::getService('dating')->getDatingParticipate($aUser['user_id']);
            if (empty($datingParticipate)) {
                return false;
            }
        }

        if ($aUser["exclude"] == 1) {
            return false;
        }

        $this->template()->assign(array(
                'aUser' => $aUser,
                'isSponsored' => Phpfox::getService('dating')->isSponsored($aUser['user_id']),
            )
        );

	}

}