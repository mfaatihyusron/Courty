<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Api
 * REST API Controller for Courty endpoints
 * 
 * @property CI_Loader $load
 * @property Model $Model
 * @property CI_Output $output
 */
class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
    }

    /**
     * Endpoint: GET /api/status
     * Health check endpoint returning server info and timestamp
     */
    public function status()
    {
        $response = [
            'status'     => 'success',
            'message'    => 'Courty API Gateway is operational',
            'service'    => 'backend-ci3',
            'timestamp'  => date('Y-m-d H:i:s'),
            'server_ip'  => $_SERVER['SERVER_ADDR'] ?? gethostname()
        ];

        return $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_status_header(200)
            ->set_output(json_encode($response, JSON_PRETTY_PRINT));
    }

    /**
     * Endpoint: GET /api/venues
     * Returns venue listings from database
     */
    public function venues()
    {
        $venues = $this->Model->get_featured_venues();

        $response = [
            'status'     => 'success',
            'total'      => count($venues),
            'timestamp'  => date('Y-m-d H:i:s'),
            'server_ip'  => $_SERVER['SERVER_ADDR'] ?? gethostname(),
            'data'       => $venues
        ];

        return $this->output
            ->set_content_type('application/json', 'utf-8')
            ->set_status_header(200)
            ->set_output(json_encode($response, JSON_PRETTY_PRINT));
    }
}
