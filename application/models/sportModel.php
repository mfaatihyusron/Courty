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
        $clean_sport_name = ucfirst(str_replace('-', ' ', $sport_name));
        
        // --- 1. LOGIKA QUERY DATABASE ---
        $this->db->select('
            v.venue_name, 
            v.address, 
            v.rating,
            COUNT(c.id_court) as court_count,
            v.coordinate as coordinates, 
            v.link_profile_img, 
            v.rating,
            (SELECT COUNT(id) FROM booking WHERE id_user = v.id_user) as review_count, /* Asumsi review = jumlah booking */
            0 as distance 
        ');
        $this->db->from('venue v'); 
        $this->db->join('court c', 'c.id_venue = v.id_venue', 'inner'); 
        $this->db->join('sport s', 's.id_sport = c.id_sport', 'inner'); 
        $this->db->where('s.name', $clean_sport_name);
        // Penting: GROUP BY harus mencakup semua kolom non-agregasi
        $this->db->group_by('v.id_venue, v.venue_name, v.address, v.rating, v.coordinate, v.link_profile_img'); 
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Data asli ditemukan di DB
            return $query->result(); 
        } else {
            // --- 2. FALLBACK: DATA DUMMY UNTUK TESTING UI (Sesuai permintaan Anda) ---
            $dummy_data = [
                (object)[
                    'venue_name' => "GOR " . $clean_sport_name . " Terdekat (DUMMY)", 
                    'address' => 'Jl. MVC No. 1', 
                    'rating' => 4.5, 
                    'court_count' => 3, 
                    'distance' => 1.2,
                    'review_count' => 120,
                    'link_profile_img' => 'https://placehold.co/400x250/926699/FFFFFF?text=DUMMY+COURTY+1'
                ],
                (object)[
                    'venue_name' => "Hall Premium " . $clean_sport_name . " (DUMMY)", 
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
    
    // Fungsi lain yang mungkin dibutuhkan...
    public function get_all_sports()
    {
        $query = $this->db->get('sport');
        return $query->result();
    }

}