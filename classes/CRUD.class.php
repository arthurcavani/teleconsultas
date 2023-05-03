<?php
//include_once("classes/Geral.class.php");
	class CRUD extends DB {

		public static function CripSenha($senha){
			//$senha = openssl_digest($senha, 'sha512');
			$senha = sha1($senha);
			return $senha;
		}		

		

		static function SelectAnexo($tabela,$campo,$id){
			$list = self::getConn()->prepare("SELECT * FROM {$tabela} WHERE {$campo} = ? ORDER BY `id` DESC");
			$list->execute(array($id));
			$d['num'] = $list->rowCount();
			$d['dados'] = $list->fetchAll();
			return $d;
		}		

		public static function InsertAjax($tabela,$dados){
			$insert = self::getConn()->prepare("INSERT INTO $tabela SET $dados");
			$insert->execute();
			$lastId = self::getConn()->lastInsertId();
			return $lastId;
		}

		public static function UpdateAjax($tabela,$dados){
			$insert = self::getConn()->prepare("UPDATE $tabela SET $dados");
			$result = $insert->execute();
			return $result;
		}

		public static function LastId(){
			$lastId = self::getConn()->lastInsertId();
			return $lastId;
		}
		

		public static function Select($tabela,$ordem='id DESC'){
			$select = self::getConn()->prepare("SELECT * FROM {$tabela} ORDER BY {$ordem}");
			$select->execute();

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll(PDO::FETCH_ASSOC);

			return $d;
		}

		public static function Select2($tabela1,$tabela2,$id){
			$field = 'id_'.$tabela1;
			$select = self::getConn()->prepare("SELECT * FROM {$tabela1} INNER JOIN {$tabela2} ON {$tabela1}.`id` = {$tabela2}.{$field} WHERE {$tabela1}.`id` = ? ORDER BY {$tabela1}.`id` DESC");
			$select->execute(array($id));

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll();

			return $d;
		}


		

		public static function SelectOne($tabela,$campo,$valor,$ordem='id DESC'){
			$select = self::getConn()->prepare("SELECT * FROM {$tabela} WHERE {$campo}=? ORDER BY {$ordem}");
			$select->execute(array($valor));

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll();

			return $d;
		}

		public static function SelectTwoMore($tabela,$campo,$ordem='id DESC'){
			$select = self::getConn()->prepare("SELECT * FROM {$tabela} WHERE {$campo} ORDER BY {$ordem}");
			$select->execute();

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll();

			return $d;
		}

		public static function Delete($tabela,$campo,$id=0){
			$delete = self::getConn()->prepare("DELETE FROM {$tabela} WHERE {$campo}=?");
			
			$delete->execute(array($id));

			return $delete;
		}

			

		public static function SelectJoin($tabela,$inner,$where,$ordem = 'id DESC'){
			$select = self::getConn()->prepare("SELECT * FROM {$tabela} {$inner} WHERE {$where} ORDER BY {$ordem}");
			$select->execute();

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll();

			return $d;
		}

		public static function SelectExtra($sql){
			$select = self::getConn()->prepare($sql);
			$select->execute();

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll(PDO::FETCH_ASSOC);

			return $d;
		}

		public static function Truncate($tabela){
			$select = self::getConn()->prepare("TRUNCATE table {$tabela}");
			$select->execute();
		}

		public static function DeleteImagem($tabela,$pasta,$id) {
			$img = self::SelectOne($tabela,'id',$id);
			// return $img['dados'][0]['imagem'];
			unlink($pasta.'/'.$img['dados'][0]['imagem']);
		}		

		public static function SelectLimit($tabela,$limit=12,$offset=0,$ordem='id DESC'){
			$select = self::getConn()->prepare("SELECT * FROM {$tabela} ORDER BY {$ordem} LIMIT :lim OFFSET :off");
			$select->bindParam(':lim',$limit, PDO::PARAM_INT);
			$select->bindParam(':off',$offset, PDO::PARAM_INT);
			$select->execute();

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll();

			return $d;
		}

		public static function SelectLimitOne($tabela,$campo,$valor,$limit=12,$offset=0,$ordem='id DESC'){
			$select = self::getConn()->prepare("SELECT * FROM {$tabela} WHERE {$campo}= :val ORDER BY {$ordem} LIMIT :lim OFFSET :off");
			$select->bindParam(':val',$valor, PDO::PARAM_INT);
			$select->bindParam(':lim',$limit, PDO::PARAM_INT);
			$select->bindParam(':off',$offset, PDO::PARAM_INT);
			$select->execute();

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll();

			return $d;
		}

		public static function SelectLimitTwoMore($tabela,$campo,$limit=12,$offset=0,$ordem='id DESC'){
			$select = self::getConn()->prepare("SELECT * FROM {$tabela} WHERE {$campo} ORDER BY {$ordem} LIMIT :lim OFFSET :off");
			$select->bindParam(':lim',$limit, PDO::PARAM_INT);
			$select->bindParam(':off',$offset, PDO::PARAM_INT);
			$select->execute();

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll();

			return $d;
		}

		public static function SelectLimitJoin($tabela,$inner,$where,$limit=12,$offset=0,$ordem='id DESC',$campos='*'){
			$select = self::getConn()->prepare("SELECT {$campos} FROM {$tabela} {$inner} WHERE {$where} ORDER BY {$ordem} LIMIT :lim OFFSET :off");
			$select->bindParam(':lim',$limit, PDO::PARAM_INT);
			$select->bindParam(':off',$offset, PDO::PARAM_INT);
			$select->execute();

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll();

			return $d;
		}

		static function SelectExtraLimit($sql,$limit=12,$offset=0,$ordem='id DESC'){

			$select = self::getConn()->prepare("{$sql} ORDER BY {$ordem} LIMIT :lim OFFSET :off");
			$select->bindParam(':lim',$limit, PDO::PARAM_INT);
			$select->bindParam(':off',$offset, PDO::PARAM_INT);
			$select->execute();

			$d['num'] = $select->rowCount();
			$d['dados'] = $select->fetchAll();
			return $d;
		}

		public static function CopyTable($table,$id) {
			$monta_fields = array();
			$columns = self::getConn()->prepare("SHOW COLUMNS FROM {$table}");
			$columns->execute();
			$fields = $columns->fetchAll();
			foreach ($fields as $lista_fields) {
				if($lista_fields['Field'] != 'ID') {
					array_push($monta_fields, $lista_fields['Field']);
				}
			}
			$fields = implode(', ', $monta_fields);

			$copy = self::getConn()->prepare("INSERT INTO {$table} ({$fields}) SELECT {$fields} FROM {$table} WHERE ID= ?");
			$copy->execute(array($id));
			$lastId = self::getConn()->lastInsertId();
			$novo_id = $lastId;

			return $novo_id;
		}

		public static function CopyTableWithId($table,$id,$campo,$newId) {
			$monta_fields = array();
			$columns = self::getConn()->prepare("SHOW COLUMNS FROM {$table}");
			$columns->execute();
			$fields = $columns->fetchAll();
			foreach ($fields as $lista_fields) {
				if($lista_fields['Field'] != 'ID' && $lista_fields['Field'] != $campo) {
					array_push($monta_fields, $lista_fields['Field']);
				}
			}
			$fields = implode(', ', $monta_fields);

			$copy2 = self::getConn()->prepare("INSERT INTO {$table} ({$campo}, {$fields}) SELECT ?, {$fields} FROM {$table} WHERE {$campo}= ?");
			$copy2->execute(array($newId,$id));

		}


		public static function GerarCodigoEmail($id){
			$codigo = time();
			$codigo = base64_encode($codigo);
			$codigo = substr($codigo, 10, 4);
			$codigo = str_pad($codigo, 4 , "x");
			$codigo .= base64_encode($id);
			$codigo = base64_encode($codigo);
			return $codigo;
		}

		public static function ReverterCodigoEmail($codigo){
			$id = base64_decode($codigo);	
			$id = substr($id, 4);
			$id = base64_decode($id);
			return $id;
		}
		

		


	}