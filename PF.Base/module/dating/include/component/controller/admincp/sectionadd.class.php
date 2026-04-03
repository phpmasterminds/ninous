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
class Dating_Component_Controller_Admincp_Sectionadd extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
    {
        if ($iDelete = $this->request()->getInt('delete')) {
            if (Dating_Service_Field::instance()->delete($iDelete)) {
                $this->url()->send('admincp.dating.sec', null, _p('Sections successfully deleted'));
            }
        }

		$bIsEdit = false;
		if ($iEditId = $this->request()->getInt('id')) {
            $bIsEdit = true;
            $aCategory = Dating_Service_Field::instance()->getForSectionEdit($iEditId);
            if (!isset($aCategory['section_id'])) {
                $this->url()->send('admincp.dating.sec', null, _p('not_found'));
            }
            $this->template()->assign([
                'aForms' => $aCategory,
                'iEditId' => $iEditId
            ]);
		}

		if ($aVals = $this->request()->getArray('val')) {
            if ($bIsEdit) {
                if (Dating_Service_Field::instance()->updateSectionDetails($aVals)) {
                    $this->url()->send('admincp.dating.sec', false, _p('Sections successfully updated'));
                }
            } else {
                if (Dating_Service_Field::instance()->addSectionDetails($aVals)) {
                    $this->url()->send('admincp.dating.sec', false, _p('Sections successfully added'));
                }
            }
		}
		

		$this->template()->setTitle(($bIsEdit ? _p('Edit Section') : _p('Create Section')))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p("Manage Sections"), $this->url()->makeUrl('admincp.dating.sec'))
			->setBreadCrumb(($bIsEdit ? _p('Edit Section') : _p('Create Section')), $this->url()->makeUrl('admincp.dating.add'))
			->assign([
                'bIsEdit' => $bIsEdit,
				'aSections'=> Dating_Service_Field::instance()->getSectionDetails()
            ]);
	}

}