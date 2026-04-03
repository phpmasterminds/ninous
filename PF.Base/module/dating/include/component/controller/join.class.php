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
class Dating_Component_Controller_Join extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        Phpfox::isUser(true);
		
		$this->template()->setTitle(_p('Join'));
        $this->template()->setBreadCrumb(_p('Dating'), $this->url()->makeUrl("dating"));
        $this->template()->setBreadCrumb(_p("Join"), $this->url()->makeUrl("dating.join"));
		
		$aDetails = Dating_Service_Field::instance()->getJoinPageDetails();
		
		$this->template()
            ->setHeader('cache', array(
                    //'main.css' => 'module_dating',
                )
            )
            ->assign(array(
                    'aDetails' => $aDetails,
                    //'path' =>  setting('core.path_actual') . "PF.Base/module/dating/static/image/",
                )
            );
			
	}
}