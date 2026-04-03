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
class Dating_Component_Controller_Admincp_Add extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
    {
        if ($iDelete = $this->request()->getInt('delete')) {
            if (Dating_Service_Field::instance()->delete($iDelete)) {
                $this->url()->send('admincp.dating.index', null, _p('Field successfully deleted'));
            }
        }

		$bIsEdit = false;
		if ($iEditId = $this->request()->getInt('id')) {
            $bIsEdit = true;
            $aCategory = Dating_Service_Field::instance()->getForEdit($iEditId);
            if (!isset($aCategory['field_id'])) {
                $this->url()->send('admincp.dating.index', null, _p('not_found'));
            }
            $this->template()->assign([
                'aForms' => $aCategory,
                'iEditId' => $iEditId
            ]);
		}

		if ($aVals = $this->request()->getArray('val')) {
			$aVals = $this->_processFieldOptions($aVals);
			
            if ($bIsEdit) {
                if (Dating_Service_Field::instance()->update($aVals)) {
                    $this->url()->send('admincp.dating.index', false, _p('Field successfully updated'));
                }
            } else {
                if (Dating_Service_Field::instance()->add($aVals)) {
                    $this->url()->send('admincp.dating.index', false, _p('Field successfully added'));
                }
            }
		}

		$this->template()->setTitle(($bIsEdit ? _p('Edit Field') : _p('Create Field')))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p("Manage Fields"), $this->url()->makeUrl('admincp.dating.index'))
			->setBreadCrumb(($bIsEdit ? _p('Edit Field') : _p('Create Field')), $this->url()->makeUrl('admincp.dating.add'))
			->assign([
                'bIsEdit' => $bIsEdit,
				'aSections'=>Dating_Service_Field::instance()->getSections()
            ]);
	}

	private function _processFieldOptions($aVals)
    {
        $fieldType = !empty($aVals['type']) ? $aVals['type'] : '';
        
        // Only process options for radio and multiple choice fields
        if ($fieldType === 'radio' || $fieldType === 'multiple') {
            $aOptions = [];
            
            // Collect all option values from option_* inputs
            foreach ($aVals as $key => $value) {
                if (strpos($key, 'option_') === 0 && !empty($value)) {
                    $aOptions[] = trim($value);
                }
            }
            
            // Store options as JSON string
            $aVals['options'] = !empty($aOptions) ? json_encode($aOptions) : '';
            
            // Remove individual option inputs to keep database clean
            foreach ($aVals as $key => $value) {
                if (strpos($key, 'option_') === 0) {
                    unset($aVals[$key]);
                }
            }
        } else {
            // Clear options for non-option fields
            $aVals['options'] = '';
            
            // Remove any option inputs
            foreach ($aVals as $key => $value) {
                if (strpos($key, 'option_') === 0) {
                    unset($aVals[$key]);
                }
            }
        }
        
        return $aVals;
    }
	
}