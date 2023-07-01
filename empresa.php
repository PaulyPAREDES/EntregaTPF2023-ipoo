<?php
include_once "BaseDatos.php";
class empresa{
    private $idEmpresa;
    private $nombreEmpresa;
    private $direccionEmpresa;
    private $mensajeOperacion;

    public function __construct(){	
		$this->idEmpresa = "";
		$this->nombreEmpresa = "";
		$this->direccionEmpresa = "";
	}

	public function cargar($idEmpresa,$nombreEmpresa,$direccionEmpresa){		
		$this->setIdEmpresa($idEmpresa);
		$this->setNombreEmpre($nombreEmpresa);
		$this->setDireccionEmpre($direccionEmpresa);	
    }

  /*Metodos get y set para idEmpresa*/
    public function getIdEmpresa(){
        return $this->idEmpresa;
    }  
	public function setIdEmpresa($idEmpresa){
		$this->idEmpresa=$idEmpresa;
	}
 /*Metodos get y set para nombreEmpresa*/
    public function getNombreEmpre(){
        return $this->nombreEmpresa;
    }  
    public function setNombreEmpre($nombreEmpresa){
       $this->nombreEmpresa=$nombreEmpresa;
   }
 /*Metodos get y set para nombreEmpresa*/
   public function getDireccionEmpre(){
       return $this->direccionEmpresa;
     }  
   public function setDireccionEmpre($direccionEmpresa){
       $this->direccionEmpresa=$direccionEmpresa;
     }
/*Metodos get y set para mensajeoperacion*/
     public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensaje){
        $this->mensajeOperacion = $mensaje;
    }

    /**
	 * Recupera los datos de una empresa por su id
	 * @param int $idEmpresa
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idEmpresa){
		$baseDatos=new BaseDatos();
		$consultaEmpresa="Select * from empresa where idEmpresa=".$idEmpresa;
		$resp= false;
		if($baseDatos->Iniciar()){
			if($baseDatos->Ejecutar($consultaEmpresa)){
				if($fila2=$baseDatos->Registro()){					
				    $this->cargar($idEmpresa, $fila2['nombreEmpresa'], $fila2['direccionEmpresa']);
					$resp = true;
				}				
		 	} else {
		 			$this->setMensajeOperacion($baseDatos->getError());
			}
		 } else {
		 		$this->setMensajeOperacion($baseDatos->getError());	
		 }		
		 return $resp;
	}
	
    
 /*Funcion Listar */
    public function listar($condicion=""){
	    $arregloEmpresa = null;
		$baseDatos=new BaseDatos();
		$consultaEmpresas="Select * from empresa ";//seleciona las empresas cargadas
		if ($condicion != ""){
			$consultaEmpresas.=$consultaEmpresas.' where '.$condicion;
		}
		else if($baseDatos->Iniciar()){
			 if($baseDatos->Ejecutar($consultaEmpresas)){				
				$arregloEmpresa= [];
				while($fila2=$baseDatos->Registro()){
				
                    $idEmpresa=$fila2['idEmpresa'];
                    $nombreEmpresa=$fila2['nombreEmpresa'];
                    $direccionEmpresa=$fila2['direccionEmpresa'];
				
					$empresa=new empresa();
					$empresa->cargar( $idEmpresa,$nombreEmpresa, $direccionEmpresa);
				    $arregloEmpresa[]=$empresa;
				}
		 	}	else {
		 			$this->setMensajeOperacion($baseDatos->getError());	
			}
		 }	else {
		 		$this->setMensajeOperacion($baseDatos->getError());
		 }	
		 return $arregloEmpresa;
	}	
 /*funcion Insertar*/ 
	public function insertar(){
		$baseDatos=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa(nombreEmpresa,direccionEmpresa) 
				VALUES ('".$this->getNombreEmpre()."','".$this->getDireccionEmpre()."')";
		
		if($baseDatos->Iniciar()){
			if($idEmpresa=$baseDatos->devuelveIDInsercion($consultaInsertar)){
                $this->setIdEmpresa($idEmpresa);
			    $resp= true;

			}	else {
					$this->setMensajeOperacion($baseDatos->getError());		
			}

		} else {
				$this->setMensajeOperacion($baseDatos->getError());	
		}
		return $resp;
	}

 /*funcion modificar o actualizar datos de la tabla*/ 

 public function modificar(){
	$resp =false; 
	$baseDatos=new BaseDatos();
	$consultaModificar="UPDATE empresa SET nombreEmpresa='".$this->getNombreEmpre()."', direccionEmpresa='".$this->getDireccionEmpre()
					   ."' WHERE idEmpresa=". $this->getIdEmpresa();
	if($baseDatos->Iniciar()){
		if($baseDatos->Ejecutar($consultaModificar)){
			$resp=  true;
		}else{
			$this->setMensajeOperacion($baseDatos->getError());
		}
	}else{
			$this->setMensajeOperacion($baseDatos->getError());
	}
	return $resp;
}

/* funcion delete o iliminar datos*/ 
 public function eliminar(){
	$baseBase=new BaseDatos();
	$resp=false;
	if($baseBase->Iniciar()){
			$consultaBorrar="DELETE FROM empresa WHERE idEmpresa=".$this->getIdEmpresa();
			if($baseBase->Ejecutar($consultaBorrar)){
				$resp=  true;
			}else{
					$this->setMensajeOperacion($baseBase->getError());	
			}
	}else{
			$this->setMensajeOperacion($baseBase->getError());	
	}
	return $resp; 
 }
 
 /*Funcion to string()*/
 public function __toString(){
	return "\nId Empresa: ".$this->getIdEmpresa(). "\nNombre empresa:".$this->getNombreEmpre()."\nDireccion: ".$this->getDireccionEmpre()
  	."\n";		
 }

}
?>
