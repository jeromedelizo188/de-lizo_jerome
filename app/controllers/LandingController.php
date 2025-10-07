<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class LandingController extends Controller 
{
    public function __construct()
    {
        parent::__construct();
    }

    public function landing()
    {
        $this->call->view('landing-page'); 
    }
}
?>
