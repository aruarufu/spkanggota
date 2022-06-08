<?php
/**
 * Created by PhpStorm.
 * User: sankester
 * Date: 11/05/2017
 * Time: 15:42
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Anggota extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->page->setTitle('Anggota');
        $this->load->model('MKriteria');
        $this->load->model('MSubKriteria');
        $this->load->model('MAnggota');
        $this->load->model('MNilai');
        $this->page->setLoadJs('assets/js/anggota');
    }

    public function index()
    {
        $data['anggota'] = $this->MAnggota->getAll();
        loadPage('anggota/index', $data);
    }

    public function tambah($id = null)
    {

        if ($id == null) {
            if (count($_POST)) {
                $this->form_validation->set_rules('anggota', '', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $errors = $this->form_validation->error_array();
                    $this->session->set_flashdata('errors', $errors);
                    redirect(current_url());
                } else {

                    $anggota = $this->input->post('anggota');
                    $nilai = $this->input->post('nilai');

                    $this->MAnggota->anggota = $anggota;
                    if ($this->MAnggota->insert() == true) {
                        $success = false;
                        $kdAnggota = $this->MAnggota->getLastID()->kdAnggota;
                        foreach ($nilai as $item => $value) {
                            $this->MNilai->kdAnggota = $kdAnggota;
                            $this->MNilai->kdKriteria = $item;
                            $this->MNilai->nilai = $value;
                            if ($this->MNilai->insert()) {
                                $success = true;
                            }
                        }
                        if ($success == true) {
                            $this->session->set_flashdata('message', 'Berhasil menambah data :)');
                            redirect('anggota');
                        } else {
                            echo 'gagal';
                        }
                    }
                }
                //-----
            }else{
                $data['dataView'] = $this->getDataInsert();
                loadPage('anggota/tambah', $data);
            }
        }else{
            if(count($_POST)){
                $kdAnggota = $this->uri->segment(3, 0);
                dump($kdAnggota);
                if($kdAnggota > 0){
                    $anggota = $this->input->post('anggota');
                    $nilai = $this->input->post('nilai');
                    $where = array('kdAnggota' => $kdAnggota);
                    $this->MAnggota->anggota = $anggota;
                    dump($anggota);
                    if($this->MAnggota->update($where) == true){
                        $success = false;
                        foreach ($nilai as $item => $value) {
                            $this->MNilai->kdAnggota = $kdAnggota;
                            $this->MNilai->kdKriteria = $item;
                            $this->MNilai->nilai = $value;
                            if ($this->MNilai->update()) {
                                $success = true;
                            }
                        }
                        if ($success == true) {
                            $this->session->set_flashdata('message', 'Berhasil mengubah data :)');
                            redirect('anggota');
                        } else {
                            echo 'gagal';
                        }
                    }
                }
            }
            $data['dataView'] = $this->getDataInsert();
            $data['nilaiAnggota'] = $this->MNilai->getNilaiByUniveristas($id);
            loadPage('anggota/tambah', $data);
        }

    }

    private function getDataInsert()
    {
        $dataView = array();
        $kriteria = $this->MKriteria->getAll();
        foreach ($kriteria as $item) {
            $this->MSubKriteria->kdKriteria = $item->kdKriteria;
            $dataView[$item->kdKriteria] = array(
                'nama' => $item->kriteria,
                'data' => $this->MSubKriteria->getById()
            );
        }

        return $dataView;
    }

    public function delete($id)
    {
        if($this->MNilai->delete($id) == true){
            if($this->MAnggota->delete($id) == true){
                $this->session->set_flashdata('message','Berhasil menghapus data :)');
                echo json_encode(array("status" => 'true'));
            }
        }
    }
}