<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');

class StudentsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->model('StudentsModel');
        $this->call->library('pagination');
        // Ensure session is loaded if flash messages are used outside AuthController
        $this->call->library('session'); 
    }

    function test()
    {
        if ($this->db) {
            echo 'Connection was established';
        }
    }

    function get_all()
    {
        // Check if user is logged in and is admin before proceeding
        if (!$this->session->get_userdata('user') || $this->session->get_userdata('user')['user_type'] !== 'admin') {
            redirect('login');
            return;
        }

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $per_page = 5;

        $result = $this->StudentsModel->get_paginated($search, $per_page, $page);

        $data['users']       = $result['records'];
        $data['total_rows']  = $result['total_rows'];
        $data['per_page']    = $per_page;
        $data['page']        = $page;
        $data['search_term'] = $search;
        $data['total_pages'] = ceil($result['total_rows'] / $per_page);

        $this->call->view('view', $data);
    }

    function create()
{
    // Check if user is logged in and is admin before proceeding
    if (!$this->session->get_userdata('user') || $this->session->get_userdata('user')['user_type'] !== 'admin') {
        redirect('login');
        return;
    }

    if ($this->form_validation->submitted()) {
        $student_id = $this->io->post('student_id');
        $last_name  = $this->io->post('lastname');
        $first_name = $this->io->post('firstname');
        $email      = $this->io->post('email');
        $password   = $this->io->post('password');
        $confirm    = $this->io->post('confirm_password');
        $role       = $this->io->post('role') ?? 'user';

        // ✅ Basic validation
        if ($password !== $confirm) {
            // FIX: Using session library consistently
            $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'Passwords do not match.']);
            redirect('create');
            return;
        }

        // ✅ Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // ✅ Prepare data for DB
        $data = array(
            'student_id' => $student_id,
            'last_name'  => $last_name,
            'first_name' => $first_name,
            'email'      => $email,
            'password'   => $hashed_password,
            'user_type'  => $role
        );

        // ✅ Insert into DB
        if ($this->StudentsModel->insert($data)) {
            // FIX: Using session library consistently
            $this->session->set_flashdata('flash', ['type' => 'success', 'message' => 'User created successfully!']);
            redirect('view');
        } else {
            // FIX: Using session library consistently
            $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'Failed to create user.']);
            redirect('create');
        }
    } else {
        $this->call->view('create');
    }
}


    function update($id)
{
    // Check if user is logged in and is admin before proceeding
    if (!$this->session->get_userdata('user') || $this->session->get_userdata('user')['user_type'] !== 'admin') {
        redirect('login');
        return;
    }
    
    $user = $this->StudentsModel->find($id);

    if (!$user) {
        echo "Student not found.";
        return;
    }

    if ($this->io->method() == 'post') {
        $last_name  = $this->io->post('lastname');
        $first_name = $this->io->post('firstname');
        $email      = $this->io->post('email');
        $role       = $this->io->post('role');   // ✅ new

        $password   = $this->io->post('password');
        $confirm    = $this->io->post('confirm_password');

        // ✅ Build data array
        $data = array(
            'last_name'  => $last_name,
            'first_name' => $first_name,
            'email'      => $email,
            'user_type'  => $role   // ✅ save role
        );

        // ✅ Only update password if provided
        if (!empty($password)) {
            if ($password !== $confirm) {
                // FIX: Using session library consistently
                $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'Passwords do not match.']);
                $this->call->view('update', ['user' => $user]);
                return;
            }
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // ✅ Update user
        if ($this->StudentsModel->update($id, $data)) {
            // FIX: Using session library consistently
            $this->session->set_flashdata('flash', ['type' => 'success', 'message' => 'User updated successfully!']);
            redirect('view');
        } else {
            // FIX: Using session library consistently
            $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'Failed to update user.']);
            $this->call->view('update', ['user' => $user]);
        }

    } else {
        $this->call->view('update', ['user' => $user]);
    }
}


    function delete($id)
    {
        // Check if user is logged in and is admin before proceeding
        if (!$this->session->get_userdata('user') || $this->session->get_userdata('user')['user_type'] !== 'admin') {
            redirect('login');
            return;
        }
        
        if ($this->StudentsModel->delete($id)) {
            redirect('view');
        }
    }

}

