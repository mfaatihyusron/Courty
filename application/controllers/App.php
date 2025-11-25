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
        $this->load->model('SportModel'); // <--- PERBAIKAN 1: Model Wajib Dimuat!
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
        // PERBAIKAN 2: Menghapus data dummy yang hardcoded
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
    
    public function formvalidasi()
	{
		$data['content'] = "formvalidasi"; 
		$this->load->view('template', $data);
	}
}