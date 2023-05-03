<?php
require_once("config.php");
require_once("DB.class.php");
require_once("CRUD.class.php");

class Paciente
{
    private $id_usuario;
    private $id_estadocivil;
    private $id_profissao;
    private $nacionalidade;


    private static function crip($senha)
    {
        $senhacrip = sha1($senha);
        return $senhacrip;
    }



    public function loadById($id)
    {
        $row = CRUD::SelectExtra("SELECT * FROM paciente WHERE id_usuario = $id");

        if ($row['num'] > 0) {

            foreach ($row['dados'] as $paciente) {
                $this->setId_usuario($paciente['id_usuario']);
                $this->setId_estadocivil($paciente['id_estadocivil']);
                $this->setId_profissao($paciente['id_profissao']);
                $this->setNacionalidade($paciente['nacionalidade']);
            }
        } else {
            $this->setId_usuario(-1);
        }
    }

    public static function ListaPacientes(){
        $row = CRUD::SelectExtra("SELECT * FROM paciente AS P JOIN usuario AS U ON P.id_usuario = U.id");
        return $row;
    }

    public static function getEcivilString($id)
    {
        $query = CRUD::SelectExtra("SELECT * FROM estadocivil WHERE id = $id");
        return $query['dados']['0']['ec'];
    }
    
    public static function getProfString($id)
    {
        $query = CRUD::SelectExtra("SELECT * FROM profissao WHERE id = $id");
        return $query['dados']['0']['prof'];
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
     * Get the value of id_estadocivil
     */ 
    public function getId_estadocivil()
    {
        return $this->id_estadocivil;
    }

    /**
     * Set the value of id_estadocivil
     *
     * @return  self
     */ 
    public function setId_estadocivil($id_estadocivil)
    {
        $this->id_estadocivil = $id_estadocivil;

        return $this;
    }

    /**
     * Get the value of id_profissao
     */ 
    public function getId_profissao()
    {
        return $this->id_profissao;
    }

    /**
     * Set the value of id_profissao
     *
     * @return  self
     */ 
    public function setId_profissao($id_profissao)
    {
        $this->id_profissao = $id_profissao;

        return $this;
    }

    /**
     * Get the value of nacionalidade
     */ 
    public function getNacionalidade()
    {
        return $this->nacionalidade;
    }

    /**
     * Set the value of nacionalidade
     *
     * @return  self
     */ 
    public function setNacionalidade($nacionalidade)
    {
        $this->nacionalidade = $nacionalidade;

        return $this;
    }
}
