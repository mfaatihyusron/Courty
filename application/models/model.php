<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model {

    
    // FUNGSI BARU: Mengupdate data Venue
    public function update_venue($id_venue, $data)
    {
        $this->db->where('id_venue', $id_venue);
        return $this->db->update('venue', $data);
    }

    // FUNGSI BARU: Menambahkan data Court
    public function add_court($data)
    {
        return $this->db->insert('court', $data);
    }
    
    // FUNGSI BARU: Mengambil data sport (diperlukan untuk form tambah court)
    public function get_all_sports()
    {
        $query = $this->db->get('sport');
        return $query->result_array();
    }
    
    // FUNGSI BARU: Mengambil data venue berdasarkan ID User (Admin Venue)
    public function get_venue_by_user_id($user_id)
    {
        $this->db->where('id_user', $user_id);
        // Ambil semua kolom dari tabel 'venue'
        $query = $this->db->get('venue');
        // Gunakan row_array() karena satu user (admin venue) hanya punya satu venue
        return $query->row_array();
    }

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

    // FUNGSI BARU: Mendaftarkan Mitra/Partner (Role 3: Admin Venue)
    public function register_partner($data)
    {
        $data_user = array(
            'name'      => $data['name'],
            'email'     => $data['email'],
            'telp'      => $data['telp'],
            'password'  => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'      => 3 // Role khusus untuk Admin Venue
        );
        
        // Masukkan data ke tabel 'users'
        $this->db->insert('users', $data_user);
        
        // Mengembalikan ID User yang baru dibuat untuk digunakan pada langkah selanjutnya (venue)
        return $this->db->insert_id();
    }
    
    // FUNGSI BARU: Menambahkan Data Venue
    public function add_venue($data)
    {
        return $this->db->insert('venue', $data);
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