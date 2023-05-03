<?php
require_once("config.php");
require_once("DB.class.php");
require_once("CRUD.class.php");
class Endereco
{

    private $id;
    private $cidade;
    private $uf;
    private $cep;
    private $logradouro;
    private $numero;
    private $complemento;
    private $id_usuario;  

    public function loadById($id)
    {

        $row = CRUD::SelectExtra("SELECT * FROM endereco WHERE id = $id");

        if (count($row) > 0) {

            foreach ($row['dados'] as $endereco) {
                $this->setId($endereco['id']);
                $this->setLogradouro($endereco['logradouro']);
                $this->setNumero($endereco['numero']);
                $this->setCep($endereco['cep']);
                $this->setId_usuario($endereco['id_usuario']);
                $this->setCidade($endereco['cidade']);
                $this->setUf($endereco['uf']);
                $this->setComplemento($endereco['complemento']);
            }
        } else
            return false;
    }

    public static function loadByUser($id)
    {
        $row = CRUD::SelectOne('endereco', 'id_usuario', $id);
        $ends = array();
        $i = 0;
        foreach ($row['dados'] as $item) {
            $ends[$i] = $item['id'];
            $i++;
        }
        return $ends;
    }

    public static function lastIn()
    {
        $ultimo = CRUD::LastId();
        return $ultimo;
    }


    public static function novoEndereco($logradouro, $numero, $cep, $id_usuario, $cidade, $uf, $complemento)
    {
        $newid = CRUD::InsertAjax("endereco", "logradouro = \"$logradouro\", numero = \"$numero\", cep = \"$cep\",
        id_usuario = \"$id_usuario\", cidade = \"$cidade\", uf = \"$uf\", complemento = \"$complemento\"");

        return $newid;
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
     * Get the value of logradouro
     */
    public function getLogradouro()
    {
        return $this->logradouro;
    }

    /**
     * Set the value of logradouro
     *
     * @return  self
     */
    public function setLogradouro($logradouro)
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    /**
     * Get the value of numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of cep
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * Set the value of cep
     *
     * @return  self
     */
    public function setCep($cep)
    {
        $this->cep = $cep;

        return $this;
    }

    /**
     * Get the value of cidade
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * Set the value of cidade
     *
     * @return  self
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get the value of estado
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * Set the value of estado
     *
     * @return  self
     */
    public function setUf($uf)
    {
        $this->uf = $uf;

        return $this;
    }

    /**
     * Get the value of complemento
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * Set the value of complemento
     *
     * @return  self
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;

        return $this;
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
}
