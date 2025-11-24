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
        // Untuk query, kita gunakan huruf kecil semua untuk memastikan Case-Insensitivity
        $lower_sport_name = strtolower($sport_name); 
        
        // --- 1. LOGIKA QUERY DATABASE ---
        $this->db->select('
            v.venue_name, 
            v.address, 
            /* HAPUS: v.rating (Kolom ini tidak ada di tabel venue Anda!) */
            (SELECT SUM(id_court) FROM court WHERE id_venue = v.id_venue) as court_count, /* Dapatkan jumlah court */
            v.coordinate as coordinates, 
            v.link_profile_img, 
            /* Hitung rata-rata rating dari tabel review/booking, sekarang diset DUMMY 4.5 */
            4.5 as rating, 
            /* Hitung jumlah review/booking (Asumsi review = jumlah booking) */
            (SELECT COUNT(id) FROM booking WHERE id_user = v.id_user) as review_count, 
            0 as distance 
        ');
        $this->db->from('venue v'); 
        $this->db->join('court c', 'c.id_venue = v.id_venue', 'inner'); 
        $this->db->join('sport s', 's.id_sport = c.id_sport', 'inner'); 
        
        // KRITIS: Menggunakan LOWER() di SQL untuk memaksa kecocokan Case-Insensitive
        $this->db->where('LOWER(s.name)', $lower_sport_name); 
        
        // Penting: GROUP BY harus mencakup semua kolom non-agregasi
        $this->db->group_by('v.id_venue, v.venue_name, v.address, v.coordinate, v.link_profile_img'); 
        
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Data asli ditemukan di DB
            return $query->result(); 
        } else {
            // --- 2. FALLBACK: DATA DUMMY (Jika Query tetap gagal atau data kosong) ---
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