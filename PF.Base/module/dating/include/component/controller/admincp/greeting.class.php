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
class Dating_Component_Controller_Admincp_Greeting extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
    {
		
		if ($iDeleteId = $this->request()->getInt('delete'))
		{
			if (Phpfox::getService('dating.field')->deleteSection($iDeleteId))
			{
				$this->url()->send('admincp.dating.greeting', null, _p('successfully_deleted'));
			}
		}
		
		
		$aParentId = $this->request()->getInt('parent_id',0);
		
		$this->template()
			->setSectionTitle(_p('Manage Greeting'))
			->setActionMenu([
				_p('Create Greeting') => [
					'custom' => 'data-custom-class="js_box_full"',
					'url' => $this->url()->makeUrl('admincp.dating.greetingadd')
				]
			])
            ->setPhrase(['error'])
            ->setEditor()
			->setTitle(_p('Manage Greeting'))
			->setBreadCrumb(_p('Manage Greeting'))
           // ->setActiveMenu('admincp.appearance.page')
			->assign(array(
				'aPages' => Phpfox::getService('dating.field')->getGreetingDetails($aParentId),
				'aParentId'=>$aParentId
			)
		);
	}
}