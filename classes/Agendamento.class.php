<?php
require_once("config.php");
require_once("DB.class.php");
require_once("CRUD.class.php");
// require_once("Usuario.class.php");

//confirmado = -1 RECUSADO - 0 PENDENTE - 1 CONFIRMADO - 2 INICIADO - 3 FINALIZADO

class Agendamento
{
    private $id;
    private $id_usuario;
    private $id_medico;
    private $dataconsulta;
    private $horaconsulta;
    private $confirmado;
    private $especialidade;
    private $datarecusado;


    public function loadById($id)
    {
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id = $id");

        if ($row['num'] > 0) {

            foreach ($row['dados'] as $agendamento) {
                $this->setId($agendamento['id']);
                $this->setId_usuario($agendamento['id_usuario']);
                $this->setId_medico($agendamento['id_medico']);
                $this->setDataconsulta($agendamento['dataconsulta']);
                $this->setHoraconsulta($agendamento['horaconsulta']);
                $this->setConfirmado($agendamento['confirmado']);
                $this->setEspecialidade($agendamento['especialidade']);
                $this->setDatarecusado($agendamento['datarecusado']);
            }
        } else $this->setId("-1");
    }

    public static function NomePacienteAgendamento($ida){
        $agendamento = new Agendamento();
        $agendamento->loadById($ida);
        $paciente = $agendamento->getId_usuario();
        $paciente = CRUD::SelectExtra("SELECT * FROM usuario WHERE id = $paciente");
        return $paciente['dados'][0]['nome'];
    }

    public static function NomeMedicoAgendamento($ida){
        $agendamento = new Agendamento();
        $agendamento->loadById($ida);
        $medico = $agendamento->getId_medico();
        $medico = CRUD::SelectExtra("SELECT * FROM usuario WHERE id = $medico");
        return $medico['dados'][0]['nome'];
    }

    public static function CancelaAgendamentoPaciente($ida, $idu)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $data = $now->format('Y-m-d');
        $update = CRUD::UpdateAjax("agendamento", "confirmado = '-1', datarecusado = \"$data\" WHERE id = {$ida} AND id_usuario = {$idu}");
        return $update;
    }

    public static function CancelaAgendamentoMedico($ida)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $data = $now->format('Y-m-d');
        $update = CRUD::UpdateAjax("agendamento", "confirmado = \"-1\", datarecusado = \"$data\" WHERE id = {$ida}");
        return $update;
    }

    public static function AprovaAgendamento($ida)
    {
        $update = CRUD::UpdateAjax("agendamento", "confirmado = 1 WHERE id = {$ida}");
        return $update;
    }

    public static function ListaPendentesMedico($idm)
    {
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_medico = $idm AND confirmado = 0");
        return $row;
    }

    public static function ListaPendentesPaciente($idp)
    {
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_usuario = $idp AND confirmado = 0");
        return $row;
    }

    public static function ListaPassadasMedico($idm)
    {
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_medico = $idm AND confirmado = 3");
        return $row;
    }

    public static function ListaPassadasPaciente($idp, $idm)
    {
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_usuario = $idp AND id_medico = $idm AND confirmado = 3");
        return $row;
    }

    public static function ListaGeralPassadasPaciente($idp)
    {
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_usuario = $idp AND confirmado = 3");
        return $row;
    }

    public static function ListaRecusadosPaciente($idp)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $data = $now->format('Y-m-d');
        $data = strtotime("-90 days", strtotime($data));
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_usuario = $idp AND confirmado = -1 AND datarecusado > '" . date('Y-m-d', $data) . "' ORDER BY datarecusado DESC");
        return $row;
    }

    public static function ListaRecusadosMedico($idm)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $data = $now->format('Y-m-d');
        $data = strtotime("-31 days", strtotime($data));
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_medico = $idm AND confirmado = -1 AND datarecusado > '" . date('Y-m-d', $data) . "' ORDER BY datarecusado DESC");
        return $row;
    }

    public static function ListaProximasMedico($idm)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $data = $now->format('Y-m-d');
        $hora = $now->format('H:i:s');        
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_medico = $idm AND confirmado = 1 AND dataconsulta >= '" . $data . "' ORDER BY dataconsulta ASC, horaconsulta ASC");
        return $row;
    }

    public static function ListaProximasPaciente($idp)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $data = $now->format('Y-m-d');
        $hora = $now->format('H:i:s');        
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_usuario = $idp AND confirmado = 1 AND dataconsulta >= '" . $data . "' ORDER BY dataconsulta ASC, horaconsulta ASC");
        return $row;
    }

    public static function ListaDiaMedico($idm)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $data = $now->format('Y-m-d');
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_medico = $idm AND confirmado = 1 AND dataconsulta = '" . $data . "' ORDER BY dataconsulta ASC, horaconsulta ASC");
        return $row;
    }

    public static function ListaDiaPaciente($idp)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $data = $now->format('Y-m-d');
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_usuario = $idp AND confirmado IN (1,2) AND dataconsulta = '" . $data . "' ORDER BY dataconsulta ASC, horaconsulta ASC");
        return $row;
    }

    public static function novoAgendamento($id_usuario, $id_medico, $dataconsulta, $horaconsulta, $especialidade)
    {
        $newid = CRUD::InsertAjax("agendamento", "id_usuario = \"$id_usuario\", id_medico = \"$id_medico\",
        dataconsulta = \"$dataconsulta\", horaconsulta = \"$horaconsulta\", confirmado = 0, especialidade = \"$especialidade\"");
        return $newid;
    }

    public static function ProxDisp($idm)
    {
        $i = 0;
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $data = $now->format('Y-m-d');
        $dias = array();
        $data = strtotime("+1 days", strtotime($data));
        while ($i < 5) {
            if (self::DispDia(date('Y-m-d', $data), $idm) != -1) {
                $dias[$i] = date('d/m/Y', $data);
                $i++;
            }
            $data = strtotime("+1 days", $data);
        }
        return $dias;
    }

    public static function DispDia($diames, $idm)
    {
        $i = 0;
        $horarios = array();
        if (self::ExpedienteData($diames, $idm)) {
            $row = CRUD::SelectExtra("SELECT * FROM disponibilidade WHERE id_medico = $idm");
            foreach ($row['dados'] as $disp) {
                $duracao = $disp['duracao_consulta'];
                $primeira = $disp['primeira_consulta'];
                $ultima = $disp['ultima_consulta'];
            }
            $horario = strtotime($primeira);
            while ($horario <= strtotime($ultima)) {
                if (self::DataHoraDisp($idm, $diames, date('H:i:s', $horario))) {
                    $horarios[$i] = date('H:i', $horario);
                    $i++;
                }
                $horario = strtotime("+$duracao minutes", $horario);
            }
            if (count($horarios) > 0) {
                return $horarios;
            } else return -1;
        } else return -1;
    }

    public static function ExpedienteData($diames, $idm)
    {
        $row = CRUD::SelectExtra("SELECT * FROM disponibilidade WHERE id_medico = $idm");
        foreach ($row['dados'] as $disp) {
            $seg = $disp['seg'];
            $ter = $disp['ter'];
            $qua = $disp['qua'];
            $qui = $disp['qui'];
            $sex = $disp['sex'];
            $sab = $disp['sab'];
            $dom = $disp['dom'];
        }
        $diasemana = date('w', strtotime($diames));

        if ($diasemana == 0) {
            if ($dom == 1) {
                return true;
            } else return false;
        }

        if ($diasemana == 1) {
            if ($seg == 1) {
                return true;
            } else return false;
        }

        if ($diasemana == 2) {
            if ($ter == 1) {
                return true;
            } else return false;
        }

        if ($diasemana == 3) {
            if ($qua == 1) {
                return true;
            } else return false;
        }

        if ($diasemana == 4) {
            if ($qui == 1) {
                return true;
            } else return false;
        }

        if ($diasemana == 5) {
            if ($sex == 1) {
                return true;
            } else return false;
        }

        if ($diasemana == 6) {
            if ($sab == 1) {
                return true;
            } else return false;
        }
    }

    public static function DataHoraDisp($idm, $data, $hora)
    {
        $row = CRUD::SelectExtra("SELECT * FROM agendamento WHERE id_medico = $idm AND dataconsulta = '$data' AND horaconsulta = '$hora' AND confirmado != -1;");
        if ($row['num'] > 0) {
            return false;
        } else {
            $row = CRUD::SelectExtra("SELECT * FROM disponibilidade WHERE id_medico = $idm");
            foreach ($row['dados'] as $disp) {
                $iniciop = $disp['inicio_pausa'];
                $fimp = $disp['fim_pausa'];
            }
            if (strtotime($hora) < strtotime($iniciop) || strtotime($hora) >= strtotime($fimp)) {
                return true;
            } else return false;
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
     * Get the value of dataconsulta
     */
    public function getDataconsulta()
    {
        return $this->dataconsulta;
    }

    /**
     * Set the value of dataconsulta
     *
     * @return  self
     */
    public function setDataconsulta($dataconsulta)
    {
        $this->dataconsulta = $dataconsulta;

        return $this;
    }

    /**
     * Get the value of horaconsulta
     */
    public function getHoraconsulta()
    {
        return $this->horaconsulta;
    }

    /**
     * Set the value of horaconsulta
     *
     * @return  self
     */
    public function setHoraconsulta($horaconsulta)
    {
        $this->horaconsulta = $horaconsulta;

        return $this;
    }

    /**
     * Get the value of confirmado
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }

    /**
     * Set the value of confirmado
     *
     * @return  self
     */
    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;

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
     * Get the value of datarecusado
     */
    public function getDatarecusado()
    {
        return $this->datarecusado;
    }

    /**
     * Set the value of datarecusado
     *
     * @return  self
     */
    public function setDatarecusado($datarecusado)
    {
        $this->datarecusado = $datarecusado;

        return $this;
    }
}
