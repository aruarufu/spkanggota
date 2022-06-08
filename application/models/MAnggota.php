<?php
/**
 * Created by PhpStorm.
 * User: sankester
 * Date: 11/05/2017
 * Time: 15:51
 */

class MAnggota extends CI_Model{

    public $kdAnggota;
    public $anggota;

    public function __construct(){
        parent::__construct();
    }

    private function getTable(){
        return 'anggota';
    }

    private function getData(){
        $data = array(
            'anggota' => $this->anggota
        );

        return $data;
    }

    public function getAll()
    {
        $anggota = array();
        $query = $this->db->get($this->getTable());
        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $anggota[] = $row;
            }
        }
        return $anggota;
    }


    public function insert()
    {
        $this->db->insert($this->getTable(), $this->getData());
        return $this->db->insert_id();
    }

    public function update($where)
    {
        $status = $this->db->update($this->getTable(), $this->getData(), $where);
        return $status;

    }

    public function delete($id)
    {
        $this->db->where('kdAnggota', $id);
        return $this->db->delete($this->getTable());
    }

    public function getLastID(){
        $this->db->select('kdAnggota');
        $this->db->order_by('kdAnggota', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get($this->getTable());
        return $query->row();
    }


}