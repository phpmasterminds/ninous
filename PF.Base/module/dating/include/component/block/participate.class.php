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
class Dating_Component_Block_Participate extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        if (!Phpfox::getParam('dating.enableparticipation')) {
           return false;
        }

        $datingParticipate = Phpfox::getService('dating')->getDatingParticipate();
        if (!empty($datingParticipate)) {
            return false;
        }

        $this->template()->assign(array(
                'datingpath' =>  setting('core.path_actual') . "PF.Base/module/dating/static/image/",
            )
        );
	}

}