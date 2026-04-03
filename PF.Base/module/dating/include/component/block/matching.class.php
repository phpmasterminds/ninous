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
class Dating_Component_Block_Matching extends Phpfox_Component
{
    /**
     * Controller
     */
    public function process()
    {
        $iPageSize = $this->getParam('limit', 10);
        $iPage = $this->getParam('page', 1);
        $sTab = $this->getParam('tab', 'attending');
        $sContainer = $this->getParam('container', '.item-event-member-block');
        if (!(int)$iPageSize) {
            return false;
        }
       
		$aCond[] = 'v.user_id != '.Phpfox::getUserId();
		list($iCnt, $aUsers) = Phpfox::getService('dating.matching')->getMatchingUsers($aCond,$iPage, $iPageSize);
			
        $aParamsPager = array(
            'page' => $iPage,
            'size' => $iPageSize,
            'count' => $iCnt,
            'paging_mode' => 'pagination',
            'ajax_paging' => [
                'block' => 'dating.matching',
                'params' => [
                    'tab' => $sTab,
                ],
                'container' => $sContainer
            ]
        );
        $this->template()->assign(array(
                'iCnt' => $iCnt,
                'aUsers' => $aUsers,
                'bIsPaging' => $this->getParam('ajax_paging', 0)
            )
        );
        Phpfox::getLib('pager')->set($aParamsPager);
		return 'block';
	}
}