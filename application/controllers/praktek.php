<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Praktek
 * @property CI_Loader $load
 * @property Model $Model 
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 */
class praktek extends CI_Controller {

    // Constructor untuk memuat Model dan Library
    public function __construct()
    {
        parent::__construct();
        
        // Memuat Model
        $this->load->model('Model'); 
        
        // Memuat Helper form dan URL
        $this->load->helper(array('form', 'url'));
        
        // Memuat Library form_validation dan session (Ini adalah langkah krusial)
        $this->load->library(array('form_validation', 'session'));
    }

	public function index()
	{
        // Menampilkan halaman utama
        // Anda bisa menambahkan pesan sambutan di sini
        $data['user_name'] = $this->session->userdata('name');
		$data['content'] = "index"; 
		$this->load->view('template', $data);
	}
    
    // ------------------------------------------------------------------
    // FITUR ADMIN DASHBOARD (Akses hanya untuk role 1)
    // ------------------------------------------------------------------

    public function admin_dashboard()
    {
        // Pengecekan Hak Akses
        // 1. Cek apakah sudah login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Anda harus login untuk mengakses halaman Admin.');
            redirect('praktek/login');
            return;
        }

        // 2. Cek apakah role adalah 1 (Admin)
        if ($this->session->userdata('role') != 1) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses sebagai Admin.');
            redirect('praktek/index');
            return;
        }

        // Jika lolos pengecekan, ambil data user
        $data['users'] = $this->Model->get_all_users();
        $data['content'] = "admin_dashboard"; 
        $this->load->view('template', $data);
    }
    
    // ------------------------------------------------------------------
    // FITUR REGISTRASI
    // ------------------------------------------------------------------

    public function register()
    {
        // Cek jika user sudah login, arahkan ke halaman utama
        if ($this->session->userdata('logged_in')) {
            redirect('praktek/index');
        }

        // Set rules untuk form validation
        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]|max_length[255]',
            array('is_unique' => 'Email ini sudah terdaftar. Silakan login.')
        );
        $this->form_validation->set_rules('telp', 'Nomor Telepon', 'required|trim|numeric|max_length[255]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[255]');
        $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]');
        
        // Mengubah pesan error ke Bahasa Indonesia
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('valid_email', 'Format {field} tidak valid.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('matches', '{field} tidak cocok dengan Password.');
        $this->form_validation->set_message('numeric', '{field} harus berisi angka.');

        if ($this->form_validation->run() == FALSE)
        {
            // Jika validasi gagal atau ini adalah tampilan form pertama
            $data['content'] = "register"; 
            $this->load->view('template', $data);
        }
        else
        {
            // Jika validasi sukses, proses pendaftaran
            $data_insert = array(
                'name'      => $this->input->post('name'),
                'email'     => $this->input->post('email'),
                'telp'      => $this->input->post('telp'),
                'password'  => $this->input->post('password')
            );

            // Panggil fungsi register di model
            if ($this->Model->register_user($data_insert)) {
                $this->session->set_flashdata('success', 'Pendaftaran berhasil! Silakan login.');
                redirect('praktek/login');
            } else {
                $this->session->set_flashdata('error', 'Pendaftaran gagal. Silakan coba lagi.');
                redirect('praktek/register');
            }
        }
    }

    // ------------------------------------------------------------------
    // FITUR LOGIN
    // ------------------------------------------------------------------
    
    public function login()
    {
        // Cek jika user sudah login, arahkan ke halaman utama
        if ($this->session->userdata('logged_in')) {
            redirect('praktek/index');
        }

        // Set rules untuk form validation
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        // Mengubah pesan error ke Bahasa Indonesia
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('valid_email', 'Format {field} tidak valid.');

        if ($this->form_validation->run() == FALSE)
        {
            // Jika validasi gagal atau ini adalah tampilan form pertama
            $data['content'] = "login"; 
            $this->load->view('template', $data);
        }
        else
        {
            // Jika validasi sukses, proses login
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->Model->check_login($email, $password);

            if ($user) {
                // Login berhasil, buat session
                $session_data = array(
                    'user_id'   => $user['id_user'],
                    'name'      => $user['name'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($session_data);
                $this->session->set_flashdata('success', 'Selamat datang kembali, ' . $user['name'] . '!');
                redirect('praktek/index'); // Arahkan ke halaman utama
            } else {
                // Login gagal
                $this->session->set_flashdata('error', 'Email atau Password salah.');
                redirect('praktek/login');
            }
        }
    }
    
    // ------------------------------------------------------------------
    // FITUR LOGOUT
    // ------------------------------------------------------------------
    
    public function logout()
    {
        // Hapus semua data session
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Anda telah berhasil logout.');
        redirect('praktek/index');
    }
    
    // Fungsi formvalidasi (dari file asli Anda, saya biarkan)
    public function formvalidasi()
	{
		$data['content'] = "formvalidasi"; 
		$this->load->view('template', $data);
	}
	
}