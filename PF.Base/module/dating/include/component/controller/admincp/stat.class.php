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
class Dating_Component_Controller_Admincp_Stat extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        //Get all category belong to this category
        $stats = Dating_Service_Dating::instance()->getAdminStats();

        $this->template()->setTitle(_p('Dating Statistic'))
            ->assign(array(
                "stats"=>$stats
            ))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p('Dating Statistic'), $this->url()->makeUrl('admincp.dating.stat'));
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('store.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}