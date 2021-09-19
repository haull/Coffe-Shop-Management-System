/*
SQLyog Community v12.09 (64 bit)
MySQL - 10.4.11-MariaDB : Database - kopihub
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kopihub` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `kopihub`;

/*Table structure for table `detail_pesanan` */

DROP TABLE IF EXISTS `detail_pesanan`;

CREATE TABLE `detail_pesanan` (
  `no_pesanan` int(11) NOT NULL,
  `id_menu` varchar(4) NOT NULL,
  `id_pembayaran` int(11) NOT NULL,
  `id_pegawai` varchar(4) NOT NULL,
  `qty` int(11) DEFAULT NULL,
  KEY `no_pesanan` (`no_pesanan`) USING BTREE,
  KEY `id_menu` (`id_menu`) USING BTREE,
  KEY `id_pembayaran` (`id_pembayaran`) USING BTREE,
  KEY `id_pegawai` (`id_pegawai`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

/*Data for the table `detail_pesanan` */

insert  into `detail_pesanan`(`no_pesanan`,`id_menu`,`id_pembayaran`,`id_pegawai`,`qty`) values (27,'AR02',0,'P002',1),(27,'AR03',0,'P002',1),(28,'AR02',0,'P002',1),(28,'AR03',0,'P002',2),(29,'AR04',0,'P003',10),(29,'AR05',0,'P003',2),(30,'AR02',0,'P002',11),(30,'AR03',0,'P002',1),(31,'AR02',0,'P002',1),(32,'AR04',0,'P002',2),(32,'AR05',0,'P002',3),(33,'AR05',0,'P002',2),(36,'AR04',0,'P002',2),(38,'AR04',0,'P002',2),(39,'AR04',0,'P002',1),(39,'AR05',0,'P002',3),(40,'AR04',0,'P002',2),(40,'AR05',0,'P002',1);

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id_menu` varchar(4) NOT NULL,
  `nama_menu` varchar(50) NOT NULL,
  `harga` double NOT NULL,
  `stok` int(11) DEFAULT NULL,
  `gambar_menu` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id_menu`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

/*Data for the table `menu` */

insert  into `menu`(`id_menu`,`nama_menu`,`harga`,`stok`,`gambar_menu`,`deskripsi`) values ('AR01','Es Kopi',20000,50,'KopiHub Image 04-08-21 eskopi.jpg','Kopi manis tapi dingin sih'),('AR02','Americano',20000,50,'KopiHub Image 04-08-21 americano.jpg','Pahit tapi bisa ditambahin gula sesuai seleramu'),('AR05','Tubruk',10000,50,'tubruk.jpg','Kopi hitam dengan seduhan manual khas indonesia'),('AR07','Kopi Jos',8000,50,'KopiHub Image 04-08-21 kopijos.jpg','Menu utama yang paling mantep rasanya tapi murah'),('AR08','V60',25000,50,'KopiHub Image 04-08-21 v60.jpg','Kopi paling indie banget cocok sambil sebat'),('AR09','Vietnam Drip',15000,50,'KopiHub Image 04-08-21 vietnam drip.jpg','Ini kopi paling cocok buat pemula karena ada rasa manis susu');

/*Table structure for table `pegawai` */

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `id_pegawai` varchar(4) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `jk` enum('L','P') NOT NULL,
  `jabatan` enum('pelayan','barista','kasir') NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id_pegawai`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

/*Data for the table `pegawai` */

insert  into `pegawai`(`id_pegawai`,`nama`,`alamat`,`jk`,`jabatan`,`password`) values ('P001','Udin Hernandez','Jl Jakarta No.29','L','pelayan','827ccb0eea8a706c4c34a16891f84e7b'),('P002','Vena Hermione','Jl. Batununggal No.120','P','kasir','e10adc3949ba59abbe56e057f20f883e'),('P003','Agus Supriatno','Jl. Soekarno Hata No.89','L','barista','fcea920f7412b5da7be0cf42b8c93759');

/*Table structure for table `pembayaran` */

DROP TABLE IF EXISTS `pembayaran`;

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `total_harga` double NOT NULL,
  `no_pesanan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pembayaran`) USING BTREE,
  KEY `fk_no_pesanan` (`no_pesanan`) USING BTREE,
  CONSTRAINT `fk_no_pesanan` FOREIGN KEY (`no_pesanan`) REFERENCES `pesanan` (`no_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

/*Data for the table `pembayaran` */

insert  into `pembayaran`(`id_pembayaran`,`tanggal`,`total_harga`,`no_pesanan`) values (1,'2021-07-15',222222222,NULL),(2,'2021-07-29',170000,NULL),(3,'2021-07-29',55000,28),(4,'2021-07-29',290000,31),(5,'2021-07-29',290000,30),(6,'2021-07-30',60000,32),(7,'2021-07-31',30000,38);

/*Table structure for table `pesanan` */

DROP TABLE IF EXISTS `pesanan`;

CREATE TABLE `pesanan` (
  `no_pesanan` int(11) NOT NULL AUTO_INCREMENT,
  `no_meja` char(3) NOT NULL,
  `status_pesanan` int(11) NOT NULL COMMENT '0 = belum, 1 = belum dibayar, 2 = sudah dibayar',
  `jumlah_pesanan` int(11) NOT NULL,
  `sub_total` double NOT NULL,
  PRIMARY KEY (`no_pesanan`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

/*Data for the table `pesanan` */

insert  into `pesanan`(`no_pesanan`,`no_meja`,`status_pesanan`,`jumlah_pesanan`,`sub_total`) values (22,'12',0,1,123000),(27,'8',2,2,40000),(28,'9',2,3,55000),(29,'99',2,12,170000),(30,'124',2,12,290000),(31,'1',2,1,25000),(32,'18',2,5,60000),(33,'20',1,2,20000),(34,'99',0,2,30000),(35,'99',0,2,30000),(36,'99',0,2,30000),(37,'100',0,2,30000),(38,'AR2',2,2,30000),(39,'1',0,4,45000),(40,'3',1,3,40000);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
