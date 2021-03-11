<?php defined('BASEPATH') OR exit('No direct script access allowed');
    require_once 'application/core/MY_Model_Interface.php';

    abstract class MY_Model extends CI_Model implements MY_Model_Interface{

        public function __construct(){
            parent::__construct();
            $this->load->database();
        }

        private function insert(){
            $this->db->insert($this->get_db_table(), $this);
            $this->{$this->get_db_table_pk()} = $this->db->insert_id();
            return $this->{$this->get_db_table_pk()};
        }

        private function update(){
            $this->db->update($this->get_db_table(), $this, array(
                $this->get_db_table_pk() => $this->{$this->get_db_table_pk()}
            ));
            return $this->{$this->get_db_table_pk()};
        }

        private function save(){
            if (isset($this->{get_db_table_pk()})) {
                $id = $this->update();
            } else {
                $id = $this->insert();
            }
        }

        private function delete(){
            $this->db->delete($this->get_db_table(), array(
                $this->get_db_table_pk() => $this->{$this->get_db_table_pk()};
            ));
            return $this->{$this->get_db_table_pk()};
        }

        private function getData(){
            return $this->db->select(*)
                ->from($this->get_db_table())
                ->get()
                ->result()
        }
    }