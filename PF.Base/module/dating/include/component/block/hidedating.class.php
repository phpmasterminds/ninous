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
class Dating_Component_Block_Hidedating extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        if (!db()->isField(Phpfox::getT('dating_values'), 'dating_participate')) {
            db()->query("ALTER TABLE  `" . Phpfox::getT('dating_values') . "` ADD `dating_participate` INT");
        }

        if (Phpfox::getLib('module')->isModule('phpfoxexpertemoney')) {
            //CHECK OLD SPONSORED DATING PROFILES
            PHPFOX::getService('dating')->checkOldFeatured();
        }

        //CHECK QUERY
        $cond = Dating_Service_Dating::instance()->getFilter();
        $this->template()->assign(array(
            'cond' => $cond
        ));
    }
}