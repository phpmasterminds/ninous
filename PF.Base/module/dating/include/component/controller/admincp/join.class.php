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
class Dating_Component_Controller_Admincp_Join extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
    {
		$bIsEdit = true;
		

		if ($aVals = $this->request()->getArray('val')) {
            if ($bIsEdit) {
				
				if (!empty($_FILES['product_image']['name'])) {
					$uploadDir = Phpfox::getParam('core.dir_pic') . 'dating2014/';
					if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

					$ext = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
					//$fileName = 'product_' . uniqid() . '.' . $ext;
					$fileName = 'join_page_image.' . $ext;
					$targetPath = $uploadDir . $fileName;

					if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetPath)) {
						// Optional thumbnail (requires GD)
						$thumbPath = $uploadDir . 'thumb_' . $fileName;
						Phpfox::getLib('image')->createThumbnail($targetPath, $thumbPath, 400, 400);

						$imageURL = Phpfox::getParam('core.path') . 'file/pic/dating2014/' . $fileName;
						$aVals['image_path'] = $imageURL;
					} else {
						
					}
				}
				
                if (Dating_Service_Field::instance()->updateJoinPageDetails($aVals)) {
                    $this->url()->send('admincp.dating.join', false, _p('Successfully updated'));
                }
            } else {
                if (Dating_Service_Field::instance()->addJoinPageDetails($aVals)) {
                    $this->url()->send('admincp.dating.join', false, _p('Successfully added'));
                }
            }
		}
		
		$aDetails = Dating_Service_Field::instance()->getJoinPageDetails();
		
		$this->template()->setTitle(($bIsEdit ? _p('Edit Field') : _p('Create Field')))
            ->setBreadCrumb(_p("Apps"), $this->url()->makeUrl('admincp.apps'))
            ->setBreadCrumb(_p("Manage Fields"), $this->url()->makeUrl('admincp.dating.index'))
			->setBreadCrumb(($bIsEdit ? _p('Join Page') : _p('Join Page')), $this->url()->makeUrl('admincp.dating.join'))
			->assign([
                'aForms' => $aDetails,
                'iEditId' => 1,
				'bIsEdit'=>$bIsEdit
            ]);
	}
}