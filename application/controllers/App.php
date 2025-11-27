<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class App
 * @property CI_Loader $load
 * @property Model $Model 
 * @property SportModel $SportModel // Dideklarasikan untuk diakses
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
class App extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Memuat Model yang diperlukan
        $this->load->model('Model'); 
        $this->load->model('SportModel'); 
        $this->load->helper(array('url'));
        $this->load->library(array('session'));
    }

	public function index()
	{
        // Ambil data venue unggulan dari Model (Mungkin bisa diganti dengan Trending)
        $featured_venues = $this->Model->get_featured_venues();
        
        $data['user_name'] = $this->session->userdata('name');
        $data['featured_venues'] = $featured_venues; 
		$data['content'] = "index"; 
		$this->load->view('template', $data);
	}
    
    public function venue()
	{
        // Menggunakan fungsi baru: get_trending_by_views()
        $trending_data = $this->Model->get_trending_by_views();

        $data['user_name'] = $this->session->userdata('name');
        
        // Kirim data trending ke View dengan nama variabel 'trending_venues'
        $data['trending_venues'] = $trending_data; 
        
		$data['content'] = "venue"; 
		$this->load->view('template', $data);
	}

    // FUNGSI KRITIS: UNTUK HALAMAN DETAIL VENUE
    public function detail_venue($id_venue)
    {
        // === LANGKAH KRITIS: DATA TRACKING ===
        // 1. Panggil fungsi Model untuk menambah jumlah dilihat (Increment View Count)
        // Ini adalah praktek yang baik untuk mengukur popularitas venue (Data Analysis!)
        $this->Model->increment_view_count($id_venue);
        
        // 2. Ambil detail venue untuk ditampilkan
        $venue_detail = $this->Model->get_venue_detail_by_id($id_venue);

        // Pengecekan jika venue tidak ditemukan
        if (!$venue_detail) {
            // Jika ID tidak valid atau data tidak ada, tampilkan 404
            show_404(); 
        }

        // 3. Ambil court yang tersedia
        $courts = $this->Model->get_courts_by_venue_id($id_venue);

        // 4. Ambil Galeri Foto
        $gallery_photos = $this->Model->get_venue_gallery($id_venue); 

        $data['user_name'] = $this->session->userdata('name');
        $data['venue'] = $venue_detail;
        $data['courts'] = $courts;
        $data['gallery_photos'] = $gallery_photos; 
        $data['title'] = $venue_detail['venue_name'];
        // Memuat View: venue_detail.php
        $data['content'] = "venue_detail"; 
        $this->load->view('template', $data);
    }

    public function about()
	{
	    $data['user_name'] = $this->session->userdata('name');
		$data['content'] = "about"; 
		$this->load->view('template', $data);
    }

    public function view_sport_category($sport_name = 'futsal')
    {
        // PANGGILAN MODEL YANG MENGGUNAKAN LOGIKA DARI SPORTMODEL.PHP DI ATAS
        $venue_data = $this->SportModel->get_venues_by_sport($sport_name); 
        
        $data['user_name'] = $this->session->userdata('name');
        $data['nama_olahraga'] = ucfirst(str_replace('-', ' ', $sport_name)); 
        $data['venue_list'] = $venue_data;
        $data['title'] = 'Reservasi Lapangan ' . $data['nama_olahraga'];
        
        $data['content'] = "sport_category"; 
        $this->load->view('template', $data);
    }
}