<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Obat extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Obat_model');
	}
	public function index()
	{
		$data['judul'] = "Halaman obat";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['obat'] = $this->Obat_model->get();
		$this->load->view("Layout/header", $data);
		$this->load->view("obat/vw_obat", $data);
		$this->load->view("Layout/footer", $data);
	}
	public function tambah()
	{
		$data['judul'] = "Halaman Tambah Obat";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data['obat'] = $this->Obat_model->get();
		$this->form_validation->set_rules('nama', 'Nama obat', 'required', [
			'required' => 'Nama obat Wajib di isi'
		]);
		$this->form_validation->set_rules('harga', 'Harga', 'required', [
			'required' => 'Harga obat Wajib di isi'
		]);
		$this->form_validation->set_rules('stok', 'Stok', 'required', [
			'required' => 'Stok obat Wajib di isi'
		]);

		if ($this->form_validation->run() == false) {
			$this->load->view("layout/header", $data);
			$this->load->view("obat/vw_tambah_obat", $data);
			$this->load->view("layout/footer");
		} else {
			$data = [
				'nama' => $this->input->post('nama'),
				'harga' => $this->input->post('harga'),
				'stok' => $this->input->post('stok'),
			];
        $upload_image = $_FILES['gambar']['name'];
        if ($upload_image) {
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/img/obat/';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('gambar')) {
                $new_image = $this->upload->data('file_name');
                $this->db->set('gambar', $new_image);
            } else {
                echo $this->upload->display_errors();
            }
        }
			$this->Obat_model->insert($data);
			$this->session->set_flashdata('message', '<div class="alert alert-success"
	role="alert">Data obat Berhasil Ditambah!</div>');
			redirect('Obat');
		}
	}
	public function edit($id)
	{
		$data['judul'] = "Halaman Edit Obat";
		$data['obat'] = $this->Obat_model->getById($id);
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$this->form_validation->set_rules('nama', 'Nama obat', 'required', [
			'required' => 'Nama obat Wajib di isi'
		]);
		$this->form_validation->set_rules('harga', 'Harga', 'required', [
			'required' => 'Harga obat Wajib di isi'
		]);
		$this->form_validation->set_rules('stok', 'Stok', 'required', [
			'required' => 'Jumlah Stok Wajib di isi'
		]);
		if ($this->form_validation->run() == false) {
			$this->load->view("layout/header", $data);
			$this->load->view("obat/vw_ubah_obat", $data);
			$this->load->view("layout/footer");
		} else {
			$data = [
				'nama' => $this->input->post('nama'),
				'stok' => $this->input->post('stok'),
				'harga' => $this->input->post('harga'),
			];
            $upload_image = $_FILES['gambar']['name'];
            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/obat/';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('gambar')) {
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('gambar', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }
			$id = $this->input->post('id');
            $this->Obat_model->update(['id' => $id],$data, $upload_image);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data obat Berhasil Ubah!</div>');
            redirect('Obat');
		}
	}
	public function detail($id)
	{
		$data['judul'] = "Halaman Detail obat";
		$data['obat'] = $this->Obat_model->getById($id);
		$this->load->view("Layout/header", $data);
		$this->load->view("obat/vw_detail_obat", $data);
		$this->load->view("Layout/footer");
	}
	public function hapus($id)
	{
		$this->Obat_model->delete($id);
        $error = $this->db->error();
        if ($error['code'] != 0) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"><i class="icon fas fa-info-circle"></i>Data obat tidak dapat dihapus!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><i class="icon fas fa-check-circle"></i>Data obat Berhasil Dihapus!</div>');
        }
        redirect('Obat');
    }
}