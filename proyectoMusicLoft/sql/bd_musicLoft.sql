-- MySQL Script generated by MySQL Workbench
-- Thu Apr 18 20:10:39 2019
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema bd_musicLoft
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `bd_musicLoft` ;

-- -----------------------------------------------------
-- Schema bd_musicLoft
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bd_musicLoft` DEFAULT CHARACTER SET utf8 ;
USE `bd_musicLoft` ;

-- -----------------------------------------------------
-- Table `bd_musicLoft`.`establecimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_musicLoft`.`establecimiento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `contrasena` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(45) NOT NULL,
  `informacion` VARCHAR(45) NOT NULL,
  `hombres` INT NULL,
  `mujeres` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `bd_musicLoft`.`establecimiento` (`id` ASC);

CREATE UNIQUE INDEX `correo_UNIQUE` ON `bd_musicLoft`.`establecimiento` (`correo` ASC);


-- -----------------------------------------------------
-- Table `bd_musicLoft`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_musicLoft`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(45) NOT NULL,
  `contrasena` VARCHAR(45) NOT NULL,
  `sexo` ENUM('hombre', 'mujer') NOT NULL,
  `token` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `correo_UNIQUE` ON `bd_musicLoft`.`usuario` (`correo` ASC);

CREATE UNIQUE INDEX `id_UNIQUE` ON `bd_musicLoft`.`usuario` (`id` ASC);


-- -----------------------------------------------------
-- Table `bd_musicLoft`.`usulocal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_musicLoft`.`usulocal` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idLocal` INT NOT NULL,
  `idUsuario` INT NOT NULL,
  `monedasVirtuales` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `id_localadmin`
    FOREIGN KEY (`idLocal`)
    REFERENCES `bd_musicLoft`.`establecimiento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `id_usuario`
    FOREIGN KEY (`idUsuario`)
    REFERENCES `bd_musicLoft`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `id_UNIQUE` ON `bd_musicLoft`.`usulocal` (`id` ASC);

CREATE INDEX `id_localadmin_idx` ON `bd_musicLoft`.`usulocal` (`idLocal` ASC);

CREATE INDEX `id_usuario_idx` ON `bd_musicLoft`.`usulocal` (`idUsuario` ASC);


-- -----------------------------------------------------
-- Table `bd_musicLoft`.`cancion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_musicLoft`.`cancion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idLocal` INT NOT NULL,
  `titulo` VARCHAR(45) NOT NULL,
  `artista` VARCHAR(45) NOT NULL,
  `foto` VARCHAR(255) NOT NULL,
  `precio` VARCHAR(45) NOT NULL,
  `precioTotal` VARCHAR(45) NOT NULL,
  `cantidadSeleccionada` VARCHAR(45) NOT NULL,
  `escuchado` INT NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `nombreFichero` VARCHAR(200) NOT NULL,
  `contador` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `id_local`
    FOREIGN KEY (`idLocal`)
    REFERENCES `bd_musicLoft`.`establecimiento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `id_local_idx` ON `bd_musicLoft`.`cancion` (`idLocal` ASC);

CREATE UNIQUE INDEX `id_UNIQUE` ON `bd_musicLoft`.`cancion` (`id` ASC);


-- -----------------------------------------------------
-- Table `bd_musicLoft`.`codigoqr`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_musicLoft`.`codigoqr` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idlocal` INT NOT NULL,
  `codQR` VARCHAR(45) NOT NULL,
  `precio` VARCHAR(45) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `id_establecimiento`
    FOREIGN KEY (`idlocal`)
    REFERENCES `bd_musicLoft`.`establecimiento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `id_local_idx` ON `bd_musicLoft`.`codigoqr` (`idlocal` ASC);

CREATE UNIQUE INDEX `id_UNIQUE` ON `bd_musicLoft`.`codigoqr` (`id` ASC);


-- -----------------------------------------------------
-- Table `bd_musicLoft`.`empleado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bd_musicLoft`.`empleado` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idLocal` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(45) NOT NULL,
  `contrasena` VARCHAR(45) NOT NULL,
  `sexo` ENUM('hombre', 'mujer') NOT NULL,
  `token` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `idLocal`
    FOREIGN KEY (`idLocal`)
    REFERENCES `bd_musicLoft`.`establecimiento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE UNIQUE INDEX `correo_UNIQUE` ON `bd_musicLoft`.`empleado` (`correo` ASC);

CREATE UNIQUE INDEX `id_UNIQUE` ON `bd_musicLoft`.`empleado` (`id` ASC);

CREATE INDEX `idLocal_idx` ON `bd_musicLoft`.`empleado` (`idLocal` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- Volcado de datos
--

INSERT INTO `establecimiento` (`id`,`nombre`, `contrasena`, `correo`, `informacion`, `hombres`, `mujeres`) VALUES
(1,'Clasica', 'clasica1234', 'clasica@clasica.com', 'Electronica, Pop, Tecno',40,30),
(2,'4-Calles', '1234', '4calles@4calles.com', 'Metal,Rap, Heavy ,Rock and Roll',20,30),
(3,'Premium', '1234', 'premium@premium.com', 'Rumba,Blues,Reggeton, Punk',10,20),
(4,'Kapital', '1234', 'kapital@kapital.com', 'Pop,House',0,0);
COMMIT;

INSERT INTO `codigoqr` (`id`,`idLocal`,`codQR`,`precio`, `url`) VALUES
(1,'1','aaaa0005','5','http://drive.google.com/uc?export=view&id=1vZ9ZFVYXhcc18PU28lpXdqmFTDMGbzha'),
(2,'1','aaaa0010','10','http://drive.google.com/uc?export=view&id=17tSIo2dVIF_rRCS1SUR5XTqCYRtI0Xcs'),
(3,'1','aaaa0015','15','http://drive.google.com/uc?export=view&id=1qPDolzkNLFAPF7Jc7z-leyi9RxuOO0SQ'),
(4,'1','aaaa0020','20','http://drive.google.com/uc?export=view&id=1BzX0XkCvUfjnlGJi8skzHHTAdeJDz9Mu'),
(5,'1','aaaa0025','25','http://drive.google.com/uc?export=view&id=1BzX0XkCvUfjnlGJi8skzHHTAdeJDz9Mu'),
(6,'2','aaab0005','5', 'http://drive.google.com/uc?export=view&id=1HBxj6DMOFUd-B-TpIfunMU7coaG8ABc9'),
(7,'2','aaab0010','10', 'http://drive.google.com/uc?export=view&id=1HBxj6DMOFUd-B-TpIfunMU7coaG8ABc9'),
(8,'2','aaab0015','15', 'http://drive.google.com/uc?export=view&id=1HBxj6DMOFUd-B-TpIfunMU7coaG8ABc9'),
(9,'2','aaab0020','20', 'http://drive.google.com/uc?export=view&id=1HBxj6DMOFUd-B-TpIfunMU7coaG8ABc9'),
(10,'2','aaab0025','25', 'http://drive.google.com/uc?export=view&id=1HBxj6DMOFUd-B-TpIfunMU7coaG8ABc9');
COMMIT;


INSERT INTO `usuario` (`id`,`nombre`,`correo`, `contrasena`,`sexo`,`token`) VALUES
(1,'cliente','cliente@gmail.com',  'cliente1234','hombre',''),
(2,'Adriana','adriana@adriana',  '1234', 'mujer',''),
(3,'Max', 'a', 'a', 'hombre',''),
(4,'jefferson', 'jeffersonmax90@gmail.com', 'jefferson1234', 'hombre','');
COMMIT;

INSERT INTO `empleado` (`id`,`idLocal`,`nombre`,`correo`, `contrasena`,`sexo`,`token`) VALUES
(1,1,'camarero1','camarero@clasica.com',  'clasica1234','mujer',''),
(2,1,'camarero2','camarero2@clasica.com',  'clasica1234', 'hombre',''),
(3,2,'camarero3', 'camarero3', '1234', 'hombre','');
COMMIT;

INSERT INTO `usulocal` (`id`,`idLocal`,`idUsuario`, `monedasVirtuales`) VALUES
(1,2,1,'250'),
(2,2,3,'250'),
(3,3,3,'10'),
(4,1,4,'100');
COMMIT;

INSERT INTO `cancion` (`id`,`idLocal`,`titulo`, `artista`, `foto`, `precio`, `precioTotal`,`cantidadSeleccionada`,`escuchado`,`tipo`,`nombreFichero`,`contador`) VALUES
(1,1,'beckyyNatthi-SinPijama', 'beckyyNatthi', 'http://diariometro.com.ni/wp-content/uploads/2018/10/BECKY-G.jpg', 5, 5, 1,0,'audio','beckyyNatthi-SinPijama',20),
(2,1,'moratalvaro-yoContigoTuConmigo', 'moratalvaro', 'https://e.radio-corazon.io/normal/2017/11/14/151715_519207.jpg', 5, 5, 1,0,'audio','moratalvaro-yoContigoTuConmigo',10),
(3,1,'kiesza-Hideaway', 'kieza', 'http://pop4parents.com/sites/default/files/song-images/kiesza--hideaway.jpg', 5, 45, 9,0,'video','kiesza-Hideaway',30),
(4,1,'Lykke LI-I Follow Rivers', 'Lykke Li', 'https://i1.sndcdn.com/artworks-000051074839-cdgv24-t500x500.jpg', 5, 35, 7,0,'video','Lykke LI-I Follow Rivers',3),
(5,2,'beckyyNatthi-SinPijama', 'beckyyNatthi', 'http://diariometro.com.ni/wp-content/uploads/2018/10/BECKY-G.jpg', 5, 20, 4,0,'audio','beckyyNatthi-SinPijama',50),
(6,2,'jason-derulo', 'jason-derulo', 'https://media.brstatic.com/2016/12/28063219/jason-derulo-house-sold-1-intro.jpg', 5, 50, 10,0,'audio','jason-derulo',42),
(7,2,'jbalvin-Bonita', 'jbalvin-Bonita', 'https://f4.bcbits.com/img/a3449685738_10.jpg', 5, 40, 8,0,'audio','jbalvin-Bonita',36),
(8,2,'moratalvaro-yoContigoTuConmigo', 'moratalvaro', 'https://e.radio-corazon.io/normal/2017/11/14/151715_519207.jpg', 5, 30, 6,0,'audio','moratalvaro-yoContigoTuConmigo',15),
(9,2,'redFoo-newThang', 'redFoo-newThang', 'https://i.vimeocdn.com/video/487254569_1280x720.jpg', 5, 10, 2,0,'audio','edFoo-newThang',35),
(10,2,'kiesza-Hideaway', 'kieza', 'http://pop4parents.com/sites/default/files/song-images/kiesza--hideaway.jpg', 5, 45, 9,0,'video','kiesza-Hideaway',27),
(11,2,'Lykke LI-I Follow Rivers', 'Lykke Li', 'https://i1.sndcdn.com/artworks-000051074839-cdgv24-t500x500.jpg', 5, 35, 7,0,'video','Lykke LI-I Follow Rivers',3),
(12,2,'shakiraMaluma-clandestino', 'Shakira y Maluma', 'https://estaticos.elperiodico.com/resources/jpg/6/0/1528449696806.jpg', 6, 12, 2,0,'video','shakiraMaluma-clandestino',2),
(13, 1, 'Fleetwood Mac - Seven Wonders', 'Fleetwood Mac', 'https://i.ytimg.com/vi/9b4F_ppjnKU/maxresdefault.jpg', '5', 10, 2, 0, 'video', 'fleetwood_mac_seven_wonders_official_music_video', 0),
(14, 1, 'Fuel Fandango-Trece_lunas', 'Alejandro Acosta y Nita', 'https://warnermusic.es/wp-content/uploads/2016/05/fuel-fandango-trece-lunas.jpg', '5', 10, 2, 0, 'video', 'fuel_fandango_trece_lunas_lyric_video', 22),
(15, 1, 'Make the girl dance_bayby_baby', 'Make the girl dance', 'https://i.ytimg.com/vi/htYm5hVPLK8/maxresdefault.jpg', '7', 7, 1, 0, 'video', 'make_the_girl_dance_baby_baby_baby', 0),
(16, 1, 'Sade- smooth operator', 'sade', 'https://softbackingtracks.com/wp-content/uploads/2019/03/smooth-operator-FM-s.jpg', '5', 10, 2, 0, 'video', 'sade_smooth_operator_official360p', 40),
(17, 1, 'I Love It', 'Sneaky Sound System', 'https://images.991.com/large_image/Sneaky+Sound+System+I+Love+It-470793.jpg', '5', 10, 2, 0, 'video', 'sneaky_sound_system_i_love_it', 0),
(18, 1, 'The Derevolutions- Its a Derevolution Baby', 'The Derevolutions', 'https://i.ytimg.com/vi/z3JIZgSnp2A/maxresdefault.jpg', '5', 10, 2, 0, 'video', 'the_derevolutions_its_a_derevolution_baby_', 0),
(19, 1, 'The Presets- Kicking and Screaming', 'The Presets', 'https://i.ytimg.com/vi/vOjgDZsN7LA/hqdefault.jpg', '5', 10, 2, 0, 'video', 'the_presets_kicking_and_screaming_live_', 0),
(20, 1, 'shakira y maluma-clandestino_s', 'shakira&maluma', 'https://estaticos.elperiodico.com/resources/jpg/6/0/1528449696806.jpg', '5', 0, 0, 0, 'video', 'shakiramaluma-clandestino', 0);

COMMIT;