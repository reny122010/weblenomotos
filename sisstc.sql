# Host: localhost  (Version 5.5.5-10.1.13-MariaDB)
# Date: 2017-06-08 23:26:20
# Generator: MySQL-Front 5.3  (Build 5.39)

/*!40101 SET NAMES latin1 */;

#
# Structure for table "tbcliente"
#

CREATE TABLE `tbcliente` (
  `cpf` bigint(20) NOT NULL DEFAULT '0',
  `nome` varchar(255) CHARACTER SET latin1 NOT NULL,
  `logradouro` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `cidade` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `bairro` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `telefone` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `limite` decimal(10,2) DEFAULT NULL,
  `sobrenome` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `debito` decimal(10,2) NOT NULL DEFAULT '0.00',
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "tbcliente"
#


#
# Structure for table "tbcompra"
#

CREATE TABLE `tbcompra` (
  `Idcompra` int(11) NOT NULL AUTO_INCREMENT,
  `cpfcliente` bigint(20) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`Idcompra`),
  KEY `cpfcliente` (`cpfcliente`),
  CONSTRAINT `tbcompra_ibfk_1` FOREIGN KEY (`cpfcliente`) REFERENCES `tbcliente` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

#
# Data for table "tbcompra"
#


#
# Structure for table "tbpagamento"
#

CREATE TABLE `tbpagamento` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `cpfcliente` bigint(20) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `cpfcliente` (`cpfcliente`),
  CONSTRAINT `tbpagamento_ibfk_1` FOREIGN KEY (`cpfcliente`) REFERENCES `tbcliente` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

#
# Data for table "tbpagamento"
#


#
# Structure for table "tbproduto"
#

CREATE TABLE `tbproduto` (
  `Idproduto` int(11) NOT NULL AUTO_INCREMENT,
  `codigodebarras` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `nome` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT '0.00',
  `custo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantidade` int(11) DEFAULT NULL,
  `unidade` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `ativo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Idproduto`),
  UNIQUE KEY `codigodebarras` (`codigodebarras`)
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;

#
# Data for table "tbproduto"
#

INSERT INTO `tbproduto` VALUES (15,'00001','patins de freio  /cobreq',22.40,14.50,21,'UN',1),(16,'00002','patins de freio cobreq',22.00,14.00,5,'UN',1),(18,'00005','oléo mobil 4t mix',25.00,14.00,10,'UN',0),(19,'00007','carburador NXR 03/05 Audax',105.00,74.00,1,'UN',0),(20,'00008','Diagragma do carburador twister/tornado /peças',28.00,11.00,3,'UN',0),(21,'00009','Reparo do carburador CBX 250',18.00,9.00,4,'UN',0),(22,'00010','câmara de ar 14 pirelli',35.00,22.00,3,'UN',0),(23,'00011','câmara de ar 14 velth',28.00,17.00,4,'UN',0),(24,'00012','câmara de ar 14 vulcan',28.00,17.00,3,'UN',0),(25,'00013','câmara de ar 17 pirelli',35.00,22.00,5,'UN',0),(26,'00014','Câmara de ar 17 levorin',30.00,13.00,5,'UN',0),(27,'00015','câmara de ar 17 velth',28.00,17.00,1,'UN',0),(28,'00016','câmara de ar 18 vulcan',28.00,17.00,2,'UN',0),(29,'00017','câmara de ar 18 pirelli',35.00,22.00,7,'UN',0),(30,'00018','câmara de ar 18 kb',28.00,16.00,5,'UN',0),(31,'00019','câmara de ar MB 18 traz. torn/xr/xre/pirelli',45.00,32.00,1,'UN',0),(32,'00020','câmara de ar mc 17 traz/bros/ pirelli',45.00,33.00,1,'UN',0),(33,'00021','câmara de ar 21 diant/torn/xr/xre/xlr/buty',35.00,19.00,1,'UN',0),(34,'00022','CâMARA DE AR 400-17 bros /traz /kb',35.00,19.00,2,'UN',0),(35,'00023','câmara de ar vtb 17 bros/traz/velth',35.00,19.00,2,'UN',0),(36,'00024','capacete samarino 58 preto',140.00,99.00,1,'UN',0),(37,'00025','capacete samarino 58 vermelho',140.00,99.00,2,'UN',0),(38,'00026','capacete samarino ',140.00,99.00,0,'UN',0),(39,'00027','capacete samarino ',140.00,99.00,0,'UN',0),(40,'00028','capacete libert 58 rosa',78.00,49.00,1,'UN',0),(41,'00029','capacete libert 58 vermelho',78.00,47.00,1,'UN',0),(42,'00030','capacete libert 58 preto',78.00,47.00,1,'UN',0),(43,'00031','capacete libert 58 branco',78.00,47.00,1,'UN',0),(44,'00032','capacete libert 58',78.00,47.00,0,'UN',0),(45,'00033','capa de banco 150 /campinas capas',25.00,9.00,1,'UN',0),(46,'00034','capa de banco 150 2009',25.00,9.00,8,'UN',0),(47,'00035','capa de banco 2000',25.00,9.00,2,'UN',0),(48,'00036','capa de banco ybr / campinas capa ',25.00,9.00,2,'UN',0),(49,'00037','capa de banco BIZ 125 2008',25.00,11.00,2,'UN',0),(50,'00038','capa de banco BIZ 125 2013 /campinas capa ',30.00,12.00,2,'UN',0),(51,'00039','capa de banco BIZ 100 /campinas capas',25.00,9.00,2,'UN',0),(52,'00040','capa de banco JET',30.00,11.00,2,'UN',0),(53,'00041','capa de banco shineray fénix',25.00,9.00,2,'UN',0),(54,'00042','capa de banco POP/campinas capa ',25.00,9.00,2,'UN',0),(55,'00044','capa de banco CB 300',38.00,14.00,2,'UN',0),(56,'00054','capa de banco TORNADO /campinas capas',25.00,11.00,2,'UN',0),(57,'00046','capa de banco 99 /campinas capas',25.00,9.00,2,'UN',0),(58,'00047','capa de banco BROS 2008/campinas capas',30.00,11.00,2,'UN',0),(59,'00048','capa de banco BROS 2009/campinas capas',30.00,11.00,0,'UN',0),(60,'00049','capa de banco ',25.00,9.00,0,'UN',0),(61,'00050','capa de banco ',25.00,9.00,0,'UN',0),(62,'00051','capa protetora ´`P `´',36.00,19.00,2,'UN',0),(63,'00052','capa protetora G',36.00,19.00,1,'UN',0),(64,'00053','Interroptor de partida YBR 125/09/scud',39.00,15.00,5,'UN',0),(65,'00055','Interroptor de partida fan 125/2009 scud',26.00,12.00,1,'UN',0),(66,'00056','Interroptor de partida NXR 150 2009 scud',28.00,12.00,3,'UN',0),(67,'00057','Interroptor de partida BROS 150/09 magnetron',44.00,21.00,1,'UN',0),(68,'00058','INTERROPITOR DE EMERG.PARTIDA NX200/condor',25.00,11.00,1,'UN',0),(69,'00059','Punho CG mod. orig/moto2000',10.00,3.00,6,'UN',1),(70,'00060','Punho Bros mod.orig/footflex',10.00,3.00,2,'UN',0),(71,'00061','Punho circuito cinza ',38.00,14.00,2,'UN',0),(72,'00062','punho rosa / klarion',32.00,17.00,2,'UN',0),(73,'00063','punho lilas',32.00,17.00,1,'UN',0),(74,'00064','punho vermelho /klarion',32.00,17.00,2,'UN',0),(75,'00065','punho',32.00,17.00,0,'UN',0),(76,'00066','punho',0.00,0.00,0,'UN',0),(77,'00067','punho',0.00,0.00,0,'UN',0),(78,'00068','chave de luz XY50q lad.direito/rialli',38.00,17.00,5,'UN',0),(79,'00069','CHAVE DE LUZ XRE /HONDA',89.00,53.00,2,'UN',0),(80,'00070','chave de luz CB 300/ honda',95.00,59.00,1,'UN',0),(81,'00071','chave de luz 2000/honda',80.00,49.00,2,'UN',0),(82,'00072','chave de luz 150 2009',90.00,58.00,2,'UN',0),(83,'00073','chave de luz POP /honda',85.00,58.00,1,'UN',0),(84,'00074','chave de luz shineray ',58.00,28.00,1,'UN',0),(85,'00075','filtro de ar Bros /150/ tiofil',18.00,7.00,8,'UN',0),(86,'00076','filtro de ar 125 2000/ rifel',18.00,7.00,1,'UN',0),(87,'00077','filtro de ar 150 2014/ filtran',25.00,11.00,5,'UN',0),(88,'00078','filtro de ar 150 2000',18.00,7.00,3,'UN',0),(89,'00079','filtro de ar BIZ 125 2012/duramax',25.00,12.00,2,'UN',0),(90,'00080','filtro de ar TORNADO / filtran',18.00,8.00,3,'UN',0),(91,'00081','filtro de ar CB 300/dannixx',30.00,15.00,4,'UN',0),(92,'00082','FILTRO DE AR XRE 300/ dannixx',30.00,16.00,3,'UN',0),(93,'00083','filtro de ar XRE 300/riffel',28.00,14.00,1,'UN',0),(94,'00084','FILTRO DE AR CRF 230/peças',64.00,48.00,2,'UN',0),(95,'00085','filtro de ar XTZ esponja ',3.00,1.00,5,'UN',0),(96,'00086','filtro de ar YBR esponja',3.00,1.00,7,'UN',0),(97,'00087','filtro de ar shineray esponja ',7.00,2.00,5,'UN',0),(98,'00088','filtro de ar shineray caixa completa ',52.00,22.00,1,'UN',0),(99,'00089','caixa de filtro de ar cinquentinha',38.00,16.00,1,'UN',0),(100,'00090','espelho de freio /traz BIZ /POP /redfox',35.00,18.00,1,'UN',0),(101,'00091','espelho de freio /diant.pop 100',68.00,34.00,1,'UN',0),(102,'00092','franger da coroa XY 50q phoenix',48.00,24.00,2,'UN',0),(103,'00093','franger da coroa shineray',42.00,24.00,3,'UN',0),(104,'00094','platôr de embreagem CG 150/bros150/scud',35.00,14.00,5,'UN',0),(105,'00095','platôr de embreagem titan /1995-2004',35.00,17.00,2,'UN',0),(106,'00096','platôr de embreagem YBR 125',25.00,14.00,2,'UN',0),(107,'00097','platôr de embreagem twister/tornado',38.00,16.00,1,'UN',0),(108,'00098','cubo de embreagem CG 125 1995-2004',38.00,17.00,2,'UN',0),(109,'00099','cubo de enbreagem twister/tornado',38.00,17.00,1,'UN',0),(110,'00100','cubo de embreagem CG 150/BROS150',38.00,17.00,4,'UN',0),(111,'00101','cubo de embreagem',0.00,0.00,0,'UN',0),(112,'00102','rede /capacete',7.00,1.00,5,'UN',0),(113,'00103','filtro de gasolina shineray/cg',5.00,1.00,34,'UN',0),(114,'00104','filtro de combustivel 150/ 741',14.00,6.00,5,'UN',0),(115,'00105','filtro de combustivel 125/740',14.00,6.00,3,'UN',0),(116,'00106','filtro de oléo xr/cb300/nx/xre',10.00,2.00,5,'UN',0),(117,'00107','filtro de oléo xlr/nx/twister /cb300',10.00,3.00,4,'UN',0),(118,'00108','filtro de oléo fazer/lander 250',10.00,2.00,4,'UN',0),(119,'00109','lamera da balança cg 2000',8.00,2.00,2,'UN',0),(120,'00110','lamera da balança cg 150',8.00,3.00,4,'UN',0),(121,'00111','lamera do paralama cg',8.00,2.00,5,'UN',0),(122,'00112','lamera pop',5.00,2.00,4,'UN',0),(123,'00113','lamera da moster',5.00,2.00,4,'UN',0),(124,'00114','Biela completa BIZ 125',62.00,38.00,3,'UN',0),(125,'00115','Biela completa cg 150',90.00,52.00,2,'UN',0),(126,'00116','Biela completa cg 125 2009',78.00,48.00,1,'UN',0),(127,'00117','Biela crypton',98.00,58.00,1,'UN',0),(128,'00118','Guia de corrente shineray ',18.00,8.00,15,'UN',0),(129,'00119','Guia de corrente 150 2014',22.00,9.00,5,'UN',0),(130,'00120','Guia de corrente tornado ',19.00,9.00,1,'UN',0),(131,'00121','Guia de corrente nxr bros 125',22.00,9.00,3,'UN',0),(132,'00122','Pedaleira traz cg',26.00,14.00,2,'UN',0),(133,'00123','Borracha do estribo cg',5.00,1.00,20,'UN',0),(134,'00124','Borracha do estribo BIZ ',5.00,2.00,12,'UN',0),(135,'00125','Borracha do estribo shineray',8.00,4.00,14,'UN',0),(136,'00126','Borracha do estribo Bros',10.00,4.00,12,'UN',0),(137,'00127','Tração 125 2000 riffel 1045',78.00,49.00,2,'UN',0),(138,'00128','Tração 125 2000 unifort',68.00,39.00,2,'UN',0),(139,'00129','Tração 125 2009 riffel 1045',78.00,52.00,6,'UN',0),(140,'00130','tração 125 2009',78.00,48.00,0,'UN',0),(141,'00131','Tração 150 riffel 1045',78.00,52.00,3,'UN',0),(142,'00132','tração 150',78.00,42.00,0,'UN',0),(143,'00133','Tração Biz riffel 1045',78.00,49.00,0,'UN',0),(144,'00134','Tração Biz riffel',68.00,39.00,3,'UN',0),(145,'00135','Tração Bros riffel 1045',110.00,89.00,5,'UN',0),(146,'00136','Tração BROS 160',98.00,79.00,3,'UN',0),(147,'00137','Tração shineray 36 dentes',65.00,36.00,1,'UN',0),(148,'00138','Tração shineray 45 dentes',65.00,36.00,3,'UN',0),(149,'00139','Tração CB 300 scud',158.00,96.00,1,'UN',0),(150,'00140','Tração YBR unifort',65.00,39.00,1,'UN',0),(151,'00141','Tração YBR riffel',68.00,41.00,2,'UN',0),(152,'00142','Tração TWISTER',95.00,69.00,1,'UN',0),(153,'00143','Tração XRE 300 unifort',110.00,82.00,5,'UN',0),(154,'00144','Tração Tornado /xr /riffel 1045',128.00,89.00,1,'UN',0),(155,'00145','Tração 99 unifort',65.00,39.00,2,'UN',0),(156,'00146','Bateria moura 5 ap',150.00,102.00,2,'UN',0),(157,'00147','Bateria moura 7 ap ',170.00,114.00,0,'UN',0),(158,'00148','Bateria pioneiro 5 ap',120.00,82.00,8,'UN',0),(159,'00149','Bateria pioneiro 7 ap',145.00,102.00,0,'UN',0),(160,'00150','YSLAYDE HONDA',55.00,28.00,5,'UN',0),(161,'00151','Alça traz titan',65.00,39.00,5,'UN',0),(162,'00152','Tampa do tainque shineray',25.00,11.00,3,'UN',0),(163,'00153','Tampa do tainque YBR/XTZ 125 06/08',42.00,22.00,1,'UN',0),(164,'00154','Tampa do tainque 83/88',22.00,11.00,3,'UN',0),(165,'00155','Tampa do tainque CG',28.00,12.00,3,'UN',0),(166,'00000008','Ruan',12.70,9.00,6,'UN',0),(167,'1111','Teste',10.51,10.00,10,'UN',0),(168,'10000','Teste1',100.00,10.00,100,'UN',0),(169,'33333','Teste',50.00,10.00,50,'UN',0),(170,'15550303','Teste',19.10,14.50,50,'KG',1),(171,'5040404','Teste1',12.60,10.10,4,'KG',1),(172,'3333','Teste3',10.00,20.50,50,'KG',1),(173,'1234','Teste4',10.01,5.02,2,'UN',1),(174,'4344444','Rene teste',10.50,3.21,10,'M',1),(175,'5444444','Teste Rene',10.50,52.12,50,'KG',1),(176,'44454545454','Teste 6',20.40,120.10,1099,'UN',1),(177,'55454537437','rererer',13.50,21.34,404,'UN',1);

#
# Structure for table "tbprodutosparacompra"
#

CREATE TABLE `tbprodutosparacompra` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `idcompra` int(11) DEFAULT NULL,
  `idproduto` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `idcompra` (`idcompra`),
  KEY `idproduto` (`idproduto`),
  CONSTRAINT `tbprodutosparacompra_ibfk_1` FOREIGN KEY (`idcompra`) REFERENCES `tbcompra` (`Idcompra`),
  CONSTRAINT `tbprodutosparacompra_ibfk_2` FOREIGN KEY (`idproduto`) REFERENCES `tbproduto` (`Idproduto`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8;

#
# Data for table "tbprodutosparacompra"
#


#
# Trigger "addcompra"
#

CREATE DEFINER='root'@'localhost' TRIGGER `addcompra` AFTER UPDATE ON `tbcompra`
  FOR EACH ROW BEGIN
   UPDATE tbcliente
   SET debito = debito+new.valor
   WHERE cpf = new.cpfcliente;

END;

#
# Trigger "addpagamento"
#

CREATE DEFINER='root'@'localhost' TRIGGER `addpagamento` AFTER INSERT ON `tbpagamento`
  FOR EACH ROW BEGIN
   UPDATE tbcliente
   SET debito = debito-new.valor
   WHERE cpf = new.cpfcliente;
END;

#
# Trigger "AdicionarAoEstoque"
#

CREATE DEFINER='root'@'localhost' TRIGGER `AdicionarAoEstoque` AFTER DELETE ON `tbprodutosparacompra`
  FOR EACH ROW BEGIN
   UPDATE tbproduto
   SET quantidade = quantidade+old.quantidade
   WHERE idproduto = old.idproduto;
END;

#
# Trigger "antesDeUpdate_empregados"
#

CREATE DEFINER='root'@'localhost' TRIGGER `antesDeUpdate_empregados` BEFORE DELETE ON `tbpagamento`
  FOR EACH ROW BEGIN
update tbcliente set debito = debito + old.valor where old.cpfcliente = cpf;


END;

#
# Trigger "RemoveDoEstoque"
#

CREATE DEFINER='root'@'localhost' TRIGGER `RemoveDoEstoque` AFTER INSERT ON `tbprodutosparacompra`
  FOR EACH ROW BEGIN
   UPDATE tbproduto
   SET quantidade = quantidade-NEW.quantidade
   WHERE idproduto = NEW.idproduto;
END;

#
# Trigger "retiraDebito"
#

CREATE DEFINER='root'@'localhost' TRIGGER `retiraDebito` BEFORE DELETE ON `tbcompra`
  FOR EACH ROW BEGIN
  IF (not old.data is null) THEN
   update tbcliente set debito = debito - old.valor where old.cpfcliente = cpf;
 END IF;
END;
