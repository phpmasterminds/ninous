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
class Dating_Service_Matching extends Phpfox_Service
{
	public function getMatchingUsers($aCond = [], $iPage = 0, $iPageSize = 8)
	{
		$iUserId = Phpfox::getUserId();
		$aUsers  = [];
		$iCnt    = 0;

		/* --------------------------------------------------
		 * 1) Detect REAL field_X columns dynamically
		 * -------------------------------------------------- */
		$aColumns = $this->database()
			->select('COLUMN_NAME')
			->from('information_schema.COLUMNS')
			->where("
				TABLE_SCHEMA = DATABASE()
				AND TABLE_NAME = '" . Phpfox::getT('dating_values') . "'
				AND COLUMN_NAME LIKE 'field_%'
			")
			->execute('getSlaveRows');

		if (!$aColumns) {
			return [0, []];
		}

		$aExistingFields = [];
		foreach ($aColumns as $aCol) {
			$iFieldId = (int)str_replace('field_', '', $aCol['COLUMN_NAME']);
			if ($iFieldId > 0) {
				$aExistingFields[$iFieldId] = true;
			}
		}

		/* --------------------------------------------------
		 * 2) Load question titles & options
		 * -------------------------------------------------- */
		$aFieldTitles  = [];
		$aFieldOptions = [];

		$aFieldRows = $this->database()
			->select('f.field_id, f.title, f.options, s.section_name')
			->from(Phpfox::getT('dating_fields'),'f')
			->join(Phpfox::getT('dating_sections'), 's', 's.section_id = f.section_id')
			->where('f.section_id > 0')
			->order('f.section_id ASC')
			->execute('getSlaveRows');

		foreach ($aFieldRows as $aField) {
			$iFieldId = (int)$aField['field_id'];

			if (isset($aExistingFields[$iFieldId])) {
				$aFieldTitles[$iFieldId]['question'] = $aField['title'];
				$aFieldTitles[$iFieldId]['section_name'] = $aField['section_name'];

				if (!empty($aField['options'])) {
					$aFieldOptions[$iFieldId] = json_decode($aField['options'], true);
				}
			}
		}

		if (!$aFieldTitles) {
			return [0, []];
		}

		/* --------------------------------------------------
		 * 3) Build dynamic SQL for matching
		 * -------------------------------------------------- */
		$aMatchSql    = [];
		$aAnsweredSql = [];

		foreach ($aExistingFields as $iFieldId => $_) {

			$aMatchSql[] = "
				IF(
					v.field_{$iFieldId} IS NOT NULL
					AND v.field_{$iFieldId} != ''
					AND v.field_{$iFieldId} = my.field_{$iFieldId},
					1,
					0
				)
			";

			$aAnsweredSql[] = "
				IF(
					my.field_{$iFieldId} IS NOT NULL
					AND my.field_{$iFieldId} != '',
					1,
					0
				)
			";
		}

		$sMatchSql    = implode(' + ', $aMatchSql);
		$sAnsweredSql = implode(' + ', $aAnsweredSql);

		/* --------------------------------------------------
		 * 4) COUNT QUERY (pagination)
		 * -------------------------------------------------- */
		$aCond[] = "AND ({$sMatchSql}) > 0";

		$iCnt = (int)$this->database()
			->select('COUNT(DISTINCT u.user_id)')
			->from(Phpfox::getT('dating_values'), 'v')
			->join(Phpfox::getT('dating_values'), 'my', 'my.user_id = ' . (int)$iUserId)
			->join(Phpfox::getT('user'), 'u', 'u.user_id = v.user_id')
			->where($aCond)
			->execute('getSlaveField');

		/* --------------------------------------------------
		 * 5) DATA QUERY (paginated)
		 * -------------------------------------------------- */
		if ($iCnt) {

	$aMySelect = [];

	foreach ($aExistingFields as $iFieldId => $_) {
		$aMySelect[] = "my.field_{$iFieldId} AS my_field_{$iFieldId}";
	}

	$sMySelect = implode(",\n", $aMySelect);


			$aUsers = $this->database()
				->select("
					u.user_id,
					u.full_name,
					u.birthday,
					u.email,
					u.user_image,
					u.server_id,
					uf.*,

					v.*,
					{$sMySelect},

					({$sMatchSql}) AS matched_answers,
					ROUND(
						(({$sMatchSql}) / NULLIF(({$sAnsweredSql}), 0)) * 100,
					0) AS match_percent
				")
				->from(Phpfox::getT('dating_values'), 'v')
				->join(Phpfox::getT('dating_values'), 'my', 'my.user_id = ' . (int)$iUserId)
				->join(Phpfox::getT('user'), 'u', 'u.user_id = v.user_id')
				->join(Phpfox::getT('user_field'), 'uf', 'uf.user_id = u.user_id')
				->where($aCond)
				->order('match_percent DESC')
				->limit($iPage, $iPageSize, $iCnt)
				->execute('getSlaveRows');

			/* --------------------------------------------------
			 * 6) Build "Why you matched" details
			 * -------------------------------------------------- */
			
			foreach ($aUsers as &$aUser) {

				$aUser['matched_details'] = [];

				foreach ($aExistingFields as $iFieldId => $_) {

					$sField    = 'field_' . $iFieldId;
					$sMyField  = 'my_field_' . $iFieldId;

					if (
						!empty($aUser[$sField]) &&
						!empty($aUser[$sMyField]) &&
						$aUser[$sField] == $aUser[$sMyField]
					) {
						$sTitle = $aFieldTitles[$iFieldId]['question'] ?? 'Answer';
						$aSection = $aFieldTitles[$iFieldId]['section_name'];
						$sValue = $aUser[$sField];

						if (isset($aFieldOptions[$iFieldId][$sValue])) {
							$sValue = $aFieldOptions[$iFieldId][$sValue];
						}
						
						$sentence = $this->makeMatchSentence($sTitle, $sValue);

						if ($sentence) {
							$aUser['matched_details'][$aSection][] = $sentence;
						}


						/*$sentence = $this->makeMatchSentence($sTitle, $sValue);
						//$aUser['matched_details'][$sTitle] = $sValue;
						$aUser['matched_details'][$aSection][] = $sentence;*/
					}
				}
				
				//GET ADDITIONAL INFO
				$aUser['is_poked'] = Phpfox::getService('dating')->ispoked($aUser["user_id"],PHPFOX::getUserId(),'tier1');
				$aUser['is_poked2'] = Phpfox::getService('dating')->ispoked($aUser["user_id"],PHPFOX::getUserId(),'tier2');
				$aUser['is_online'] = Phpfox::getService('dating')->isOnline($aUser["user_id"]);
			}

		}
		return [$iCnt, $aUsers];
	}

	public function makeMatchSentence(string $question, string $answer): ?string
	{
		// Normalize array / JSON answers
		$decoded = json_decode($answer, true);
		if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
			$answer = implode(' and ', $decoded);
		}
	
		$q = strtolower(trim($question));
		$a = trim($answer);

		// Ignore garbage answers
		if ($a === '' || $a === '0' || strtolower($a) === 'test') {
			return null;
		}

		// YES / NO
		if (strtolower($a) === 'yes') {
			if (preg_match('/marriage/', $q)) {
				return 'Desires sacramental marriage';
			}

			return 'Affirms this value';
		}

		// Church / faith
		if (preg_match('/church|faith|orthodox/', $q)) {
			return "Attends church {$a}";
		}

		// Marriage / family
		if (preg_match('/marriage|family|home/', $q)) {
			return 'Values a strong and peaceful family life';
		}

		// Joy / peace
		if (preg_match('/joy|peace/', $q)) {
			return 'Values peace and inner balance in daily life';
		}

		// Disagreements / communication
		if (preg_match('/disagree|conversation|conflict/', $q)) {
			return 'Approaches difficult conversations thoughtfully';
		}

		// Food
		if (preg_match('/food/', $q)) {
			return "Enjoys {$a} cuisine";
		}

		// Short option answers (radio / select)
		if (strlen($a) < 40) {
			return ucfirst($a);
		}

		// Long reflective answers
		if (strlen($a) >= 40) {
			//return 'Thoughtful and reflective in personal responses';
			return ucfirst($a);
		}

		return null;
	}


	public function sendGreet($iUserId,$aGreetingId,$aTier)
    {
        if ($iUserId == Phpfox::getUserId()) {
            return false;
        }
		
        /* if the other user has not seen a poke then we do not add it */
        $iExists = db()->select('poke_id')
            ->from(Phpfox::getT('dating_greeting_users'))
            ->where('user_id = ' . Phpfox::getUserId() . ' AND to_user_id = ' . (int)$iUserId . ' AND greeting_id = ' .$aGreetingId)
            ->execute('getSlaveField');
			
        if ($iExists > 0) {
            return false;
        }
        $iPokeId = db()->insert(Phpfox::getT('dating_greeting_users'), array(
            'user_id' => Phpfox::getUserId(),
            'to_user_id' => (int)$iUserId,
            'greeting_id' => (int)$aGreetingId,
            'tier' => $aTier,
        ));

        /* Ignore all pokes from $iUserId to us */
       // $this->ignore($iUserId);

       // $this->cache()->remove('pokes_total_' . $iUserId);

        if (Phpfox::getParam('poke.add_to_feed') && Phpfox::isModule('feed')) {
          //  Phpfox::getService('feed.process')->add('poke', $iPokeId, 0, 0, 0, $iUserId);
        }
        if (Phpfox::isModule('notification')) {
            Phpfox::getService('notification.process')->add('dating', $iPokeId, (int)$iUserId, Phpfox::getUserId());
        }

        Phpfox::getLib('mail')->to($iUserId)
            ->subject('poke_mail_subject')
            ->message(array(
                'full_name_has_poked_you',
                array(
                    'full_name' => Phpfox::getUserBy('full_name')
                )
            ))
            ->send();
        return true;
    }


}