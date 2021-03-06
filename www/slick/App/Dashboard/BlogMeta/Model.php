<?php
class Slick_App_Dashboard_BlogMeta_Model extends Slick_Core_Model
{
	public function getFieldForm($fieldId = 0)
	{
		$form = new Slick_UI_Form;
		
		$label = new Slick_UI_Textbox('label');
		$label->addAttribute('required');
		$label->setLabel('Label');
		$form->add($label);
		
		$slug = new Slick_UI_Textbox('slug');
		$slug->addAttribute('required');
		$slug->setLabel('Slug (blank to auto generate)');
		$form->add($slug);
		
		$type = new Slick_UI_Select('type');
		$type->setLabel('Field Type');
		$type->addOption('textbox', 'Textbox');
		$type->addOption('textarea', 'Textarea');
		$type->addOption('select', 'Select Dropdown');
		$form->add($type);
		
		$options = new Slick_UI_Textarea('options');
		$options->setLabel('Options (if dropdown) - 1 per line');
		$form->add($options);
		
		$active = new Slick_UI_Checkbox('active', 'active');
		$active->setLabel('Active?');
		$active->setBool(1);
		$active->setValue(1);
		$form->add($active);
		
		$public = new Slick_UI_Checkbox('isPublic', 'isPublic');
		$public->setLabel('Publicly Accessable? (e.g via API)');
		$public->setBool(1);
		$public->setValue(1);
		$form->add($public);	
		
		$hidden = new Slick_UI_Checkbox('hidden', 'hidden');
		$hidden->setLabel('Hidden?');
		$hidden->setBool(1);
		$hidden->setValue(1);
		$form->add($hidden);			

		$rank = new Slick_UI_Textbox('rank');
		$rank->setLabel('Order Rank');
		$form->add($rank);
		
		
		return $form;
	}
	


	public function addField($data)
	{
		$req = array('label' => true, 'slug' => true, 'type' => true, 'options' => false, 'active' => false, 'siteId' => true, 'rank' => false, 'isPublic' => false, 'hidden' => false);
		$useData = array();
		foreach($req as $key => $required){
			if(!isset($data[$key])){
				if($required){
					throw new Exception(ucfirst($key).' required');
				}
				else{
					$useData[$key] = '';
				}
			}
			else{
				$useData[$key] = $data[$key];
			}
		}
		
		if(trim($useData['slug']) == ''){
			$useData['slug'] = genURL($useData['label']);
		}
		
		if(trim($useData['isPublic']) == ''){
			$useData['isPublic'] = 0;
		}
		else{
			$useData['isPublic'] = intval($useData['isPublic']);
		}
		
		if(trim($useData['hidden']) == ''){
			$useData['hidden'] = 0;
		}
		else{
			$useData['hidden'] = intval($useData['hidden']);
		}
				
		
		$add = $this->insert('blog_postMetaTypes', $useData);
		if(!$add){
			throw new Exception('Error adding field');
		}
		
		return $add;
	}
		
	public function editField($id, $data)
	{
		$req = array('label' => true, 'type' => true, 'options' => false, 'slug' => true, 'active' => false, 'siteId' => true, 'rank' => false, 'isPublic' => false, 'hidden' => false);
		$useData = array();
		foreach($req as $key => $required){
			if(!isset($data[$key])){
				if($required){
					throw new Exception(ucfirst($key).' required');
				}
				else{
					$useData[$key] = '';
				}
			}
			else{
				$useData[$key] = $data[$key];
			}
		}

		if(trim($useData['slug']) == ''){
			$useData['slug'] = genURL($useData['label']);
		}
		
		if(trim($useData['isPublic']) == ''){
			$useData['isPublic'] = 0;
		}
		else{
			$useData['isPublic'] = intval($useData['isPublic']);
		}		
		
		if(trim($useData['hidden']) == ''){
			$useData['hidden'] = 0;
		}
		else{
			$useData['hidden'] = intval($useData['hidden']);
		}
					
		
		$edit = $this->edit('blog_postMetaTypes', $id, $useData);
		if(!$edit){
			throw new Exception('Error editing field');
		}

		return true;	
	}

}
?>
