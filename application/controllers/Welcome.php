<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        $this->load->view('multiupload', array('error' => ''));
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
