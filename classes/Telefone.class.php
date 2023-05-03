<?php
require_once("config.php");
require_once("DB.class.php");
require_once("CRUD.class.php");

class Telefone
{

    private $id; //    
    private $id_usuario;
    private $tel; //    

    public function loadById($id)
    {
        $row = CRUD::SelectExtra("SELECT * FROM telefone WHERE id = $id");

        if ($row['num'] > 0) {

            foreach ($row['dados'] as $telefone) {
                $this->setId($telefone['id']);
                $this->setId_usuario($telefone['id_usuario']);
                $this->setTel($telefone['tel']);
            }
        }
    }

    public function loadByIdUser($iduser)
    {
        $row = CRUD::SelectExtra("SELECT * FROM telefone WHERE id_usuario = $iduser");

        if ($row['num'] > 0) {

            foreach ($row['dados'] as $telefone) {
                $this->setId($telefone['id']);
                $this->setId_usuario($telefone['id_usuario']);
                $this->setTel($telefone['tel']);
            }
        }
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }



    /**
     * Get the value of id_usuario
     */
    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     *
     * @return  self
     */
    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    /**
     * Get the value of tel
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set the value of tel
     *
     * @return  self
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }
}
