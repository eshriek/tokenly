<?php
class Slick_App_Dashboard_Files_Controller extends Slick_App_ModControl
{
    public $data = array();
    public $args = array();
    
    function __construct()
    {
        parent::__construct();
        
        $this->model = new Slick_App_Dashboard_Files_Model;
        
        
    }
    
    public function init()
    {

		$output = parent::init();
        $output['view'] = 'index';
        $output['template'] = 'admin';
        $themeUrl = $this->data['site']['url'].'/themes/'.$this->data['themeData']['location'];
        
        if(!isset($output['scripts'])){
			$output['scripts'] = '';
		}
        $output['scripts'] .= '<link rel="stylesheet" type="text/css" media="screen" href="'.$themeUrl.'/css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="'.$themeUrl.'/css/theme.css">
        <script type="text/javascript" src="'.$themeUrl.'/js/elfinder.min.js"></script>';

        return $output;
    }


}

?>
