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
class Dating_Component_Block_Menu extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
		$aOwnProfile = false;
		if(Phpfox::getLib('request')->get('req2') == 'profile'){
			$aOwnProfile = true;
			if(!empty(Phpfox::getLib('request')->get('userid'))){
				$aOwnProfile = false;
			}
		}
		$this->template()
          
            ->assign(array(
                    'aCurrent' => Phpfox::getLib('request')->get('req2'),
					'aOwnProfile'=>$aOwnProfile
                )
            );
	}
}