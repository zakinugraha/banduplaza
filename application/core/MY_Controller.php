<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['user_account'])) {
            redirect ('administrator');
        }
        
    }   
}
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */