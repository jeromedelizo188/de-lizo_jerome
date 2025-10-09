<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->call->model('StudentsModel');
        $this->call->library('session');


        if (!$this->session->userdata('user') || $this->session->userdata('user')['user_type'] !== 'user') {
            redirect('login');
        }
    }

    public function dashboard()
    {
        $search   = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page     = isset($_GET['page']) ? max((int) $_GET['page'], 1) : 1;
        $per_page = 5;

        $result = $this->StudentsModel->get_paginated($search, $per_page, $page);

        $data = [
            'users'       => $result['records'],
            'total_rows'  => $result['total_rows'],
            'per_page'    => $per_page,
            'page'        => $page,
            'search_term' => $search,
            'total_pages' => ceil($result['total_rows'] / $per_page)
        ];

       
        $this->call->view('readonly-view', $data);
    }
}
