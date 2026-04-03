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
class Dating_Component_Block_New extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        if (Phpfox::getParam('dating.enableparticipation')) {
            $datingParticipate = Phpfox::getService('dating')->getDatingParticipate();
            if (empty($datingParticipate)) {
                return false;
            }
        }

        $top_bloggers = Phpfox::getService('dating')->getNewMembers();
        if (empty($top_bloggers)) {
            return false;
        }

        foreach($top_bloggers as &$item)
        {
            $pUsersInfo = array(
                'title' => $item['full_name'],
                'path' => 'core.url_user',
                'file' => $item['user_image'],
                'suffix' => '_50_square',
                'width' => 50,
                'height' => 50,
            );
            $item['profile_image'] = Phpfox::getLib('image.helper')->display(array_merge(array('user' => Phpfox::getService('user')->getUserFields(true, $item)), $pUsersInfo));
        }
        $this->template()->assign(array(
                'top_bloggers' => $top_bloggers,
                'path' =>  setting('core.path_actual') . "PF.Base/module/dating/static/image/",
            )
        );
	}

}