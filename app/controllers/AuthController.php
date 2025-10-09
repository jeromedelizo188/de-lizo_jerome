<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller {

    public function __construct()
    {
        parent::__construct();
        $this->call->model('StudentsModel');
        $this->call->library('session');
    }

    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $first_name = trim($this->io->post('first-name'));
            $last_name  = trim($this->io->post('last-name'));
            $email      = trim($this->io->post('email'));
            $password   = trim($this->io->post('password'));
            $user_type  = $this->io->post('user-type') ?? 'user';

            if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
                $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'All fields are required.']);
                redirect('signup');
                return;
            }

            if ($this->StudentsModel->email_exists($email)) {
                $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'Email is already registered.']);
                redirect('signup');
                return;
            }

            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $data = [
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'email'      => $email,
                'password'   => $hashed_password,
                'user_type'  => $user_type
            ];

            if ($this->StudentsModel->insert_user($data)) {
                $this->session->set_flashdata('flash', ['type' => 'success', 'message' => 'Account created successfully! Please log in.']);
                redirect('login');
            } else {
                $this->session->set_flashdata('flash', ['type' => 'error', 'message' => 'Registration failed, please try again.']);
                redirect('signup');
            }

        } else {
            $this->call->view('signup-page');
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($this->io->post('email'));
            $password = trim($this->io->post('password'));

            if (empty($email) || empty($password)) {
                $this->call->view('login-page', ['error' => 'Please fill in both fields.', 'old_email' => $email]);
                return;
            }

            $user = $this->StudentsModel->find_by_email($email);

            if (!$user) {
                $this->call->view('login-page', ['error' => 'No account found.', 'old_email' => $email]);
                return;
            }

            if (!password_verify($password, $user['password'])) {
                $this->call->view('login-page', ['error' => 'Incorrect password.', 'old_email' => $email]);
                return;
            }
            
            $this->session->set_userdata('user', $user);

            if ($user['user_type'] === 'admin') {
                redirect('view');
            } else {
                redirect('user/dashboard');
            }

        } else {
            $this->call->view('login-page');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('landing-page');
    }
}
