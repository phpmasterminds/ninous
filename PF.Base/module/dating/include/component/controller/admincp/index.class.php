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
class Dating_Component_Controller_Admincp_Index extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
    {
        //Get all category belong to this category
        $aCategories = Dating_Service_Field::instance()->getForManageHierarchical();

		$this->template()->setTitle(_p('Manage Fields'))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
			->setBreadCrumb(_p('Manage Fields'), $this->url()->makeUrl('admincp.dating.index'))
			->setHeader([
                'drag.js' => 'static_script',
                '<script type="text/javascript">$Behavior.coreDragInit = function() { Core_drag.init({table: \'#js_drag_drop\', ajax: \'dating.categoryOrdering\'}); }</script>',
            ])->assign([
                'aHierarchicalData' => $aCategories
            ]);
	}
}