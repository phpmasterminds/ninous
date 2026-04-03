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
class Dating_Service_Field extends Phpfox_Service
{
    public function __construct()
    {
        $this->_sTable = Phpfox::getT('dating_fields');
    }
	
	public function getJoinPageDetails()
    {
		/*$this->database()->query("
			CREATE TABLE IF NOT EXISTS `phpfox_dating_join_page_details` (
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`image_path` VARCHAR(255) NULL,
				`join_title` VARCHAR(255) NULL,
				`join_text_description` VARCHAR(500) NULL,
				`join_button_text` VARCHAR(100) NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");*/

		
        $aDetails = $this->database()->select('*')
            ->from(Phpfox::getT('dating_join_page_details'))
            ->execute('getSlaveRow');

        return $aDetails;
    }
	public function addJoinPageDetails($aVals){
		
		$iCategoryId = $this->database()->insert(Phpfox::getT('dating_join_page_details'), [
            'join_title' => !empty($aVals["join_title"]) ? $aVals["join_title"] : "",
            'join_text_description' => !empty($aVals["join_text_description"]) ? $aVals["join_text_description"] : "",
            'join_button_text' => !empty($aVals["join_button_text"]) ? $aVals["join_button_text"] : "",
            
        ]);
		
        return $iCategoryId;
	}
	
	public function updateJoinPageDetails($aVals){
		
		$this->database()->update(Phpfox::getT('dating_join_page_details'), [
            'join_title' => !empty($aVals["join_title"]) ? $aVals["join_title"] : "",
            'join_text_description' => !empty($aVals["join_text_description"]) ? $aVals["join_text_description"] : "",
            'join_button_text' => !empty($aVals["join_button_text"]) ? $aVals["join_button_text"] : "",
            'image_path' => !empty($aVals["image_path"]) ? $aVals["image_path"] : "",
        ], 'id = 1'
        );
		
        return true;
	}
	
	public function getSectionDetails($aParentId = 0)
    {
		
        $aDetails = $this->database()->select('*')
            ->from(Phpfox::getT('dating_sections'))
			->where('parent_id = '.$aParentId.' AND is_delete = 0')
            ->execute('getSlaveRows');

        return $aDetails;
    }
	public function addSectionDetails($aVals){
		
		$iCategoryId = $this->database()->insert(Phpfox::getT('dating_sections'), [
            'section_name' => !empty($aVals["section_name"]) ? $aVals["section_name"] : "",
            'parent_id' => !empty($aVals["parent_id"]) ? $aVals["parent_id"] : "0",
            'background_color' => !empty($aVals["background_color"]) ? $aVals["background_color"] : "",
            'color' => !empty($aVals["color"]) ? $aVals["color"] : "",
            'description' => !empty($aVals["description"]) ? $aVals["description"] : "",
            
        ]);
		
        return $iCategoryId;
	}
	
	public function updateSectionDetails($aVals){
		
		$this->database()->update(Phpfox::getT('dating_sections'), [
            'section_name' => !empty($aVals["section_name"]) ? $aVals["section_name"] : "",
			'parent_id' => !empty($aVals["parent_id"]) ? $aVals["parent_id"] : "0",
            'background_color' => !empty($aVals["background_color"]) ? $aVals["background_color"] : "",
            'color' => !empty($aVals["color"]) ? $aVals["color"] : "",
			'description' => !empty($aVals["description"]) ? $aVals["description"] : "",
        ], 'section_id = '.$aVals['edit_id']
        );
		
        return true;
	}
	
	public function getGreetingDetails($aParentId = 0)
    {
		
        $aDetails = $this->database()->select('*')
            ->from(Phpfox::getT('dating_greetings'))
			->where('is_active = 0 AND is_delete = 0')
            ->execute('getSlaveRows');
			

        return $aDetails;
    }
	
	public function getGreetingTier($aTier)
    {
		
        $aDetails = $this->database()->select('*')
            ->from(Phpfox::getT('dating_greetings'))
			->where('is_active = 0 AND is_delete = 0 AND tier = "'.$aTier.'"')
            ->execute('getSlaveRows');
			

        return $aDetails;
    }
	
	
	public function getForGreetingEdit($iGenreId)
    {
        $aGenre = $this->database()->select('*')
            ->from(Phpfox::getT('dating_greetings'))
            ->where('greeting_id =' . (int) $iGenreId)
            ->execute('getSlaveRow');

        return $aGenre;
    }
	
	public function addGreetingDetails($aVals){
		
		$iCategoryId = $this->database()->insert(Phpfox::getT('dating_greetings'), [
            'title' => !empty($aVals["title"]) ? $aVals["title"] : "",
            'tier' => !empty($aVals["tier"]) ? $aVals["tier"] : "NULL",
            'emoji' => !empty($aVals["emoji"]) ? $aVals["emoji"] : "",
            
        ]);
		
        return $iCategoryId;
	}
	
	public function updateGreetingDetails($aVals){
		
		$this->database()->update(Phpfox::getT('dating_greetings'), [
           'title' => !empty($aVals["title"]) ? $aVals["title"] : "",
            'tier' => !empty($aVals["tier"]) ? $aVals["tier"] : "NULL",
            'emoji' => !empty($aVals["emoji"]) ? $aVals["emoji"] : "",
        ], 'greeting_id = '.$aVals['edit_id']
        );
		
        return true;
	}
	
	public function deleteSection($aId)
	{
		$this->database()->update(Phpfox::getT('dating_sections'), [
            'is_delete' => 1,
        ], 'section_id = '.$aId
        );
		return true;
	}
	
	public function getForSectionEdit($iGenreId)
    {
        $aGenre = $this->database()->select('*')
            ->from(Phpfox::getT('dating_sections'))
            ->where('section_id =' . (int) $iGenreId)
            ->execute('getSlaveRow');

        return $aGenre;
    }
	
	public function getSections()
	{
		$aRows = $this->database()->select('*')
			->from(Phpfox::getT('dating_sections'))
			->where('is_active = 1 AND is_delete = 0')
			->order('section_id ASC')
			->execute('getSlaveRows');

		$aSections = [];

		foreach ($aRows as $row) {
			if ((int)$row['parent_id'] === 0) {
				// Main category
				$aSections[$row['section_id']] = [
					'section_id'       => $row['section_id'],
					'section_name'     => $row['section_name'],
					'background_color' => $row['background_color'],
					'color'            => $row['color'],
					'description'      => $row['description'],
					'sub_sections'     => []
				];
			}
		}

		// Attach subcategories
		foreach ($aRows as $row) {
			if ((int)$row['parent_id'] > 0 && isset($aSections[$row['parent_id']])) {
				$aSections[$row['parent_id']]['sub_sections'][] = [
					'section_id'       => $row['section_id'],
					'section_name'     => $row['section_name'],
					'background_color' => $row['background_color'],
					'color'            => $row['color'],
					'description'      => $row['description']
				];
			}
		}

		return array_values($aSections); // clean index
	}


    /*public function getForEdit($iGenreId)
    {
        $aGenre = $this->database()->select('*')
            ->from($this->_sTable)
            ->where('field_id=' . (int) $iGenreId)
            ->execute('getSlaveRow');

        return $aGenre;
    }*/
	public function getWizardData()
	{
		// 1️⃣ Get PRIMARY sections (wizard steps)
		$aParents = $this->database()->select('*')
			->from(Phpfox::getT('dating_sections'))
			->where('is_active = 1 AND is_delete = 0 AND parent_id = 0')
			->order('section_id ASC')
			->execute('getSlaveRows');
		
		foreach ($aParents as &$parent) {
			// 2️⃣ Get SUB-SECTIONS under each parent
			$parent['sub_sections'] = $this->database()->select('*')
				->from(Phpfox::getT('dating_sections'))
				->where('parent_id = ' . (int)$parent['section_id'].' AND is_delete = 0')
				->order('section_id ASC')
				->execute('getSlaveRows');
			
			// 3️⃣ Check if parent has sub-sections
			if (empty($parent['sub_sections'])) {
				// ⭐ NO SUB-SECTIONS: Get fields directly from parent section
				$parent['sub_sections'] = [
					[
						'section_id' => $parent['section_id'],
						'section_name' => $parent['section_name'],
						'fields' => $this->database()->select('*')
							->from(Phpfox::getT('dating_fields'))
							->where('section_id = ' . (int)$parent['section_id'])
							->order('ordering ASC')
							->execute('getSlaveRows')
					]
				];
				
				// Decode JSON options for parent section fields
				foreach ($parent['sub_sections'][0]['fields'] as &$field) {
					if (!empty($field['options']) && in_array($field['type'], ['radio', 'multiple'])) {
						$decodedOptions = json_decode($field['options'], true);
						$field['options'] = is_array($decodedOptions) ? $decodedOptions : [];
					}
				}
			} else {
				// ⭐ HAS SUB-SECTIONS: Process fields under each sub-section
				foreach ($parent['sub_sections'] as &$sub) {
					// Get FIELDS for each sub-section
					$sub['fields'] = $this->database()->select('*')
						->from(Phpfox::getT('dating_fields'))
						->where('section_id = ' . (int)$sub['section_id'])
						->order('ordering ASC')
						->execute('getSlaveRows');
					
					// Decode JSON OPTIONS for radio and multiple choice fields
					foreach ($sub['fields'] as &$field) {
						if (!empty($field['options']) && in_array($field['type'], ['radio', 'multiple'])) {
							$decodedOptions = json_decode($field['options'], true);
							$field['options'] = is_array($decodedOptions) ? $decodedOptions : [];
						}
					}
				}
			}
		}
		
		return $aParents;
	}

	public function getForEdit($iFieldId)
	{
		$aField = $this->database()->select('*')
			->from(Phpfox::getT('dating_fields'))
			->where('field_id = ' . (int)$iFieldId)
			->execute('getSlaveRow');

		// Defaults
		$aField['category_id'] = '';
		$aField['sub_section_id'] = '';

		if (!empty($aField['section_id'])) {
			$aSection = $this->database()->select('section_id, parent_id')
				->from(Phpfox::getT('dating_sections'))
				->where('section_id = ' . (int)$aField['section_id'])
				->execute('getSlaveRow');

			if (!empty($aSection)) {
				if ((int)$aSection['parent_id'] > 0) {
					// This is a sub category
					$aField['category_id'] = $aSection['parent_id'];
					$aField['sub_section_id'] = $aSection['section_id'];
				} else {
					// This is a main category
					$aField['category_id'] = $aSection['section_id'];
				}
			}
		}

		return $aField;
	}

	
	public function getForManageHierarchical()
	{
		// Get all sections (both parent and child)
		$aSections = $this->database()->select('s.*')
			->from(Phpfox::getT('dating_sections'), 's')
			->where('s.is_delete = 0')
			->order('s.parent_id ASC')
			->execute('getSlaveRows');
		
		// Get all fields with section information
		$aFields = $this->database()->select('f.*, s.section_name, s.section_id, s.parent_id')
			->from(Phpfox::getT('dating_fields'), 'f')
			->leftJoin(Phpfox::getT('dating_sections'), 's', 's.section_id = f.section_id')
			->order('f.section_id ASC, f.ordering ASC')
			->execute('getSlaveRows');
		
		// Build hierarchical structure
		$aHierarchy = array();
		$aParentSections = array();
		$aChildSections = array();
		
		// Separate parent and child sections
		foreach ($aSections as $aSection) {
			if ($aSection['parent_id'] == 0) {
				// This is a parent section
				$aParentSections[$aSection['section_id']] = $aSection;
			} else {
				// This is a child section
				$aChildSections[$aSection['section_id']] = $aSection;
			}
		}
		
		// Build the hierarchy
		foreach ($aParentSections as $iParentId => $aParentSection) {
			$aHierarchy[$iParentId] = array(
				'parent' => $aParentSection,
				'children' => array(),
				'fields' => array()
			);
			
			// Find children for this parent
			foreach ($aChildSections as $iChildId => $aChildSection) {
				if ($aChildSection['parent_id'] == $iParentId) {
					$aHierarchy[$iParentId]['children'][$iChildId] = array(
						'section' => $aChildSection,
						'fields' => array()
					);
				}
			}
		}
		
		// Assign fields to sections
		foreach ($aFields as $aField) {
			$iSectionId = $aField['section_id'];
			$iParentId = $this->getSectionParentId($iSectionId, $aChildSections);
			
			if ($iParentId == 0) {
				// Field belongs directly to parent section
				if (isset($aHierarchy[$iSectionId])) {
					$aHierarchy[$iSectionId]['fields'][] = $aField;
				}
			} else {
				// Field belongs to child section
				if (isset($aHierarchy[$iParentId]['children'][$iSectionId])) {
					$aHierarchy[$iParentId]['children'][$iSectionId]['fields'][] = $aField;
				}
			}
		}
		
		return $aHierarchy;
	}

	/**
	 * Helper method to get parent ID of a section
	 */
	private function getSectionParentId($iSectionId, $aChildSections)
	{
		if (isset($aChildSections[$iSectionId])) {
			return $aChildSections[$iSectionId]['parent_id'];
		}
		return 0;
	}


    public function getForManage()
    {
        $aGenres = $this->database()->select('mc.*')
            ->from($this->_sTable, 'mc')
            ->order('mc.ordering ASC')
            ->execute('getSlaveRows');

        return $aGenres;
    }

    public function getForSearch()
    {
        $aGenres = $this->database()->select('mc.*')
            ->from($this->_sTable, 'mc')
            ->where("mc.is_search = 1")
            ->order('mc.ordering ASC')
            ->execute('getSlaveRows');

        return $aGenres;
    }

    public function delete($iId)
    {
        $this->database()->delete($this->_sTable, 'field_id = ' . (int) $iId);

        $this->database()->query("ALTER TABLE `".Phpfox::getT('dating_values')."`
             DROP COLUMN  `field_{$iId}`");

        return true;
    }


    public function add($aVals)
    {
		if(isset($aVals['sub_section_id']) AND !empty($aVals['sub_section_id'])){
			$aVals['category_id'] = $aVals['sub_section_id'];
		}
        $iCategoryId = $this->database()->insert($this->_sTable, [
            'title' => !empty($aVals["title"]) ? $aVals["title"] : "",
            'type' => !empty($aVals["type"]) ? $aVals["type"] : "",
            'is_search' => (!empty($aVals['is_search']) ? 1 : 0),
            'is_required' => (!empty($aVals['is_required']) ? 1 : 0),
            'section_id' => (!empty($aVals['category_id']) ? $aVals['category_id'] : 0),
			'options' => !empty($aVals['options']) ? $aVals['options'] : '',

        ]);

        $this->database()->query("ALTER TABLE `".Phpfox::getT('dating_values')."`
            ADD `field_{$iCategoryId}` TEXT NULL;");


        return $iCategoryId;
    }

    /**
     * @param array  $aVals
     * @param string $sName
     *
     * @return bool
     */
    public function update($aVals)
    {
		if(isset($aVals['sub_section_id']) AND !empty($aVals['sub_section_id'])){
			$aVals['category_id'] = $aVals['sub_section_id'];
		}
		
        $this->database()->update($this->_sTable, [
            'title' => !empty($aVals["title"]) ? $aVals["title"] : "",
            'type' => !empty($aVals["type"]) ? $aVals["type"] : "",
            'is_search' => (!empty($aVals['is_search']) ? 1 : 0),
            'is_required' => (!empty($aVals['is_required']) ? 1 : 0),
			'section_id' => (!empty($aVals['category_id']) ? $aVals['category_id'] : 0),
			'options' => !empty($aVals['options']) ? $aVals['options'] : '',
        ], 'field_id = ' . $aVals['edit_id']
        );

        return true;
    }
	public function getOptionsArray($jsonOptions)
	{
		if (empty($jsonOptions)) {
			return [];
		}
		
		$options = json_decode($jsonOptions, true);
		return is_array($options) ? $options : [];
	}

}