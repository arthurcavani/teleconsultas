<?php
require_once("config.php");
require_once("DB.class.php");
require_once("CRUD.class.php");

class Medico
{
    private $id_usuario;
    private $crm;
    private $especialidade;

    public function loadById($id)
    {
        $row = CRUD::SelectExtra("SELECT * FROM medico WHERE id_usuario = $id");

        if ($row['num'] > 0) {

            foreach ($row['dados'] as $medico) {
                $this->setId_usuario($medico['id_usuario']);
                $this->setCrm($medico['crm']);
                $this->setEspecialidade($medico['especialidade']);
            }
        }
    }

    public static function ListarMedicos(){
        $row = CRUD::SelectExtra("SELECT * FROM medico");
        return $row;
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
     * Get the value of especialidade
     */ 
    public function getEspecialidade()
    {
        return $this->especialidade;
    }

    /**
     * Set the value of especialidade
     *
     * @return  self
     */ 
    public function setEspecialidade($especialidade)
    {
        $this->especialidade = $especialidade;

        return $this;
    }

    /**
     * Get the value of crm
     */ 
    public function getCrm()
    {
        return $this->crm;
    }

    /**
     * Set the value of crm
     *
     * @return  self
     */ 
    public function setCrm($crm)
    {
        $this->crm = $crm;

        return $this;
    }
}
