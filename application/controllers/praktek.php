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
        $this->load->model('sportModel');
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
        // NOTE: Anda perlu membuat Model bernama 'SportModel' dan method 'get_venues_by_sport'
        // Untuk latihan, $venue_data adalah data dummy jika model belum dibuat:
        $venue_data = [
            (object)['venue_name' => 'GOR Futsal A', 'distance' => '1.2', 'court_count' => 3, 'review_count' => 120, 'image_url' => 'https://placehold.co/400x250/926699/FFFFFF?text=COURTY'],
            (object)['venue_name' => 'Hall Premium B', 'distance' => '5.5', 'court_count' => 5, 'review_count' => 90, 'image_url' => 'https://placehold.co/400x250/347048/FFFFFF?text=COURTY'],
            (object)['venue_name' => 'Lapangan Cepat', 'distance' => '2.1', 'court_count' => 2, 'review_count' => 45, 'image_url' => 'https://placehold.co/400x250/B9CF32/FFFFFF?text=COURTY'],
        ]; 
        
        // 2. Siapkan data untuk dikirim ke View
        $data['user_name'] = $this->session->userdata('name');
        // Mengubah 'sepak-bola' menjadi 'Sepak Bola'
        $data['nama_olahraga'] = ucfirst(str_replace('-', ' ', $sport_name)); 
        $data['venue_list'] = $venue_data;
        $data['title'] = 'Reservasi Lapangan ' . $data['nama_olahraga'];
        
        // 3. Muat View dinamis ke dalam template
        $data['content'] = "sport_category"; // Mengacu pada file sport_category.php
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

        // --- UPDATE VALIDASI SESUAI TABEL VENUE BARU (COORDINATE DIHAPUS) ---
        $this->form_validation->set_rules('venue_name', 'Nama Venue', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('address', 'Alamat Lengkap', 'required|trim');
        // VALIDASI LAT & LON DIHAPUS
        $this->form_validation->set_rules('maps_url', 'URL Google Maps', 'trim|valid_url'); 
        $this->form_validation->set_rules('description', 'Deskripsi Venue', 'required');
        $this->form_validation->set_rules('opening_time', 'Jam Buka', 'required|trim|max_length[5]'); 
        $this->form_validation->set_rules('closing_time', 'Jam Tutup', 'required|trim|max_length[5]');
        // Tidak ada set_rules untuk file upload

        $this->form_validation->set_message('required', '{field} wajib diisi.');
        // PESAN ERROR NUMERIC DIHAPUS KARENA LAT/LON TIDAK ADA
        $this->form_validation->set_message('valid_url', '{field} harus berupa URL yang valid.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['content'] = "partner_register_venue"; 
            $this->load->view('template', $data);
        }
        else
        {
            $maps_url = $this->input->post('maps_url');
            
            // --- KOORDINAT MANUAL DARI FORM DIHAPUS ---
            // $coordinate_string = $this->input->post('lat') . ',' . $this->input->post('lon');

            // --- LOGIKA UPLOAD FOTO ---
            $config['upload_path']   = './assets/uploads/venue_profiles/'; 
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048; // Maksimal 2MB
            $config['file_name']     = 'venue-' . $partner_id . '-' . time();
            $config['overwrite']     = TRUE;

            $this->upload->initialize($config);
            
            $uploaded_file_path = 'placeholder.jpg';
            
            if (!empty($_FILES['link_profile_img']['name'])) {
                if ($this->upload->do_upload('link_profile_img')) {
                    $upload_data = $this->upload->data();
                    $uploaded_file_path = 'assets/uploads/venue_profiles/' . $upload_data['file_name'];
                } else {
                    $upload_error = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Upload foto gagal: ' . $upload_error);
                    redirect('praktek/partner_register_step2');
                    return;
                }
            }
            // --- AKHIR LOGIKA UPLOAD FOTO ---


            // --- DATA INSERT KE TABEL VENUE (FIELD COORDINATE DIBERI NULL ATAU STRING KOSONG) ---
            $data_insert = array(
                'id_user'            => $partner_id, 
                'venue_name'         => $this->input->post('venue_name'),
                'address'            => $this->input->post('address'),
                'coordinate'         => NULL, // Dihapus dari input, diset NULL di sini
                'maps_url'           => $maps_url,
                'description'        => $this->input->post('description'),
                'opening_time'       => $this->input->post('opening_time'),
                'closing_time'       => $this->input->post('closing_time'),
                'link_profile_img'   => $uploaded_file_path
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
    // FITUR EDIT VENUE (ROLE 3)
    // ------------------------------------------------------------------

    public function edit_venue()
    {
        // 1. Pengecekan Hak Akses (Wajib Role 3)
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 3) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses.');
            redirect('praktek/index');
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $venue = $this->Model->get_venue_by_user_id($user_id);
        
        if (empty($venue)) {
            $this->session->set_flashdata('error', 'Venue Anda belum terdaftar.');
            redirect('praktek/partner_dashboard');
            return;
        }

        // 2. Set Rules Validasi
        $this->form_validation->set_rules('venue_name', 'Nama Venue', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('address', 'Alamat Lengkap', 'required|trim');
        $this->form_validation->set_rules('maps_url', 'URL Google Maps', 'trim|valid_url'); 
        $this->form_validation->set_rules('description', 'Deskripsi Venue', 'required');
        $this->form_validation->set_rules('opening_time', 'Jam Buka', 'required|trim|max_length[5]'); 
        $this->form_validation->set_rules('closing_time', 'Jam Tutup', 'required|trim|max_length[5]');

        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('valid_url', '{field} harus berupa URL yang valid.');

        if ($this->form_validation->run() == FALSE)
        {
            // Tampilkan form dengan data lama
            $data['venue'] = $venue;
            $data['content'] = "edit_venue"; 
            $this->load->view('template', $data);
        }
        else
        {
            // 3. Proses Upload Foto (Opsional)
            $uploaded_file_path = $venue['link_profile_img']; // Default: pakai foto lama

            if (!empty($_FILES['link_profile_img']['name'])) {
                $config['upload_path']   = './assets/uploads/venue_profiles/'; 
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = 2048; // Maksimal 2MB
                $config['file_name']     = 'venue-' . $venue['id_venue'] . '-' . time();
                $config['overwrite']     = TRUE;

                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('link_profile_img')) {
                    $upload_data = $this->upload->data();
                    $uploaded_file_path = 'assets/uploads/venue_profiles/' . $upload_data['file_name'];
                    
                    // Hapus file lama (jika bukan placeholder)
                    if ($venue['link_profile_img'] != 'placeholder.jpg' && file_exists($venue['link_profile_img'])) {
                         unlink($venue['link_profile_img']);
                    }
                } else {
                    $upload_error = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Update gagal: Upload foto gagal: ' . $upload_error);
                    redirect('praktek/edit_venue');
                    return;
                }
            }

            // 4. Data Update
            $data_update = array(
                'venue_name'         => $this->input->post('venue_name'),
                'address'            => $this->input->post('address'),
                'maps_url'           => $this->input->post('maps_url'),
                'description'        => $this->input->post('description'),
                'opening_time'       => $this->input->post('opening_time'),
                'closing_time'       => $this->input->post('closing_time'),
                'link_profile_img'   => $uploaded_file_path
            );

            if ($this->Model->update_venue($venue['id_venue'], $data_update)) {
                $this->session->set_flashdata('success', 'Detail Venue berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('error', 'Update gagal. Tidak ada perubahan data atau terjadi kesalahan.');
            }
            redirect('praktek/partner_dashboard');
        }
    }

    // ------------------------------------------------------------------
    // FITUR TAMBAH COURT (ROLE 3)
    // ------------------------------------------------------------------

    public function add_court()
    {
        // 1. Pengecekan Hak Akses (Wajib Role 3)
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 3) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses.');
            redirect('praktek/index');
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $venue = $this->Model->get_venue_by_user_id($user_id);
        
        if (empty($venue)) {
            $this->session->set_flashdata('error', 'Venue Anda belum terdaftar.');
            redirect('praktek/partner_dashboard');
            return;
        }

        // 2. Set Rules Validasi
        $this->form_validation->set_rules('id_sport', 'Jenis Olahraga', 'required|numeric');
        $this->form_validation->set_rules('price_per_hour', 'Harga per Jam', 'required|numeric');
        $this->form_validation->set_rules('description', 'Deskripsi Lapangan', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('numeric', '{field} harus berupa angka.');

        if ($this->form_validation->run() == FALSE)
        {
            // Tampilkan form dengan data Sport
            $data['sports'] = $this->Model->get_all_sports(); 
            $data['venue'] = $venue;
            $data['content'] = "add_court"; 
            $this->load->view('template', $data);
        }
        else
        {
            $id_venue = $venue['id_venue']; // ID Venue milik mitra
            
            // 3. Proses Upload Foto Court (Wajib ada)
            $config['upload_path']   = './assets/uploads/court_profiles/'; 
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048; // Maksimal 2MB
            $config['file_name']     = 'court-' . $id_venue . '-' . time();
            $config['overwrite']     = TRUE;

            $this->upload->initialize($config);
            
            if (!$this->upload->do_upload('profile_photo')) {
                $upload_error = $this->upload->display_errors('', '');
                $this->session->set_flashdata('error', 'Tambah Lapangan gagal: Upload foto gagal: ' . $upload_error);
                redirect('praktek/add_court');
                return;
            }

            $upload_data = $this->upload->data();
            $uploaded_file_path = 'assets/uploads/court_profiles/' . $upload_data['file_name'];

            // 4. Data Insert Court
            $data_insert = array(
                'id_venue'          => $id_venue, 
                'id_sport'          => $this->input->post('id_sport'),
                'price_per_hour'    => $this->input->post('price_per_hour'),
                'description'       => $this->input->post('description'),
                'profile_photo'     => $uploaded_file_path
            );

            if ($this->Model->add_court($data_insert)) {
                $this->session->set_flashdata('success', 'Lapangan baru berhasil ditambahkan!');
                redirect('praktek/partner_dashboard');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan lapangan baru. Silakan coba lagi.');
                redirect('praktek/add_court');
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
        $data['sports'] = $this->Model->get_all_sports(); // TAMBAH: Ambil data Sport
        $data['content'] = "admin_dashboard"; 
        $this->load->view('template', $data);
    }
    
    
    // ------------------------------------------------------------------
    // FITUR PARTNER DASHBOARD (Role 3)
    // ------------------------------------------------------------------

    public function partner_dashboard()
    {
        // Pengecekan Hak Akses
        // Akses hanya untuk Role 3 (Admin Venue)
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 3) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki hak akses untuk halaman Mitra.');
            redirect('praktek/index');
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $data['venue'] = $this->Model->get_venue_by_user_id($user_id);

        if (empty($data['venue'])) {
            $this->session->set_flashdata('error', 'Venue Anda belum terdaftar. Silakan hubungi admin.');
            redirect('praktek/index');
            return;
        }

        $data['content'] = "partner_dashboard"; 
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