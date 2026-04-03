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
class Dating_Component_Block_Greet extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$greet_id = $this->request()->get('greet_id');
		$tier = $this->request()->get('tier');
		
		Phpfox::getService('user')->getUserFields(false, $aUser, null, $this->request()->get('user_id'));
        $this->template()->assign(array(
            'aUser' => $aUser,
            'greet_id' => $greet_id,
            'tier' => $tier,
            'bCanPoke' => Phpfox::getService('poke')->canSendPoke($this->request()->get('user_id'))
        ));

        return 'block';
	}
}