<?php
require_once("config.php");
require_once("DB.class.php");
require_once("CRUD.class.php");

class Usuario extends DB
{

    private $id; //    
    private $nome;
    private $cpf; //
    private $senha; //
    private $sexo; //    
    private $datanasc; //
    private $email; //
    private $datacad; //
    private $tipo;
    private $imgperfil;



    private static function crip($senha)
    {
        $senhacrip = sha1($senha);
        return $senhacrip;
    }


    public function getNome()
    {

        return $this->nome;
    }

    public function setNome($value)
    {

        $this->nome = $value;
    }



    public function getCpf()
    {

        return $this->cpf;
    }

    public function setCpf($value)
    {

        $this->cpf = $value;
    }

    public function getEmail()
    {

        return $this->email;
    }

    public function setEmail($value)
    {

        $this->email = $value;
    }

    public function getSenha()
    {

        return $this->senha;
    }

    public function setSenha($value)
    {

        $this->senha = $value;
    }

    public function loadById($id)
    {
        $row = CRUD::SelectExtra("SELECT * FROM usuario WHERE id = $id");

        if ($row['num'] > 0) {

            foreach ($row['dados'] as $user) {
                $this->setId($user['id']);
                $this->setNome($user['nome']);
                $this->setCpf($user['cpf']);
                $this->setSenha($user['senha']);
                $this->setSexo($user['sexo']);
                $this->setDatanasc($user['datanasc']);
                $this->setEmail($user['email']);
                $this->setDatacad($user['datacad']);
                $this->setTipo($user['tipo']);
                $this->setImgperfil($user['imgperfil']);
            }
        } else {
            $this->setId(-1);
        }
    }

    public static function alteraSenha($id, $novasenha)
    {
        $novasenha = self::crip($novasenha);
        return CRUD::UpdateAjax("usuario", "senha = \"$novasenha\" WHERE (id = $id)");
    }

    public static function alteraImgPerfil($img, $id)
    {
        return CRUD::UpdateAjax("usuario", "imgperfil = \"$img\" WHERE (id = $id)");
    }

    public static function alteraEmail($id, $novoemail)
    {
        if (self::emailDisponivel($novoemail)) {
            return CRUD::UpdateAjax("usuario", "email = \"$novoemail\" WHERE (id = $id)");
        } else return -1;
    }

    public static function emailDisponivel($email)
    {
        $email = CRUD::SelectOne('usuario', 'email', $email);
        if ($email['num'] > 0) {
            return false;
        } else return true;
    }

    public static function novoMedico($nome, $cpf, $senha, $sexo, $datanasc, $email, $crm, $especialidade, $tel)
    {
        $senha = self::crip($senha);
        $newid = CRUD::InsertAjax("usuario", "nome = \"$nome\", cpf = \"$cpf\", senha = \"$senha\",
        sexo = \"$sexo\", datanasc = \"$datanasc\", email = \"$email\", tipo = \"1\"");
        CRUD::InsertAjax("medico", "id_usuario = \"$newid\", crm = \"$crm\", especialidade = \"$especialidade\"");
        CRUD::InsertAjax("telefone", "id_usuario = \"$newid\", tel = \"$tel\"");
        return $newid;
    }

    public static function novoPaciente($nome, $cpf, $senha, $sexo, $datanasc, $email, $id_estadocivil, $id_profissao, $nacionalidade, $tel)
    {
        $senha = self::crip($senha);
        $newid = CRUD::InsertAjax("usuario", "nome = \"$nome\", cpf = \"$cpf\", senha = \"$senha\",
        sexo = \"$sexo\", datanasc = \"$datanasc\", email = \"$email\", tipo = \"2\"");
        CRUD::InsertAjax("paciente", "id_usuario = \"$newid\", id_estadocivil = \"$id_estadocivil\", id_profissao = \"$id_profissao\", nacionalidade = \"$nacionalidade\"");
        CRUD::InsertAjax("telefone", "id_usuario = \"$newid\", tel = \"$tel\"");
        return $newid;
    }

    private static function validarUsuario($email, $senha)
    {
        $senha = self::crip($senha);
        try {
            $validar = self::getConn()->prepare("SELECT * FROM `usuario` WHERE senha='{$senha}' and email='{$email}' LIMIT 1");
            $validar->execute();

            if ($validar->rowCount() == 1) {
                return $validar;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $erro = 'Sistema indisponível';
            logErros($e);
            return false;
        }
    }

    public function logar($email = '', $senha = '')
    {
        $validar = self::validarUsuario($email, $senha);

        if ($validar != false) {

            if (!isset($_SESSION)) {
                session_start();
            }
            $user = $validar->fetch(PDO::FETCH_ASSOC);
            $_SESSION['_id_usuario'] = $user['id'];
            $this->setId($user['id']);
            $this->setNome($user['nome']);
            $this->setCpf($user['cpf']);
            $this->setSenha($user['senha']);
            $this->setSexo($user['sexo']);
            $this->setDatanasc($user['datanasc']);
            $this->setEmail($user['email']);
            $this->setDatacad($user['datacad']);
            $this->setTipo($user['tipo']);
            return true;
        } else {
            $this->setId(-1);
            return false;
        }
    }

    public static function sair()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        unset($_SESSION['_id_usuario']);
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
     * Get the value of sexo
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Set the value of sexo
     *
     * @return  self
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get the value of datanasc
     */
    public function getDatanasc()
    {
        $datanascf = explode("-", $this->datanasc);
        $datanasc1 = $datanascf[2] . "/" . $datanascf[1] . "/" . $datanascf[0];
        return $datanasc1;
    }

    /**
     * Set the value of datanasc
     *
     * @return  self
     */
    public function setDatanasc($datanasc)
    {
        $this->datanasc = $datanasc;

        return $this;
    }

    /**
     * Get the value of datacad
     */
    public function getDatacad()
    {
        return $this->datacad;
    }

    /**
     * Set the value of datacad
     *
     * @return  self
     */
    public function setDatacad($datacad)
    {
        $this->datacad = $datacad;

        return $this;
    }

    /**
     * Get the value of tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of imgperfil
     */ 
    public function getImgperfil()
    {
        return $this->imgperfil;
    }

    /**
     * Set the value of imgperfil
     *
     * @return  self
     */ 
    public function setImgperfil($imgperfil)
    {
        $this->imgperfil = $imgperfil;

        return $this;
    }
}
