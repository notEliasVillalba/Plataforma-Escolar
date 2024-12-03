DROP DATABASE IF EXISTS `PLATAFORMA_ESCOLAR`;
CREATE DATABASE IF NOT EXISTS `PLATAFORMA_ESCOLAR`;
USE `PLATAFORMA_ESCOLAR`;

CREATE TABLE IF NOT EXISTS `Profesor` 
(
  `idProfesor` INT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico del profesor',
  `nombre` VARCHAR(45) NOT NULL COMMENT 'Nombre del profesor',
  `apepat` VARCHAR(45) NOT NULL COMMENT 'Apellido paterno del profesor',
  `apemat` VARCHAR(45) NULL COMMENT 'Apellido materno del profesor',
  `fechanac` DATE NOT NULL COMMENT 'Fecha de nacimiento del profesor',
  `genero` VARCHAR(15) NOT NULL COMMENT 'Genero del profesor',
  `vocacion` TEXT NOT NULL COMMENT 'Vocacion del profesor',
  `fecingreso` DATE NOT NULL COMMENT 'Fecha de ingreso del profesor',
  `correo` VARCHAR(45) NULL COMMENT 'Correo del profesor',
  `contrasena` VARCHAR(45) NULL COMMENT 'Llave de acceso del profesor',
  PRIMARY KEY (`idProfesor`)
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Carrera`
(
  `idCarrera` INT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la carrera',
  `clave` VARCHAR(45) NULL COMMENT 'Clave de la Carrera',
  `nombre` VARCHAR(45) NOT NULL COMMENT 'Nombre de la carrera',
  PRIMARY KEY (`idCarrera`)
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Estudiante`
(
  `idEstudiante` INT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico del estudiante',
  `nombre` VARCHAR(45) NOT NULL COMMENT 'Nombre del estudiante',
  `apepat` VARCHAR(45) NOT NULL COMMENT 'Apellido paterno del estudiante',
  `apemat` VARCHAR(45)  NULL COMMENT 'Apellido materno del estudiante',
  `fechanac` DATE NOT NULL COMMENT 'Fecha de nacimiento del estudiante',
  `genero` VARCHAR(15) NOT NULL COMMENT 'Genero del estudiante',
  `matricula` TEXT NULL COMMENT 'Matricula del estudiante',
  `fecingreso` DATE NOT NULL COMMENT 'Fecha de ingreso del estudiante',
  `correo` VARCHAR(45) NULL COMMENT 'Correo del estudiante',
  `contrasena` VARCHAR(45) NULL COMMENT 'Llave de acceso del estudiante',
  `Carrera_idCarrera` INT NOT NULL COMMENT 'Identificador unico de la carrera',
  PRIMARY KEY (`idEstudiante`,`Carrera_idCarrera`),
  CONSTRAINT `fk_Estudiante_Carrera1`
    FOREIGN KEY (`Carrera_idCarrera`)
		REFERENCES `Carrera` (`idCarrera`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Grupo`
(
  `idGrupo` INT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico del grupo',
  `nombre` VARCHAR(45) NOT NULL COMMENT 'Nombre del grupo',
  `salon` VARCHAR(45) NOT NULL COMMENT 'Salon asignado al grupo',
  `generacion` VARCHAR(45) NULL COMMENT 'Genaracion del grupo',
  PRIMARY KEY (`idGrupo`)
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Materia`
(
  `idMateria` INT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la materia',
  `nombre` VARCHAR(45) NOT NULL COMMENT 'Nombre de la materia',
  `clave` VARCHAR(45) NOT NULL COMMENT 'Clave de la materia',
  `horas` INT NOT NULL COMMENT 'Horas semanales de la materia',
  PRIMARY KEY (`idMateria`)
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Calificacion`
(
  `idCalificacion` INT NOT NULL AUTO_INCREMENT  COMMENT 'Identificador unico de la calificacion',
  `calificacion` INT NOT NULL COMMENT 'Calificacion asignada',
  `Periodo` VARCHAR(45) NULL COMMENT 'Periodo en el que se realiza la calificacion',
  `Tipo` VARCHAR(45) NULL COMMENT 'Tipo de calificacion',
  PRIMARY KEY (`idCalificacion`),
  `Materia_idMateria` INT NOT NULL COMMENT 'Identificador unico de la materia',
  `Estudiante_idEstudiante` INT NOT NULL COMMENT 'Identificador unico del Estudiante',
  CONSTRAINT `fk:_cal_estu`
	FOREIGN KEY(`Estudiante_idEstudiante`) REFERENCES `Estudiante`(`idEstudiante`)
		ON DELETE NO ACTION
        ON UPDATE NO ACTION,
  CONSTRAINT `fk_Materia_has_Calificacion_Materia1`
    FOREIGN KEY (`Materia_idMateria`)
    REFERENCES `Materia` (`idMateria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    
    UNIQUE (Materia_idMateria, Estudiante_idEstudiante, tipo, periodo)
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Estudiante_Grupo`
 (
  `Estudiante_idEstudiante` INT NOT NULL COMMENT 'Identificador unico del estudiante',
  `Grupo_idGrupo` INT NOT NULL COMMENT 'Identificador unico del grupo',
  PRIMARY KEY (`Estudiante_idEstudiante`, `Grupo_idGrupo`),
  CONSTRAINT `fk_Estudiante_has_Grupo_Estudiante`
    FOREIGN KEY (`Estudiante_idEstudiante`) REFERENCES `Estudiante` (`idEstudiante` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Estudiante_has_Grupo_`
    FOREIGN KEY (`Grupo_idGrupo`) REFERENCES `Grupo` (`idGrupo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `Profesor_Materia` 
(
  `Profesor_idProfesor` INT NOT NULL COMMENT 'Identificador unico del profesor',
  `Materia_idMateria` INT NOT NULL COMMENT 'Identificador unico de la materia',
  `Grupo_idGrupo` INT NOT NULL COMMENT 'Identificador unico del grupo',
  PRIMARY KEY (`Profesor_idProfesor`, `Materia_idMateria`, `Grupo_idGrupo`),
  CONSTRAINT `fk_Profesor_has_Materia_Profesor1`
    FOREIGN KEY (`Profesor_idProfesor`)
    REFERENCES `Profesor` (`idProfesor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Profesor_has_Materia_Materia1`
    FOREIGN KEY (`Materia_idMateria`)
    REFERENCES `Materia` (`idMateria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Profesor_has_Materia_Grupo1`
    FOREIGN KEY (`Grupo_idGrupo`)
    REFERENCES `Grupo` (`idGrupo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



CREATE TABLE IF NOT EXISTS `Bitacora` 
(
  `idaccion` INT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico de la accion',
  `accion` TEXT NOT NULL COMMENT 'Accion realizada en la base de datos',
  `fecha` DATETIME NOT NULL COMMENT 'Fecha en la que se realizo alguna accion',
  PRIMARY KEY (`idaccion`)
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `admin`
(
  `idadmin` INT NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico del administrador',
  `nombre` VARCHAR(45) NOT NULL COMMENT 'Nombre del administrador',
  `correo` VARCHAR(45) NOT NULL COMMENT 'Correo de ingreso del administrador',
  `contrasena` VARCHAR(45) NOT NULL COMMENT 'Llave de acceso del administrador',
  PRIMARY KEY (`idadmin`)
)
ENGINE = InnoDB;

-- Disparadores
DELIMITER $$
CREATE TRIGGER generador_matricula_correo_password BEFORE INSERT ON `Estudiante`
FOR EACH ROW
BEGIN
	DECLARE MATRI, CORREO TEXT;
	DECLARE N, AP, AM CHAR;
    DECLARE F, CONTADOR INT;
    DECLARE FEC, FOLIO CHAR(2);
    DECLARE CARR CHAR(3);
    
    IF NEW.apemat = '' THEN
        SET AM = 'X';
    ELSE
        SET AM = LEFT(NEW.apemat, 1);
    END IF;
    
	SELECT COUNT(*) + 1 INTO CONTADOR FROM Estudiante;
    SET FOLIO = LPAD(CONTADOR, 2, '0'); 
    
    SET N = LEFT(NEW.nombre,1);
    SET AP = LEFT(NEW.apepat,1);
    
    SET FEC = RIGHT(YEAR(NEW.fecingreso), 2);
    IF FEC < 10 THEN
		SET FEC = CONCAT('0',RIGHT(FEC,1));
    END IF;
    
    SET CARR = LEFT((SELECT CLAVE FROM CARRERA WHERE idCarrera = NEW.Carrera_idCarrera),3);
    SET MATRI = UPPER(CONCAT(AP, AM, N, FOLIO, FEC,CARR));
    SET MATRI = REPLACE(MATRI, 'Á', 'A');
    SET MATRI = REPLACE(MATRI, 'É', 'E');
    SET MATRI = REPLACE(MATRI, 'Í', 'I');
    SET MATRI = REPLACE(MATRI, 'Ó', 'O');
    SET MATRI = REPLACE(MATRI, 'Ú', 'U');
    SET MATRI = REPLACE(MATRI, 'ñ', 'n');
    SET MATRI = REPLACE(MATRI, 'Ñ', 'N');
    SET NEW.matricula = MATRI;
    SET NEW.correo = CONCAT(MATRI,'@ESCUELA.COM');
    SET new.contrasena = CONCAT
    (
        CHAR(FLOOR(65 + RAND() * 26)),  
        CHAR(FLOOR(97 + RAND() * 26)),  
        CHAR(FLOOR(48 + RAND() * 10)),
        CHAR(FLOOR(65 + RAND() * 26)),
        CHAR(FLOOR(97 + RAND() * 26)),
        CHAR(FLOOR(48 + RAND() * 10))
    );
END $$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER generador_credenciales_profesor BEFORE INSERT ON `Profesor`
FOR EACH ROW
BEGIN
	DECLARE MATRI, CORREO TEXT;
	DECLARE N, AP, AM CHAR;
    DECLARE F, CONTADOR INT;
    DECLARE FEC, FOLIO CHAR(2);
    
    IF NEW.apemat = '' THEN
        SET AM = 'X';
    ELSE
        SET AM = LEFT(NEW.apemat, 1);
    END IF;
    
    SELECT COUNT(*) + 1 INTO CONTADOR FROM Profesor;
    SET FOLIO = LPAD(CONTADOR, 2, '0'); 
    
    SET N = LEFT(NEW.nombre,1);
    SET AP = LEFT(NEW.apepat,1);
    
    SET FEC = RIGHT(YEAR(NEW.fecingreso), 2);
    IF FEC < 10 THEN
		SET FEC = CONCAT('0',RIGHT(FEC,1));
    END IF;
    
	SET MATRI = UPPER(CONCAT(AP, AM, N, FOLIO, FEC));
	SET MATRI = REPLACE(MATRI, 'Á', 'A');
    SET MATRI = REPLACE(MATRI, 'É', 'E');
    SET MATRI = REPLACE(MATRI, 'Í', 'I');
    SET MATRI = REPLACE(MATRI, 'Ó', 'O');
    SET MATRI = REPLACE(MATRI, 'Ú', 'U');
    SET MATRI = REPLACE(MATRI, 'ñ', 'n');
    SET MATRI = REPLACE(MATRI, 'Ñ', 'N');
    SET NEW.correo = CONCAT(MATRI,'@ESCUELA.COM');
    SET new.contrasena = CONCAT
    (
        CHAR(FLOOR(65 + RAND() * 26)),  
        CHAR(FLOOR(97 + RAND() * 26)),  
        CHAR(FLOOR(48 + RAND() * 10)),
        CHAR(FLOOR(65 + RAND() * 26)),
        CHAR(FLOOR(97 + RAND() * 26)),
        CHAR(FLOOR(48 + RAND() * 10))
    );
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER bitacora_insert_estudiante AFTER INSERT ON `Estudiante`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se Registro a el estudiante con Matrícula ', NEW.Matricula), NOW());
END $$
DELIMITER ;
DELIMITER $$

CREATE TRIGGER bitacora_update_estudiante AFTER UPDATE ON `Estudiante`
FOR EACH ROW
BEGIN
    IF OLD.nombre <> NEW.nombre THEN
        INSERT INTO `Bitacora` (accion, fecha)
        VALUES (CONCAT('Se modificó el nombre del estudiante con matrícula ', OLD.matricula, ': de ', OLD.nombre, ' a ', NEW.nombre), NOW());
    END IF;

    IF OLD.apepat <> NEW.apepat THEN
        INSERT INTO `Bitacora` (accion, fecha)
        VALUES (CONCAT('Se modificó el apellido paterno del estudiante con matrícula ', OLD.matricula, ': de ', OLD.apepat, ' a ', NEW.apepat), NOW());
    END IF;

    IF OLD.apemat <> NEW.apemat THEN
        INSERT INTO `Bitacora` (accion, fecha)
        VALUES (CONCAT('Se modificó el apellido materno del estudiante con matrícula ', OLD.matricula, ': de ', OLD.apemat, ' a ', NEW.apemat), NOW());
    END IF;

    IF OLD.fechanac <> NEW.fechanac THEN
        INSERT INTO `Bitacora` (accion, fecha)
        VALUES (CONCAT('Se modificó la fecha de nacimiento del estudiante con matrícula ', OLD.matricula, ': de ', OLD.fechanac, ' a ', NEW.fechanac), NOW());
    END IF;
    
    IF OLD.Carrera_idCarrera <> NEW.Carrera_idCarrera THEN
		INSERT INTO `Bitacora` (accion, fecha)
        VALUES (CONCAT('Se modificó la Carrera del estudiante con matricula ', OLD.matricula, ': de carrera con id: ', OLD.Carrera_idCarrera, ' a ', NEW.Carrera_idCarrera), NOW());
    END IF; 
    IF OLD.contrasena <> NEW.contrasena THEN
		INSERT INTO `Bitacora`(accion, fecha)
        VALUES (CONCAT('Se modificó la contraseña del estudiante con matricula ', OLD.matricula), NOW());
	END IF;
END $$

DELIMITER ;

DELIMITER $$
CREATE TRIGGER bitacora_delete_estudiante AFTER DELETE ON `Estudiante`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se eliminó el estudiante con matrícula ', OLD.matricula), NOW());
END $$

DELIMITER ;



DELIMITER $$
CREATE TRIGGER bitacora_insert_profesor AFTER INSERT ON `Profesor`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se registro al profesor  ', NEW.nombre, ' ', NEW.apepat ), NOW());
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER bitacora_insert_carrera AFTER INSERT ON `Carrera`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se registro la carrera con nombre  ', NEW.nombre, ' y clave ', NEW.CLAVE ), NOW());
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER bitacora_delete_profesor AFTER DELETE ON `Profesor`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se eliminó el profesor ', OLD.nombre, ' ', OLD.apepat), NOW());
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER bitacora_delete_carrera AFTER DELETE ON `Carrera`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se eliminó la carrera con clave ', OLD.clave), NOW());
END $$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER bitacora_insert_calificacion AFTER INSERT ON `Calificacion`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se registró una calificación con id ', NEW.idCalificacion), NOW());
END $$

CREATE TRIGGER bitacora_update_calificacion AFTER UPDATE ON `Calificacion`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se actualizó la calificación con id ', OLD.idCalificacion), NOW());
END $$

CREATE TRIGGER bitacora_delete_calificacion AFTER DELETE ON `Calificacion`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se eliminó la calificación con id ', OLD.idCalificacion), NOW());
END $$
DELIMITER ;

DELIMITER $$

CREATE TRIGGER bitacora_insert_materia AFTER INSERT ON `Materia`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se registró la materia ', NEW.nombre , ' con clave ', NEW.clave), NOW());
END $$

CREATE TRIGGER bitacora_delete_materia AFTER DELETE ON `Materia`
FOR EACH ROW
BEGIN
    INSERT INTO `Bitacora` (accion, fecha)
    VALUES (CONCAT('Se eliminó la materia ', OLD.nombre, ' con clave ', OLD.clave), NOW());
END $$

DELIMITER ;

