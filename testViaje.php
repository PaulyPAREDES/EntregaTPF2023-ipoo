<?php
include_once 'pasajero.php';
include_once 'responsable.php';
include_once 'empresa.php';
include_once 'viaje.php';
include_once "BaseDatos.php";


// Instancias de objetos*/
$objViaje= new viaje();
$objEmpresa= new empresa();
$objResponsable= new responsable();
$objPasajero= new pasajero();

/*********************************************************FUNCIONES PARA USAR EN EL MENU**************************************************************/

/* ----------------FUNCION INSERTAR OBJETOS------------------*/

function insertarNuevoObjeto($valor){

	 /*1 - Insertar nueva Empresa*/
	 if ($valor == 1){
		$idEmpresa=null;

		echo "Ingrese el nombre de la empresa:\n";
		$nombreE= trim(fgets(STDIN));
		echo "Ingrese la direccion de la empresa:\n";
		$direccionE= trim(fgets(STDIN));
		$objEmpresa= new empresa();
		$objEmpresa->cargar($idEmpresa,$nombreE, $direccionE);
		$respuesta=$objEmpresa->insertar();

		if( $respuesta == true){
		$mensaje="\n ---La empresa fue ingresada en la Base de Datos---\n";
		}else {
		$mensaje= $objEmpresa->getMensajeOperacion();
	   }
	   echo $mensaje;
	 }
	 /*2 - Insertar un nuevo Responsable*/
     else if ($valor == 2){
		$objResponsable= new responsable();
		$numeroEmpleadoResp=null;

		echo "Ingrese num de licencia del responsable\n";
		$numerolicencia= trim(fgets(STDIN));
		echo "Ingrese nombre del responsable:\n";
		$nombreResp= trim(fgets(STDIN));
		echo "Ingrese apellido del responsable:\n";
		$apellidoResp= trim(fgets(STDIN));
		$objResponsable->cargar($numeroEmpleadoResp,$numerolicencia, $nombreResp, $apellidoResp);
		$respuesta=$objResponsable->insertar();
		if( $respuesta== true){
		$mensaje="\n ---El responsable fue ingresado correctamente  en la Base de Datos---\n";
		}else {
		$mensaje= "\n ---El responsable no se ha insertado en la base de datos---\n";
	   }
	   echo $mensaje;
	}
	/*3 - Insertar nuevo Viaje*/	
	else if ($valor == 3){
	    $objViaje= new viaje();
		$objEmpresa= new empresa();
		$objResponsable= new responsable();
		$idEmpresa=null;
		echo "Ingrese el destino:\n";
		$destinoViaje= trim(fgets(STDIN));	
		echo "Ingrese cantidad maxima de pasajeros:\n";
		$vcantmaxpasajeros= trim(fgets(STDIN));
		mostrarEmpresa();
		echo "Ingrese el id de la empresa a quien pertenece:\n";
		$idEmpViaje= trim(fgets(STDIN));
		if (($objEmpresa->Buscar($idEmpViaje)) == true){
			mostrarResponsable();
			echo "Ingrese el numero del resposable del viaje:\n";
			$numRespViaje= trim(fgets(STDIN));
			if (($objResponsable->Buscar($numRespViaje)) == true){

				echo "Ingrese el importe del viaje: \n";
				 $importeViaje= trim(fgets(STDIN));
		
		$objViaje->cargar($idEmpresa,$destinoViaje,$vcantmaxpasajeros,$objEmpresa,$objResponsable,$importeViaje);
		$respuesta= $objViaje->insertar();
		$mensaje="----Se ha creado el viaje correctamente-----\n";
		    }else {
			    $mensaje="----No existe el responsable-----\n";
				
		    }
		}else {
			$mensaje="----No existe la Empresa-----\n";
		}
		echo $mensaje;
	}
	/*4 - Insertar un nuevo Pasajero*/
	else if ($valor == 4){
		$objPasajero= new pasajero();
		$objViaje= new viaje();
		$mensaje="";

		echo "Ingrese el DNI del pasajero:\n";
		$dniPasajero= trim(fgets(STDIN));
		if (($objPasajero->Buscar($dniPasajero)) == true){
			echo "----El pasajero ya existe.\n"; 
			echo "Desea cambiarle el ID del viaje?si/no:";
			$siNo= trim(fgets(STDIN));
			  if($siNo=="si"){
				mostrarViajes();
				echo "Ingrese el ID del viaje:\n";
				$idViaje=trim(fgets(STDIN));
				if (($objViaje->Buscar($idViaje)) == false) {
					$mensaje="---No existe el Viaje---\n";
				}else{
				 $coleccionPasajero=$objViaje->getcoleccionPasajeros();
				 if (count($coleccionPasajero) < $objViaje->getvcantmaxpasajeros()){
					 $objPasajero->setObjViaje($objViaje);
					 $respuesta=$objPasajero->modificar();
					  if($respuesta== true){
					    $arregloPasajeros= $objPasajero->listar("");
					    $coleccionPasajero[]=$arregloPasajeros;
					    $objViaje->setcoleccionPasajeros($coleccionPasajero);
					    $mensaje="\n---Actualizacion realizada---\n";
				      }else{
					    $mensaje=$objPasajero->getMensajeOperacion();
				      }
			     } 
				}
			}else{
				 $dniPasajero=$dniPasajero;
				  $nombrePasajero= $objPasajero->getNombrePasajero();
				  $apellidoPasajero= $objPasajero->getApellidoPasajero();
				  $telefono= $objPasajero->getTelefono();
				  mostrarViajes();
				  echo "Ingrese el id del viaje que desea agregarlo:\n";
			      $idViaje= trim(fgets(STDIN));
				  if ($objViaje->Buscar($idViaje)==true){
					$coleccionPasajero=$objViaje->getcoleccionPasajeros();
					if (count($coleccionPasajero) < $objViaje->getvcantmaxpasajeros()){
	
						$objPasajero->cargar($dniPasajero, $nombrePasajero, $apellidoPasajero, $telefono ,$objViaje);
						$respuesta= $objPasajero->insertar();
						    if($respuesta== true){
						         $mensaje="----Pasajero ingresado -----\n";
						         $arregloPasajeros= $objPasajero->listar("");
						         $coleccionPasajero[]=$arregloPasajeros;
						         $objViaje->setcoleccionPasajeros($coleccionPasajero);
						     }
					}else{
						$mensaje="----No hay lugar disponible en este viaje-----\n";
					}
				  }else{
					$mensaje="----El viaje no existe\n----";
				  }
				}
		        }
	else{
			echo "Ingrese nombre:\n";
			$nombrePasajero= trim(fgets(STDIN));
			echo "Ingrese apellido:\n";
			$apellidoPasajero= trim(fgets(STDIN));
			echo "Ingrese el telefono:\n";
			$telefono= trim(fgets(STDIN));
			mostrarViajes();
			echo "Ingrese el id del viaje que desea agregarlo:\n";
			$idViaje= trim(fgets(STDIN));
			if ($objViaje->Buscar($idViaje)==true){
	            $coleccionPasajero=$objViaje->getcoleccionPasajeros();
				if (count($coleccionPasajero) < $objViaje->getvcantmaxpasajeros()){

					$objPasajero->cargar($dniPasajero, $nombrePasajero, $apellidoPasajero, $telefono ,$objViaje);
					$respuesta= $objPasajero->insertar();
					if($respuesta== true){
					$arregloPasajeros= $objPasajero->listar("");
					$coleccionPasajero[]=$arregloPasajeros;
					$objViaje->setcoleccionPasajeros($coleccionPasajero);
					$mensaje="----Pasajero ingresado -----\n";
					}
				}else{
					$mensaje="----No hay lugar disponible en este viaje-----\n";
				}
			}else{
				$mensaje="----El viaje no existe\n----";
				}
		}
		echo $mensaje;
	  }


}

/* -----------------------SUB FUNCIONES ACTUALIZAR DATOS DE OBJETOS-------------------------*/

/** Actualizar objeto empresa */
 
function actualizarEmpresa(){
    mostrarEmpresa();
	$objEmpresa= new empresa();
	echo "Ingrese el id de la empresa a modificar:\n";
	$idEmpresa= trim(fgets(STDIN));
	if (($objEmpresa->Buscar($idEmpresa)) == false) {
		$mensaje="---No existe la empresa---\n";
	}else{
		echo "\nQue atributo desea actualizar?\n";
		echo "\n ----Ingrese el numero de opcion correspondiente----\n";
		echo "1-nombre Empresa\n";
		echo "2-direccion Empresa\n";
		$numero= trim(fgets(STDIN));
		  if( $numero== 1){
			echo "Ingrese el nuevo nombre de  empresa:\n";
			$nuevoNombre= trim(fgets(STDIN));
			$objEmpresa->setNombreEmpre($nuevoNombre);
			$respuesta=$objEmpresa->modificar();
		  }
		  else if( $numero== 2){
			echo "Ingrese la nueva direccion de la empresa:\n";
			$nuevaDireccion= trim(fgets(STDIN));
			$objEmpresa->setDireccionEmpre($nuevaDireccion);
			$respuesta=$objEmpresa->modificar();
		  }
			if($respuesta==true){
				$mensaje="\n---Actualizacion realizada---\n";
			 }else{
				$mensaje=$objEmpresa->getMensajeOperacion();
			 }
	}
	return $mensaje;
}

/* Actualizar objeto Responsable */ 
function actualizarResponsable(){
	mostrarResponsable();
	$objResponsable= new responsable();
	echo "Ingrese el numero del reponsable a modificar:\n";
	$numModificar=trim(fgets(STDIN));
	if (($objResponsable->Buscar($numModificar)) == false){
			$mensaje="----No existe responsable con ese numero----\n";
		}else{
			echo "\nQue atributo desea actualizar?\n";
			echo " ----Ingrese el numero de opcion correspondiente----\n";
			echo "1-Numerolicencia\n";
			echo "2-Nombre Responsable\n";
			echo "3-Apellido Responsable\n";
			$numero= trim(fgets(STDIN));
			  if( $numero== 1){
				echo "Ingrese la NUEVA licencia del responsable de los viajes:\n";
				$nuevaLicencia= trim(fgets(STDIN));
				$objResponsable->setNumerolicencia($nuevaLicencia);
				$respuesta=$objResponsable->modificar();
			  }
			 else if( $numero== 2){
				echo "Ingrese el NUEVO nnombre del responsable de los viajes:\n";
				$nuevoNombre= trim(fgets(STDIN));
				$objResponsable->setNombreResp($nuevoNombre);
				$respuesta=$objResponsable->modificar();
			  }
			  else if( $numero== 3){
				echo "Ingrese el NUEVO apellido del responsable de los viajes:\n";
				$nuevoApellido =trim(fgets(STDIN));
				$objResponsable->setApellidoResp($nuevoApellido);
				$respuesta= $objResponsable->modificar();
			  }
				  if($respuesta==true){
					  $mensaje="\n---Actualizacion realizada---\n";
				  }else{
					  $mensaje=$objResponsable->getMensajeOperacion();
				  }
   }
   return $mensaje;
}

/*actualizar empresa*/
function actualizarViaje(){
mostrarViajes();
		$objViaje= new viaje();
		echo "Ingrese el id del viaje a modificar:\n";
		$idViajeMod=trim(fgets(STDIN));
		if (($objViaje->Buscar($idViajeMod)) == false){
				$mensaje="---No existe un viaje con ese ID----\n";
			}else{
				echo "\nQue atributo desea actualizar?\n";
				echo " ----Ingrese el numero de opcion correspondiente----\n";
				echo "1-Destino Viaje\n";
				echo "2-cantidad maxima de pasajeros\n";
				echo "3-Empresa perteneciente al viaje\n";
				echo "4-Responsable perteneciente al viaje\n";
				echo "5-Importe del viaje\n";
				$numero= trim(fgets(STDIN));
				  if( $numero == 1){
					echo "Ingrese el NUEVO destino del viaje:\n";
					$nuevoDestino= trim(fgets(STDIN));
					$objViaje->setDestinoViaje($nuevoDestino);
					$respuesta=$objViaje->modificar();
					if($respuesta== true){
						$mensaje="\n---Actualizacion realizada---\n";
						}else{
							$mensaje=$objViaje->getMensajeOperacion();
						}
				  }
				  else if( $numero == 2){
					echo "Ingrese la NUEVA cantida max del viaje:\n";
					$nuevaCantMaxima= trim(fgets(STDIN));
					$objViaje->setVcantmaxpasajeros($nuevaCantMaxima);
					$respuesta=$objViaje->modificar();
				  }

				  else if( $numero == 3){
				  mostrarEmpresa();
				   $objEmpresa= new empresa();
                  echo "Ingrese el NUEVO ID de empresa:\n";
                  $idEmpresa= trim(fgets(STDIN));
                  if (($objEmpresa->Buscar($idEmpresa)) == false) {
                  	$mensaje="---No existe la empresa---\n";
                  }else{
                  	$objViaje->setObjEmpresa($objEmpresa);
                  	$respuesta=$objViaje->modificar();
                  }
				  }
				  else if( $numero == 4){
					mostrarResponsable();
					$objResponsable= new responsable();
					echo "Ingrese el NUEVO NUMERO del responsable:\n";
					 $numeroEmpleadoResp= trim(fgets(STDIN));
					if (($objResponsable->Buscar($numeroEmpleadoResp)) == false) {
						$mensaje="---No existe el responsable--\n";
					}else{
						$objViaje->setObjEmpresa($objResponsable);
						$respuesta=$objViaje->modificar();
					}
				  }
				  else if( $numero == 5){
					echo "Ingrese el NUEVO importe del viaje:\n";
					$nuevoImporte= trim(fgets(STDIN));
					$objViaje->setImporteViaje($nuevoImporte);
					$respuesta=$objViaje->modificar();
				  }	
				  if($respuesta== true){
					$mensaje="\n---Actualizacion realizada---\n";
					}else{
						$mensaje=$objViaje->getMensajeOperacion();
					}	
		}
		return $mensaje;
	}

	/* funcion actualizar datos de los pasajeros */
	function actualizarPasajero(){
		mostrarPasajeros();
		$objPasajero= new pasajero();
		echo "Ingrese el DNI del Pasajeros a modificar:\n";
		$dniModificar=trim(fgets(STDIN));
		if (($objPasajero->Buscar($dniModificar)) == false){
				$mensaje="----No existe un pasajero con ese DNI-----\n";
			}else{
				echo "\nQue atributo desea actualizar?\n";
				echo " ----Ingrese el numero de opcion correspondiente----\n";
				echo "1-Nombre del Pasajero:\n";
				echo "2-Apellido de pasajeros:\n";
				echo "3-Telefono del pasajeros:\n";
				$numero= trim(fgets(STDIN));
				 
					if( $numero == 1){
						
						echo "Ingrese el NUEVO nombre del pasajero:\n";
						$nuevoNombre= trim(fgets(STDIN));
						$objPasajero->setNombrePasajero($nuevoNombre);
						$respuesta=$objPasajero->modificar();
					  }
					 else if( $numero == 2){
						echo "Ingrese el NUEVO Apellido del pasajero:\n";
						$nuevoApellido= trim(fgets(STDIN));
						$objPasajero->setApellidoPasajero($nuevoApellido);
						$respuesta=$objPasajero->modificar();
					  }
					  else if( $numero == 3){
						echo "Ingrese el NUEVO Telefono del pasajero:\n";
						$nuevoTelefono= trim(fgets(STDIN));
						$objPasajero->setTelefono($nuevoTelefono);
						$respuesta=$objPasajero->modificar();
					  }	 
					  if($respuesta== true){
						$mensaje="\n---Actualizacion realizada---\n";
						}else{
							$mensaje=$objPasajero->getMensajeOperacion();
					} 
			}	
			return $mensaje;
	}

/*--------------------------FUNCION MODIFICAR PARA EL  MENU PRINCIPAL---------------------------------*/
function updateObjetos($valor){
	$mensaje="";
    /*Actualizar datos de Empresa*/
	if ($valor == 1){
		$mensaje=actualizarEmpresa();
    }
	 /*2 - Actualizar datos de  Responsable*/
	else if ($valor == 2){
		$mensaje=actualizarResponsable();
	}
	 /*3 - Actualizar datos de Viaje*/
	 else if ($valor == 3){
		$mensaje=actualizarViaje();
	}
	/*4 - Actualizar datos de Pasajero*/
	else if ($valor == 4){
		$mensaje=actualizarPasajero();
	   }

echo $mensaje;
}

/******sub funciones mostar**** */

//funcion mostrar empresa
function mostrarEmpresa(){
	$objEmpresa= new empresa();

	$colEmpresas = $objEmpresa->listar("");
	if($colEmpresas == null){
		echo "--- NO hay datos cargados ---\n";
	}else{
		echo "\n----------------------------\n";
		echo "-----Empresas cargadas------\n";
		echo "----------------------------\n";
	foreach ($colEmpresas as $unaEmpresa){
		echo $unaEmpresa;
		echo "\n---------------------------------\n";
	}
 }
}

//funcion mostrar Responsable
function mostrarResponsable(){
	$objResponsable= new responsable();
		$colResponsable = $objResponsable->listar("");
		if($colResponsable == null){
			echo "--- NO hay datos cargados ---\n";
		}else{
			echo "\n-----------------------------\n";
		    echo "---Responsable de Empresa----\n";
		   echo "-----------------------------\n";
		foreach ($colResponsable as $unResponsable){
			echo $unResponsable;
            echo "\n---------------------------------\n";
        }
      }
}

//funcion mostrar viajes
function mostrarViajes(){
	$objViaje= new viaje();
	
	$colViaje = $objViaje->listar("");
	if($colViaje == null){
		echo "--- NO hay datos cargados ---\n";
	}else{
		echo "\n-----------------------------\n";
	    echo "-------Viajes cargados-------\n";
	    echo "-----------------------------\n";
	foreach ($colViaje as $unViaje){
		echo $unViaje;
		echo "\n---------------------------------\n";
	}
   }
}

//funcion mostrar Pasajeros
function mostrarPasajeros(){
	$objPasajero= new pasajero();
	$colPasajeros= $objPasajero->listar("");
	if($colPasajeros == null){
		echo "--- NO hay datos cargados---\n";
	}else{
		echo "\n----------------------------\n";
	    echo "-----Pasajeros cargados-----\n";
	    echo "----------------------------\n";
	foreach ($colPasajeros as $unPasajero){
		echo $unPasajero;
		echo "\n---------------------------------\n";
	}
  }
}





/*-----------------------FUNCION MOSTRAR PARA EN EL MENU-----------------------------*/
function selectObjetos($valor){
     /*1-Mostrar datos de Empresa */       
	if( $valor == 1){
		mostrarEmpresa();
	}
	 /*2 - Mostrar datos de  Responsable*/
	 if( $valor == 2){
		mostrarResponsable();
     }
	  /*3 - Mostrar datos de Viaje*/
	  if( $valor == 3){
		mostrarViajes();
     }
	  /*4 - Mostrar datos de Pasajero*/
	  if( $valor == 4){
		mostrarPasajeros();
	}
	}

	/*-------- ----FUNCION ELIMINAR PARA USAR EN EL MENU--------------*/ 
	function deleteObjetos($valor){
	   $objViaje= new viaje();
       $objEmpresa= new empresa();
       $objResponsable= new responsable();
       $objPasajero= new pasajero(); 
     
	 /*1 - ELIMINAR datos de Empresa*/
	  if( $valor == 1){
		 mostrarEmpresa();// muestras las empresa que estan cargadas
	     echo "Ingrese el id de empresa cargadas a eliminar:\n";
	     $idEmpEliminar= trim(fgets(STDIN));
	    if (($objEmpresa->Buscar($idEmpEliminar)) == false) {
	          $mensaje="----No existe la empresa\n------";
	    }else{
		    $condicion= "idempresa=".$objEmpresa->getIdEmpresa();
	  	    if ($objViaje->listar($condicion) == null){
	  		    $respuesta=$objEmpresa->eliminar();
				if( $respuesta== true){
					$mensaje= "---Empresa Eliminada---\n";
				}else{
					/*$mensaje=$objEmpresa->getMensajeOperacion(); *///dice que no se puede iliminar debido ala clave foranea
					$mensaje="---No se puede eliminar la empresa porque pertenece a un viaje\n Debe eliminar el viaje asociado y luego la empresa\n";
				}	
	  	    }
	 }
	 echo $mensaje;
	}
	 /*2 - ELIMINAR datos de  Responsable*/
	 else if( $valor == 2){
		mostrarResponsable();
		echo "Ingrese el numero del responsable a eliminar:\n";
		$numRespElim= trim(fgets(STDIN));
		if (($objResponsable->Buscar($numRespElim)) == false){
			   $mensaje="---El responsable no existe.---\n";
		}else{
			$condicion= "numeroEmpleadoResp=".$objResponsable->getNumeroEmpleadoResp();	
			if ($objViaje->listar($condicion) == null){
				$respuesta=$objResponsable->eliminar();
				if( $respuesta== true){
					$mensaje= "---Responsable Eliminado---\n";
				}else{
					/*$mensaje=$objResponsable->getMensajeOperacion(); *///dice que no se puede iliminar debido ala clave foranea
					$mensaje="---No se puede eliminar el responsable porque pertenece a un viaje\n Debe eliminar el viaje asociado y luego la empresa\n";
				}
			}
	   }
	   echo $mensaje;
    }

     /*3 - ELIMINAR datos de Viaje*/
	 else if( $valor == 3){

		mostrarViajes();
		echo "Ingrese el ID del viaje a eliminar:\n";
		$idViajeElim= trim(fgets(STDIN));
		if (($objViaje->Buscar($idViajeElim)) == false){
			   $mensaje="---El viaje no existe.---\n";
		}else{
			$condicion= "idviaje=".$objViaje->getIdviaje();
			if ($objPasajero->listar($condicion)== null){
				$respuesta=$objViaje->eliminar();
				if( $respuesta== true){
					$mensaje= "---Viaje Eliminado---\n";
				}else{
					//$mensaje=$objViaje->getMensajeOperacion(); ///dice que no se puede iliminar debido ala clave foranea
					$mensaje="---No se puede eliminar el viaje porque pasajeros cargados en el viaje viaje
					\n Primero Debe eleminar los pasajeros que pertenecen al viaje ---\n";
				}
			}
	    }
		echo $mensaje;
     }
      /*3 - ELIMINAR datos de Pasajero*/
      else if( $valor == 4){
		mostrarPasajeros();
	  echo "Ingrese el DNI del pasajero a eliminar:\n";
			$dniPasajeroElim= trim(fgets(STDIN));

			if (($objPasajero->Buscar($dniPasajeroElim))== false){
				$mensaje="---El Pasajero no existe.---\n";
			 }else{
				$respuesta=$objPasajero->eliminar();
	   
	        if( $respuesta== true){
	       	$mensaje= "----Pasajero Eliminado----\n";
	        } 
	        }
			 echo $mensaje;
    }
    
	}
	

/**************************************************************************************
**************************************MENU PRINCIPAL**********************************
*************************************************************************************/
do {
	echo "**************************************************\n";
	echo "**************** MENU PRINCIPAL ******************\n";
	echo "**************************************************\n";
    echo "\n------Ingrese el NUMERO de la opcion deseada-------\n";
	echo "1 - Ver menu INSERTAR\n";
	echo "2 - Ver menu ACTUALIZAR\n";
	echo "3 - Ver menu MOSTRAR/LISTAR\n";
	echo "4 - Ver menu de ELIMINAR\n"; 
	echo "5 - Salir del menu\n";
	$valorOpcion= trim(fgets(STDIN));
  
     /*SUB- MENUES*/
 switch ($valorOpcion){
	case 1:/*menu INSERTAR*/
		echo "\n********** MENU INSERTAR *********\n";

		  do {
			echo "\n---- Ingrese el NUMERO de la opcion----- \n";
			echo "1 - Insertar nueva Empresa \n";
			echo "2 - Insertar un nuevo Responsable\n";
			echo "3 - Insertar nuevo Viaje\n";
			echo "4 - Insertar un nuevo Pasajero\n";
			echo "5 - Salir del menu insertar\n";
			$valorOpcionInsertar= trim(fgets(STDIN));
            
			$mensaje=insertarNuevoObjeto($valorOpcionInsertar);
            echo $mensaje;

			}while ($valorOpcionInsertar != 5);
	break;

	case 2;/*Ver menu ACTUALIZAR*/
		 echo "\n********* ACTUALIZAR DATOS ********\n";
		  do {
			echo "\n---- Ingrese el NUMERO de la opcion----- \n";
			echo "1 - Actualizar datos de Empresa \n";
			echo "2 - Actualizar datos de  Responsable\n";
			echo "3 - Actualizar datos de Viaje\n";
			echo "4 - Actualizar datos de Pasajero\n";
			echo "5 - Salir del menu ACTUALIZAR\n";
			$valorOpcionUpdate= trim(fgets(STDIN));
            
			$mensaje=updateObjetos($valorOpcionUpdate);
			echo $mensaje;

			}while ($valorOpcionUpdate != 5);
	break;

	case 3;/*Ver menu MOSTRAR/LISTAR*/
		echo "\n********* MOSTRAR/LISTAR DATOS ********\n";
		do {
			echo "\n---- Ingrese el NUMERO de la opcion----- \n";
			echo "1 - Mostrar datos de Empresa \n";
			echo "2 - Mostrar datos de  Responsable\n";
			echo "3 - Mostrar datos de Viaje\n";
			echo "4 - Mostrar datos de Pasajero\n";
			echo "5 - Salir del menu Mostrar\n";
			$valorOpcionSelect= trim(fgets(STDIN));
            
			   selectObjetos($valorOpcionSelect);
			
			}while ($valorOpcionSelect != 5);
	break;	
	
	case 4;/* Ver menu de ELIMINAR*/
		echo "\n********* ELIMINAR DATOS ********\n";
		do {
			echo " \n---- Ingrese el NUMERO de la opcion----- \n";
			echo "1 - ELIMINAR datos de Empresa \n";
			echo "2 - ELIMINAR datos de  Responsable\n";
			echo "3 - ELIMINAR datos de Viaje\n";
			echo "4 - ELIMINAR datos de Pasajero\n";
			echo "5 - Salir del menu Mostrar\n";
			$valorOpcionDelete= trim(fgets(STDIN));
            
			   deleteObjetos($valorOpcionDelete);
			
			}while ($valorOpcionDelete != 5);
	break;
	
    }

}while($valorOpcion!=5);
	
