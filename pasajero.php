<?php
include_once "BaseDatos.php";
class pasajero{

    private $dniPasajero;
    private $nombrePasajero;
    private $apellidoPasajero;
    private $telefono;
    private $objViaje;/*referencia a viaje Clave foranea idViaje*/
    private $mensajeOperacion;

    public function __construct(){
        $this->dniPasajero= "";
		$this->nombrePasajero = "";
        $this->apellidoPasajero = "";
        $this->telefono = "";
        $this->viaje= new viaje();
    }

    public function cargar($dniPasajero,$nombrePasajero,$apellidoPasajero,$telefono,$objViaje){
        $this->setDniPasajero($dniPasajero);
        $this->setNombrePasajero($nombrePasajero);
        $this->setApellidoPasajero($apellidoPasajero);
        $this->setTelefono($telefono);
        $this->setObjViaje($objViaje);
     }
 /*Metodos get y set para dniPasajero*/
 public function getDniPasajero(){
    return $this->dniPasajero;
 }  
 public function setDniPasajero($dniPasajero){
    $this->dniPasajero=$dniPasajero;
 }

  /*Metodos get y set para nombrePasajero*/
  public function getNombrePasajero(){
    return $this->nombrePasajero;
 }  
 public function setNombrePasajero($nombrePasajero){
    $this->nombrePasajero=$nombrePasajero;
 }

 /*Metodos get y set para apellidoPasajero*/
 public function getApellidoPasajero(){
    return $this->apellidoPasajero;
 }  
 public function setApellidoPasajero($apellidoPasajero){
    $this->apellidoPasajero=$apellidoPasajero;
 }

  /*Metodos get y set para telefono*/
  public function getTelefono(){
    return $this->telefono;
 }  
 public function setTelefono($telefono){
    $this->telefono=$telefono;
 }

   /*Metodos get y set para idviaje*/
   public function getObjViaje(){
    return $this->objViaje;
 }  
 public function setObjViaje($objViaje){
    $this->objViaje=$objViaje;
 }

  /*Metodos get y set para mensajeoperacion*/
  public function getMensajeOperacion(){
    return $this->mensajeOperacion;
 }
 public function setMensajeOperacion($mensaje){
    $this->mensajeOperacion = $mensaje;
 } 

     /**
	 * Recupera los datos de un Pasajero por su  clave primaria numero dni
	 * @param int $dniPasajero
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar ($dniPasajero){
		$baseDatos=new BaseDatos();
		$consultPas="Select * from pasajero where dniPasajero=".$dniPasajero;
		$resp= false;
		if($baseDatos->Iniciar()){
			if($baseDatos->Ejecutar($consultPas)){
				if($fila2=$baseDatos->Registro()){	
                    $objViaje=new viaje();
                    $objViaje->Buscar($fila2['idviaje']);
                    $this->cargar($dniPasajero, $fila2['nombrePasajero'], $fila2['apellidoPasajero'],$fila2['telefono'],$objViaje);
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

  /*Funcion Listar pasajero*/
  public function listar($condicion=""){
    $arreglopasajero = null;
    $baseDatos=new BaseDatos();
    $consultaPas="Select * from pasajero";//seleciona  los pasajero cargados
    if ($condicion != ""){
        $consultaPas.=$consultaPas.' where '.$condicion;
    }
    else if($baseDatos->Iniciar()){
         if($baseDatos->Ejecutar($consultaPas)){				
            $arreglopasajero= [];
            while($fila2=$baseDatos->Registro()){

               $dniPasajero=$fila2['dniPasajero'];
               $nombrePasajero =$fila2['nombrePasajero'];
               $apellidoPasajero =$fila2['apellidoPasajero'];
               $telefono =$fila2['telefono'];

               $viaje= new viaje();
               $viaje->Buscar($fila2['idviaje']);
             
                $pasajero=new pasajero();
                $pasajero->cargar($dniPasajero, $nombrePasajero, $apellidoPasajero, $telefono ,$viaje);
                $arreglopasajero[]=$pasajero;
            }
         }	else {
                 $this->setMensajeOperacion($baseDatos->getError());	
        }
     }	else {
             $this->setMensajeOperacion($baseDatos->getError());
     }	
     return  $arreglopasajero;
}	

   /*funcion Insertar*/ 
   public function insertar(){
    $baseDatos=new BaseDatos();
    $resp= false;
    $consultaInsertar="INSERT INTO pasajero(dniPasajero,nombrePasajero,apellidoPasajero,telefono,idviaje) 
            VALUES ('".$this->getDniPasajero()."','".$this->getNombrePasajero()."','".$this->getApellidoPasajero()."','"
            .$this->getTelefono()."','".$this->getObjViaje()->getIdviaje()."')";
    
    if($baseDatos->Iniciar()){
        if($baseDatos->Ejecutar($consultaInsertar)){
            $resp=  true;
        }	else {
                $this->setMensajeOperacion($baseDatos->getError());		
        }

    } else {
            $this->setMensajeOperacion($baseDatos->getError());	
    }
    return $resp;
}


    /*funcion modificar o actualizar datos de la tabla pasajero*/ 

    public function modificar(){
        $resp =false; 
        $baseDatos=new BaseDatos();
        $consultaModificar="UPDATE pasajero SET  nombrePasajero='".$this->getNombrePasajero()."', apellidoPasajero='".$this->getApellidoPasajero()
        ."', telefono='".$this->getTelefono()."',idviaje='".$this->getObjViaje()->getIdviaje()."' WHERE dniPasajero=". $this->getDniPasajero();
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

    /* funcion delete o iliminar datos de la tabla pasajero*/ 
public function eliminar(){
	$baseBase=new BaseDatos();
	$resp=false;
	if($baseBase->Iniciar()){
			$consultaBorrar="DELETE FROM pasajero WHERE dniPasajero=". $this->getDniPasajero();
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
	return "\nDNI Pasajero: ".$this->getDniPasajero(). "\nNombre:".$this->getNombrePasajero()."\nApellido: ".$this->getApellidoPasajero()
    ."\ntelefono: ".$this->getTelefono()."\nviaje: ".$this->getObjViaje()->getIdviaje()."\n";		
 }

}
?>