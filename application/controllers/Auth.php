<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Auth
 * @property CI_Loader $load
 * @property Model $Model 
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Upload $upload
 */
class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model'); 
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session'));
    }

    // ------------------------------------------------------------------
    // FITUR REGISTRASI USER BIASA (Role 0)
    // ------------------------------------------------------------------

    public function register()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('app/index'); // Mengarahkan ke App/index
        }

        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]|max_length[255]',
            array('is_unique' => 'Email ini sudah terdaftar. Silakan login.')
        );
        $this->form_validation->set_rules('telp', 'Nomor Telepon', 'required|trim|numeric|max_length[255]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[255]');
        $this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]');
        
        $this->form_validation->set_message('required', '{field} wajib diisi.');
        $this->form_validation->set_message('valid_email', 'Format {field} tidak valid.');
        $this->form_validation->set_message('min_length', '{field} minimal {param} karakter.');
        $this->form_validation->set_message('matches', '{field} tidak cocok dengan Password.');
        $this->form_validation->set_message('numeric', '{field} harus berisi angka.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['content'] = "register"; 
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

            if ($this->Model->register_user($data_insert)) {
                $this->session->set_flashdata('success', 'Pendaftaran berhasil! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Pendaftaran gagal. Silakan coba lagi.');
                redirect('auth/register');
            }
        }
    }

    // ------------------------------------------------------------------
    // FITUR LOGIN
    // ------------------------------------------------------------------
    
    public function login()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('app/index');
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
                
                // Arahkan berdasarkan role
                if ($user['role'] == 1) {
                    redirect('admin/dashboard'); // Mengarahkan ke Admin/dashboard
                } elseif ($user['role'] == 3) {
                     redirect('mitra/partner_dashboard'); // Mengarahkan ke Mitra/dashboard
                } else {
                    redirect('app/index'); // Mengarahkan ke App/index
                }
            } else {
                $this->session->set_flashdata('error', 'Email atau Password salah.');
                redirect('auth/login');
            }
        }
    }
    
    // ------------------------------------------------------------------
    // FITUR LOGOUT
    // ------------------------------------------------------------------

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Anda telah berhasil logout.');
        redirect('app/index');
    }
}