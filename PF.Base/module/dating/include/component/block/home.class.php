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
class Dating_Component_Block_Home extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        $cond = Dating_Service_Dating::instance()->getFilter();
        $search = '';
        if (!empty($cond["query"])) {
            parse_str($cond["query"], $search);
            $this->template()->assign(array(
                'aForms' => $search["search"]
            ));
        }

        $this->template()->assign(array(
                'country' => Core_Service_Country_Country::instance()->get(),
                'path' =>  setting('core.path_actual') . "PF.Base/module/dating/static/image/",
            )
        );

        $this->template()->assign(array(
                'aCountryChildren' => Core_Service_Country_Country::instance()->get(),
                'bForceDiv' => $this->getParam('country_force_div', false)
            )
        );
	}
}