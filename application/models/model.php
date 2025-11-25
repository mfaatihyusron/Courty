<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model {

    // FUNGSI BARU UNTUK MENGAMBIL DATA TRENDING BERDASARKAN JUMLAH DILIHAT
    public function get_trending_by_views()
    {
        // Untuk menghindari error MySQL Strict Mode (ONLY_FULL_GROUP_BY), kita nonaktifkan strict mode untuk query ini
        $this->db->query('SET SESSION sql_mode = ""');

        $this->db->select('
            v.*, 
            COUNT(c.id_court) as court_count, 
            MIN(c.price_per_hour) as min_price,
            GROUP_CONCAT(DISTINCT s.name SEPARATOR ", ") as sports_offered
        ');
        $this->db->from('venue v');
        $this->db->join('court c', 'c.id_venue = v.id_venue', 'left');
        $this->db->join('sport s', 's.id_sport = c.id_sport', 'left');
        
        // KRITIS: Di CI3, jika menggunakan v.*, kita harus group by berdasarkan primary key (id_venue)
        // Jika server menggunakan ONLY_FULL_GROUP_BY, ini akan menyebabkan error.
        $this->db->group_by('v.id_venue');
        
        $this->db->having('court_count > 0'); 
        
        // KRITIS: Mengurutkan berdasarkan kolom 'view_count' yang baru (tertinggi ke terendah)
        // In English: ORDER BY view_count DESC
        $this->db->order_by('v.view_count', 'DESC'); 
        
        // Batasi hanya 6 hasil teratas
        $this->db->limit(6); 

        $query = $this->db->get();
        // Kembalikan strict mode ke default setelah query selesai (optional, tapi baik)
        // $this->db->query('SET SESSION sql_mode = "STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"');
        
        return $query->result_array();
    }
    
    // FUNGSI BARU UNTUK MENAMBAH JUMLAH DILIHAT
    public function increment_view_count($id_venue)
    {
        // Pastikan kolom 'view_count' sudah ditambahkan ke tabel 'venue' melalui SQL
        $this->db->where('id_venue', $id_venue);
        $this->db->set('view_count', 'view_count+1', FALSE); // FALSE agar 'view_count+1' dianggap ekspresi SQL
        return $this->db->update('venue');
    }

    // FUNGSI LAMA: Mengambil detail Venue berdasarkan ID Venue
    public function get_venue_detail_by_id($id_venue)
    {
        $this->db->where('id_venue', $id_venue);
        $query = $this->db->get('venue');
        return $query->row_array();
    }

    public function get_venue_gallery($id_venue)
    {
        // Query untuk mendapatkan foto-foto yang terkait dengan courts di venue ini
        $this->db->select('p.link as url');
        $this->db->from('photo p');
        $this->db->join('court c', 'c.id_court = p.id_court');
        $this->db->where('c.id_venue', $id_venue);
        $this->db->limit(9);
        
        $query = $this->db->get();
        
        // Data dummy (Placeholder) jika DB kosong, menghindari error di View
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [
                ['url' => 'https://placehold.co/400x300/B9CF32/FFFFFF?text=GALERI_1'],
                ['url' => 'https://placehold.co/400x300/926699/FFFFFF?text=GALERI_2'],
                ['url' => 'https://placehold.co/400x300/F87B1B/FFFFFF?text=GALERI_3'],
            ];
        }
    }

    // FUNGSI LAMA: Mengambil daftar Venue yang direkomendasikan dengan agregasi data Court
     public function get_featured_venues()
    {
        // Nonaktifkan Strict Mode sementara untuk query ini
        $this->db->query('SET SESSION sql_mode = ""'); 

        $this->db->select('
            v.*, 
            COUNT(c.id_court) as court_count, 
            MIN(c.price_per_hour) as min_price,
            GROUP_CONCAT(DISTINCT s.name SEPARATOR ", ") as sports_offered
        ');
        $this->db->from('venue v');
        $this->db->join('court c', 'c.id_venue = v.id_venue', 'left');
        $this->db->join('sport s', 's.id_sport = c.id_sport', 'left');
        $this->db->group_by('v.id_venue');
        // Filter: Hanya tampilkan venue yang sudah punya court
        $this->db->having('court_count > 0'); 
        // Order: Mengurutkan berdasarkan views (trending)
        $this->db->order_by('v.view_count', 'DESC'); 
        $this->db->limit(10); 
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // FUNGSI LAMA: Mengupdate data Court
    public function delete_court($id_court)
    {
        $this->db->where('id_court', $id_court);
        return $this->db->delete('court');
    }

    // FUNGSI LAMA: Mengambil semua Court berdasarkan ID Venue
    public function get_courts_by_venue_id($id_venue)
    {
        $this->db->select('c.*, s.name as sport_name');
        $this->db->from('court c');
        $this->db->join('sport s', 's.id_sport = c.id_sport', 'left');
        $this->db->where('c.id_venue', $id_venue);
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan semua court dalam bentuk array
    }
    
    // FUNGSI LAMA: Mengambil detail Court berdasarkan ID Court
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
    
    // FUNGSI LAMA: Mengupdate data Court
    public function update_court($id_court, $data)
    {
        $this->db->where('id_court', $id_court);
        return $this->db->update('court', $data);
    }

    // FUNGSI LAMA: Mengambil semua data Sport
    public function get_all_sports()
    {
        $query = $this->db->get('sport');
        return $query->result_array();
    }
    
    // FUNGSI LAMA: Menambahkan data Sport
    public function add_sport($data)
    {
        return $this->db->insert('sport', $data);
    }
    
    // FUNGSI LAMA: Menghapus data Sport
    public function delete_sport($id_sport)
    {
        $this->db->where('id_sport', $id_sport);
        return $this->db->delete('sport');
    }
    
    // FUNGSI LAMA: Mengambil data Sport berdasarkan ID
    public function get_sport_by_id($id_sport)
    {
        $this->db->where('id_sport', $id_sport);
        return $this->db->get('sport')->row_array();
    }
    
    // FUNGSI LAMA: Mengupdate data Sport
    public function update_sport($id_sport, $data)
    {
        $this->db->where('id_sport', $id_sport);
        return $this->db->update('sport', $data);
    }

    // FUNGSI LAMA: Mengupdate data Venue
    public function update_venue($id_venue, $data)
    {
        $this->db->where('id_venue', $id_venue);
        return $this->db->update('venue', $data);
    }

    // FUNGSI LAMA: Menambahkan data Court
    public function add_court($data)
    {
        return $this->db->insert('court', $data);
    }
    

    // FUNGSI LAMA: Mengambil data venue berdasarkan ID User (Admin Venue)
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

    // FUNGSI LAMA: Mendaftarkan Mitra/Partner (Role 3: Admin Venue)
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
    
    // FUNGSI LAMA: Menambahkan Data Venue
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
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if ($query->num_rows() == 1) {
            $user = $query->row_array();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return FALSE;
    }
}