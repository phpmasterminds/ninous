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
class Dating_Component_Controller_Admincp_Order extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
    {
		$ids = request()->get('ids');
		var_dump($ids);
		die();
        $ids = trim($ids, ',');
        $ids = explode(',', $ids);
        $values = [];
        foreach ($ids as $key => $id) {
            $values[$id] = $key + 1;
        }
        Phpfox::getService('core.process')->updateOrdering([
                'table' => 'icons_category',
                'key' => 'category_id',
                'values' => $values,
            ]
        );
		
		return true;
		exit;
	}
}