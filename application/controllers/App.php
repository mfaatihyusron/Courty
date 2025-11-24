<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class App
 * @property CI_Loader $load
 * @property Model $Model 
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
        $this->load->helper(array('url'));
        $this->load->library(array('session'));
    }

	public function index()
	{
        $data['user_name'] = $this->session->userdata('name');
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
        $venue_data = [
            (object)['venue_name' => 'GOR Futsal A', 'distance' => '1.2', 'court_count' => 3, 'review_count' => 120, 'image_url' => 'https://placehold.co/400x250/926699/FFFFFF?text=COURTY'],
            (object)['venue_name' => 'Hall Premium B', 'distance' => '5.5', 'court_count' => 5, 'review_count' => 90, 'image_url' => 'https://placehold.co/400x250/347048/FFFFFF?text=COURTY'],
            (object)['venue_name' => 'Lapangan Cepat', 'distance' => '2.1', 'court_count' => 2, 'review_count' => 45, 'image_url' => 'https://placehold.co/400x250/B9CF32/FFFFFF?text=COURTY'],
        ]; 
        
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