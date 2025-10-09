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
    $this->call->library('session'); 
    $this->call->library('form_validation');
}


    function test()
    {
        if ($this->db) {
            echo 'Connection was established';
        }
    }

    function get_all()
    {
        
        $user = $this->session->userdata('user');
        if (!$user || $user['user_type'] !== 'admin') {
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

        $user = $this->session->userdata('user');
        if (!$user || $user['user_type'] !== 'admin') {
            redirect('login');
            return;
        }

        if ($this->form_validation->submitted()) {

            $last_name  = $this->io->post('lastname');
            $first_name = $this->io->post('firstname');
            $email      = $this->io->post('email');
            $password   = $this->io->post('password');
            $confirm    = $this->io->post('confirm_password');
            $role       = $this->io->post('role') ?? 'user';

            if ($password !== $confirm) {
                $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'Passwords do not match.']);
                redirect('create');
                return;
            }

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $data = [
                
                'last_name'  => $last_name,
                'first_name' => $first_name,
                'email'      => $email,
                'password'   => $hashed_password,
                'user_type'  => $role
            ];

            if ($this->StudentsModel->insert($data)) {
                $this->session->set_flashdata('flash', ['type' => 'success', 'message' => 'User created successfully!']);
                redirect('view');
            } else {
                $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'Failed to create user.']);
                redirect('create');
            }
        } else {
            $this->call->view('create');
        }
    }

    function update($id)
    {
        
        $user = $this->session->userdata('user');
        if (!$user || $user['user_type'] !== 'admin') {
            redirect('login');
            return;
        }

        $student = $this->StudentsModel->find($id);

        if (!$student) {
            echo "Student not found.";
            return;
        }

        if ($this->io->method() == 'post') {
            $last_name  = $this->io->post('lastname');
            $first_name = $this->io->post('firstname');
            $email      = $this->io->post('email');
            $role       = $this->io->post('role');
            $password   = $this->io->post('password');
            $confirm    = $this->io->post('confirm_password');

            $data = [
                'last_name'  => $last_name,
                'first_name' => $first_name,
                'email'      => $email,
                'user_type'  => $role
            ];

            if (!empty($password)) {
                if ($password !== $confirm) {
                    $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'Passwords do not match.']);
                    $this->call->view('update', ['user' => $student]);
                    return;
                }
                $data['password'] = password_hash($password, PASSWORD_BCRYPT);
            }

            if ($this->StudentsModel->update($id, $data)) {
                $this->session->set_flashdata('flash', ['type' => 'success', 'message' => 'User updated successfully!']);
                redirect('view');
            } else {
                $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'Failed to update user.']);
                $this->call->view('update', ['user' => $student]);
            }
        } else {
            $this->call->view('update', ['user' => $student]);
        }

    }


    function delete($id)
    {

        $user = $this->session->userdata('user');
        if (!$user || $user['user_type'] !== 'admin') {
            redirect('login');
            return;
        }

        if ($this->StudentsModel->delete($id)) {
            redirect('view');
        }
    }

}
?>
