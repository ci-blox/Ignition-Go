<?php

class Admin_Controller extends Base_Controller
{
    protected $require_authentication = true;

    //--------------------------------------------------------------------------

    /**
     * Class constructor setup login restriction and load various libraries.
     *
     * @return void
     */
    public function __construct()
    {
        $this->autoload['helpers'][] = 'form';
        $this->autoload['libraries'][] = 'Template';

        parent::__construct();

        $this->load->library('form_validation');
        //$this->form_validation->CI =& $this;
        $this->form_validation->set_error_delimiters('', '');

        Template::set_theme('backend');
    }
}
