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
    }

    function test()
    {
        if ($this->db) {
            echo 'Connection was established';
        }
    }

    function get_all()
    {
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
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Passwords do not match.'];
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
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'User created successfully!'];
            redirect('view');
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to create user.'];
            redirect('create');
        }
    } else {
        $this->call->view('create');
    }
}

    

    function update($id)
{
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
                $_SESSION['flash'] = ['type' => 'error', 'message' => 'Passwords do not match.'];
                $this->call->view('update', ['user' => $user]);
                return;
            }
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // ✅ Update user
        if ($this->StudentsModel->update($id, $data)) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'User updated successfully!'];
            redirect('view');
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'message' => 'Failed to update user.'];
            $this->call->view('update', ['user' => $user]);
        }

    } else {
        $this->call->view('update', ['user' => $user]);
    }
}


    function delete($id)
    {
        if ($this->StudentsModel->delete($id)) {
            redirect('view');
        }
    }

}
?>
