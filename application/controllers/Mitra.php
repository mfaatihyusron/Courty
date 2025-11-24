<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Mitra
 * @property CI_Loader $load
 * @property Model $Model 
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
class Mitra extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model'); 
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session', 'upload'));
    }

    // ------------------------------------------------------------------
    // REGISTRASI MITRA (2 STEP)
    // ------------------------------------------------------------------

    // STEP 1: Pendaftaran User (Role 3: Admin Venue)
    public function partner_register_step1()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('app/index');
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

            $user_id = $this->Model->register_partner($data_insert);

            if ($user_id) {
                $this->session->set_flashdata('success', 'Data personal berhasil disimpan. Lanjutkan ke pendaftaran Venue.');
                $this->session->set_userdata('temp_partner_id', $user_id);
                redirect('mitra/partner_register_step2');
            } else {
                $this->session->set_flashdata('error', 'Pendaftaran gagal. Silakan coba lagi.');
                redirect('mitra/partner_register_step1');
            }
        }
    }
    
    public function partner_register_step2()
    {
        $partner_id = $this->session->userdata('temp_partner_id');
        if (!$partner_id) {
            $this->session->set_flashdata('error', 'Silakan isi data pribadi Anda terlebih dahulu.');
            redirect('mitra/partner_register_step1');
            return;
        }

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
            $data['content'] = "partner_register_venue"; 
            $this->load->view('template', $data);
        }
        else
        {
            $maps_url = $this->input->post('maps_url');
            $config['upload_path']   = './assets/uploads/venue_profiles/'; 
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048; 
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
                    redirect('mitra/partner_register_step2');
                    return;
                }
            }

            $data_insert = array(
                'id_user'            => $partner_id, 
                'venue_name'         => $this->input->post('venue_name'),
                'address'            => $this->input->post('address'),
                'coordinate'         => NULL, 
                'maps_url'           => $maps_url,
                'description'        => $this->input->post('description'),
                'opening_time'       => $this->input->post('opening_time'),
                'closing_time'       => $this->input->post('closing_time'),
                'link_profile_img'   => $uploaded_file_path
            );

            if ($this->Model->add_venue($data_insert)) {
                $this->session->unset_userdata('temp_partner_id'); 
                $this->session->set_flashdata('success', 'Pendaftaran Mitra berhasil! Venue Anda sudah terdaftar. Silakan Login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Pendaftaran Venue gagal. Silakan coba lagi.');
                redirect('mitra/partner_register_step2');
            }
        }
    }

    // ------------------------------------------------------------------
    // DASHBOARD & MANAJEMEN VENUE (Wajib Role 3)
    // ------------------------------------------------------------------
    
    public function partner_dashboard()
    {
        // Pengecekan Hak Akses
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 3) {
            $this->session->set_flashdata('error_access', 'Anda tidak memiliki hak akses untuk halaman Mitra.');
            redirect('app/index');
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $venue = $this->Model->get_venue_by_user_id($user_id);

        if (empty($venue)) {
            $this->session->set_flashdata('error', 'Venue Anda belum terdaftar. Silakan hubungi admin.');
            redirect('app/index');
            return;
        }
        
        $data['courts'] = $this->Model->get_courts_by_venue_id($venue['id_venue']);
        $data['venue'] = $venue;
        $data['content'] = "partner_dashboard"; 
        $this->load->view('template', $data);
    }

    public function edit_venue()
    {
        // Cek Hak Akses di dalam fungsi
        if (!$this->_check_mitra_access()) return;

        $user_id = $this->session->userdata('user_id');
        $venue = $this->Model->get_venue_by_user_id($user_id);
        
        if (empty($venue)) {
            $this->session->set_flashdata('error', 'Venue Anda belum terdaftar.');
            redirect('mitra/partner_dashboard');
            return;
        }

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
            $data['venue'] = $venue;
            $data['content'] = "edit_venue"; 
            $this->load->view('template', $data);
        }
        else
        {
            $uploaded_file_path = $venue['link_profile_img']; 

            if (!empty($_FILES['link_profile_img']['name'])) {
                $config['upload_path']   = './assets/uploads/venue_profiles/'; 
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = 2048; 
                $config['file_name']     = 'venue-' . $venue['id_venue'] . '-' . time();
                $config['overwrite']     = TRUE;

                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('link_profile_img')) {
                    $upload_data = $this->upload->data();
                    $uploaded_file_path = 'assets/uploads/venue_profiles/' . $upload_data['file_name'];
                    
                    if ($venue['link_profile_img'] != 'placeholder.jpg' && file_exists($venue['link_profile_img'])) {
                         unlink($venue['link_profile_img']);
                    }
                } else {
                    $upload_error = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Update gagal: Upload foto gagal: ' . $upload_error);
                    redirect('mitra/edit_venue');
                    return;
                }
            }

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
            redirect('mitra/partner_dashboard');
        }
    }
    
    // ------------------------------------------------------------------
    // MANAJEMEN COURT (Wajib Role 3)
    // ------------------------------------------------------------------

    public function add_court()
    {
        if (!$this->_check_mitra_access()) return;

        $user_id = $this->session->userdata('user_id');
        $venue = $this->Model->get_venue_by_user_id($user_id);
        
        if (empty($venue)) {
            $this->session->set_flashdata('error', 'Venue Anda belum terdaftar.');
            redirect('mitra/partner_dashboard');
            return;
        }

        $this->form_validation->set_rules('id_sport', 'Jenis Olahraga', 'required|numeric');
        $this->form_validation->set_rules('price_per_hour', 'Harga per Jam', 'required|numeric');
        $this->form_validation->set_rules('description', 'Deskripsi Lapangan', 'required');
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('numeric', '{field} harus berisi angka.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['sports'] = $this->Model->get_all_sports(); 
            $data['venue'] = $venue;
            $data['content'] = "add_court"; 
            $this->load->view('template', $data);
        }
        else
        {
            $id_venue = $venue['id_venue'];
            $config['upload_path']   = './assets/uploads/court_profiles/'; 
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048;
            $config['file_name']     = 'court-' . $id_venue . '-' . time();
            $config['overwrite']     = TRUE;

            $this->upload->initialize($config);
            
            if (!$this->upload->do_upload('profile_photo')) {
                $upload_error = $this->upload->display_errors('', '');
                $this->session->set_flashdata('error', 'Tambah Lapangan gagal: Upload foto gagal: ' . $upload_error);
                redirect('mitra/add_court');
                return;
            }

            $upload_data = $this->upload->data();
            $uploaded_file_path = 'assets/uploads/court_profiles/' . $upload_data['file_name'];

            $data_insert = array(
                'id_venue'          => $id_venue, 
                'id_sport'          => $this->input->post('id_sport'),
                'price_per_hour'    => $this->input->post('price_per_hour'),
                'description'       => $this->input->post('description'),
                'profile_photo'     => $uploaded_file_path
            );

            if ($this->Model->add_court($data_insert)) {
                $this->session->set_flashdata('success', 'Lapangan baru berhasil ditambahkan!');
                redirect('mitra/partner_dashboard');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan lapangan baru. Silakan coba lagi.');
                redirect('mitra/add_court');
            }
        }
    }

    public function edit_court($id_court)
    {
        if (!$this->_check_mitra_access()) return;

        $user_id = $this->session->userdata('user_id');
        $venue = $this->Model->get_venue_by_user_id($user_id);
        $court = $this->Model->get_court_by_id($id_court);
        
        if (empty($court) || $court['id_venue'] != $venue['id_venue']) {
            $this->session->set_flashdata('error', 'Lapangan tidak ditemukan atau bukan milik Anda.');
            redirect('mitra/partner_dashboard');
            return;
        }

        $this->form_validation->set_rules('id_sport', 'Jenis Olahraga', 'required|numeric');
        $this->form_validation->set_rules('price_per_hour', 'Harga per Jam', 'required|numeric');
        $this->form_validation->set_rules('description', 'Deskripsi Lapangan', 'required');
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('numeric', '{field} harus berisi angka.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['sports'] = $this->Model->get_all_sports();
            $data['court'] = $court;
            $data['content'] = "edit_court"; 
            $this->load->view('template', $data);
        }
        else
        {
            $uploaded_file_path = $court['profile_photo'];

            if (!empty($_FILES['profile_photo']['name'])) {
                $config['upload_path']   = './assets/uploads/court_profiles/'; 
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = 2048; 
                $config['file_name']     = 'court-' . $court['id_court'] . '-' . time();
                $config['overwrite']     = TRUE;

                $this->upload->initialize($config);
                
                if ($this->upload->do_upload('profile_photo')) {
                    $upload_data = $this->upload->data();
                    $uploaded_file_path = 'assets/uploads/court_profiles/' . $upload_data['file_name'];
                    
                    if (file_exists($court['profile_photo'])) {
                         unlink($court['profile_photo']);
                    }
                } else {
                    $upload_error = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('error', 'Update gagal: Upload foto gagal: ' . $upload_error);
                    redirect('mitra/edit_court/' . $id_court);
                    return;
                }
            }

            $data_update = array(
                'id_sport'          => $this->input->post('id_sport'),
                'price_per_hour'    => $this->input->post('price_per_hour'),
                'description'       => $this->input->post('description'),
                'profile_photo'     => $uploaded_file_path
            );

            if ($this->Model->update_court($id_court, $data_update)) {
                $this->session->set_flashdata('success', 'Detail Lapangan berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('error', 'Update gagal. Tidak ada perubahan data atau terjadi kesalahan.');
            }
            redirect('mitra/partner_dashboard');
        }
    }

    public function delete_court($id_court)
    {
        if (!$this->_check_mitra_access()) return;

        $user_id = $this->session->userdata('user_id');
        $venue = $this->Model->get_venue_by_user_id($user_id);
        $court = $this->Model->get_court_by_id($id_court);
        
        if (empty($court) || $court['id_venue'] != $venue['id_venue']) {
            $this->session->set_flashdata('error', 'Lapangan tidak ditemukan atau bukan milik Anda.');
            redirect('mitra/partner_dashboard');
            return;
        }

        if ($this->Model->delete_court($id_court)) {
            if (file_exists($court['profile_photo'])) {
                unlink($court['profile_photo']);
            }
            $this->session->set_flashdata('success', 'Lapangan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus lapangan. Mungkin terdapat data terkait lainnya.');
        }

        redirect('mitra/partner_dashboard');
    }
    
    // --- PRIVATE FUNCTION UNTUK PENCEGAHAN REDUNDANSI ---
    private function _check_mitra_access()
    {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 3) {
            $this->session->set_flashdata('error_access', 'Anda tidak memiliki hak akses untuk halaman Mitra.');
            redirect('app/index');
            return false;
        }
        return true;
    }
}