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
class Dating_Component_Controller_Admincp_Photo extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        //DELETE
        if ($iDelete = $this->request()->getInt('delete')) {
            if (Phpfox::getService('dating')->deleteImage($iDelete)) {
                $this->url()->send('admincp.dating.photo', null, _p('Successfully deleted photo'));
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
                'search' => "AND l.image_id LIKE '%[VALUE]%'"
            ),
            'display' => array(
                'type' => 'select',
                'options' => $aDisplays,
                'default' => '5'
            ),
            'sort' => array(
                'type' => 'select',
                'options' => $aSorts,
                'default' => 'l.image_id',
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
        list($iCnt, $aImages) = (Dating_Service_Dating::instance()->query($oSearch->getConditions(), $oSearch->getSort(), $oSearch->getPage(),$iLimit));

        Phpfox::getLib('pager')->set(array('page' => $iPage, 'size' => $iLimit, 'count' => $oSearch->getSearchTotal($iCnt)));

        $this->template()->setTitle(_p('Manage Photos'))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p('Manage Photos'), $this->url()->makeUrl('admincp.dating.photo'))
            ->assign([
                'aImages' => $aImages
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