<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Admin
 * @property CI_Loader $load
 * @property Model $Model 
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model'); 
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session', 'upload'));

        // Cek Hak Akses di construct: Wajib Role 1
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 1) {
            $this->session->set_flashdata('error_access', 'Anda tidak memiliki hak akses untuk halaman Admin.');
            redirect('app/index');
            return;
        }
    }

    // ------------------------------------------------------------------
    // DASHBOARD SUPER ADMIN (Role 1)
    // ------------------------------------------------------------------

    public function dashboard()
    {
        $data['users'] = $this->Model->get_all_users();
        $data['sports'] = $this->Model->get_all_sports(); 
        $data['content'] = "admin_dashboard"; 
        $this->load->view('template', $data);
    }

    // ------------------------------------------------------------------
    // MANAJEMEN SPORT
    // ------------------------------------------------------------------

    public function add_sport()
    {
        $this->form_validation->set_rules('name', 'Nama Olahraga', 'required|trim|max_length[255]|is_unique[sport.name]',
            array('is_unique' => 'Olahraga ini sudah ada dalam daftar.')
        );
        $this->form_validation->set_message('required', '{field} wajib diisi.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['content'] = "add_sport"; 
            $this->load->view('template', $data);
        }
        else
        {
            $data_insert = array(
                'name' => $this->input->post('name')
            );
            
            if ($this->Model->add_sport($data_insert)) {
                $this->session->set_flashdata('success', 'Olahraga baru berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan olahraga.');
            }
            redirect('admin/dashboard'); 
        }
    }
    
    public function edit_sport($id_sport)
    {
        $sport = $this->Model->get_sport_by_id($id_sport);
        if (!$sport) {
            $this->session->set_flashdata('error', 'Data olahraga tidak ditemukan.');
            redirect('admin/dashboard');
            return;
        }
        
        $unique_rule = '|is_unique[sport.name]';
        if ($this->input->post('name') == $sport['name']) {
            $unique_rule = '';
        }

        $this->form_validation->set_rules('name', 'Nama Olahraga', 'required|trim|max_length[255]' . $unique_rule,
            array('is_unique' => 'Olahraga ini sudah ada dalam daftar.')
        );
        $this->form_validation->set_message('required', '{field} wajib diisi.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['sport'] = $sport;
            $data['content'] = "edit_sport"; 
            $this->load->view('template', $data);
        }
        else
        {
            $data_update = array(
                'name' => $this->input->post('name')
            );
            
            if ($this->Model->update_sport($id_sport, $data_update)) {
                $this->session->set_flashdata('success', 'Nama olahraga berhasil diperbarui!');
            } else {
                $this->session->set_flashdata('error', 'Update gagal. Tidak ada perubahan data atau terjadi kesalahan.');
            }
            redirect('admin/dashboard');
        }
    }
    
    public function delete_sport($id_sport)
    {
        if ($this->Model->delete_sport($id_sport)) {
            $this->session->set_flashdata('success', 'Olahraga berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus olahraga. Mungkin sedang digunakan oleh Court.');
        }
        redirect('admin/dashboard');
    }
}