<?php
require_once("config.php");
require_once("DB.class.php");
require_once("CRUD.class.php");
require_once("Agendamento.class.php");
require_once("Usuario.class.php");

//confirmado = -1 RECUSADO - 0 PENDENTE - 1 CONFIRMADO - 2 INICIADO - 3 FINALIZADO

class Consulta
{
    private $id;
    private $cid;
    private $id_usuario;
    private $id_medico;
    private $dtfinalizada;
    private $observacoes;
    private $diagnostico;
    private $dtiniciada;
    private $idsala;


    public function loadById($id)
    {
        $row = CRUD::SelectExtra("SELECT * FROM consulta WHERE id = $id");

        if ($row['num'] > 0) {

            foreach ($row['dados'] as $consulta) {
                $this->setId($consulta['id']);
                $this->setId_usuario($consulta['id_usuario']);
                $this->setId_medico($consulta['id_medico']);
                $this->setCid($consulta['cid']);
                $this->setDtfinalizada($consulta['dtfinalizada']);
                $this->setObservacoes($consulta['observacoes']);
                $this->setDiagnostico($consulta['diagnostico']);
                $this->setDtiniciada($consulta['dtiniciada']);
                $this->setIdsala($consulta['idsala']);
            }
        } else $this->setId("-1");
    }

    public static function GeraHash()
    {
        $options = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET'
            )
        );
        $url = urlom . 'services/user/login?user=' . userom . '&pass=' . passom;
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return false;
        } else {
            $arrayr = json_decode($result, true);
            foreach ($arrayr as $sr) {
                if (isset($sr['message'])) {
                    $sid = $sr['message'];
                } else {
                    $sid = false;
                }
            }
            return $sid;
        }
    }

    // public static function GeraLinkSala($idu, $ids, $sid)
    // {   
    //     $user = new Usuario();
    //     $user->loadById($idu);
    //     if ($user->getTipo() == 1) {
    //         $moderator = true;
    //     } else {
    //         $moderator = false;
    //     }

    //     $url = urlom . 'services/user/hash?sid=' . $sid;

    //     $user = json_encode(array(
    //         "firstname" => $user->getNome(),
    //         "lastname" => "",
    //         "externalId" => $idu,
    //         "externalType" => "user",
    //         "login" => $user->getEmail()
    //     ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    //     $opt = json_encode(array(
    //         "roomId" => $ids,
    //         "moderator" => $moderator,
    //         "showAudioVideoTest" => true
    //     ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    //     $data = array('user' => $user, 'options' => $opt);

    //     $options = array(
    //         "ssl" => array(
    //             "verify_peer" => false,
    //             "verify_peer_name" => false,
    //         ),
    //         'http' => array(
    //             'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    //             'method'  => 'POST',
    //             'content' => http_build_query($data)
    //         )
    //     );
    //     $context  = stream_context_create($options);
    //     $result = file_get_contents($url, false, $context);
    //     if ($result === FALSE) {
    //         return -1;
    //     } else {
    //         $arrayr = json_decode($result, true);
    //         foreach ($arrayr as $sr) {
    //             $sid = $sr['message'];
    //         }
    //         return urlom . "hash?secure=" . $sid;
    //     }
    // }

    public static function GeraLinkSala($idu, $ids, $sid)
    {
        $user = new Usuario();
        $user->loadById($idu);
        if ($user->getTipo() == 1) {
            $moderator = true;
        } else {
            $moderator = false;
        }
        // if ($_SERVER['SERVER_NAME'] == 'localhost') {
            $url = 'http://localhost:9996/openmeetings/services/user/hash?sid=' . $sid;
        // } else {
        //     $url = 'https://192.168.1.6:9992/openmeetings/services/user/hash?sid=' . $sid;
        // }

        $user = json_encode(array(
            "firstname" => $user->getNome(),
            "lastname" => "",
            "externalId" => $idu,
            "externalType" => "user",
            "login" => $user->getEmail()
        ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $opt = json_encode(array(
            "roomId" => $ids,
            "moderator" => $moderator,
            "showAudioVideoTest" => true
        ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $data = array('user' => $user, 'options' => $opt);

        $options = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return -1;
        } else {
            $arrayr = json_decode($result, true);
            foreach ($arrayr as $sr) {
                $sid = $sr['message'];
            }
            // if ($_SERVER['SERVER_NAME'] == 'localhost') {
                return 'http://localhost:9996/openmeetings/hash?secure=' . $sid;
            // } else {
            //     return "https://192.168.1.6:9992/openmeetings/hash?secure=" . $sid;
            // }
            
        }
    }

    public static function CriaSala($ida, $sid)
    {
        if ($_SERVER['SERVER_NAME'] == 'localhost') {
            $url = 'https://localhost:9997/openmeetings/services/room?sid=' . $sid;
        } else {
            $url = 'https://192.168.1.6:9992/openmeetings/services/room?sid=' . $sid;
        }

        $paciente = Agendamento::NomePacienteAgendamento($ida);
        $medico = Agendamento::NomeMedicoAgendamento($ida);
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        $now = $now->format('d/m/Y');

        $room = json_encode(array(
            "allowRecording" => true,
            "allowUserQuestions" => false,
            "appointment" => false,
            "audioOnly" => false,
            "capacity" => 2,
            "closed" => false,
            "comment" => "Teleconsulta de " . $paciente . " com Dr. " . $medico . ", realizada no dia: " . $now,
            // "confno" => "valor de confno",
            "demo" => false,
            "demoTime" => 0,
            "externalId" => $ida,
            // "externalType" => "teleconsulta",
            // "files" => array(
            //     "fileId" => 0,
            //     "id" => 0,
            //     "wbIdx" => 0
            // ),
            "hiddenElements" => array(
                "ACTIVITIES", "POLL_MENU", "ACTION_MENU"
            ),
            "moderated" => true,
            "name" => "Teleconsulta de " . $paciente . " com Dr. " . $medico . ", dia: " . $now,
            "public" => false,
            "redirectUrl" => redirectom,
            "type" => "PRESENTATION",
            "waitModerator" => false,
            "waitRecording" => false
        ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $data = array('room' => $room);

        $options = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            return -1;
        } else {
            $resposta = json_decode($result, true);
            foreach ($resposta as $room) {
                $idsala = $room['id'];
            }
            return $idsala;
        }
    }

    public static function IniciaConsulta($ida, $idu, $idm)
    {
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        // $data = $now->format('Y-m-d H:i:s');
        $update = CRUD::UpdateAjax("agendamento", "confirmado = '2' WHERE id = {$ida}");
        //verificar se já existe uma consulta com o id igual ida
        $newid = CRUD::InsertAjax("consulta", "id = $ida, id_usuario = $idu, id_medico = $idm, dtiniciada = '$now'");
        $sid = self::GeraHash();
        self::CriaSala($ida, $sid);
        //return $update;
    }

    public static function FinalizaConsulta($ida, $idu, $idm)
    {   //todo
        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        // $data = $now->format('Y-m-d H:i:s');
        $update = CRUD::UpdateAjax("agendamento", "confirmado = '2' WHERE id = {$ida}");
        $newid = CRUD::InsertAjax("consulta", "id_agendamento = $ida, id_usuario = $idu, id_medico = $idm, dtiniciada = '$now'");
        //return $update;
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
     * Get the value of cid
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * Set the value of cid
     *
     * @return  self
     */
    public function setCid($cid)
    {
        $this->cid = $cid;

        return $this;
    }

    /**
     * Get the value of dtfinalizada
     */
    public function getDtfinalizada()
    {
        return $this->dtfinalizada;
    }

    /**
     * Set the value of dtfinalizada
     *
     * @return  self
     */
    public function setDtfinalizada($dtfinalizada)
    {
        $this->dtfinalizada = $dtfinalizada;

        return $this;
    }

    /**
     * Get the value of observacoes
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * Set the value of observacoes
     *
     * @return  self
     */
    public function setObservacoes($observacoes)
    {
        $this->observacoes = $observacoes;

        return $this;
    }

    /**
     * Get the value of diagnostico
     */
    public function getDiagnostico()
    {
        return $this->diagnostico;
    }

    /**
     * Set the value of diagnostico
     *
     * @return  self
     */
    public function setDiagnostico($diagnostico)
    {
        $this->diagnostico = $diagnostico;

        return $this;
    }

    /**
     * Get the value of dtiniciada
     */
    public function getDtiniciada()
    {
        return $this->dtiniciada;
    }

    /**
     * Set the value of dtiniciada
     *
     * @return  self
     */
    public function setDtiniciada($dtiniciada)
    {
        $this->dtiniciada = $dtiniciada;

        return $this;
    }

    /**
     * Get the value of idsala
     */
    public function getIdsala()
    {
        return $this->idsala;
    }

    /**
     * Set the value of idsala
     *
     * @return  self
     */
    public function setIdsala($idsala)
    {
        $this->idsala = $idsala;

        return $this;
    }
}
