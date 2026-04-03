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
class Dating_Component_Controller_Photo extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        Phpfox::isUser();

        //ADD PHOTOS
        if ($aVals = $this->request()->getArray('val')) {
            Dating_Service_Dating::instance()->addPhoto();
            $this->url()->send("dating.photo",false,_p("Photo Successfully added!"));
        }

        //GET IMAGES
        $aImages = Dating_Service_Dating::instance()->getImages(Phpfox::getUserId());

        $this->template()->assign(array(
                'aImages' => $aImages
            )
        )->setHeader('cache',array(
            'progress.js' => 'static_script',
            '<script type="text/javascript">$Behavior.storeProgressBarSettings = function(){ if ($Core.exists(\'#js_marketplace_form_holder\')) { oProgressBar = {holder: \'#js_marketplace_form_holder\', progress_id: \'#js_progress_bar\', uploader: \'#js_progress_uploader\', add_more: true, max_upload: ' . (int) 100 . ', total: 1, frame_id: \'js_upload_frame\', file_id: \'image[]\'}; $Core.progressBarInit(); } }</script>',
        ));

        Dating_Service_Dating::instance()->getSectionMenu();
        $this->template()
            ->setBreadCrumb(_p("Dating"), $this->url()->makeUrl("dating"))
            ->setBreadCrumb(_p("Dating Profile"), $this->url()->makeUrl("dating.manage"))
            ->setBreadCrumb(_p("Photos"), $this->url()->makeUrl("dating.photo"))
            ->setHeader('cache', array(
                'main.css' => 'module_dating'
            ));
	}

}