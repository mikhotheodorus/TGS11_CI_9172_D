<?php

    defined('BASEPATH') OR exit('No direct script access allowed');


    class KendaraanModel extends CI_Model {
        private $table = 'layanan';
        public $id;
        public $name;
        public $price;
        public $type;
        public $created_at;
        public $rule = [
            [
                'field' => 'name',
                'label' => 'name',
                'rules' => 'required'
            ],
            [
                'field' => 'price',
                'label' => 'price',
                'rules' => 'required'
            ],
            [
                'field' => 'type',
                'label' => 'type',
                'rules' => 'required'
            ],
        ];


        public function Rules() {
            return $this->rule;
        }


        public function getAll() {
            $this->db->get('data_mahasiswa')->result();
        }


        public function store($request) {
            $this->name = $request->name;
            $this->price = $request->price;
            $this->type = $request->type;
            $this->created_at = date('Y-m-d H:i:s');
            echo $created_at;
            //$this->password = password_hash($request->password, PASSWORD_BCRYPT);

            if ($this->db->insert($this->table, $this)) {
                return [
                    'msg' => 'Berhasil',
                    'error' => FALSE,
                ];
            }

            return [
                'msg' => 'Gagal',
                'error' => TRUE,
            ];
        }


        public function update($request, $id) {
            $updateData = [
                'price' => $request->price,
                'type' => $request->type,
                'name' => $request->name
            ];

            if ($this->db->where('id', $id)->update($this->table, $updateData)) {
                return [
                    'msg' => 'Berhasil',
                    'error' => FALSE,
                ];
            }

            return [
                'msg' => 'Gagal',
                'error' => TRUE,
            ];
        }


        public function destroy($id) {
            if (empty($this->db->select('*')->where(array('id' => $id))->get($this->table)->row())) {
                return [
                    'msg' => 'ID Tidak Ditemukan!',
                    'error' => TRUE,
                ];
            }
            
            if ($this->db->delete($this->table, array('id' => $id))) {
                return [
                    'msg' => 'Berhasil',
                    'error' => FALSE,
                ];
            }

            return [
                'msg' => 'Gagal',
                'error' => TRUE,
            ];
        }
    }
?>