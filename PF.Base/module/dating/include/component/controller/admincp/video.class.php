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
class Dating_Component_Controller_Admincp_Video extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        //DELETE
        if ($iDelete = $this->request()->getInt('delete')) {
            if (Phpfox::getService('dating')->deleteVideoAdmin($iDelete)) {
                $this->url()->send('admincp.dating.video', null, _p('Successfully deleted video'));
            }
        }

        $iPage = $this->request()->getInt('page');

        $aPages = array(5, 10, 15, 20,50);
        $aDisplays = array();
        foreach ($aPages as $iPageCnt) {
            $aDisplays[$iPageCnt] = $iPageCnt." per page";
        }

        $aSorts = array(
            'l.image_id' => _p("time")
        );

        $aFilters = array(
            'search' => array(
                'type' => 'input:text',
                'search' => "AND l.id LIKE '%[VALUE]%'"
            ),
            'display' => array(
                'type' => 'select',
                'options' => $aDisplays,
                'default' => '5'
            ),
            'sort' => array(
                'type' => 'select',
                'options' => $aSorts,
                'default' => 'l.id',
            ),
            'sort_by' => array(
                'type' => 'select',
                'options' => array(
                    'DESC' => _p("DESC"),
                    'ASC' => _p("ASC")
                ),
                'default' => 'DESC'
            )
        );

        $oSearch = Phpfox::getLib('search')->set(array(
                'type' => 'dating',
                'filters' => $aFilters,
                'search' => 'search'
            )
        );

        $this->template()->setHeader('cache',
            array(
                'pager.css' 	 => 'style_css',
                'fontawesome-stars.css'=> 'module_store',
            ));

        $iLimit = $oSearch->getDisplay();
        list($iCnt, $aVideos) = (Dating_Service_Dating::instance()->queryVideos($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(),$iLimit));

        Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $oSearch->getSearchTotal($iCnt)));

        $this->template()->setTitle(_p('Manage Videos'))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p('Manage Videos'), $this->url()->makeUrl('admincp.dating.video'))
            ->assign([
                'aVideos' => $aVideos
            ]);
	}
	
	/**
	 * Garbage collector. Is executed after this class has completed
	 * its job and the template has also been displayed.
	 */
	public function clean()
	{
		(($sPlugin = Phpfox_Plugin::get('video.component_controller_admincp_index_clean')) ? eval($sPlugin) : false);
	}
}