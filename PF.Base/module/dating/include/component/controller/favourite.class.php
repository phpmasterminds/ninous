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
class Dating_Component_Controller_Favourite extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        Phpfox::isUser(true);
        Dating_Service_Dating::instance()->getSectionMenu();
        $this->template()->setTitle(_p('Dating'));
        $this->template()->setBreadCrumb(_p('Dating'), $this->url()->makeUrl("dating"));
        $this->template()->setBreadCrumb(_p("Favourite Users"), $this->url()->makeUrl("dating.favourite"));

        $this->search()->set(array(
                'type' => 'dating.favourite',
                'field' => 'f.user_id',
                'ignore_blocked' => true,
                'search_tool' => array(
                    'table_alias' => 'f',
                    'search' => array(
                        'action' => $this->url()->makeUrl('dating.favourite'),
                        'default_value' => _p('Search users'),
                        'name' => 'search',
                        'field' => 'u.full_name'
                    ),
                    'sort' => array(
                        'latest' => array('f.id', _p('latest')),
                    ),
                    'show' => array(12, 16, 24)
                )
            )
        );

        $aBrowseParams = array(
            'module_id' => 'dating.favourite',
            'alias' => 'f',
            'field' => 'id',
            'table' => Phpfox::getT('dating_favourite')
        );
        $this->search()->setCondition(" AND f.owner_id=".Phpfox::getUserId());

        $this->search()->setContinueSearch(true);
        $this->search()->browse()->params($aBrowseParams)->execute();

        $aUsers = $this->search()->browse()->getRows();

        Phpfox_Pager::instance()->set(array('page' => $this->search()->getPage(), 'size' => $this->search()->getDisplay(), 'count' => $this->search()->browse()->getCount()));

        $this->template()
            ->setHeader('cache', array(
                    'main.css' => 'module_dating',
                )
            )
            ->assign(array(
                    'aUsers' => $aUsers,
                    'path' =>  setting('core.path_actual') . "PF.Base/module/dating/static/image/",
                )
            );
	}
}