/*
MySQL Backup
Source Server Version: 5.0.18
Source Database: Selena
Date: 24.11.2011 00:29:50
*/


-- ----------------------------
--  Table structure for `p_sw`
-- ----------------------------
DROP TABLE IF EXISTS `p_sw`;
CREATE TABLE `p_sw` (
  `id_pd` int(6) NOT NULL default '0',
  `VLan` int(6) default NULL,
  `switch` int(3) default NULL,
  PRIMARY KEY  (`id_pd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `p_sw` VALUES ('405','1000','122'),  ('406','1001','122'),  ('407','1002','122'),  ('402','1003','1'),  ('403','1004','1'),  ('404','1005','1'),  ('393','1006','2'),  ('394','1007','2'),  ('395','1008','2'),  ('396','1009','2'),  ('389','1010','3'),  ('390','1011','3'),  ('391','1012','3'),  ('392','1013','3'),  ('386','1014','4'),  ('387','1015','4'),  ('388','1016','4'),  ('675','1017','5'),  ('676','1018','5'),  ('677','1019','5'),  ('672','1020','5'),  ('673','1021','5'),  ('674','1022','5'),  ('667','1023','6'),  ('668','1024','6'),  ('669','1025','6'),  ('670','1026','6'),  ('671','1027','6'),  ('662','1028','7'),  ('663','1029','7'),  ('664','1030','7'),  ('665','1031','7'),  ('666','1032','7'),  ('679','1033','7'),  ('145','1034','8'),  ('146','1035','8'),  ('147','1036','8'),  ('148','1037','9'),  ('149','1038','9'),  ('143','1039','9'),  ('144','1040','9'),  ('150','1041','10'),  ('151','1042','10'),  ('152','1043','10'),  ('153','1045','10'),  ('154','1046','10'),  ('446','1047','11'),  ('447','1048','11'),  ('448','1049','11'),  ('449','1050','12'),  ('450','1051','12'),  ('451','1052','12'),  ('452','1053','12'),  ('453','1054','12'),  ('454','1055','13'),  ('455','1056','13'),  ('380','1057','14'),  ('381','1058','14'),  ('382','1059','14'),  ('383','1060','14'),  ('384','1061','14'),  ('385','1062','14'),  ('155','1063','15'),  ('156','1064','15'),  ('157','1065','15'),  ('197','1066','15'),  ('158','1067','16'),  ('159','1068','16'),  ('162','1069','16'),  ('166','1070','16'),  ('408','1071','17'),  ('409','1072','17'),  ('410','1073','17'),  ('411','1074','17'),  ('397','1075','18'),  ('398','1076','18'),  ('399','1077','18'),  ('177','1078','19'),  ('178','1079','19'),  ('179','1080','19'),  ('180','1081','19'),  ('181','1082','20'),  ('182','1083','20'),  ('183','1084','20'),  ('184','1085','20'),  ('167','1086','21'),  ('168','1087','21'),  ('169','1088','21'),  ('163','1089','22'),  ('164','1090','22'),  ('165','1091','22'),  ('160','1092','22'),  ('161','1093','22'),  ('171','1094','23'),  ('172','1095','23'),  ('173','1096','23'),  ('174','1097','23'),  ('175','1098','23'),  ('176','1099','23'),  ('400','1100','24'),  ('401','1101','24'),  ('414','1102','24'),  ('415','1103','24'),  ('371','1104','123'),  ('372','1105','25'),  ('373','1106','25'),  ('374','1107','25'),  ('375','1108','25'),  ('193','1109','25'),  ('194','1110','25'),  ('195','1111','25'),  ('190','1112','26'),  ('191','1113','26'),  ('192','1114','26'),  ('196','1115','26'),  ('186','1116','27'),  ('187','1117','27'),  ('188','1118','27'),  ('189','1119','27'),  ('365','1120','28'),  ('366','1121','28'),  ('367','1122','28'),  ('368','1123','28'),  ('369','1124','28'),  ('376','1125','29'),  ('377','1126','29'),  ('378','1127','29'),  ('379','1128','29'),  ('361','1129','30'),  ('362','1130','30'),  ('363','1131','30'),  ('364','1132','30'),  ('352','1134','31'),  ('353','1135','31'),  ('354','1136','31'),  ('355','1137','31'),  ('356','1138','31'),  ('357','1139','31'),  ('358','1140','32'),  ('359','1141','32'),  ('360','1142','32'),  ('350','1143','32'),  ('351','1144','32'),  ('346','1145','33'),  ('347','1146','33'),  ('348','1147','33'),  ('349','1148','33'),  ('343','1149','34'),  ('344','1150','34'),  ('345','1151','34'),  ('340','1152','34'),  ('341','1153','34'),  ('342','1154','34'),  ('441','1155','35'),  ('442','1156','35'),  ('443','1157','35'),  ('444','1158','35'),  ('445','1159','35'),  ('466','1163','124'),  ('467','1164','124'),  ('468','1165','124'),  ('464','1166','124'),  ('465','1167','124'),  ('458','1168','36'),  ('459','1169','36'),  ('460','1170','36'),  ('456','1171','36'),  ('457','1172','36'),  ('461','1173','37'),  ('462','1174','37'),  ('463','1175','37'),  ('477','1176','38'),  ('478','1177','38'),  ('479','1178','38'),  ('480','1179','38'),  ('481','1180','39'),  ('482','1181','39'),  ('483','1182','39'),  ('509','1183','39'),  ('507','1184','40'),  ('508','1185','40'),  ('471','1186','41'),  ('472','1187','41'),  ('473','1188','41'),  ('469','1189','41'),  ('470','1190','41'),  ('474','1191','42'),  ('475','1192','42'),  ('491','1193','43'),  ('492','1194','43'),  ('493','1195','43'),  ('494','1196','43'),  ('495','1197','44'),  ('496','1198','44'),  ('497','1199','44'),  ('498','1200','44'),  ('501','1201','45'),  ('502','1202','45'),  ('499','1203','45'),  ('500','1204','45'),  ('503','1205','46'),  ('504','1206','46'),  ('505','1207','46'),  ('506','1208','46'),  ('610','1209','47'),  ('611','1210','47'),  ('485','1211','48'),  ('486','1212','48'),  ('487','1213','48'),  ('488','1214','48'),  ('489','1215','48'),  ('490','1216','48'),  ('633','1219','125'),  ('634','1220','125'),  ('635','1221','125'),  ('636','1222','125'),  ('637','1223','125'),  ('644','1225','49'),  ('645','1226','49'),  ('646','1227','49'),  ('647','1228','49'),  ('648','1229','49'),  ('642','1230','49'),  ('643','1231','49'),  ('651','1232','50'),  ('652','1233','50'),  ('653','1234','50'),  ('654','1235','50'),  ('655','1236','50'),  ('649','1237','50'),  ('650','1238','50'),  ('656','1239','51'),  ('657','1240','51'),  ('658','1241','51'),  ('659','1242','51'),  ('660','1243','51'),  ('661','1244','51'),  ('273','1245','52'),  ('274','1246','52'),  ('275','1247','52'),  ('276','1248','52'),  ('307','1249','53'),  ('308','1250','53'),  ('293','1251','53'),  ('294','1252','53'),  ('262','1253','54'),  ('263','1254','54'),  ('264','1255','54'),  ('265','1256','54'),  ('284','1257','55'),  ('285','1258','55'),  ('282','1259','55'),  ('283','1260','55'),  ('286','1261','56'),  ('287','1262','56'),  ('288','1263','56'),  ('289','1264','56'),  ('254','1265','57'),  ('255','1266','57'),  ('256','1267','57'),  ('257','1268','57'),  ('277','1269','58'),  ('278','1270','58'),  ('279','1271','58'),  ('270','1272','58'),  ('271','1273','58'),  ('272','1274','58'),  ('280','1275','59'),  ('281','1276','59'),  ('12','1277','60'),  ('13','1278','60'),  ('14','1279','61'),  ('15','1280','61'),  ('266','1281','62'),  ('267','1282','62'),  ('268','1283','62'),  ('260','1284','62'),  ('261','1285','62'),  ('248','1286','63'),  ('249','1287','63'),  ('250','1288','64'),  ('251','1289','64'),  ('252','1290','64'),  ('246','1291','64'),  ('247','1292','64'),  ('1','1293','64'),  ('2','1294','64'),  ('3','1295','65'),  ('4','1296','65'),  ('5','1297','65'),  ('6','1298','65'),  ('258','1299','66'),  ('259','1300','66'),  ('7','1301','67'),  ('8','1302','67'),  ('9','1303','67'),  ('10','1304','67'),  ('638','1307','68'),  ('639','1308','68'),  ('640','1309','68'),  ('641','1310','68'),  ('630','1311','69'),  ('631','1312','69'),  ('632','1313','69'),  ('628','1314','69'),  ('629','1315','69'),  ('626','1316','126'),  ('627','1317','126'),  ('623','1318','70'),  ('624','1319','70'),  ('625','1320','70'),  ('619','1321','71'),  ('620','1322','71'),  ('621','1323','71'),  ('622','1324','71'),  ('613','1325','72'),  ('614','1326','72'),  ('615','1327','72'),  ('616','1328','72'),  ('617','1329','72'),  ('618','1330','72'),  ('609','1331','72'),  ('332','1332','73'),  ('333','1333','73'),  ('68','1347','73'),  ('334','1334','129'),  ('335','1335','129'),  ('329','1339','74'),  ('330','1340','74'),  ('322','1341','75'),  ('323','1342','75'),  ('324','1343','75'),  ('325','1344','75'),  ('338','1345','75'),  ('339','1346','75'),  ('43','1355','127'),  ('40','1356','127'),  ('41','1357','127'),  ('35','1358','76'),  ('36','1359','76'),  ('39','1360','76'),  ('31','1361','76'),  ('32','1362','76'),  ('25','1363','77'),  ('26','1364','77'),  ('16','1365','78'),  ('17','1366','78'),  ('22','1367','79'),  ('23','1368','79'),  ('24','1369','79'),  ('295','1370','80'),  ('296','1371','80'),  ('297','1372','80'),  ('27','1373','81'),  ('28','1374','81'),  ('29','1375','81'),  ('290','1376','81'),  ('291','1377','81'),  ('292','1378','81'),  ('45','1379','82'),  ('46','1380','82'),  ('47','1381','82'),  ('304','1382','82'),  ('305','1383','82'),  ('300','1384','83'),  ('301','1385','83'),  ('298','1386','83'),  ('299','1387','83'),  ('302','1388','83'),  ('303','1389','83'),  ('221','1390','84'),  ('222','1391','84'),  ('48','1392','84'),  ('49','1393','84'),  ('44','1394','84'),  ('217','1395','85'),  ('218','1396','85'),  ('219','1397','85'),  ('220','1398','85'),  ('214','1399','86'),  ('215','1400','86'),  ('216','1401','86'),  ('211','1402','87'),  ('212','1403','87'),  ('213','1404','87'),  ('209','1405','87'),  ('210','1406','87'),  ('206','1407','88'),  ('207','1408','88'),  ('208','1409','88'),  ('203','1410','88'),  ('204','1411','88'),  ('205','1412','88'),  ('201','1413','89'),  ('202','1414','89'),  ('199','1415','89'),  ('200','1416','89'),  ('20','1417','90'),  ('21','1418','90'),  ('18','1419','90'),  ('19','1420','90'),  ('50','1421','91'),  ('51','1422','91'),  ('33','1423','92'),  ('34','1424','92'),  ('30','1491','92'),  ('112','1425','93'),  ('113','1426','93'),  ('114','1427','93'),  ('103','1428','93'),  ('104','1429','93'),  ('227','1430','94'),  ('228','1431','94'),  ('229','1432','94'),  ('223','1433','95'),  ('224','1434','95'),  ('225','1435','95'),  ('226','1436','95'),  ('232','1437','96'),  ('233','1438','96'),  ('234','1439','96'),  ('230','1440','96'),  ('231','1441','96'),  ('236','1442','97'),  ('237','1443','97'),  ('238','1444','97'),  ('239','1445','97'),  ('242','1446','98'),  ('243','1447','98'),  ('240','1448','98'),  ('241','1449','98'),  ('244','1450','98'),  ('245','1451','98'),  ('100','1452','99'),  ('101','1453','99'),  ('102','1454','99'),  ('108','1455','100'),  ('109','1456','100'),  ('110','1457','100'),  ('111','1458','100'),  ('105','1459','100'),  ('106','1460','100'),  ('107','1461','100'),  ('115','1462','101'),  ('116','1463','101'),  ('117','1464','101'),  ('118','1465','101'),  ('119','1466','101'),  ('120','1467','102'),  ('121','1468','102'),  ('122','1469','102'),  ('131','1470','103'),  ('132','1471','103'),  ('133','1472','103'),  ('134','1473','104'),  ('135','1474','104'),  ('136','1475','104'),  ('129','1476','104'),  ('130','1477','104'),  ('123','1484','106'),  ('124','1485','106'),  ('125','1486','106'),  ('126','1487','106'),  ('127','1489','106'),  ('128','1490','106'),  ('419','1495','128'),  ('420','1496','128'),  ('421','1497','128'),  ('422','1498','128'),  ('427','1499','107'),  ('428','1500','107'),  ('429','1501','107'),  ('430','1502','107'),  ('436','1503','108'),  ('437','1504','108'),  ('438','1505','108'),  ('439','1506','108'),  ('440','1507','108'),  ('416','1508','109'),  ('417','1509','109'),  ('418','1510','109'),  ('432','1511','110'),  ('433','1512','110'),  ('434','1513','110'),  ('435','1514','110'),  ('431','1515','111'),  ('423','1517','112'),  ('424','1518','112'),  ('425','1519','112'),  ('426','1520','112'),  ('96','1521','113'),  ('97','1522','113'),  ('98','1523','113'),  ('99','1524','113'),  ('92','1525','114'),  ('93','1526','114'),  ('94','1527','114'),  ('95','1528','114'),  ('85','1529','115'),  ('86','1530','115'),  ('87','1531','115'),  ('88','1532','115'),  ('89','1533','116'),  ('90','1534','116'),  ('91','1535','116'),  ('82','1536','116'),  ('83','1537','116'),  ('84','1538','116'),  ('311','1539','117'),  ('312','1540','117'),  ('313','1541','117'),  ('309','1545','118'),  ('310','1546','118'),  ('560','1548','119'),  ('559','1549','120'),  ('607','1591','121'),  ('608','1592','121');
