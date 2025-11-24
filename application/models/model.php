<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model {

    // FUNGSI BARU: Mengambil semua Court berdasarkan ID Venue
    public function get_courts_by_venue_id($id_venue)
    {
        // Join dengan tabel sport agar nama olahraga bisa ditampilkan
        $this->db->select('c.*, s.name as sport_name');
        $this->db->from('court c');
        $this->db->join('sport s', 's.id_sport = c.id_sport', 'left');
        $this->db->where('c.id_venue', $id_venue);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // FUNGSI BARU: Mengambil detail Court berdasarkan ID Court
    public function get_court_by_id($id_court)
    {
        // Join dengan tabel sport agar nama olahraga bisa ditampilkan
        $this->db->select('c.*, s.name as sport_name');
        $this->db->from('court c');
        $this->db->join('sport s', 's.id_sport = c.id_sport', 'left');
        $this->db->where('c.id_court', $id_court);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    // FUNGSI BARU: Mengupdate data Court
    public function update_court($id_court, $data)
    {
        $this->db->where('id_court', $id_court);
        return $this->db->update('court', $data);
    }

    // FUNGSI BARU: Mengambil semua data Sport
    public function get_all_sports()
    {
        $query = $this->db->get('sport');
        return $query->result_array();
    }
    
    // FUNGSI BARU: Menambahkan data Sport
    public function add_sport($data)
    {
        return $this->db->insert('sport', $data);
    }
    
    // FUNGSI BARU: Menghapus data Sport
    public function delete_sport($id_sport)
    {
        $this->db->where('id_sport', $id_sport);
        return $this->db->delete('sport');
    }
    
    // FUNGSI BARU: Mengambil data Sport berdasarkan ID
    public function get_sport_by_id($id_sport)
    {
        $this->db->where('id_sport', $id_sport);
        return $this->db->get('sport')->row_array();
    }
    
    // FUNGSI BARU: Mengupdate data Sport
    public function update_sport($id_sport, $data)
    {
        $this->db->where('id_sport', $id_sport);
        return $this->db->update('sport', $data);
    }

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