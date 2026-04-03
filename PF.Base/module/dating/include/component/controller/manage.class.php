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
class Dating_Component_Controller_Manage extends Phpfox_Component
{
	/**
	 * Controller
	 */
	public function process()
	{
        Phpfox::isUser();

        //BUY FEATURED SONG
        if (!empty($_GET["featured"])) {
            switch ($_GET["featured"]) {
                case 1:
                    $cost = Phpfox::getParam('dating.dayfeatured');
                    $dateEnd = time()+3600*24;
                    break;
                case 2:
                    $cost = Phpfox::getParam('dating.weekfeatured');
                    $dateEnd = time()+3600*24*7;
                    break;
                case 3:
                    $cost = Phpfox::getParam('dating.monthfeatured');
                    $dateEnd = time()+3600*24*30;
                    break;
            }
            if ($cost > 0) {
                //BUYER
                $userPoint = PHPFOX::getService('phpfoxexpertemoney.userpoints')->getByUserId(PHPFOX::getUserId());
                $price = $cost;
                if (!empty($userPoint) && ($userPoint['points'] > $price)) {
                    $newPoint = $userPoint['points'] - $price;
                    $dataPayer = array(
                        'points' => $newPoint
                    );

                    PHPFOX::getService('phpfoxexpertemoney.userpoints')->update($dataPayer, $userPoint['points_id']);
                    $gSett = Phpfox::getService('phpfoxexpertemoney.globalsettings');

                    $hVals = array(
                        'user_id' => PHPFOX::getUserId(),
                        'points' => $price,
                        'paid_type' => 'dating',
                        'paid_date' => PHPFOX_TIME,
                        'comment' => _p("Buy sponsored dating profile")
                    );
                    PHPFOX::getService('phpfoxexpertemoney.userpointshistory')->add($hVals);

                    //ADD INTO PAID HISTORY
                    Phpfox::getService('dating')->addPaid(Phpfox::getUserId(), $dateEnd);

                    $this->url()->send('dating.manage', false, _p("Profile successfully sponsored!"));
                } else {
                    $this->url()->send('phpfoxexpertemoney.paypal', array("funds"=>$cost), _p("Not enough user balance, Please add funds!"));
                }
            }
        }

        //CHECK EMONEY SETTINGS
        if (Phpfox::getLib('module')->isModule('phpfoxexpertemoney')) {
            $eSett = Phpfox::getService('phpfoxexpertemoney.globalsettings');
            $currency = $eSett->getCurrency();
            $this->template()->assign(array(
                'currency' => $currency
            ));
        }

        //SAVE DATA
        if ($aVals = $this->request()->getArray('val')) {
            $aVals['dating_participate'] = $this->request()->get('dating_participate');
            Dating_Service_Dating::instance()->saveData($aVals, $this->request()->get('exclude'));
        }

        $aForms = Dating_Service_Dating::instance()->getData(Phpfox::getUserId());

        Dating_Service_Dating::instance()->getSectionMenu();
        $this->template()
            ->setBreadCrumb(_p("Dating"), $this->url()->makeUrl("dating"))
            ->setBreadCrumb(_p("Dating Profile"), $this->url()->makeUrl("dating.manage"))
            ->setHeader('cache', array(
                'main.css' => 'module_dating'
            ))
            ->assign(array(
                "aForms" => $aForms,
                "bIsEdit" => 1,
                "isSponsor" => Dating_Service_Dating::instance()->isSponsor(),
                "fields" => Dating_Service_Field::instance()->getForManage()
            ));

	}

}