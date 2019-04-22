<?php
class Login extends CI_Controller{
 
    function __construct(){
        parent::__construct();		
        $this->load->model('m_login');

    }

    function index(){
        $this->load->view('login');
    }

    function aksi_login(){
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        
        $where_admin = array(
            'admin_username' => $username,
            'admin_password' => $password
        );

        $where_guru = array(
            'guru_username' => $username,
            'guru_password' => $password
        );

        $where_siswa = array(
            'siswa_username' => $username,
            'siswa_password' => $password
        );

        $cek_admin  = $this->m_login->cek_login("admin",$where_admin)->num_rows();
        $cek_guru   = $this->m_login->cek_login("guru",$where_guru)->num_rows();
        $cek_siswa  = $this->m_login->cek_login("siswa",$where_siswa)->num_rows();

        if ( $cek_admin > 0 ) {
            # code...
            $data_session = array(
                'nama' => $username,
                'status' => "login"
            );
        
            $this->session->set_userdata($data_session);
        
            redirect(base_url("admin"));
        }

        elseif ( $cek_guru > 0 ) {
            # code...
            $data_session = array(
                'nama' => $username,
                'status' => "login"
            );
        
            $this->session->set_userdata($data_session);
        
            redirect(base_url("admin/guru"));
        }

        elseif ( $cek_siswa > 0 ) {
            # code...
            $data_session = array(
                'nama' => $username,
                'status' => "login"
            );
        
            $this->session->set_userdata($data_session);
        
            redirect(base_url("admin/siswa"));
        }

        else{
            // login error
            // redirect(base_url("login-error"));
            $this->load->view('login_error');
        }
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }
}