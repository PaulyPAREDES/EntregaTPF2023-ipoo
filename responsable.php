<?php
include_once "BaseDatos.php";
class responsable{
     
    private $numeroEmpleadoResp;
    private $numerolicencia ;
    private $nombreResp;
    private $apellidoResp;
    private $mensajeOperacion;

 public function __construct(){
    $this->numeroEmpleadoResp = "";
    $this->numerolicencia = "";
    $this->nombreResp = "";
    $this->apellidoResp = "";
 }

 public function cargar($numeroEmpleadoResp,$numerolicencia,$nombreResp,$apellidoResp){
    $this->setNumeroEmpleadoResp($numeroEmpleadoResp);
    $this->setNumerolicencia($numerolicencia);
    $this->setNombreResp($nombreResp);
    $this->setApellidoResp($apellidoResp);
 }

 /*Metodos get y set para numeroEmpleadoResp*/
 public function getNumeroEmpleadoResp(){
    return $this->numeroEmpleadoResp;
 }  
 public function setNumeroEmpleadoResp($numeroEmpleadoResp){
    $this->numeroEmpleadoResp=$numeroEmpleadoResp;
 }

 /*Metodos get y set para numerolicencia*/
 public function getNumerolicencia(){
    return $this->numerolicencia;
 }  
 public function setNumerolicencia($numerolicencia){
    $this->numerolicencia=$numerolicencia;
 }

 /*Metodos get y set para nombreResp*/
 public function getNombreResp(){
    return $this->nombreResp;
 }  
 public function setNombreResp($nombreResp){
    $this->nombreResp=$nombreResp;
 }

  /*Metodos get y set para apellidoResp*/
  public function getApellidoResp(){
    return $this->apellidoResp;
 }  
 public function setApellidoResp($apellidoResp){
    $this->apellidoResp=$apellidoResp;
 }

 /*Metodos get y set para mensajeoperacion*/
 public function getMensajeOperacion(){
    return $this->mensajeOperacion;
 }
 public function setMensajeOperacion($mensaje){
    $this->mensajeOperacion = $mensaje;
 } 

     /**
	 * Recupera los datos de un responsable por su  clave primaria numero empleado
	 * @param int $numeroEmpleadoResp
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($numeroEmpleadoResp){
		$baseDatos=new BaseDatos();
		$consultaRes="Select * from responsable where numeroEmpleadoResp=".$numeroEmpleadoResp;
		$resp= false;
		if($baseDatos->Iniciar()){
			if($baseDatos->Ejecutar($consultaRes)){
				if($fila2=$baseDatos->Registro()){	
                    $this->cargar($numeroEmpleadoResp,$fila2['numerolicencia'], $fila2['nombreResp'],$fila2['apellidoResp']);
					$resp= true;
				}				
		 	} else {
		 			$this->setMensajeOperacion($baseDatos->getError());
			}
		 } else {
		 		$this->setMensajeOperacion($baseDatos->getError());	
		 }		
		 return $resp;
	}
    
    /*Funcion Listar Responsable*/
    public function listar($condicion=""){
	    $arregloResponsable = null;
		$baseDatos=new BaseDatos();
		$consultaResp="Select * from responsable";//seleciona  los responsable cargados
		if ($condicion != ""){
			$consultaResp.=$consultaResp.' where '.$condicion;
		}
		else if($baseDatos->Iniciar()){
			 if($baseDatos->Ejecutar($consultaResp)){				
				$arregloResponsable= [];
				while($fila2=$baseDatos->Registro()){

                    $numeroEmpleadoResp=$fila2['numeroEmpleadoResp'];
                    $numerolicencia=$fila2['numerolicencia']; ;
                    $nombreResp=$fila2['nombreResp'];;
                    $apellidoResp=$fila2['apellidoResp'];;
				
					$responsable=new responsable();
					$responsable->cargar( $numeroEmpleadoResp, $numerolicencia, $nombreResp, $apellidoResp);
				    $arregloResponsable[]=$responsable;
				}
		 	}	else {
		 			$this->setMensajeOperacion($baseDatos->getError());	
			}
		 }	else {
		 		$this->setMensajeOperacion($baseDatos->getError());
		 }	
		 return $arregloResponsable ;
	}	

     /*funcion Insertar*/ 
	public function insertar(){
		$baseDatos=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO responsable( numerolicencia,nombreResp,apellidoResp) 
				VALUES ('".$this->getNumerolicencia()."','".$this->getNombreResp()."','".$this->getApellidoResp()."')";
		
		if($baseDatos->Iniciar()){
			if($numeroEmpleadoResp=$baseDatos->devuelveIDInsercion($consultaInsertar)){
                $this->setNumeroEmpleadoResp($numeroEmpleadoResp);
			    $resp=  true;
			}	else {
					$this->setMensajeOperacion($baseDatos->getError());		
			}

		} else {
				$this->setMensajeOperacion($baseDatos->getError());	
		}
		return $resp;
	}

    /*funcion modificar o actualizar datos de la tabla responsable*/ 

 public function modificar(){
	$resp =false; 
	$baseDatos=new BaseDatos();
	$consultaModificar="UPDATE responsable SET numerolicencia='".$this->getNumerolicencia()."', nombreResp='".$this->getNombreResp()."', apellidoResp='".$this->getApellidoResp()
					   ."' WHERE numeroEmpleadoResp=". $this->getNumeroEmpleadoResp();
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

/* funcion delete o iliminar datos de la tabla responsable*/ 
public function eliminar(){
	$baseBase=new BaseDatos();
	$resp=false;
	if($baseBase->Iniciar()){
			$consultaBorrar="DELETE FROM responsable WHERE numeroEmpleadoResp=".$this->getNumeroEmpleadoResp();
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
	return "\nNum Responsable: ".$this->getNumeroEmpleadoResp(). "\nNumero de Licencia:".$this->getNumerolicencia()."\nNombre del Responsable: ".$this->getNombreResp()
    ."\nApellido del Responsable: ".$this->getApellidoResp()."\n";		
 }
}
?>