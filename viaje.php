<?php
include_once "BaseDatos.php";
class viaje{

    private $idviaje;
    private $destinoViaje;
    private $vcantmaxpasajeros;
	private $objEmpresa;//referencia a empresa atravez de la clave foranea idEmpresa
    private $objResponsable;//referencia a responsable atravez de la clave foranea numeroEmpleadoResp 
    private $importeViaje;
	private $coleccionPasajeros;
	private $mensajeOperacion;
    
    public function __construct(){
        $this->idviaje = "";
        $this->destinoViaje= "";
        $this->vcantmaxpasajeros = "";
		$this->objEmpresa= new empresa;
        $this->objResponsable = new responsable;
        $this->importeViaje = "";
		$this->coleccionPasajeros=[];
	}

    public function cargar($idviaje,$destinoViaje,$vcantmaxpasajeros,$objEmpresa,$objResponsable,$importeViaje){
        $this->setIdviaje($idviaje);
        $this->setDestinoViaje($destinoViaje);
        $this->setVcantmaxpasajeros($vcantmaxpasajeros);
		$this->setObjEmpresa($objEmpresa);
        $this->setObjResponsable($objResponsable);
        $this->setImporteViaje($importeViaje);
}

/*Metodos get y set para numeroEmpleadoResp*/
public function getIdviaje(){
    return $this->idviaje;
 }  
 public function setIdviaje($idviaje){
    $this->idviaje=$idviaje;
 }

 /*Metodos get y set para destinoViaje*/
public function getDestinoViaje(){
    return $this->destinoViaje;
 }  
 public function setDestinoViaje($destinoViaje){
    $this->destinoViaje=$destinoViaje;
 }

  /*Metodos get y set para destinoViaje*/
public function getvcantmaxpasajeros(){
    return $this->vcantmaxpasajeros;
 }  
 public function setvcantmaxpasajeros($vcantmaxpasajeros){
    $this->vcantmaxpasajeros=$vcantmaxpasajeros;
 }

   /*Metodos get y set para empresa*/
public function getObjEmpresa(){
    return $this->objEmpresa;
 }  
 public function setObjEmpresa($objEmpresa){
    $this->objEmpresa=$objEmpresa;
 }

    /*Metodos get y set para responsable*/
public function getObjResponsable(){
    return $this->objResponsable;
 }  
 public function setObjResponsable($objResponsable){
    $this->objResponsable=$objResponsable;
 }

     /*Metodos get y set para importeViaje*/
public function getImporteViaje(){
    return $this->importeViaje;
 }  
 public function setImporteViaje($importeViaje){
    $this->importeViaje=$importeViaje;
 }
     /*Metodos get y set para coleccionPasajeros*/
public function getcoleccionPasajeros(){
	return $this->coleccionPasajeros;
	}  
 public function setcoleccionPasajeros($coleccionPasajeros){
	$this->coleccionPasajeros=$coleccionPasajeros;
	 }

  /*Metodos get y set para mensajeoperacion*/
  public function getMensajeOperacion(){
    return $this->mensajeOperacion;
 }
 public function setMensajeOperacion($mensaje){
    $this->mensajeOperacion = $mensaje;
 } 


     /**
	 * Recupera los datos de un viaje por id
	 * @param int idviaje
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idviaje){
		$baseDatos=new BaseDatos();
		$consultaViaje="Select * from viaje where idviaje=".$idviaje;
		$resp= false;
		if($baseDatos->Iniciar()){
			if($baseDatos->Ejecutar($consultaViaje)){
				if($fila2=$baseDatos->Registro()){	

					$empresa= new empresa();
					$empresa->Buscar($fila2['idEmpresa']);//Busco empresa por el id para cargarla ala  tabla viaje

					$empleadoR= new responsable();//Busco al responsable del viaje por su clave primaria numeroEmpleadoResp
					$empleadoR->Buscar($fila2['numeroEmpleadoResp']);

                    $this->cargar($idviaje, $fila2['destinoViaje'], $fila2['vcantmaxpasajeros'],$empresa,$empleadoR,$fila2['importeViaje']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setMensajeOperacion($baseDatos->getError());
			}
		 }	else {
		 		$this->setMensajeOperacion($baseDatos->getError());
		 }		
		 return $resp;
	}	
 /*Funcion Listar Viaje*/
    public function listar($condicion=""){
	    $arregloViaje = null;
		$baseDatos=new BaseDatos();
		$consultaEmpresa="select * from viaje ";
		if ($condicion != "" ){
            $consultaEmpresa.=$consultaEmpresa.' where '.$condicion;
		}
		if($baseDatos->Iniciar()){
			if($baseDatos->Ejecutar($consultaEmpresa)){				
				$arregloViaje= [];
				while($fila2=$baseDatos->Registro()){
					
					$idViaje=$fila2['idviaje'];
					$destinoViaje=$fila2['destinoViaje'];
					$vcantmaxpasajeros=$fila2['vcantmaxpasajeros'];
					$importeViaje=$fila2['importeViaje'];

					$objEmpresa= new empresa();
					$objEmpresa->Buscar($fila2['idEmpresa']);

					$objResponsable= new responsable();
					$objResponsable->Buscar($fila2['numeroEmpleadoResp']);

					$viaje=new Viaje();
					$viaje->cargar($idViaje,$destinoViaje,$vcantmaxpasajeros,$objEmpresa,$objResponsable,$importeViaje);
                    $arregloViaje[]=$viaje;
				}
				
		 	}	else {
		 			$this->setMensajeOperacion($baseDatos->getError()); 		
			}
		 }	else {
		 		$this->setMensajeOperacion($baseDatos->getError());
		 }	
		 return  $arregloViaje;
	}	

       /*funcion Insertar*/ 
	public function insertar(){
		$baseDatos=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO viaje(destinoViaje,vcantmaxpasajeros,idEmpresa,numeroEmpleadoResp,importeViaje) 
				VALUES ('".$this->getDestinoViaje()."','".$this->getvcantmaxpasajeros()."','".$this->getObjEmpresa()->getIdEmpresa()
				."','".$this->getObjResponsable()->getNumeroEmpleadoResp()."','".$this->getImporteViaje()."')";
		if($baseDatos->Iniciar()){

			if($idviaje=$baseDatos->devuelveIDInsercion($consultaInsertar)){
                $this->setIdviaje($idviaje);
			    $resp=true;
			}	else {
					$this->setMensajeOperacion($baseDatos->getError());		
			}
		} else {
				$this->setMensajeOperacion($base->getError());
		}
		return $resp;
	}

      /**
	   * funcion modificar o actualizar datos de la tabla viaje
	   *@return boolean
	   */ 
    public function modificar(){
	    $resp =false; 
	    $baseDatos=new BaseDatos();
		$consultaModificar="UPDATE viaje SET destinoViaje='".$this->getDestinoViaje()."',vcantmaxpasajeros='".$this->getvcantmaxpasajeros()."',idEmpresa='".$this->getObjEmpresa()->getIdEmpresa()
				."', numeroEmpleadoResp='".$this->getObjResponsable()->getNumeroEmpleadoResp()."',importeViaje='".$this->getImporteViaje()."' WHERE idviaje=". $this->getIdviaje();
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

    /** 
	*funcion modificar o actualizar datos de la tabla viaje
	* @return boolean
	*/ 
    public function eliminar(){
		$baseDatos=new BaseDatos();
		$resp=false;
		if($baseDatos->Iniciar()){
				$consultaBorrar="DELETE FROM viaje WHERE idviaje=".$this->getIdviaje();
				if($baseDatos->Ejecutar($consultaBorrar)){
				    $resp=  true;
				}else{
						$this->setMensajeOperacion($baseDatos->getError());		
				}
		}else{
				$this->setMensajeOperacion($baseDatos->getError());	
		}
		return $resp; 
	}



    public function __toString(){
	    return "\nId viaje: ".$this->getIdviaje(). "\nDestino del viaje: ".$this->getDestinoViaje()."\ncantida Maxima pasajeros: "
		.$this->getvcantmaxpasajeros()."\nID EMPRESA: ".$this-> getObjEmpresa()->getIdEmpresa()."\nNUM Responsable: "
		.$this-> getObjResponsable()->getNumeroEmpleadoResp()."\nImporte: ".$this->getImporteViaje()."\n"
		;
			
	}



}