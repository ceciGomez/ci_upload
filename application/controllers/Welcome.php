<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        $this->load->view('form', array('error' => ' '));
    }

    public function do_upload() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 100;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('upload_form', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());

            $this->load->view('success', $data);
        }
    }

    public function upload() {
        $p1 = $p2 = [];
        if (empty($_FILES['kartik-input-704']['name'])) {
            echo '{}';
            return;
        }
        for ($i = 0; $i < count($_FILES['kartik-input-704']['name']); $i++) {
            $j = $i + 1;
            $key = '<code to parse your image key>';
            $url = '<your server action to delete the file>';
            $p1[$i] = "http://path.to.uploaded.file/{$key}.jpg"; // sends the data
            $p2[$i] = ['caption' => "Animal-{$j}.jpg", 'size' => 732762, 'width' => '120px', 'url' => $url, 'key' => $key];
        }
        echo json_encode([
            'initialPreview' => $p1,
            'initialPreviewConfig' => $p2,
            'append' => true // whether to append these configurations to initialPreview.
                // if set to false it will overwrite initial preview
                // if set to true it will append to initial preview
                // if this propery not set or passed, it will default to true.
        ]);
    }

    public function doUpload() {
        header('Content-Type: application/json;charset=utf-8');
        $nameArrayImages = "file";
        $p1 = $p2 = [];
        if (!empty($_FILES)) {
            $config['upload_path'] = "./uploads";
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload');

            $files = $_FILES;
            $number_of_files = count($_FILES[$nameArrayImages]['name']);
            $errors = 0;

            // codeigniter upload just support one file
            // to upload. so we need a litte trick
            for ($i = 0; $i < $number_of_files; $i++) {
                $_FILES[$nameArrayImages]['name'] = $files[$nameArrayImages]['name'][$i];
                $_FILES[$nameArrayImages]['type'] = $files[$nameArrayImages]['type'][$i];
                $_FILES[$nameArrayImages]['tmp_name'] = $files[$nameArrayImages]['tmp_name'][$i];
                $_FILES[$nameArrayImages]['error'] = $files[$nameArrayImages]['error'][$i];
                $_FILES[$nameArrayImages]['size'] = $files[$nameArrayImages]['size'][$i];
                
                // we have to initialize before upload
                $this->upload->initialize($config);

                if (!$this->upload->do_upload("file")) {
                    $errors++;
                } else{
                    $upload_data = $this->upload->data();
                    
                    $j = $i + 1;
                    $key = $upload_data['file_name'];
                    $url = base_url('welcome/deleteImage');
                    $p1[$i] = base_url('uploads/'.$key); // sends the data
                    $p2[$i] = ['caption' => $upload_data['raw_name'], 'size' => $upload_data['file_size'], 'width' => $upload_data['image_width'], 'url' => $url, 'key' => $key];
                }
            }

            if ($errors > 0) {
                echo '{}';
                return;
            } else{
                echo json_encode([
                    'initialPreview' => $p1,
                    'initialPreviewConfig' => $p2,
                    'append' => true // whether to append these configurations to initialPreview.
                        // if set to false it will overwrite initial preview
                        // if set to true it will append to initial preview
                        // if this propery not set or passed, it will default to true.
                ]);
            }
        }else {
            
            echo '{}';
            return;
        }
    }
    
    public function deleteImage(){
        $folderContainerImage = "uploads";
        $key = $this->input->post('key');
        unlink(dirname(__FILE__).'/../../'.$folderContainerImage."/".$key);
        echo 0;
    }
}
