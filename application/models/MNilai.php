<?php

/**
 * Created by PhpStorm.
 * User: sankester
 * Date: 11/05/2017
 * Time: 15:53
 */
class MNilai extends CI_Model{

    public $kdAnggota;
    public $kdKriteria;
    public $nilai;

    public function __construct(){
        parent::__construct();
    }

    private function getTable()
    {
        return 'nilai';
    }

    private function getData()
    {
        $data = array(
            'kdAnggota' => $this->kdAnggota,
            'kdKriteria' => $this->kdKriteria,
            'nilai' => $this->nilai
        );

        return $data;
    }

    public function insert()
    {
        $status = $this->db->insert($this->getTable(), $this->getData());
        return $status;
    }

    public function getNilaiByUniveristas($id)
    {
        $query = $this->db->query(
            'select u.kdAnggota, u.anggota, k.kdKriteria, n.nilai from anggota u, nilai n, kriteria k, subkriteria sk where u.kdAnggota = n.kdAnggota AND k.kdKriteria = n.kdKriteria and k.kdKriteria = sk.kdKriteria and u.kdAnggota = '.$id.' GROUP by n.nilai '
        );
        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $nilai[] = $row;
            }

            return $nilai;
        }
    }

    public function getNilaiUniveristas()
    {
        $query = $this->db->query(
            'select u.kdAnggota, u.anggota, k.kdKriteria, k.kriteria ,n.nilai from anggota u, nilai n, kriteria k where u.kdAnggota = n.kdAnggota AND k.kdKriteria = n.kdKriteria '
        );
        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $nilai[] = $row;
            }

            return $nilai;
        }
    }

    public function update()
    {
        $data = array('nilai' => $this->nilai);
        $this->db->where('kdAnggota', $this->kdAnggota);
        $this->db->where('kdKriteria', $this->kdKriteria);
        $this->db->update($this->getTable(), $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('kdAnggota', $id);
        return $this->db->delete($this->getTable());
    }
}