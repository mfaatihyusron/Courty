<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Praktek
 * @property CI_Loader $load
 * @property Model $Model 
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
class praktek extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model'); 
        $this->load->helper(array('form', 'url'));
        // Memuat library form_validation, session, dan upload
        $this->load->library(array('form_validation', 'session', 'upload'));
    }

	public function index()
	{
        $data['user_name'] = $this->session->userdata('name');
		$data['content'] = "index"; 
		$this->load->view('template', $data);
	}
    
    public function vanue()
	{
        $data['user_name'] = $this->session->userdata('name');
		$data['content'] = "vanue"; 
		$this->load->view('template', $data);
	}

    public function about()
	{
        $data['user_name'] = $this->session->userdata('name');
		$data['content'] = "about"; 
		$this->load->view('template', $data);
	}
    // ------------------------------------------------------------------
    // FITUR REGISTRASI MITRA (2 STEP)
    // ------------------------------------------------------------------

    // STEP 1: Pendaftaran User (Role 3: Admin Venue)
    public function partner_register_step1()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('praktek/index');
        }

        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]|max_length[255]',
            array('is_unique' => 'Email ini sudah terdaftar. Silakan login atau gunakan email lain.')
        );
        $this->form_validation->set_rules('telp', 'Nomor Telepon', 'required|trim|numeric|max_length[255]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[255]');
        $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]');
        
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('valid_email', 'Format {field} tidak valid.');
        $this->form_validation->set_message('is_unique', '{field} sudah terdaftar.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('matches', '{field} tidak cocok dengan Password.');
        $this->form_validation->set_message('numeric', '{field} harus berisi angka.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['content'] = "partner_register_user"; 
            $this->load->view('template', $data);
        }
        else
        {
            $data_insert = array(
                'name'      => $this->input->post('name'),
                'email'     => $this->input->post('email'),
                'telp'      => $this->input->post('telp'),
                'password'  => $this->input->post('password')
            );

            // Panggil fungsi register partner (role 3)
            $user_id = $this->Model->register_partner($data_insert);

            if ($user_id) {
                // Simpan ID user ke session sementara untuk langkah 2
                $this->session->set_flashdata('success', 'Data personal berhasil disimpan. Lanjutkan ke pendaftaran Venue.');
                $this->session->set_userdata('temp_partner_id', $user_id);
                redirect('praktek/partner_register_step2');
            } else {
                $this->session->set_flashdata('error', 'Pendaftaran gagal. Silakan coba lagi.');
                redirect('praktek/partner_register_step1');
            }
        }
    }
    
    // STEP 2: Pendaftaran Venue (Membutuhkan ID User dari Step 1)
    public function partner_register_step2()
    {
        // Pengecekan: Pastikan user ID tersedia dari Step 1
        $partner_id = $this->session->userdata('temp_partner_id');
        if (!$partner_id) {
            $this->session->set_flashdata('error', 'Silakan isi data pribadi Anda terlebih dahulu.');
            redirect('praktek/partner_register_step1');
            return;
        }

        // --- UPDATE VALIDASI SESUAI TABEL VENUE BARU ---
        $this->form_validation->set_rules('venue_name', 'Nama Venue', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('address', 'Alamat Lengkap', 'required|trim');
        $this->form_validation->set_rules('lat', 'Latitude', 'required|trim|numeric');
        $this->form_validation->set_rules('lon', 'Longitude', 'required|trim|numeric');
        $this->form_validation->set_rules('maps_url', 'URL Google Maps', 'trim|valid_url');
        $this->form_validation->set_rules('description', 'Deskripsi Venue', 'required');
        $this->form_validation->set_rules('opening_time', 'Jam Buka', 'required|trim|max_length[5]'); 
        $this->form_validation->set_rules('closing_time', 'Jam Tutup', 'required|trim|max_length[5]');
        // Tidak ada set_rules untuk file upload, karena akan divalidasi manual

        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka (koordinat).');
        $this->form_validation->set_message('valid_url', '{field} harus berupa URL yang valid.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['content'] = "partner_register_venue"; 
            $this->load->view('template', $data);
        }
        else
        {
            // --- LOGIKA UPLOAD FOTO ---
            $config['upload_path']   = './assets/uploads/venue_profiles/'; // Pastikan folder ini ada dan writable
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048; // Maksimal 2MB
            $config['file_name']     = 'venue-' . $partner_id . '-' . time();
            $config['overwrite']     = TRUE;

            $this->upload->initialize($config);
            
            $uploaded_file_path = 'placeholder.jpg'; // Default jika upload gagal atau tidak ada file
            
            // Cek apakah ada file yang diupload (input field 'link_profile_img')
            if (!empty($_FILES['link_profile_img']['name'])) {
                if ($this->upload->do_upload('link_profile_img')) {
                    $upload_data = $this->upload->data();
                    // Simpan path relatif file yang diupload
                    $uploaded_file_path = 'assets/uploads/venue_profiles/' . $upload_data['file_name'];
                } else {
                    // Jika upload gagal, tampilkan error dan hentikan proses
                    $upload_error = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Upload foto gagal: ' . $upload_error);
                    redirect('praktek/partner_register_step2');
                    return; // Penting untuk menghentikan eksekusi
                }
            }
            // --- AKHIR LOGIKA UPLOAD FOTO ---


            // Gabungkan Latitude dan Longitude menjadi format Coordinate
            $coordinate_string = $this->input->post('lat') . ',' . $this->input->post('lon');

            // --- DATA INSERT KE TABEL VENUE ---
            $data_insert = array(
                'id_user'            => $partner_id, 
                'venue_name'         => $this->input->post('venue_name'),
                'address'            => $this->input->post('address'),
                'coordinate'         => $coordinate_string, 
                'maps_url'           => $this->input->post('maps_url') ? $this->input->post('maps_url') : '#',
                'description'        => $this->input->post('description'),
                'opening_time'       => $this->input->post('opening_time'),
                'closing_time'       => $this->input->post('closing_time'),
                'link_profile_img'   => $uploaded_file_path // Simpan path/nama file
            );

            if ($this->Model->add_venue($data_insert)) {
                // Pendaftaran venue berhasil
                $this->session->unset_userdata('temp_partner_id'); 
                $this->session->set_flashdata('success', 'Pendaftaran Mitra berhasil! Venue Anda sudah terdaftar. Silakan Login.');
                redirect('praktek/login');
            } else {
                $this->session->set_flashdata('error', 'Pendaftaran Venue gagal. Silakan coba lagi.');
                redirect('praktek/partner_register_step2');
            }
        }
    }

    // ------------------------------------------------------------------
    // FITUR ADMIN DASHBOARD
    // ------------------------------------------------------------------

    public function admin_dashboard()
    {
        // Pengecekan Hak Akses
        // Akses hanya untuk Role 1 (Super Admin)
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 1) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk halaman Admin.');
            redirect('praktek/index');
            return;
        }

        $data['users'] = $this->Model->get_all_users();
        $data['content'] = "admin_dashboard"; 
        $this->load->view('template', $data);
    }
    
    // ------------------------------------------------------------------
    // FITUR REGISTRASI USER BIASA
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

            // Panggil fungsi register di model (role 0)
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
    // FITUR LOGIN & LOGOUT
    // ------------------------------------------------------------------
    
    public function login()
    {
        // Logika login sama dengan sebelumnya...
        // ... (kode login yang sudah ada)
        if ($this->session->userdata('logged_in')) {
            redirect('praktek/index');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('valid_email', 'Format {field} tidak valid.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['content'] = "login"; 
            $this->load->view('template', $data);
        }
        else
        {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->Model->check_login($email, $password);

            if ($user) {
                $session_data = array(
                    'user_id'   => $user['id_user'],
                    'name'      => $user['name'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($session_data);
                $this->session->set_flashdata('success', 'Selamat datang kembali, ' . $user['name'] . '!');
                // Arahkan admin venue (role 3) ke dashboard mitra (jika ada) atau index
                if ($user['role'] == 3) {
                     redirect('praktek/index'); // Atau ke dashboard mitra yang akan dibuat
                } else {
                    redirect('praktek/index'); 
                }
            } else {
                $this->session->set_flashdata('error', 'Email atau Password salah.');
                redirect('praktek/login');
            }
        }
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Anda telah berhasil logout.');
        redirect('praktek/index');
    }
    
    public function formvalidasi()
	{
		$data['content'] = "formvalidasi"; 
		$this->load->view('template', $data);
	}
	
}