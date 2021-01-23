<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_terima_pelanggan_metode_bayar extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_terima_pelanggan_metode_bayar');
    $this->load->model('m_t_ak_faktur_penjualan');
    $this->load->model('m_ak_m_coa');
  }

  public function index($id,$pks_id)
  {
    $data = [
      "c_t_ak_terima_pelanggan_metode_bayar" => $this->m_t_ak_terima_pelanggan_metode_bayar->select($id),
      "terima_pelanggan_id" => $id,
      "no_akun_option" => $this->m_ak_m_coa->select_no_akun(),
      "select_no_faktur" => $this->m_t_ak_faktur_penjualan->select_no_faktur(),
      "pks_id" => $pks_id,
      "title" => "Rincian Diskon",
      "description" => "Isi Rincian Diskon"
    ];
    $this->render_backend('template/backend/pages/t_ak_terima_pelanggan_metode_bayar', $data);
  }

  


  public function delete($id,$terima_pelanggan_id,$pks_id)
  {
    $this->m_t_ak_terima_pelanggan_metode_bayar->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data User Berhasil Dihapus!</p></div>');

    redirect('c_t_ak_terima_pelanggan_metode_bayar/index/'.$terima_pelanggan_id.'/'.$pks_id);
  }



  function tambah($terima_pelanggan_id,$pks_id)
  {
    $jumlah = intval($this->input->post("jumlah"));
    $coa_id = intval($this->input->post("coa_id"));

   

    $data = array(
      'TERIMA_PELANGGAN_ID' => $terima_pelanggan_id,
      'COA_ID' => $coa_id,
      'JUMLAH' => $jumlah,
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username')
    );

    $this->m_t_ak_terima_pelanggan_metode_bayar->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_ak_terima_pelanggan_metode_bayar/index/'.$terima_pelanggan_id.'/'.$pks_id);
  }





}
