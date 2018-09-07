<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Logs Controller
 *
 * This controller displays the list of current logs in the
 * application/logs folder 
 *  
 */
class Logs extends Admin_Controller
{
    /**
     * @var Array The options from the /config/logs.php file
     */
    private $options;

    //---------------------------------------------------------------

    private $logViewer;
    
    public function __construct()
    {
        parent::__construct();
        Template::set_theme('backend');

        $this->load->helper('file');

    }
    
    /**
     * Display a list of logs
     *
     * Includes the options to delete
     * 
     *
     * @return void
     */
    public function index()
    {
        
		$data = array('page_title'=>'Logs',
        'page_subtitle'=>'',
        'page_breadcrumb'=>'Logs');

        $this->load->library('Cilogviewer');
        $data['content'] = $this->cilogviewer->showLogs();
        
        foreach( $data as $key => $value )
            Template::set($key, $value);
        Template::render();
    }   
}