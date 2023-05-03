<?php
require_once("config.php");
require_once("DB.class.php");
require_once("CRUD.class.php");

class Disponibilidade
{

    private $id_medico;
    private $duracao_consulta;
    private $primeira_consulta;
    private $ultima_consulta;
    private $inicio_pausa;
    private $fim_pausa;
    private $seg;
    private $ter;
    private $qua;
    private $qui;
    private $sex;
    private $sab;
    private $dom;

    public function loadById($id)
    {
        $row = CRUD::SelectExtra("SELECT * FROM disponibilidade WHERE id_medico = $id");

        if ($row['num'] > 0) {

            foreach ($row['dados'] as $disp) {
                $this->setId_medico($disp['id_medico']);
                $this->setDuracao_consulta($disp['duracao_consulta']);
                $this->setPrimeira_consulta($disp['primeira_consulta']);
                $this->setUltima_consulta($disp['ultima_consulta']);
                $this->setInicio_pausa($disp['inicio_pausa']);
                $this->setFim_pausa($disp['fim_pausa']);
                $this->setSeg($disp['seg']);
                $this->setTer($disp['ter']);
                $this->setQua($disp['qua']);
                $this->setQui($disp['qui']);
                $this->setSex($disp['sex']);
                $this->setSab($disp['sab']);
                $this->setDom($disp['dom']);
            }
        } else {
            $this->setId_medico(-1);
        }
    }

    /**
     * Get the value of id_medico
     */
    public function getId_medico()
    {
        return $this->id_medico;
    }

    /**
     * Set the value of id_medico
     *
     * @return  self
     */
    public function setId_medico($id_medico)
    {
        $this->id_medico = $id_medico;

        return $this;
    }

    /**
     * Get the value of duracao_consulta
     */
    public function getDuracao_consulta()
    {
        return $this->duracao_consulta;
    }

    /**
     * Set the value of duracao_consulta
     *
     * @return  self
     */
    public function setDuracao_consulta($duracao_consulta)
    {
        $this->duracao_consulta = $duracao_consulta;

        return $this;
    }

    /**
     * Get the value of primeira_consulta
     */
    public function getPrimeira_consulta()
    {
        $arraypc = explode(":", $this->primeira_consulta);
        $pc = $arraypc[0] . ":" . $arraypc[1];
        return $pc;
    }

    /**
     * Set the value of primeira_consulta
     *
     * @return  self
     */
    public function setPrimeira_consulta($primeira_consulta)
    {
        $this->primeira_consulta = $primeira_consulta;

        return $this;
    }

    /**
     * Get the value of ultima_consulta
     */
    public function getUltima_consulta()
    {
        $arrayuc = explode(":", $this->ultima_consulta);
        $uc = $arrayuc[0] . ":" . $arrayuc[1];
        return $uc;
    }

    /**
     * Set the value of ultima_consulta
     *
     * @return  self
     */
    public function setUltima_consulta($ultima_consulta)
    {
        $this->ultima_consulta = $ultima_consulta;

        return $this;
    }

    /**
     * Get the value of inicio_pausa
     */
    public function getInicio_pausa()
    {
        $arrayip = explode(":", $this->inicio_pausa);
        $ip = $arrayip[0] . ":" . $arrayip[1];
        return $ip;
    }

    /**
     * Set the value of inicio_pausa
     *
     * @return  self
     */
    public function setInicio_pausa($inicio_pausa)
    {
        $this->inicio_pausa = $inicio_pausa;

        return $this;
    }

    /**
     * Get the value of fim_pausa
     */
    public function getFim_pausa()
    {
        $arrayfp = explode(":", $this->fim_pausa);
        $fp = $arrayfp[0] . ":" . $arrayfp[1];
        return $fp;
    }

    /**
     * Set the value of fim_pausa
     *
     * @return  self
     */
    public function setFim_pausa($fim_pausa)
    {
        $this->fim_pausa = $fim_pausa;

        return $this;
    }

    /**
     * Get the value of seg
     */
    public function getSeg()
    {
        return $this->seg;
    }

    /**
     * Set the value of seg
     *
     * @return  self
     */
    public function setSeg($seg)
    {
        $this->seg = $seg;

        return $this;
    }

    /**
     * Get the value of ter
     */
    public function getTer()
    {
        return $this->ter;
    }

    /**
     * Set the value of ter
     *
     * @return  self
     */
    public function setTer($ter)
    {
        $this->ter = $ter;

        return $this;
    }

    /**
     * Get the value of qua
     */
    public function getQua()
    {
        return $this->qua;
    }

    /**
     * Set the value of qua
     *
     * @return  self
     */
    public function setQua($qua)
    {
        $this->qua = $qua;

        return $this;
    }

    /**
     * Get the value of qui
     */
    public function getQui()
    {
        return $this->qui;
    }

    /**
     * Set the value of qui
     *
     * @return  self
     */
    public function setQui($qui)
    {
        $this->qui = $qui;

        return $this;
    }

    /**
     * Get the value of sex
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set the value of sex
     *
     * @return  self
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get the value of sab
     */
    public function getSab()
    {
        return $this->sab;
    }

    /**
     * Set the value of sab
     *
     * @return  self
     */
    public function setSab($sab)
    {
        $this->sab = $sab;

        return $this;
    }

    /**
     * Get the value of dom
     */
    public function getDom()
    {
        return $this->dom;
    }

    /**
     * Set the value of dom
     *
     * @return  self
     */
    public function setDom($dom)
    {
        $this->dom = $dom;

        return $this;
    }
}
