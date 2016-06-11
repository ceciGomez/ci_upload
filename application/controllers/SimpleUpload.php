<?php
/**
 * Description of User
 *
 * @author nayosx
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class SimpleUpload extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        $this->load->view('form', array('error' => ' '));
    }

    public function doUpload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 5418;
        $config['max_height'] = 3048;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('success', $data);
        }
    }

}
