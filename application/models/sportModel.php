<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SportModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Mengambil daftar venue berdasarkan nama olahraga.
     */
    public function get_venues_by_sport($sport_name)
    {
        // 1. Bersihkan nama olahraga untuk query (case-insensitive)
        $lower_sport_name = strtolower($sport_name); 
        
        // --- 2. LOGIKA QUERY DATABASE (KOREKSI) ---
        $this->db->select('
            v.id_venue, 
            v.venue_name, 
            v.address, 
            
            /* FIX: Menghitung jumlah court yang dimiliki venue ini */
            COUNT(c.id_court) as court_count,
            
            /* Kolom koordinat yang sudah ada di DB */
            v.coordinate, 
            v.link_profile_img, 
            
            /* DUMMY/Subquery: Kolom Rating & Review */
            4.5 as rating, 
            (SELECT COUNT(id) FROM booking WHERE id_user = v.id_user) as review_count, 
            0 as distance 
        ');
        $this->db->from('venue v'); 
        $this->db->join('court c', 'c.id_venue = v.id_venue', 'inner'); 
        $this->db->join('sport s', 's.id_sport = c.id_sport', 'inner'); 
        
        // KRITIS: Menggunakan LOWER() untuk Case-Insensitive Matching dengan data sport
        $this->db->where('LOWER(s.name)', $lower_sport_name); 
        
        // Penting: GROUP BY harus mencakup semua kolom non-agregasi
        $this->db->group_by('v.id_venue, v.venue_name, v.address, v.coordinate, v.link_profile_img'); 
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Data asli ditemukan di DB (INI SEKARANG HARUS BERHASIL)
            return $query->result(); 
        } else {
            // --- FALLBACK: DATA DUMMY (Hanya berjalan jika tidak ada JOIN yang cocok) ---
            $clean_name_display = ucfirst(str_replace('-', ' ', $sport_name));
            $dummy_data = [
                (object)[
                    'venue_name' => "GOR " . $clean_name_display . " Terdekat (DUMMY)", 
                    'address' => 'Jl. MVC No. 1', 
                    'rating' => 4.5, 
                    'court_count' => 3, 
                    'distance' => 1.2,
                    'review_count' => 120,
                    'link_profile_img' => 'https://placehold.co/400x250/926699/FFFFFF?text=DUMMY+COURTY+1'
                ],
            ];
            return $dummy_data; 
        }
    }
    
    // Fungsi lain yang mungkin dibutuhkan...
    public function get_all_sports()
    {
        $query = $this->db->get('sport');
        return $query->result();
    }

}