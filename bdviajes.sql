CREATE DATABASE bdviajes; 

CREATE TABLE empresa(
    idEmpresa bigint AUTO_INCREMENT,
    nombreEmpresa varchar(150),
    direccionEmpresa varchar(150),
    PRIMARY KEY (idEmpresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    numeroEmpleadoResp bigint AUTO_INCREMENT,
    numerolicencia bigint,
	nombreResp varchar(150), 
    apellidoResp  varchar(150), 
    PRIMARY KEY ( numeroEmpleadoResp)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, 
	destinoViaje varchar(150),
    vcantmaxpasajeros int,
	idEmpresa bigint,
    numeroEmpleadoResp bigint,
    importeViaje float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idEmpresa) REFERENCES empresa (idEmpresa),
	FOREIGN KEY ( numeroEmpleadoResp) REFERENCES responsable ( numeroEmpleadoResp)
    ON UPDATE CASCADE
    ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	
CREATE TABLE pasajero (
    dniPasajero varchar(15),
    nombrePasajero varchar(150), 
    apellidoPasajero varchar(150), 
	telefono varchar(50), 
	idviaje bigint,
    PRIMARY KEY (dniPasajero),
	FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)	
    )ENGINE=InnoDB DEFAULT CHARSET=utf8; 
 
  
