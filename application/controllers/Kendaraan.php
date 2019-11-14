<?php

    use Restserver \Libraries\REST_Controller;

    class Kendaraan extends REST_Controller {
        public function __construct() {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE');
            header('Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding');

            parent::__construct();
            $this->load->model('KendaraanModel');
            $this->load->library('form_validation');
        }

        
        public function index_get() {
            return $this->returnData($this->db->get('layanan')->result(), false);
        }


        public function index_post($id = null) {
            $validation = $this->form_validation;
            $rule = $this->KendaraanModel->rules();

            if ($id == null) {
                array_push($rule, [
                    'field' => 'name',
                    'label' => 'name',
                    'rules' => 'required'
                ],
                [
                    'field' => 'price',
                    'label' => 'price',
                    'rules' => 'required|is_unique[layanan.price]|numeric'    
                ],
                [
                'field' => 'type',
                'label' => 'type',
                'rules' => 'required']);
            } 

            $validation->set_rules($rule);

            if (!$validation->run()) 
                return $this->returnData($this->form_validation->error_array(), true);
            
            $Kendaraan = new KendaraanData();
            $Kendaraan->name = $this->post('name');
            $Kendaraan->price = $this->post('price');
            $Kendaraan->type = $this->post('type');
            $Kendaraan->created_at = $this->post('created_at');


            if ($id == null) 
                $response = $this->KendaraanModel->store($Kendaraan);
            else 
                $response = $this->KendaraanModel->update($Kendaraan, $id);

            return $this->returnData($response['msg'], $response['error']);
        }


        public function index_delete($id = null) {
            if ($id == null)
                return $this->returnData('Parameter ID Tidak Ditemukan', true);

            $response = $this->KendaraanModel->destroy($id);
            return $this->returnData($response['msg'], $response['error']);
        }

        public function returnData($msg, $error) {
            $response['error'] = $error;
            $response['message'] = $msg;

            return $this->response($response);
        }
    }


    class KendaraanData {
        public $name;
        public $price;
        public $type;
        public $created_at;
    }

?>