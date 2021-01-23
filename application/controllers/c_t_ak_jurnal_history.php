<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_t_ak_jurnal_history extends MY_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('m_t_ak_jurnal_history');
    $this->load->model('m_t_ak_jurnal_edit');
    $this->load->model('m_ak_m_coa');
    $this->load->model('m_ak_m_family');
    $this->load->model('m_ak_m_type');
  }


  public function index()
  {
    $this->m_t_ak_jurnal_history->delete_created_by();
    $data = [
      "c_t_ak_jurnal_history" => $this->m_t_ak_jurnal_history->select($this->session->userdata('date_from_select_jurnal'),$this->session->userdata('date_to_select_jurnal'),$this->session->userdata('coa_id_jurnal_history')),
      "no_akun_option" => $this->m_ak_m_coa->select_no_akun(),
      "c_ak_m_family" => $this->m_ak_m_family->select(),
      "c_ak_m_type" => $this->m_ak_m_type->select(),
      "title" => "History Detail Jurnal",
      "description" => ""
    ];
    $this->render_backend('template/backend/pages/t_ak_jurnal_history', $data);
  }

  public function search_date()
  {
    $date_from_select_jurnal = ($this->input->post("date_from_select_jurnal"));
    $this->session->set_userdata('date_from_select_jurnal', $date_from_select_jurnal);

    $date_to_select_jurnal = ($this->input->post("date_to_select_jurnal"));
    $this->session->set_userdata('date_to_select_jurnal', $date_to_select_jurnal);

    $coa_id_jurnal_history = ($this->input->post("coa_id_jurnal_history"));
    $this->session->set_userdata('coa_id_jurnal_history', $coa_id_jurnal_history);


    
    redirect('/c_t_ak_jurnal_history');
  }


  public function delete($id)
  {
    $this->m_t_ak_jurnal_history->delete($id);
    $this->session->set_flashdata('notif', '<div class="alert alert-danger icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="icofont icofont-close-line-circled"></i></button><p><strong>Success!</strong> Data User Berhasil Dihapus!</p></div>');
    redirect('/c_t_ak_jurnal_history');
  }



  function tambah()
  {
    $coa_id = ($this->input->post("coa_id"));


    $debit = intval($this->input->post("debit"));
    $kredit = intval($this->input->post("kredit"));
    $catatan = ($this->input->post("catatan"));
    $departemen = ($this->input->post("departemen"));
    $no_voucer = ($this->input->post("no_voucer"));



//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'DATE' => date('Y-m-d'),
      'TIME' => date('H:i:s'),
      'CREATED_BY' => $this->session->userdata('username'),
      'UPDATED_BY' => $this->session->userdata('username'),
      'COA_ID' => $coa_id,
      'DEBIT' => $debit,
      'KREDIT' => $kredit,
      'CATATAN' => $catatan,
      'DEPARTEMEN' => $departemen,
      'NO_VOUCER' => $no_voucer
      
    );

    $this->m_t_ak_jurnal_history->tambah($data);

    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Ditambahkan!</strong></p></div>');
    redirect('c_t_ak_jurnal_history');
  }

  function move($created_id)
  {
    $read_select = $this->m_t_ak_jurnal_history->select_created_id($created_id);
    foreach ($read_select as $key => $value) 
    {

      $data = array(
        'ID' => $value->ID,
        'DATE' => date('Y-m-d'),
        'TIME' => date('H:i:s'),
        'CREATED_BY' => $this->session->userdata('username'),
        'UPDATED_BY' => $this->session->userdata('username'),
        'COA_ID' => $value->COA_ID,
        'DEBIT' => $value->DEBIT,
        'KREDIT' => $value->KREDIT,
        'CATATAN' => $value->CATATAN,
        'DEPARTEMEN' => $value->DEPARTEMEN,
        'NO_VOUCER' => $value->NO_VOUCER,
        'CREATED_ID' => $created_id
        
      );
      $this->m_t_ak_jurnal_edit->tambah($data);

    }
    redirect('c_t_ak_jurnal_edit');
  }




  public function edit_action()
  {
    $id = $this->input->post("id");


    $debit = intval($this->input->post("debit"));
    $kredit = intval($this->input->post("kredit"));
    $catatan = ($this->input->post("catatan"));
    $departemen = ($this->input->post("departemen"));
    $no_voucer = ($this->input->post("no_voucer"));



//Dikiri nama kolom pada database, dikanan hasil yang kita tangkap nama formnya.
    $data = array(
      'DATE' => date('Y-m-d'),
      'TIME' => date('H:i:s'),
      'UPDATED_BY' => $this->session->userdata('username'),
      'DEBIT' => $debit,
      'KREDIT' => $kredit,
      'CATATAN' => $catatan,
      'DEPARTEMEN' => $departemen,
      'NO_VOUCER' => $no_voucer
      
    );

    $this->m_t_ak_jurnal_history->update($data, $id);
    $this->session->set_flashdata('notif', '<div class="alert alert-info icons-alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"> <i class="icofont icofont-close-line-circled"></i></button><p><strong>Data User Berhasil Diupdate!</strong></p></div>');
    redirect('/c_t_ak_jurnal');
  }

}
