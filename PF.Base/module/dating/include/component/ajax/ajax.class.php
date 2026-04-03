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
class Dating_Component_Ajax_Ajax extends Phpfox_Ajax
{
	public function greet()
    {
        $this->setTitle(_p('Greet'));
		
		 $aParams = array(
            'greet_id' => $this->get('greet_id'),
            'tier' => $this->get('tier'),
        );

		
        Phpfox::getBlock('dating.greet',$aParams);
        echo '<script type="text/javascript">$Core.loadInit();</script>';

    }
	public function doGreet()
	{
		
		if (Phpfox::getService('dating.matching')->sendGreet($this->get('user_id'),$this->get('greet_id'),$this->get('tier'))) {
            /* Type 1 is when poking back from the display block*/
            if ((int)$this->get('type') != 1) {
                $this->call('$("#section_poke").hide().remove();');
                //return $this->alert(_p('your_poke_successfully_sent'), _p('notice'), 300, 150, true);
				$this->reload();
				$this->softNotice(_p('your_poke_successfully_sent'));
				
            }
        } else {
            $this->alert(_p('poke_could_not_be_sent'));
        }

        $this->call('$(".js_core_poke_item_' . $this->get('user_id') . '").hide().remove();');
	}
	
    public function sponsor()
    {
        if (PHPFOX::getUserId()) {
            $userId = $this->get('user_id');
            $isFollow = Phpfox::getService('dating')->sponsor($userId);
        }

        if ($isFollow == "un") {
            $this->call("$('#dating_text_".$userId."').html('<i class=\"ico ico-sponsor mr-1\"></i> "._p("Dating Sponsor")."');");
        }
        else {
            $this->call("$('#dating_text_".$userId."').html('<span style=\"color:#297fc7;\"><i class=\"ico ico-sponsor mr-1\"></i> "._p("Dating Sponsored")."</span>');");
        }
    }

	public function add()
	{
		Phpfox::isUser(true);
		if (Advancedlike_Service_Process::instance()->add($this->get('type_id'), $this->get('item_id'), null, $this->get('app_id', null), [], $this->get('table_prefix', ''), $this->get("like_type"))) {
			if ($this->get('type_id') == 'pages') {
				$this->call('window.location.reload();');
				return;
			}

			if ($this->get('type_id') == 'feed_mini' && $this->get('custom_inline')) {
				$this->_loadCommentLikes();
			}
			else {
				/* When clicking "Like" from the Feed */
				$this->_loadLikes();
			}

			if (!$this->get('counterholder')) {
			    $this->call('$Core.loadInit();');
			}
		}
	}
	
	public function saveWizardStep()
	{
		$aVals = $this->get('val');
		if (empty($aVals)) {
			echo json_encode([
				'error'   => true,
				'message' => 'No data received'
			]);
			return false;
		}
		$aVals['dating_participate'] = 1;
        try {
			Dating_Service_Dating::instance()->saveData($aVals, 0);

			echo json_encode([
				'error'   => false,
				'message' => 'Saved successfully'
			]);
			return true;

		} catch (Exception $e) {
			echo json_encode([
				'error'   => true,
				'message' => $e->getMessage()
			]);
			return false;
		}
	}

    public function deleteImage()
    {
        Dating_Service_Dating::instance()->deleteImage($this->get('id'));
    }

    public function setDefault()
    {
        Dating_Service_Dating::instance()->setDefault($this->get('id'));
    }

    public function categoryOrdering()
    {
        Phpfox::isAdmin(true);
        $aVals = $this->get('val');
        Core_Service_Process::instance()->updateOrdering([
            'table' => 'dating_fields',
            'key' => 'field_id',
            'values' => $aVals['ordering']
        ]);
    }

    public function favourite()
    {
        if (PHPFOX::getUserId()) {
            $userId = $this->get('user_id');
            $isFollow = Phpfox::getService('dating')->addFavourite($userId);
        }

        if ($isFollow == "un") {
            $this->call("$('#dating_text_".$userId."').html('<i class=\"fa fa-star-o\"></i> "._p("Add favourite")."');");
        }
        else {
            $this->call("$('#dating_text_".$userId."').html('<span style=\"color:#297fc7;\"><i class=\"fa fa-star\"></i> "._p("Remove favourite")."</span>');");
        }
    }

    public function like()
    {
        $likeUserId = $this->get("user_id");
        $isuser = $this->get("isuser");

        if (!empty($likeUserId)) {
            Dating_Service_Dating::instance()->addLike($likeUserId);
        }

        if (!empty($isuser)) {
            $status = Dating_Service_Dating::instance()->getStatus($likeUserId);
            if ($status["status"] == 'mutual') {
                $this->call('$(".what").hide();');
            }
            $this->html('#single_action', $status["phrase"]);
        } else {
            $this->getDatingUser();
        }
    }

    public function next()
    {
        $likeUserId = $this->get("user_id");
        $isuser = $this->get("isuser");

        if (!empty($likeUserId)) {
            Dating_Service_Dating::instance()->addNext($likeUserId);
        }

        if (!empty($isuser)) {
            $status = Dating_Service_Dating::instance()->getStatus($likeUserId);
            $this->html('#single_action', $status["phrase"]);
        } else {
            $this->getDatingUser();
        }
    }

    public function getDatingUser()
    {
        $this->call("$('#datingcont').hide();");
        $this->call("$('#imagecont').fadeIn();");
        Phpfox::getComponent('dating.search', array(
            'searchtext' => $this->get("searchtext")
        ), 'controller');

        $this->html('#datingcont', $this->getContent(false));
        $this->call("$('#imagecont').hide();");
        $this->call("$('#datingcont').fadeIn(1000);");

        $this->call('$Core.loadInit();');
        return null;
    }
	
	public function getMatchingUser()
    {
        $this->call("$('#datingcont').hide();");
		
		Phpfox::getBlock('dating.matching');
            
        $this->html('#datingcont', $this->getContent(false));
        $this->call("$('#datingcont').show();");

        $this->call('$Core.loadInit();');
        return null;
    }
}