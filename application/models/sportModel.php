<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SportModel extends CI_Model {

    // Konstruktor
    public function __construct()
    {
        parent::__construct();
        // Memuat database
        $this->load->database();
    }

    /**
     * Mengambil daftar venue berdasarkan nama olahraga.
     * Logika ini digunakan oleh fungsi view_sport_category() di Controller.
     * @param string $sport_name (e.g., 'futsal', 'badminton')
     * @return array
     */
    public function get_venues_by_sport($sport_name)
    {
        // Bersihkan nama olahraga (misalnya, ubah "sepak-bola" menjadi "Sepak Bola")
        $clean_sport_name = ucfirst(str_replace('-', ' ', $sport_name));
        
        // --- LOGIKA QUERY DATABASE ---
        $this->db->select('
            v.venue_name, 
            v.address, 
            v.rating,
            COUNT(c.id_court) as court_count,
            v.latitude, 
            v.longitude,
            "placeholder.jpg" as image_url, 
            0 as distance,
            0 as review_count
        ');
        $this->db->from('venues v');
        $this->db->join('courts c', 'c.id_venue = v.id_venue', 'inner');
        $this->db->join('sports s', 's.id_sport = c.id_sport', 'inner');
        $this->db->where('s.name', $clean_sport_name);
        $this->db->group_by('v.id_venue');
        $query = $this->db->get();

        // NOTE: Dalam implementasi final, Anda perlu menambahkan logika 
        //       untuk menghitung Jarak (Haversine) dan jumlah review yang sesungguhnya.

        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan data sebagai array objek
        } else {
            return []; // Mengembalikan array kosong jika tidak ada hasil
        }
    }
    
    /**
     * Mengambil daftar semua olahraga (untuk menu bar di homepage)
     * @return array
     */
    public function get_all_sports()
    {
        $query = $this->db->get('sports');
        return $query->result();
    }

}