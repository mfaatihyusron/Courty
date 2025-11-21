<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model {

    // Fungsi untuk mengambil semua data user dari tabel 'users'
    public function get_all_users()
    {
        // Pengecualian: jangan tampilkan kolom password
        $this->db->select('id_user, name, role, email, telp'); 
        $query = $this->db->get('users');
        return $query->result_array();
    }

    // Fungsi untuk mendaftarkan user baru
    public function register_user($data)
    {
        // Data yang dimasukkan ke database
        // 'role' diset default 0 seperti permintaan
        $data_user = array(
            'name'      => $data['name'],
            'email'     => $data['email'],
            'telp'      => $data['telp'],
            'password'  => password_hash($data['password'], PASSWORD_DEFAULT), // Enkripsi password
            'role'      => 0 // Default role adalah 0 (Users)
        );
        
        // Masukkan data ke tabel 'users'
        return $this->db->insert('users', $data_user);
    }

    // Fungsi untuk mengecek email apakah sudah terdaftar
    public function check_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    // Fungsi untuk memverifikasi login user
    public function check_login($email, $password)
    {
        // Cari user berdasarkan email
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            $user = $query->row_array();
            
            // Verifikasi password yang dienkripsi
            if (password_verify($password, $user['password'])) {
                // Password cocok, kembalikan data user
                return $user;
            }
        }
        
        // Gagal login atau password salah
        return false;
    }
}