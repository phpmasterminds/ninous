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
class Dating_Component_Controller_Admincp_Greetingadd extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
    {
        if ($iDelete = $this->request()->getInt('delete')) {
            if (Dating_Service_Field::instance()->delete($iDelete)) {
                $this->url()->send('admincp.dating.greeting', null, _p('Greeting successfully deleted'));
            }
        }

		$bIsEdit = false;
		if ($iEditId = $this->request()->getInt('id')) {
            $bIsEdit = true;
            $aCategory = Dating_Service_Field::instance()->getForGreetingEdit($iEditId);
            if (!isset($aCategory['greeting_id'])) {
                $this->url()->send('admincp.dating.greeting', null, _p('not_found'));
            }
            $this->template()->assign([
                'aForms' => $aCategory,
                'iEditId' => $iEditId
            ]);
		}

		if ($aVals = $this->request()->getArray('val')) {
            if ($bIsEdit) {
                if (Dating_Service_Field::instance()->updateGreetingDetails($aVals)) {
                    $this->url()->send('admincp.dating.greeting', false, _p('Sections successfully updated'));
                }
            } else {
                if (Dating_Service_Field::instance()->addGreetingDetails($aVals)) {
                    $this->url()->send('admincp.dating.greeting', false, _p('Sections successfully added'));
                }
            }
		}
		

		$this->template()->setTitle(($bIsEdit ? _p('Edit Greeting') : _p('Create Greeting')))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p("Manage Sections"), $this->url()->makeUrl('admincp.dating.greeting'))
			->setBreadCrumb(($bIsEdit ? _p('Edit Greeting') : _p('Create Greeting')), $this->url()->makeUrl('admincp.dating.greetingadd'))
			->assign([
                'bIsEdit' => $bIsEdit,
				'aSections'=> Dating_Service_Field::instance()->getSectionDetails()
            ]);
	}

}