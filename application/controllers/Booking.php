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
class Booking extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model'); 
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session', 'upload'));
        
        // Cek Login: User wajib login untuk booking
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu untuk melakukan booking.');
            redirect('auth/login');
        }
    }

    // 1. PROSES PEMBUATAN BOOKING (Dari Form Venue Detail)
    public function create()
    {
        $this->form_validation->set_rules('court_id', 'Lapangan', 'required|numeric');
        $this->form_validation->set_rules('booking_date', 'Tanggal Main', 'required');
        $this->form_validation->set_rules('start_time', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('duration', 'Durasi', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', 'Data booking tidak lengkap.');
            redirect($_SERVER['HTTP_REFERER']); // Kembali ke halaman sebelumnya
        } else {
            // Ambil data court untuk hitung harga
            $court_id = $this->input->post('court_id');
            $court = $this->Model->get_court_by_id($court_id);
            
            if (!$court) {
                show_404();
            }

            $duration = $this->input->post('duration');
            $total_price = $court['price_per_hour'] * $duration;

            // Hitung End Time
            $start_time = $this->input->post('start_time');
            $end_time = date('H:i', strtotime($start_time) + ($duration * 3600));

            $data_insert = array(
                'id_user'        => $this->session->userdata('user_id'),
                'id_court'       => $court_id,
                'booking_date'   => $this->input->post('booking_date'),
                'start_time'     => $start_time,
                'end_time'       => $end_time,
                'duration_hours' => $duration . ' Jam',
                'total_price'    => $total_price,
                'status'         => 'Pending', // Status Awal
                'created_at'     => date('Y-m-d H:i:s')
            );

            if ($this->Model->create_booking($data_insert)) {
                $this->session->set_flashdata('success', 'Request Booking berhasil dikirim! Menunggu konfirmasi Mitra.');
                redirect('booking/my_orders');
            } else {
                $this->session->set_flashdata('error', 'Gagal membuat booking.');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    // 2. HALAMAN DAFTAR PESANAN SAYA (User)
    public function my_orders()
    {
        $user_id = $this->session->userdata('user_id');
        $data['orders'] = $this->Model->get_bookings_by_user($user_id);
        
        $data['title'] = "Pesanan Saya";
        $data['content'] = "user_orders"; // File view baru
        $this->load->view('template', $data);
    }

    // 3. UPLOAD BUKTI PEMBAYARAN (User)
    public function upload_payment()
    {
        $booking_id = $this->input->post('booking_id');
        
        // Config Upload
        $config['upload_path']   = './assets/uploads/payments/'; 
        $config['allowed_types'] = 'jpg|png|jpeg|pdf';
        $config['max_size']      = 2048; // 2MB
        $config['file_name']     = 'pay-' . $booking_id . '-' . time();
        $config['overwrite']     = TRUE;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('payment_proof')) {
            $upload_data = $this->upload->data();
            $file_path = 'assets/uploads/payments/' . $upload_data['file_name'];

            // Update DB: Set Link Bukti & Ubah Status jadi 'Paid' (Menunggu Verifikasi)
            $update_data = array(
                'link_payment_prove' => $file_path,
                'status'             => 'Paid'
            );

            $this->Model->update_booking($booking_id, $update_data);
            $this->session->set_flashdata('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi Mitra.');
        } else {
            $this->session->set_flashdata('error', 'Upload gagal: ' . $this->upload->display_errors());
        }

        redirect('booking/my_orders');
    }
}