<?php if ( ! defined('BASEPATH')) exit('Não permitido o acesso direto ao script');
/**
 * @author Romão
 * 
 * Arquivo criado com desenvolvimento interno

 */
class Csvmodel{
	
	
	private $campos;
	
	/**
	 * 
	 * Cache temporária, para várias inserções com maior desempenho
	 * @var unknown_type
	 */
	private $cache;
	/**
	 * Seleciona os dados de um determinado arquivo CSV, de acordo com os campos selecionados
	 * 
	 * @param $arquivo String
	 * @param $campos array (valor default array vazio)
	 * @return array
	 */
	function select($arquivo,$camposSelecionados=array()){
		
		if(count(array_keys($camposSelecionados))==0){
			return $this->getValores($arquivo);
		}
		else{			
			$valores=$this->getValores($arquivo);
			$chaves=array_keys($camposSelecionados);
			$contador=0;
			$retorno=array();
			foreach($valores as $valor){
				//verifica quais campos tem valores iguais aos selecionados
				$valoresIguais=0;
				foreach ($chaves as $campo){			
						
					if($valor[$campo]==$this->trataString($camposSelecionados[$campo])){
						
						$valoresIguais++;
					}
										
				}
				//quando o campo tiver todos os valores iguais ao selecionado adiciona ao vetor de retorno
				
				if(count($chaves)==$valoresIguais){
					$retorno[$contador]=$valor;
					$contador++;
				}
			}
			return $retorno;
		}		
	}
	
	/**
	 * Insere um novo registro. Se o $primaryKey for true, será utilizado o auto complemento da chave primária.
	 * Senão insere todos os campos
	 * 
	 * @param String $arquivo
	 * @param array $post
	 * @param boolean $primaryKey
	 * @return void
	 */
	function insert($arquivo,$post,$primaryKey=false){
		$valores=@$this->getValores($arquivo);
		$campos=$this->campos;
		$read="";
		if($primaryKey==true){
			$maiores=array();
			foreach($valores as $valor){
				$maiores[]=$valor[$campos[0]];
			}
			$maior=(count($maiores)>0?max($maiores):0)+1;
			$read.=$maior.";";
			
			$tamanho=count($campos);
			//o primeiro campo será considerado chave primária
			for($i=1;$i<$tamanho;$i++){
				$post[$campos[$i]]=$this->trataString($post[$campos[$i]]);
				$read.=$post[$campos[$i]].";";
			}
			$read.="\n";
		}
		else{
			$campos=$this->campos;
			$tamanho=count($campos);
			
			for($i=0;$i<$tamanho;$i++){
				$post[$campos[$i]]=$this->trataString($post[$campos[$i]]);
				
				$read.=$post[$campos[$i]].";";				
			}
			$read.="\n";			
		}
		//$read=trim($read);
		//echo $arquivo;
		$handle = $this->fopen_mail($arquivo,"a+");
		fwrite($handle, $read);
		fclose($handle);
	}
	
	/**
	 * 
	 * Insere os valores a serem inseridos na memória
	 * @param array $post
	 */
	function escreveCache($post){
		
		$campos=$this->campos;
		$read="";
		
		$campos=$this->campos;
		$tamanho=count($campos);
		
		for($i=0;$i<$tamanho;$i++){
			$post[$campos[$i]]=$this->trataString($post[$campos[$i]]);
			
			$read.=$post[$campos[$i]].";";				
		}
		$read=substr($read, 0,-1);
		$read.="\n";
		$this->cache.=$read;
	}
	
	/**
	 * Salva os dados na memória para um arquivo csv
	 * @param string $arquivo
	 */
	function insertCache($arquivo){
		$this->cache = trim($this->cache);
		$handle = $this->fopen_mail($arquivo,"a+");
		fwrite($handle, $this->cache);
		$this->cache="";
		fclose($handle);
	}
	
	/**
	 * Exibe um print do csv para download, sem salvar em cache
	 * @param string $nome
	 * 
	 */
	function printCache($nome){		
		
		header ( "Content-Disposition: attachment; filename=\"{$nome}\"" );
		header('Content-Type: application/csv; charset=UTF-8');
		//header ( "Content-Length: ".strlen($this->cache) );
                
		print trim($this->cache);
	}
	
	/**
	 * Atualiza uma linha do arquivo csv de acordo com a chave primária
	 * 
	 * @param $arquivo String
	 * @param $post array
	 * @param $chave int
	 * @return void
	 */
	function update($arquivo,$post,$chave){
		$valores=$this->getValores($arquivo);
		$campos=$this->campos;
		$read="";
		$tamanho=count($campos);
		foreach($valores as $valor){
			if($valor[$campos[0]]==$chave){
				
				for($i=0;$i<$tamanho;$i++){
					if(isset($post[$campos[$i]])&&strlen($post[$campos[$i]])>0){
						$post[$campos[$i]]=$this->trataString($post[$campos[$i]]);
						$read.=$post[$campos[$i]].";";
					}
					else{
						$read.=$valor[$campos[$i]].";";
					}
				}
			}
			else{
				
				for($i=0;$i<$tamanho;$i++){
					$read.=$valor[$campos[$i]].";";
					
				}
			}
			//echo $valor[$campos[0]];
			$read.="\n";
		}
		//echo $read;
		$handle = $this->fopen_mail($arquivo,"w");
		fwrite($handle, $read);
		fclose($handle);
	}
	
	/**
	 * Deleta um registro do arquivo csv
	 * 
	 * @param $arquivo String
	 * @param $id int
	 * @return void
	 */
	function delete($arquivo,$camposSelecionados){
		$valores=$this->getValores($arquivo);
		$campos=$this->campos;
		$chaves=array_keys($camposSelecionados);
		$contador=0;
		$retorno=array();
		$read="";
		foreach($valores as $valor){
			//verifica quais campos tem valores iguais aos selecionados
			$valoresIguais=0;
			foreach ($chaves as $campo){					
				if($valor[$campo]==$this->trataString($camposSelecionados[$campo])){
					$valoresIguais++;
				}					
			}
			
			if($valoresIguais!=count($chaves)){
				
				$tamanho=count($campos);
				for($i=0;$i<$tamanho;$i++){
					$read.=$valor[$campos[$i]].";";
				}
				$read.="\n";
			}
		}
		$handle = $this->fopen_mail($arquivo,"w");
		fwrite($handle, $read);
		fclose($handle);
	}
	
	/**
	 * Altera os valores dos campos a serem inseridos no banco
	 * 
	 * @return array
	 */
	function setCampos($array){
		$this->campos=$array;
	}
	
	/**
	 * Retorna todos os valores de um determinado arquivo em um vetor
	 * @param String $arquivo
	 * 
	 * @return array
	 */
	private function getValores($arquivo){
		$handle = $this->fopen_mail($arquivo, "r");
		$retorno=array();
		$campos=$this->campos;
		$contador=0;
		$tamanho=count($campos);
		while($row=fgetcsv($handle,8000,";")){
			
			for($i=0;$i<$tamanho;$i++){
				
				$retorno[$contador][$campos[$i]]=trim($row[$i]);
			}
			$contador++;
		}
		fclose($handle);
		return $retorno;
	}
	
	/**
	 * Método que verifica se as permissões para abrir estão corretas. Se tiver, abre o arquivo
	 * 
	 * @param String $arquivo
	 * @param String $paramentro
	 * @return buffer
	 */
	function fopen_mail($arquivo,$parametro){
		$handle=@fopen($arquivo,$parametro);
		if(!$handle){
			echo "Erro ao abrir o arquivo ".$arquivo,"O servidor ".$_SERVER["SERVER_NAME"]." apresenta problemas de permissão ou inexistência do arquivo. Verificar com o administrador.";
			
		}
		//else{
		return $handle;
		//}
	}

	/**
	 * Trata a string, evitando que caracteres indevidos entrem no csv
	 * @param $string
	 * @return String
	 */
	private function trataString($string){
                $string = str_replace("&nbsp;"," ",$string);
		$string=str_replace(";","",$string);
                
		$string=str_replace("\n"," ",$string);
		$string=str_replace("\r"," ",$string);
                $string = preg_replace('/\s/',' ',$string);
		return $string;
	}
}

?>