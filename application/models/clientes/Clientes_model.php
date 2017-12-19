<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getClientesModel($Data, $limite = null, $inicio = null)
    {

        if (isset($Data['where'])) {
            $this->db->where($Data['where']);
        }
        if ($Data['like'] != "") {
            $this->db->like("cliente_nomefantasia",$Data['like']);
            $this->db->or_like("cliente_cnpj",$Data['like']);
        }
        if(isset($limite)){
            $this->db->limit($limite,$inicio);
        }

        return $this->db->get("tb_clientes");

    }

    public function createClienteModel($Data)
    {

        $this->db->insert('tb_clientes', $Data);
        return $this->db->insert_id();


    }

    public function createUserCliente($Data, $cnpj){

        $this->load->library('fo_login');

        $this->db->insert('tb_user_cliente', $Data);

        $passTocrypt = $cnpj."nccinco"."123";

        var_dump($passTocrypt);

        $pass = $this->fo_login->encrypt_password($passTocrypt);

        $DataPass = array(
            "user_id_fk" => $this->db->insert_id(),
            "user_pass" =>  $pass,
            "user_name" => $Data['user_email'],
            "user_status" => "1"
    );
        return $this->db->insert('tb_user_cliente_data', $DataPass);

    }

    public function getClientesCreateModel($id)
    {

            $this->db->where("cliente_id", $id);

        return $this->db->get("tb_clientes");

    }

}
