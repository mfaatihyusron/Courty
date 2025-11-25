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
        // Hanya memuat model dan helper yang diperlukan untuk halaman publik
        $this->load->model('Model'); 
        $this->load->model('SportModel'); 
        $this->load->helper(array('url'));
        $this->load->library(array('session'));
    }

	public function index()
	{
        // Ambil data venue unggulan dari Model
        $featured_venues = $this->Model->get_featured_venues();
        
        $data['user_name'] = $this->session->userdata('name');
        $data['featured_venues'] = $featured_venues; // Kirim data venue ke view
		$data['content'] = "index"; 
		$this->load->view('template', $data);
	}
    
    public function venue()
	{
        $data['user_name'] = $this->session->userdata('name');
		$data['content'] = "venue"; 
		$this->load->view('template', $data);
	}

    public function about()
	{
        $data['user_name'] = $this->session->userdata('name');
		$data['content'] = "about"; 
		$this->load->view('template', $data);
	}

    public function view_sport_category($sport_name = 'futsal') // Beri nilai default
    {
        // 1. Ambil data venue berdasarkan nama olahraga (melalui Model)
        // PERBAIKAN 2: Panggil Model yang benar dan HAPUS SEMUA DUMMY DATA HARDCODED DI SINI
        $venue_data = $this->SportModel->get_venues_by_sport($sport_name); 
        
        // 2. Siapkan data untuk dikirim ke View
        $data['user_name'] = $this->session->userdata('name');
        $data['nama_olahraga'] = ucfirst(str_replace('-', ' ', $sport_name)); 
        $data['venue_list'] = $venue_data;
        $data['title'] = 'Reservasi Lapangan ' . $data['nama_olahraga'];
        
        // 3. Muat View dinamis ke dalam template
        $data['content'] = "sport_category"; 
        $this->load->view('template', $data);
    }

    public function view_venue_detail($id_venue)
    {
        // 1. Ambil data Venue
        $venue_data = $this->Model->get_venue_detail_by_id($id_venue);

        if (empty($venue_data)) {
            // Handle jika venue tidak ditemukan
            show_404();
            return;
        }

        // 2. Ambil daftar Lapangan (Courts) yang dimiliki venue tersebut
        $court_list = $this->Model->get_courts_by_venue_id($id_venue);

        // 3. Siapkan data untuk View
        $data['user_name'] = $this->session->userdata('name');
        $data['venue'] = $venue_data;
        $data['courts'] = $court_list;

        // Data dummy untuk Gallery Photo (Untuk simulasi, asumsikan ada 3 foto tambahan selain foto profil)
        $data['gallery_photos'] = [
            ['url' => 'https://placehold.co/800x600/926699/FFFFFF?text=GALERI+FOTO+1'],
            ['url' => 'https://placehold.co/800x600/B9CF32/FFFFFF?text=GALERI+FOTO+2'],
            ['url' => 'https://placehold.co/800x600/808080/FFFFFF?text=GALERI+FOTO+3'],
        ];

        $data['content'] = 'venue_detail'; // Nama file View baru
        $this->load->view('template', $data);
    }
    
    public function formvalidasi()
	{
		$data['content'] = "formvalidasi"; 
		$this->load->view('template', $data);
	}
}