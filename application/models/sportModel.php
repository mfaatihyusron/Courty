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
        $clean_name_display = ucfirst(str_replace('-', ' ', $sport_name)); // Untuk fallback
        
        // --- 2. LOGIKA QUERY DATABASE (KOREKSI FINAL DAN MINIMALIS) ---
        // PENTING: Semua komentar SQL sudah dihapus dari dalam string SELECT
        $this->db->select("
            v.id_venue, 
            v.venue_name, 
            v.address, 
            v.coordinate, 
            v.link_profile_img, 
            
            COUNT(c.id_court) as court_count,
            
            /* Kolom DUMMY untuk VIEW (rating, review, distance) */
            4.5 as rating, 
            150 as review_count, 
            0 as distance 
        ");
        $this->db->from('venue v'); 
        $this->db->join('court c', 'c.id_venue = v.id_venue', 'inner'); 
        $this->db->join('sport s', 's.id_sport = c.id_sport', 'inner'); 
        
        // KRITIS: Menggunakan LOWER() untuk Case-Insensitive Matching
        $this->db->where('LOWER(s.name)', $lower_sport_name); 
        
        // Penting: GROUP BY harus mencakup semua kolom non-agregasi
        $this->db->group_by('v.id_venue, v.venue_name, v.address, v.coordinate, v.link_profile_img'); 
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Data asli ditemukan di DB
            return $query->result(); 
        } else {
            // --- FALLBACK: DATA DUMMY ---
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
                (object)[
                    'venue_name' => "Hall Premium " . $clean_name_display . " (DUMMY)", 
                    'address' => 'Jl. Database Kosong No. 2', 
                    'rating' => 5.0, 
                    'court_count' => 5, 
                    'distance' => 3.5,
                    'review_count' => 250,
                    'link_profile_img' => 'https://placehold.co/400x250/347048/FFFFFF?text=DUMMY+COURTY+2'
                ],
            ];
            return $dummy_data; 
        }
    }
    
    public function get_all_sports()
    {
        $query = $this->db->get('sport');
        return $query->result();
    }
}