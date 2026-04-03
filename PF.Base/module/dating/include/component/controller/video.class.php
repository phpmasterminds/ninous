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
class Dating_Component_Controller_Video extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        Phpfox::isUser();

        //DELETE VIDEO
        if (!empty($_GET["videodelete"])) {
            Dating_Service_Dating::instance()->deleteVideo((int)$_GET["videodelete"]);
            $this->url()->send("dating.video",false,_p("Video Successfully deleted"));
        }

        //ADD VIDEO
        if ($aVals = $this->request()->getArray('val')) {
            Dating_Service_Dating::instance()->addVideo($aVals);
            $this->url()->send("dating.video",false,_p("Video Successfully added!"));
        }

        //GET VIDEOS
        $aVideos = Dating_Service_Dating::instance()->getVideos(Phpfox::getUserId());
        if (!empty($aVideos)) {
            $this->template()->assign(array(
                "aVideos" => $aVideos
            ));
        }

        Dating_Service_Dating::instance()->getSectionMenu();
        $this->template()
            ->setBreadCrumb(_p("Dating"), $this->url()->makeUrl("dating"))
            ->setBreadCrumb(_p("Dating Profile"), $this->url()->makeUrl("dating.manage"))
            ->setBreadCrumb(_p("Videos"), $this->url()->makeUrl("dating.video"))
            ->setHeader('cache', array(
                'main.css' => 'module_dating'
            ));
	}

}