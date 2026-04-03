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
class Dating_Component_Controller_Question extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        Phpfox::isUser(true);
		
		$this->template()->setTitle(_p('Question'));
		
		    $aSections = Phpfox::getService('dating.field')->getWizardData();

		$aForms = Dating_Service_Dating::instance()->getData(Phpfox::getUserId());
		
		foreach ($aForms as $key => $value) {
			if (is_string($value) && strpos($value, '[') === 0) {
				$decoded = json_decode($value, true);
				if (json_last_error() === JSON_ERROR_NONE) {
					$aForms[$key] = $decoded;
				}
			}
		}


		$this->template()
            ->setHeader('cache', array(
                    //'main.css' => 'module_dating',
                )
            )
            ->assign(array(
                    'aSections' => $aSections,
					"aForms" => $aForms,
                    //'path' =>  setting('core.path_actual') . "PF.Base/module/dating/static/image/",
                )
            );
			
	}
}