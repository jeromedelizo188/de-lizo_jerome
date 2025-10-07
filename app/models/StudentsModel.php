<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentsModel extends Model {
    protected $table = 'students';
    protected $primary_key = 'student_id';

    public function __construct()
    {
        parent::__construct();
    }

    /* ===============================
       EXISTING CRUD (unchanged)
    =============================== */
    public function get_paginated($q = '', $records_per_page = null, $page = null) {
        if (is_null($page)) {
            // Use select_count to get total rows (compatible with your DB wrapper)
            $total_rows = $this->db->table($this->table)
                                   ->select_count('*', 'count')
                                   ->get()['count'];

            return [
                'records'    => $this->db->table($this->table)->get_all(),
                'total_rows' => $total_rows
            ];
        } else {
            $query = $this->db->table($this->table);

            if (!empty($q)) {
                $like = "%{$q}%";

                $query->like('student_id', $like)
                      ->or_like('last_name', $like)
                      ->or_like('first_name', $like)
                      ->or_like('email', $like);
            }

            $countQuery = clone $query;
            $data['total_rows'] = $countQuery->select_count('*', 'count')->get()['count'];

            $data['records'] = $query->pagination($records_per_page, $page)->get_all();

            return $data;
        }
    }

    /* ===============================
       AUTHENTICATION EXTENSION
    =============================== */

    // Insert new user (for signup)
    public function insert_user($data) {
        return $this->db->table($this->table)->insert($data);
    }

    // Find user by email (for login). Returns single row or false/null depending on DB wrapper.
    public function find_by_email($email) {
        return $this->db->table($this->table)
                        ->where('email', $email)
                        ->get();
    }

    // Check if email already exists (safe counting)
    public function email_exists($email) {
        $count = $this->db->table($this->table)
                          ->where('email', $email)
                          ->select_count('*', 'count')
                          ->get()['count'];

        return (int)$count > 0;
    }
}
?>
