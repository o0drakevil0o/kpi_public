/*
 Navicat Premium Dump SQL

 Source Server         : 192.168.2.249_3306
 Source Server Type    : MySQL
 Source Server Version : 100119 (10.1.19-MariaDB)
 Source Host           : 192.168.2.249:3306
 Source Schema         : kpi_new

 Target Server Type    : MySQL
 Target Server Version : 100119 (10.1.19-MariaDB)
 File Encoding         : 65001

 Date: 18/06/2025 08:22:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for hr_department
-- ----------------------------
DROP TABLE IF EXISTS `hr_department`;
CREATE TABLE `hr_department`  (
  `HR_DEPARTMENT_ID` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'รหัสกลุ่มงาน',
  `HR_DEPARTMENT_NAME` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'ชื่อกุล่มงาน',
  `BOOK_NUM` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'เลขที่หนังสือกลุ่มงาน',
  `ACTIVE` enum('True','False') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'True' COMMENT 'สถานะ',
  `BOOK_HR_ID` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'สารบรรณกลุ่มงาน',
  `LEADER_HR_ID` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'หัวหน้ากลุ่มงาน',
  `PHONE_IN` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เบอร์โทรภายใน',
  `LINE_TOKEN_SET` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ISORGOUT` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'True เป็นองค์กรภายนอก',
  `HR_DEPART_ID` int NULL DEFAULT NULL COMMENT 'รหัสกลุ่มภารกิจ',
  `ISPLAN` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เปิดใช้แผนงานโครงการ',
  PRIMARY KEY (`HR_DEPARTMENT_ID`) USING BTREE,
  INDEX `IX_HR_DEPARTMENT_ID`(`HR_DEPARTMENT_ID` ASC) USING BTREE,
  INDEX `IX_BOOK_HR_ID`(`BOOK_HR_ID` ASC) USING BTREE,
  INDEX `IX_LEADER_HR_ID`(`LEADER_HR_ID` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'กลุ่มงาน' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of hr_department
-- ----------------------------
INSERT INTO `hr_department` VALUES ('01', 'กลุ่มงานบริหารทั่วไป', '', '', '', '', '', '', '', NULL, NULL);
INSERT INTO `hr_department` VALUES ('02', 'กลุ่มงานรังสีวิทยา', '', '', '', '', '', '', NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('03', 'กลุ่มงานเทคนิคการแพทย์', '', '', '', '', NULL, '', NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('04', 'กลุ่มงานเวชกรรมฟื้นฟู', '', '', '', '', NULL, '', NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('05', 'กลุ่มงานทันตกรรม', '', '', '', '', NULL, '', NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('06', 'กลุ่มงานประกันสุขภาพ ยุทธศาสตร์และสารสนเทศทางการแพทย์', '', '', NULL, '', NULL, '', NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('07', 'กลุ่มงานเภสัชกรรมและคุ้มครองผู้บริโภค', '', '', '', '', NULL, '', NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('08', 'กลุ่มงานบริการด้านปฐมภูมิและองค์รวม', '', '', '', '', '', '', NULL, 2, NULL);
INSERT INTO `hr_department` VALUES ('09', 'กลุ่มงานการแพทย์', '', '', '', '', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('10', 'กลุ่มงานการพยาบาล', '', '', NULL, '', NULL, '', NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('12', 'กลุ่มงานจิตเวช', '', '', '', '', NULL, '', NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('13', 'แพทย์แผนไทย', '', '', NULL, '', NULL, '', NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('14', 'กลุ่มงานศูนย์คุณภาพ', '', '', '', '', NULL, '', NULL, NULL, NULL);
INSERT INTO `hr_department` VALUES ('15', 'กลุ่มงานสุขภาพดิจิทัล', '', '', '', '', NULL, '', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for hr_team
-- ----------------------------
DROP TABLE IF EXISTS `hr_team`;
CREATE TABLE `hr_team`  (
  `HR_TEAM_ID` int NOT NULL AUTO_INCREMENT,
  `HR_TEAM_NAME` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `HR_TEAM_DETAIL` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `LINE_TOKEN_SET` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ACTIVE` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'True',
  PRIMARY KEY (`HR_TEAM_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'ทีมนำ' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of hr_team
-- ----------------------------
INSERT INTO `hr_team` VALUES (1, 'PCT', '-', '', 'True');
INSERT INTO `hr_team` VALUES (2, 'PTC', '-', NULL, 'True');
INSERT INTO `hr_team` VALUES (3, 'HRD', 'งานบุคลากร', NULL, 'True');
INSERT INTO `hr_team` VALUES (4, 'NUR', 'การพยาบาล', NULL, 'True');
INSERT INTO `hr_team` VALUES (5, 'MSO', '-', NULL, 'True');
INSERT INTO `hr_team` VALUES (6, 'ENV', 'งานสิ่งแวดล้อม', NULL, 'True');
INSERT INTO `hr_team` VALUES (7, 'IC', 'ความสะอาด', NULL, 'True');
INSERT INTO `hr_team` VALUES (8, 'RM', 'งานความเสี่ยง', NULL, 'True');
INSERT INTO `hr_team` VALUES (9, 'IM', 'สารสนเทศ', NULL, 'True');
INSERT INTO `hr_team` VALUES (10, 'ESB', '-', NULL, 'True');
INSERT INTO `hr_team` VALUES (11, 'CEO', 'ผู้บริหาร กกบ.', NULL, 'True');
INSERT INTO `hr_team` VALUES (12, 'xxxxx', '', NULL, 'True');

-- ----------------------------
-- Table structure for kp_budyear
-- ----------------------------
DROP TABLE IF EXISTS `kp_budyear`;
CREATE TABLE `kp_budyear`  (
  `BUDYEAR_ID` int NOT NULL,
  `BUDYEAR_NAME` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `BUDYEAR_DATE_START` date NULL DEFAULT NULL,
  `BUDYEAR_DATE_END` date NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_budyear
-- ----------------------------
INSERT INTO `kp_budyear` VALUES (1, '2564', '2020-10-01', '2021-09-30');
INSERT INTO `kp_budyear` VALUES (2, '2565', '2021-10-01', '2022-09-30');
INSERT INTO `kp_budyear` VALUES (3, '2566', '2022-10-01', '2023-09-30');
INSERT INTO `kp_budyear` VALUES (4, '2567', '2023-10-01', '2024-09-30');
INSERT INTO `kp_budyear` VALUES (5, '2568', '2024-10-01', '2025-09-30');
INSERT INTO `kp_budyear` VALUES (6, '2560', '2016-10-01', '2017-09-30');
INSERT INTO `kp_budyear` VALUES (7, '2561', '2017-10-01', '2018-09-30');
INSERT INTO `kp_budyear` VALUES (8, '2562', '2018-10-01', '2019-09-30');
INSERT INTO `kp_budyear` VALUES (9, '2563', '2019-10-01', '2020-09-30');
INSERT INTO `kp_budyear` VALUES (10, '2569', '2025-10-01', '2026-09-30');
INSERT INTO `kp_budyear` VALUES (11, '2570', '2026-10-01', '2027-09-30');

-- ----------------------------
-- Table structure for kp_child
-- ----------------------------
DROP TABLE IF EXISTS `kp_child`;
CREATE TABLE `kp_child`  (
  `child_id` int NOT NULL AUTO_INCREMENT COMMENT 'ตัวชี้วัดรอง',
  `kpi_id` int NOT NULL COMMENT 'ตัวชี้วัดหลัก',
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อตัวชี้วัด',
  `strategic` int NULL DEFAULT NULL COMMENT 'หมวดหมู่ตัวชี้วัด',
  `issue` int NULL DEFAULT NULL COMMENT 'ปัญหา',
  `goal` int NULL DEFAULT NULL COMMENT 'เป้าประสงค์',
  `goal2` int NULL DEFAULT NULL COMMENT 'เป้าประสงค์',
  `project` int(3) UNSIGNED ZEROFILL NULL DEFAULT NULL COMMENT 'โครงการที่รองรับ',
  `team` int NULL DEFAULT NULL COMMENT 'ทีมรับผิดชอบ',
  `manager` int NULL DEFAULT NULL COMMENT 'ผู้รับผิดชอบ',
  `budyear` int NOT NULL COMMENT 'ปีงบ',
  `weight` int NULL DEFAULT NULL COMMENT 'น้ำหนัก',
  `plan` int NULL DEFAULT NULL COMMENT 'แผนยุทธศาสตร์',
  `type_kpi` int NULL DEFAULT NULL COMMENT 'ประเภทตัวชี้วัด',
  PRIMARY KEY (`child_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 155 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for kp_department_register
-- ----------------------------
DROP TABLE IF EXISTS `kp_department_register`;
CREATE TABLE `kp_department_register`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kpi_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้วัดหลัก',
  `child_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้วัดรอง',
  `subchild_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้วัดย่อย',
  `department` int NULL DEFAULT NULL COMMENT 'ประเภทการส่ง',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_department_register
-- ----------------------------

-- ----------------------------
-- Table structure for kp_goal
-- ----------------------------
DROP TABLE IF EXISTS `kp_goal`;
CREATE TABLE `kp_goal`  (
  `GOAL_ID` int NOT NULL AUTO_INCREMENT,
  `GOAL_NAME` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`GOAL_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_goal
-- ----------------------------
INSERT INTO `kp_goal` VALUES (1, 'ระบบบริการมีคุณภาพ ปลอดภัย พึงพอใจ และได้มาตรฐาน');
INSERT INTO `kp_goal` VALUES (2, 'พัฒนาระบบบริการสุขภาพ\r\nปฐมภูมิให้เข้มแข็ง\r\n');
INSERT INTO `kp_goal` VALUES (3, 'พัฒนางานด้านส่งเสริมสุขภาพและป้องกันโรคในประชาชนทุกกลุ่มวัย');
INSERT INTO `kp_goal` VALUES (4, 'การป้องกันควบคุมโรคและลดปัจจัยเสี่ยงด้านสุขภาพ');
INSERT INTO `kp_goal` VALUES (5, 'มีบุคลากรเพียงพอกับการปฏิบัติงาน ');
INSERT INTO `kp_goal` VALUES (6, 'บุคลากรมีความรู้ความสามารถ เหมาะสมกับการให้บริการ');
INSERT INTO `kp_goal` VALUES (7, 'บุคลากรมีความสุข และมีความผูกพันต่อองค์กร');
INSERT INTO `kp_goal` VALUES (8, 'พัฒนาระบบการจัดการผลการปฏิบัติงาน (Performance Management System)');
INSERT INTO `kp_goal` VALUES (9, 'การบริหารจัดการตามหลักองค์กรที่มีคุณธรรมและความโปร่งใสของหน่วยงานภาครัฐ');
INSERT INTO `kp_goal` VALUES (10, 'ขับเคลื่อนองค์กรคุณภาพ');
INSERT INTO `kp_goal` VALUES (11, 'ขับเคลื่อนองค์กรด้วยระบบเทคโนโลยีสารสนเทศ');
INSERT INTO `kp_goal` VALUES (12, 'พัฒนาระบบการจัดการความรู้ งานวิจัยและนวัตกรรมขององค์กร ');
INSERT INTO `kp_goal` VALUES (13, 'พัฒนาการบริหารจัดการด้านการเงินการคลังอย่างมีประสิทธิภาพ');
INSERT INTO `kp_goal` VALUES (14, 'การจัดการองค์กรแห่งความปลอดภัย');

-- ----------------------------
-- Table structure for kp_hcode
-- ----------------------------
DROP TABLE IF EXISTS `kp_hcode`;
CREATE TABLE `kp_hcode`  (
  `id` int NOT NULL,
  `hcode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `hname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_hcode
-- ----------------------------
INSERT INTO `kp_hcode` VALUES (1, '11161', 'โรงพยาบาลฟากท่า');
INSERT INTO `kp_hcode` VALUES (2, '06299', 'รพ.ส.ตสองคอน');
INSERT INTO `kp_hcode` VALUES (3, '06300', 'รพ.สต.ห้วยใส');
INSERT INTO `kp_hcode` VALUES (4, '06301', 'รพ.สต.บ้านเสี้ยว');
INSERT INTO `kp_hcode` VALUES (5, '06302', 'รพ.สต.สองห้อง');

-- ----------------------------
-- Table structure for kp_kpi
-- ----------------------------
DROP TABLE IF EXISTS `kp_kpi`;
CREATE TABLE `kp_kpi`  (
  `kpi_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `stratetgic` int NULL DEFAULT NULL COMMENT 'หมวดหมู่',
  `issues` int NULL DEFAULT NULL COMMENT 'ปํญหา',
  `goal` int NULL DEFAULT NULL COMMENT 'เป้าหมาย ',
  `goal2` int NULL DEFAULT NULL COMMENT 'เป้าหมาย',
  `project` int(3) UNSIGNED ZEROFILL NULL DEFAULT NULL COMMENT 'โครงการ',
  `team` int NULL DEFAULT NULL COMMENT 'ทีมรับผิดชอบ',
  `manager` int NULL DEFAULT NULL COMMENT 'ผู้รับผิดชอบ',
  `budyear` int NOT NULL COMMENT 'ปีงบ',
  `type_kpi` int NULL DEFAULT NULL COMMENT 'ประเภทตัวชี้วัด',
  `level_kpi` int NULL DEFAULT NULL COMMENT 'ระดับตัวชี้ด',
  `weight` int NULL DEFAULT NULL COMMENT 'น้ำหนัก',
  `plan` int NULL DEFAULT NULL COMMENT 'แผนยุทธศาสตร์',
  PRIMARY KEY (`kpi_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 543 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;


-- ----------------------------
-- Table structure for kp_level_kpi
-- ----------------------------
DROP TABLE IF EXISTS `kp_level_kpi`;
CREATE TABLE `kp_level_kpi`  (
  `typelevel_id` int NOT NULL,
  `typelevel_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_level_kpi
-- ----------------------------
INSERT INTO `kp_level_kpi` VALUES (1, 'Service Plan');
INSERT INTO `kp_level_kpi` VALUES (2, 'ระดับจังหวัด (MOU)');
INSERT INTO `kp_level_kpi` VALUES (3, 'การพัฒนาคุณภาพ');
INSERT INTO `kp_level_kpi` VALUES (4, 'ยุทธศาสตร์โรงพยาบาล');

-- ----------------------------
-- Table structure for kp_month
-- ----------------------------
DROP TABLE IF EXISTS `kp_month`;
CREATE TABLE `kp_month`  (
  `id` int NOT NULL,
  `month_id` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `month_name` varchar(254) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_month
-- ----------------------------
INSERT INTO `kp_month` VALUES (1, '10', 'ตุลาคม');
INSERT INTO `kp_month` VALUES (2, '11', 'พฤศจิกายน');
INSERT INTO `kp_month` VALUES (3, '12', 'ธันวาคม');
INSERT INTO `kp_month` VALUES (4, '1', 'มกราคม');
INSERT INTO `kp_month` VALUES (5, '2', 'กุมภาพันธ์');
INSERT INTO `kp_month` VALUES (6, '3', 'มีนาคม');
INSERT INTO `kp_month` VALUES (7, '4', 'เมษายน');
INSERT INTO `kp_month` VALUES (8, '5', 'พฤษภาคม');
INSERT INTO `kp_month` VALUES (9, '6', 'มิถุนายน');
INSERT INTO `kp_month` VALUES (10, '7', 'กรกฎาคม');
INSERT INTO `kp_month` VALUES (11, '8', 'สิงหาคม');
INSERT INTO `kp_month` VALUES (12, '9', 'กันยายน');

-- ----------------------------
-- Table structure for kp_plan_duration
-- ----------------------------
DROP TABLE IF EXISTS `kp_plan_duration`;
CREATE TABLE `kp_plan_duration`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `plan_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'ชื่อแผนยุทธศาสตร์ ระหว่างปี-ปี',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_plan_duration
-- ----------------------------
INSERT INTO `kp_plan_duration` VALUES (1, 'แผนยุทธศาสตร์ โรงพยาบาลฟากท่า ระยะ 5 ปี (พ.ศ.2560 - 2564)');
INSERT INTO `kp_plan_duration` VALUES (2, 'แผนยุทธศาสตร์ โรงพยาบาลฟากท่า ระยะ 5 ปี (พ.ศ.2564 - 2568)');
INSERT INTO `kp_plan_duration` VALUES (3, 'แผนยุทธศาสตร์ โรงพยาบาลฟากท่า ระยะ 5 ปี (พ.ศ.2566 - 2570)');

-- ----------------------------
-- Table structure for kp_project
-- ----------------------------
DROP TABLE IF EXISTS `kp_project`;
CREATE TABLE `kp_project`  (
  `P_id` int(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `P_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`P_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_project
-- ----------------------------
INSERT INTO `kp_project` VALUES (001, 'พัฒนาระบบบริการสุขภาพตาม Service Planให้สอดคล้องกับยุค  New Normal');
INSERT INTO `kp_project` VALUES (002, 'พัฒนาระบบบริการตามมาตรฐานวิชาชีพ');
INSERT INTO `kp_project` VALUES (003, 'การพัฒนาเครือข่ายกำลังคนด้านสุขภาพและ อสม.ในการดูแลผู้ป่วย');
INSERT INTO `kp_project` VALUES (004, 'พัฒนา “ชุมชนสร้างสุข โดยตำบลจัดการคุณภาพชีวิต”');
INSERT INTO `kp_project` VALUES (005, 'พัฒนา รพ.สต. ให้มีคุณภาพได้มาตรฐาน');
INSERT INTO `kp_project` VALUES (006, 'ดำเนินการพัฒนางานส่งเสริมและป้องกันโรคในประชาชนในแต่ละกลุ่มวัย');
INSERT INTO `kp_project` VALUES (007, 'ขับเคลื่อนกลไกพัฒนาคุณภาพชีวิตระดับอำเภอ (พชอ.)');
INSERT INTO `kp_project` VALUES (008, 'พัฒนาความรอบรู้ด้านสุขภาพของประชาชนอำเภอฟากท่า');
INSERT INTO `kp_project` VALUES (009, 'พัฒนาระบบเฝ้าระวังควบคุมโรคและภัยสุขภาพ');
INSERT INTO `kp_project` VALUES (010, 'พัฒนาระบบการตอบโต้ภาวะฉุกเฉินและภัยสุขภาพ');
INSERT INTO `kp_project` VALUES (011, 'การคุ้มครองผู้บริโภคด้านผลิตภัณฑ์สุขภาพและบริการสุขภาพ');
INSERT INTO `kp_project` VALUES (012, 'วางแผนอัตรากำลังและสรรหาบุคลากรอย่างมีประสิทธิภาพ สอดคล้องกับภารกิจ และรองรับการเติบโตขององค์กร');
INSERT INTO `kp_project` VALUES (013, 'พัฒนาบุคลากรทุกระดับให้มีสมรรถนะและความเชี่ยวชาญเหมาะสมกับตำแหน่ง และสอดคล้องกับเป้าหมายขององค์กร');
INSERT INTO `kp_project` VALUES (014, 'พัฒนาองค์กรแห่งความสุข');
INSERT INTO `kp_project` VALUES (015, 'การกำหนดตัวชี้วัดของตำแหน่งงานให้สอดคล้องกับเป้าหมายขององค์กร');
INSERT INTO `kp_project` VALUES (016, 'พัฒนาระบบตรวจสอบและควบคุมภายในและการบริหารความเสี่ยงของหน่วยงาน(EIA)');
INSERT INTO `kp_project` VALUES (017, 'พัฒนาโรงพยาบาลตามเกณฑ์การประเมินคุณธรรมและความโปร่งใส(ITA)');
INSERT INTO `kp_project` VALUES (018, 'พัฒนาคุณภาพอย่างต่อเนื่องตามมาตรฐาน HA');
INSERT INTO `kp_project` VALUES (019, 'พัฒนาโรงพยาบาลสู่ “Smart Hospital”');
INSERT INTO `kp_project` VALUES (020, 'ขับเคลื่อนการจัดการความรู้ งานวิจัยและนวัตกรรมขององค์กร');
INSERT INTO `kp_project` VALUES (021, 'การจัดทำ Business Plan เพื่อหารายได้ ลดรายจ่าย และ อุดรูรั่ว ของโรงพยาบาล');
INSERT INTO `kp_project` VALUES (022, 'สร้างวัฒนธรรมความปลอดภัยในการดูแลผู้ป่วย   ๑.๑ การขับเคลื่อนนโยบาย 2P Safety     ๑.๒เพิ่มประสิทธิภาพระบบบริหารจัดการความเสี่ยง โดยมุ่งเน้นความเสี่ยงเชิงรุก');

-- ----------------------------
-- Table structure for kp_quarter
-- ----------------------------
DROP TABLE IF EXISTS `kp_quarter`;
CREATE TABLE `kp_quarter`  (
  `QUARTER_ID` int NOT NULL,
  `QUARTER_NAME` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_quarter
-- ----------------------------
INSERT INTO `kp_quarter` VALUES (1, 'ไตรมาสที่ 1 (1ต.ค. - 31ธ.ค.)');
INSERT INTO `kp_quarter` VALUES (2, 'ไตรมาสที่ 2 (1ม.ค. - 31มี.ค.)');
INSERT INTO `kp_quarter` VALUES (3, 'ไตรมาสที่ 3 (1เม.ย. - 30 มิ.ย.)');
INSERT INTO `kp_quarter` VALUES (4, 'ไตรมาสที่ 4 (1ก.ค. - 30 ก.ย.)');

-- ----------------------------
-- Table structure for kp_result_calculate_tmp
-- ----------------------------
DROP TABLE IF EXISTS `kp_result_calculate_tmp`;
CREATE TABLE `kp_result_calculate_tmp`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kpt_id` int NULL DEFAULT NULL,
  `kpi_id` int NOT NULL,
  `child_id` int NOT NULL,
  `sub_id` int NOT NULL,
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `reslute_check` int NULL DEFAULT NULL,
  `reslut_total` int NULL DEFAULT NULL,
  `condition` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `result` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `PASS_CHECK` int NULL DEFAULT NULL,
  `SENT_ COUNT_DATA` int NULL DEFAULT NULL,
  `people_target` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `BUDYEAR_NAME` text CHARACTER SET utf32 COLLATE utf32_general_ci NULL,
  `count` int NULL DEFAULT NULL,
  `send_type` int NULL DEFAULT NULL,
  `send_type_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `STRAT_NAME` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `min_traget` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `level_id` int NULL DEFAULT NULL,
  `level_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 89 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for kp_resulte
-- ----------------------------
DROP TABLE IF EXISTS `kp_resulte`;
CREATE TABLE `kp_resulte`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kpi_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้วัดหลัก',
  `child_id` int NOT NULL COMMENT 'ตัวชี้วัดรอง',
  `subchild_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้้ย่อย',
  `hcode` int NOT NULL COMMENT 'สถานบริการ',
  `target` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เป้าหมาย',
  `value_a` float NULL DEFAULT NULL COMMENT 'ค่าตัวแปร a',
  `value_b` float NULL DEFAULT NULL COMMENT 'ค่าตัวแปร b',
  `value_c` float NULL DEFAULT NULL COMMENT 'ค่าตัวแปร c',
  `value_d` float NULL DEFAULT NULL COMMENT 'ค่าตัวแปร d',
  `result` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ผลลัพธ์',
  `reslute_check` int NULL DEFAULT NULL COMMENT '4.ผ่าน 3.อยู่ระหว่างดำเนินการ 2.ไม่ผ่าน 1.ไม่ประเมิน',
  `send_type` int NULL DEFAULT NULL COMMENT 'ประเภทการส่ง\r\n1.รายเดือน\r\n2.รายไตรมาส\r\n3.ครึ่งปี\r\n4.รายปี',
  `successkey` int NULL DEFAULT NULL COMMENT 'กุญแจแห่งความสำเร็จ',
  `budyear` int NULL DEFAULT NULL COMMENT 'ปีงบ',
  `user_key` int NULL DEFAULT NULL COMMENT 'ผู้ลงข้อมูล',
  `position` int NULL DEFAULT NULL COMMENT 'ตำแหน่ง',
  `created_at` date NULL DEFAULT NULL,
  `crearted_by` int NULL DEFAULT NULL,
  `updated_at` date NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `count` int NULL DEFAULT NULL COMMENT 'ปี/ครึ่งปี/ไตรมาส/เดือน/',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2288 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for kp_send_type
-- ----------------------------
DROP TABLE IF EXISTS `kp_send_type`;
CREATE TABLE `kp_send_type`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'ประเภทการส่ง',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_send_type
-- ----------------------------
INSERT INTO `kp_send_type` VALUES (1, 'ตัวชี้วัดรายเดือน');
INSERT INTO `kp_send_type` VALUES (2, 'ตัวชี้วัดรายไตรมาส');
INSERT INTO `kp_send_type` VALUES (3, 'ตัวชี้วัดครึ่งปี');
INSERT INTO `kp_send_type` VALUES (4, 'ตัวชี้วัดรายปี');

-- ----------------------------
-- Table structure for kp_send_type_register
-- ----------------------------
DROP TABLE IF EXISTS `kp_send_type_register`;
CREATE TABLE `kp_send_type_register`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kpi_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้วัดหลัก',
  `child_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้วัดรอง',
  `subchild_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้วัดย่อย',
  `send_type` int NULL DEFAULT NULL COMMENT 'ประเภทการส่ง',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_send_type_register
-- ----------------------------

-- ----------------------------
-- Table structure for kp_stratetgic
-- ----------------------------
DROP TABLE IF EXISTS `kp_stratetgic`;
CREATE TABLE `kp_stratetgic`  (
  `STRAT_ID` int NOT NULL,
  `STRAT_NAME` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `type_kpi` int NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_stratetgic
-- ----------------------------
INSERT INTO `kp_stratetgic` VALUES (1, 'ยุทธศาสตร์ที่ 1 พัฒนาด้านบริการเป็นเลิศ(Service Excellence)', 2);
INSERT INTO `kp_stratetgic` VALUES (2, 'ยุทธศาสตร์ที่ 2 พัฒนาด้านส่งเสริมสุขภาพป้องกันโรคและคุ้มครองผู้บริโภคเป็นเลิศ(PP&P Excellence)', 2);
INSERT INTO `kp_stratetgic` VALUES (3, 'ยุทธศาสตร์ที่ 3 พัฒนาด้านด้านบุคลากรเป็นเลิศ(Personal Excellence)', 2);
INSERT INTO `kp_stratetgic` VALUES (4, 'ยุทธศาสตร์ที่ 4 พัฒนาด้านบริหารเป็นเลิศ(Governance Excellence)', 2);
INSERT INTO `kp_stratetgic` VALUES (5, 'ความสำเร็จในการพัฒนางานสาธารณสุขตามแนวทางโครงการพระราชดำริและโครงการเฉลิมพระเกียรติด้านสาธารณสุข', 1);
INSERT INTO `kp_stratetgic` VALUES (6, 'ความสำเร็จในการพัฒนาสุขภาพภาคประชาชนและคุณภาพชีวิตระดับอำเภอ', 1);
INSERT INTO `kp_stratetgic` VALUES (7, 'ความสำเร็จในการพัฒนาระบบบริการปฐมภูมิและเขตเมือง', 1);
INSERT INTO `kp_stratetgic` VALUES (8, 'ความสำเร็จในการพัฒนาระบบส่งเสริมสุขภาพทุกกลุ่มวัย', 1);
INSERT INTO `kp_stratetgic` VALUES (9, 'ความสำเร็จในการพัฒนาระบบดูแลสุขภาพผู้สูงอายุ/ผู้พิการ/ผู้มีภาวะพึ่งพิงด้านสุขภาพ ( รวม IMC / LTC / PC ) ', 1);
INSERT INTO `kp_stratetgic` VALUES (10, 'ความสำเร็จในการพัฒนาระบบป้องกัน ควบคุมโรคติดต่อ', 1);
INSERT INTO `kp_stratetgic` VALUES (11, ' ความสำเร็จในการพัฒนาระบบป้องกัน ควบคุมโรคไม่ติดต่อ', 1);
INSERT INTO `kp_stratetgic` VALUES (12, 'ความสำเร็จในการพัฒนาการจัดการอนามัยสิ่งแวดล้อมและอาชีวอนามัย', 1);
INSERT INTO `kp_stratetgic` VALUES (13, 'ความสำเร็จในการพัฒนาระบบบริการสุขภาพให้ได้มาตรฐาน', 1);
INSERT INTO `kp_stratetgic` VALUES (14, 'ความสำเร็จในการพัฒนาระบบการแพทย์ฉุกเฉินและสาธารณภัย', 1);
INSERT INTO `kp_stratetgic` VALUES (15, 'ความสำเร็จในการพัฒนาระบบงานสุขภาพจิตและยาเสพติด', 1);
INSERT INTO `kp_stratetgic` VALUES (16, 'ความสำเร็จในการพัฒนางานแพทย์แผนไทยและทางเลือก', 1);
INSERT INTO `kp_stratetgic` VALUES (17, 'ความสำเร็จในการพัฒนาระบบยา เภสัชสาธารณสุข และส่งเสริมความปลอดภัยด้านอาหาร ผลิตภัณฑ์และบริการสุขภาพ', 1);
INSERT INTO `kp_stratetgic` VALUES (18, 'ความสำเร็จในการพัฒนาระบบบริหารทรัพยากรบุคคล (HRM, HRP, HRD, ค่านิยมองค์กร และ KM)', 1);
INSERT INTO `kp_stratetgic` VALUES (19, 'ความสำเร็จในการพัฒนาระบบบริหารจัดการยุทธศาสตร์ ร่วมกับภาคีเครือข่าย', 1);
INSERT INTO `kp_stratetgic` VALUES (20, 'ความสำเร็จในการพัฒนาเทคโนโลยีและสารสนเทศ', 1);
INSERT INTO `kp_stratetgic` VALUES (21, 'ความสำเร็จในการพัฒนาการบริหารจัดการ การเงิน การคลัง และประกันสุขภาพ', 1);
INSERT INTO `kp_stratetgic` VALUES (22, 'ความสำเร็จในการส่งเสริมการบริหารจัดการตามหลักธรรมาภิบาล/กฎหมายด้านสาธารณสุขและมาตรฐานวิชาชีพ', 1);

-- ----------------------------
-- Table structure for kp_stratetgic_original
-- ----------------------------
DROP TABLE IF EXISTS `kp_stratetgic_original`;
CREATE TABLE `kp_stratetgic_original`  (
  `STRAT_ID` int NOT NULL AUTO_INCREMENT,
  `STRAT_NAME` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`STRAT_ID`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_stratetgic_original
-- ----------------------------
INSERT INTO `kp_stratetgic_original` VALUES (1, 'ยุทธศาสตร์ที่ 1 พัฒนาด้านบริการเป็นเลิศ(Service Excellence)');
INSERT INTO `kp_stratetgic_original` VALUES (2, 'ยุทธศาสตร์ที่ 2 พัฒนาด้านส่งเสริมสุขภาพป้องกันโรคและคุ้มครองผู้บริโภคเป็นเลิศ(PP&P Excellence)');
INSERT INTO `kp_stratetgic_original` VALUES (3, 'ยุทธศาสตร์ที่ 3 พัฒนาด้านด้านบุคลากรเป็นเลิศ(Personal Excellence)');
INSERT INTO `kp_stratetgic_original` VALUES (4, 'ยุทธศาสตร์ที่ 4 พัฒนาด้านบริหารเป็นเลิศ(Governance Excellence)');

-- ----------------------------
-- Table structure for kp_subchild
-- ----------------------------
DROP TABLE IF EXISTS `kp_subchild`;
CREATE TABLE `kp_subchild`  (
  `subchild_id` int NOT NULL AUTO_INCREMENT COMMENT 'ตัวชี้วัดย่อย',
  `kpi_id` int NOT NULL COMMENT 'ตัวชี้วัดหลัก',
  `child_id` int NOT NULL COMMENT 'ตักวชี้วัดรอง',
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'ชื่อตัวชี้วัด',
  `strategic` int NULL DEFAULT NULL COMMENT 'หมวดหมู่หลัก',
  `issue` int NULL DEFAULT NULL COMMENT 'ปัญหา',
  `goal` int NULL DEFAULT NULL COMMENT 'เป้าประสงค์',
  `goal2` int NULL DEFAULT NULL COMMENT 'เป้าประสงค์ที่สอง',
  `project` int(3) UNSIGNED ZEROFILL NULL DEFAULT NULL COMMENT 'โครงการที่แก้ไข้',
  `team` int NULL DEFAULT NULL COMMENT 'ทีมรับผิดชอบ',
  `manager` int NULL DEFAULT NULL COMMENT 'ผู้รับผิดชอบ',
  `type_kpi` int NULL DEFAULT NULL COMMENT 'ประเภทตัวชี้วัด',
  `budyear` int NOT NULL COMMENT 'ปีงบ',
  `weight` int NULL DEFAULT NULL COMMENT 'น้ำหนัก',
  `plan` int NULL DEFAULT NULL COMMENT 'แผนยุทธศาสตร์',
  PRIMARY KEY (`subchild_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 67 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for kp_success
-- ----------------------------

DROP TABLE IF EXISTS `kp_success`;
CREATE TABLE `kp_success`  (
  `s_id` int NOT NULL,
  `s_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_success
-- ----------------------------
INSERT INTO `kp_success` VALUES (1, 'ไม่มีการประเมิน');
INSERT INTO `kp_success` VALUES (2, 'ไม่ผ่าน');
INSERT INTO `kp_success` VALUES (3, 'อยู่ระหว่างดำเนินการ');
INSERT INTO `kp_success` VALUES (4, 'ผ่าน');

-- ----------------------------
-- Table structure for kp_success_original
-- ----------------------------
DROP TABLE IF EXISTS `kp_success_original`;
CREATE TABLE `kp_success_original`  (
  `s_id` int NOT NULL,
  `s_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`s_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_success_original
-- ----------------------------
INSERT INTO `kp_success_original` VALUES (1, 'ไม่มีการประเมิน');
INSERT INTO `kp_success_original` VALUES (2, 'ไม่ผ่าน');
INSERT INTO `kp_success_original` VALUES (3, 'อยู่ระหว่างดำเนินการ');
INSERT INTO `kp_success_original` VALUES (4, 'ผ่าน');

-- ----------------------------
-- Table structure for kp_team
-- ----------------------------
DROP TABLE IF EXISTS `kp_team`;
CREATE TABLE `kp_team`  (
  `T_id` int NOT NULL,
  `T_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_team
-- ----------------------------
INSERT INTO `kp_team` VALUES (1, 'กลุ่มงานการพยาบาล');
INSERT INTO `kp_team` VALUES (2, 'กลุ่มงานทันตกรรม');
INSERT INTO `kp_team` VALUES (3, 'กลุ่มงานเทคนิคการแพทย์');
INSERT INTO `kp_team` VALUES (4, 'กลุ่มงานเทคโนโลยีสารสนเทศ');
INSERT INTO `kp_team` VALUES (5, 'กลุ่มงานบริการด้านปฐมภูมิและองค์รวม');
INSERT INTO `kp_team` VALUES (6, 'กลุ่มงานบริหารงานทั่วไป');
INSERT INTO `kp_team` VALUES (7, 'กลุ่มงานแพทย์แผนไทยฯ');
INSERT INTO `kp_team` VALUES (8, 'กลุ่มงานเภสัชกรรมฯ');
INSERT INTO `kp_team` VALUES (9, 'กลุ่มงานรังสีวิทยา');
INSERT INTO `kp_team` VALUES (10, 'กลุ่มงานเวชกรรมฟื้นฟู');
INSERT INTO `kp_team` VALUES (11, 'คณะกรรมการพัฒนาคุณภาพโรงพยาบาล');
INSERT INTO `kp_team` VALUES (12, 'งานห้องคลอด');
INSERT INTO `kp_team` VALUES (13, 'งานอุบัติเหตุฉุกเฉินและนิติเวช');
INSERT INTO `kp_team` VALUES (14, 'ทีม CRC');
INSERT INTO `kp_team` VALUES (15, 'ทีม ENV');
INSERT INTO `kp_team` VALUES (16, 'ทีม FA');
INSERT INTO `kp_team` VALUES (17, 'ทีม HRM');
INSERT INTO `kp_team` VALUES (18, 'ทีม IC');
INSERT INTO `kp_team` VALUES (19, 'ทีม PCT');
INSERT INTO `kp_team` VALUES (20, 'ทีม Service plan');
INSERT INTO `kp_team` VALUES (21, 'ทีมความเสี่ยง');
INSERT INTO `kp_team` VALUES (22, 'ทีมอนามัยแม่และเด็ก');
INSERT INTO `kp_team` VALUES (23, 'ทีมอาชีวอนามัย');
INSERT INTO `kp_team` VALUES (24, 'ผู้รับผิดชอบงาน NDC');
INSERT INTO `kp_team` VALUES (25, 'องค์กรพยาบาล');
INSERT INTO `kp_team` VALUES (26, 'องค์กรแพทย์');

-- ----------------------------
-- Table structure for kp_team_register
-- ----------------------------
DROP TABLE IF EXISTS `kp_team_register`;
CREATE TABLE `kp_team_register`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kpi_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้วัดหลัก',
  `child_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้วัดรอง',
  `subchild_id` int NULL DEFAULT NULL COMMENT 'ตัวชี้วัดย่อย',
  `team` int NULL DEFAULT NULL COMMENT 'ประเภทการส่ง',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_team_register
-- ----------------------------

-- ----------------------------
-- Table structure for kp_templete
-- ----------------------------
DROP TABLE IF EXISTS `kp_templete`;
CREATE TABLE `kp_templete`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kpi_id` int NULL DEFAULT NULL,
  `child_id` int NULL DEFAULT NULL,
  `sub_id` int NULL DEFAULT NULL,
  `tem_kpiname` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'ชื่อตัวชี้วัด',
  `tem_dic` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'คำอธิบายตัวชี้วัด',
  `tem_unit` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'หน่วยตัวชี้วัด',
  `unit_a` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'หน่วยตัวชี้วัด A',
  `dic_a` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'นิยามตัวแปร A',
  `unit_b` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'หน่วยตัวชี้วัด B',
  `dic_b` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'นิยามตัวแปร B',
  `unit_c` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'หน่วยตัวชี้วัด C',
  `dic_c` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'นิยามตัวแปร C',
  `unit_d` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'หน่วยตัวชี้วัด D',
  `dic_d` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'นิยามตัวแปร D',
  `cal` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'วิธีการคำนวณ',
  `min_traget` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'เป้าหมายต่ำสุด',
  `people_target` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'ประชาชนกลุ่มเป้าหมาย',
  `process_data` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'วิธรการจัดเก็บข้อมูล ',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'แหล่งข้อมูล',
  `created_at` int NULL DEFAULT NULL,
  `updated_at` int NULL DEFAULT NULL,
  `support_people` int NULL DEFAULT NULL COMMENT 'ผู้รับผิดชอบ/ดูแลจัดการ',
  `condition` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'เงื่อนไขตัวชี้วัด',
  `weight` float NULL DEFAULT NULL COMMENT 'ค่าน้ำหนักัตัวชี้วัด',
  `send_type` int NULL DEFAULT NULL COMMENT 'ประเภทการส่ง',
  `plan` int NULL DEFAULT NULL COMMENT 'แผนยุทธศาสตร์',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 678 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;
-- ----------------------------
-- Table structure for kp_type_kpi
-- ----------------------------
DROP TABLE IF EXISTS `kp_type_kpi`;
CREATE TABLE `kp_type_kpi`  (
  `type_id` int NOT NULL,
  `type_name` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kp_type_kpi
-- ----------------------------
INSERT INTO `kp_type_kpi` VALUES (1, 'KPI-MOU');
INSERT INTO `kp_type_kpi` VALUES (2, 'KPI');

-- ----------------------------
-- Table structure for kt_budyear
-- ----------------------------
DROP TABLE IF EXISTS `kt_budyear`;
CREATE TABLE `kt_budyear`  (
  `id` int NOT NULL,
  `bud_year` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `duration_start` date NULL DEFAULT NULL,
  `duration_end` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kt_budyear
-- ----------------------------
INSERT INTO `kt_budyear` VALUES (1, '2566', '2022-10-01', '2023-09-30');
INSERT INTO `kt_budyear` VALUES (2, '2567', '2023-10-01', '2024-09-30');
INSERT INTO `kt_budyear` VALUES (3, '2568', '2024-10-01', '2025-09-30');

-- ----------------------------
-- Table structure for kt_main
-- ----------------------------
DROP TABLE IF EXISTS `kt_main`;
CREATE TABLE `kt_main`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `owner` int NULL DEFAULT NULL,
  `year` int NULL DEFAULT NULL,
  `traget` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kt_main
-- ----------------------------
INSERT INTO `kt_main` VALUES (1, 'สปสช', 1, 2566, 100);

-- ----------------------------
-- Table structure for kt_month
-- ----------------------------
DROP TABLE IF EXISTS `kt_month`;
CREATE TABLE `kt_month`  (
  `id` int NOT NULL,
  `month_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `quater` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kt_month
-- ----------------------------
INSERT INTO `kt_month` VALUES (1, 'มกราคม', 2);
INSERT INTO `kt_month` VALUES (2, 'กุมภาพันธ์', 2);
INSERT INTO `kt_month` VALUES (3, 'มีนาคม', 2);
INSERT INTO `kt_month` VALUES (4, 'เมษายน', 3);
INSERT INTO `kt_month` VALUES (5, 'พฤษภาคม', 3);
INSERT INTO `kt_month` VALUES (6, 'มิถุนายน', 3);
INSERT INTO `kt_month` VALUES (7, 'กรกฏาคม', 4);
INSERT INTO `kt_month` VALUES (8, 'สิงหาคม', 4);
INSERT INTO `kt_month` VALUES (9, 'กันยายน', 4);
INSERT INTO `kt_month` VALUES (10, 'ตุลาคม', 1);
INSERT INTO `kt_month` VALUES (11, 'พฤศจิกายน', 1);
INSERT INTO `kt_month` VALUES (12, 'ธันวาคม', 1);

-- ----------------------------
-- Table structure for kt_resulte
-- ----------------------------
DROP TABLE IF EXISTS `kt_resulte`;
CREATE TABLE `kt_resulte`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `owner` int NULL DEFAULT NULL,
  `main_id` int NULL DEFAULT NULL,
  `submain_id` int NULL DEFAULT NULL,
  `budyear_id` int NULL DEFAULT NULL,
  `month_id` int NULL DEFAULT NULL,
  `year` int NULL DEFAULT NULL,
  `target` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `success` int NULL DEFAULT NULL,
  `processing` int NULL DEFAULT NULL,
  `unprocessing` int NULL DEFAULT NULL,
  `bud_traget` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `bud_success` int NULL DEFAULT NULL,
  `bud_proceesing` int NULL DEFAULT NULL,
  `bud_unprocessing` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `budyear_kt`(`budyear_id` ASC) USING BTREE,
  INDEX `submain_kt`(`submain_id` ASC) USING BTREE,
  INDEX `main_kt`(`main_id` ASC) USING BTREE,
  INDEX `kt_month`(`month_id` ASC) USING BTREE,
  CONSTRAINT `budyear_kt` FOREIGN KEY (`budyear_id`) REFERENCES `kt_budyear` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `kt_month` FOREIGN KEY (`month_id`) REFERENCES `kt_month` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `main_kt` FOREIGN KEY (`main_id`) REFERENCES `kt_main` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `submain_kt` FOREIGN KEY (`submain_id`) REFERENCES `kt_submain` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kt_resulte
-- ----------------------------
INSERT INTO `kt_resulte` VALUES (1, 1, 1, 1, 1, 1, 1, '100', 50, 50, 50, '100', 20, 80, 80);
INSERT INTO `kt_resulte` VALUES (2, 1, 1, 2, 1, 1, 1, '100', 50, 50, 50, '100', 20, 80, 80);
INSERT INTO `kt_resulte` VALUES (3, 1, 1, 1, 1, 2, 1, '100', 50, 50, 50, '100', 20, 80, 80);
INSERT INTO `kt_resulte` VALUES (4, 1, 1, 2, 1, 2, 1, '100', 50, 50, 50, '100', 20, 80, 80);

-- ----------------------------
-- Table structure for kt_submain
-- ----------------------------
DROP TABLE IF EXISTS `kt_submain`;
CREATE TABLE `kt_submain`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `owner` int NULL DEFAULT NULL,
  `kt_mian_id` int NOT NULL,
  `year` int NULL DEFAULT NULL,
  `traget` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `main_id`(`kt_mian_id` ASC) USING BTREE,
  CONSTRAINT `main_id` FOREIGN KEY (`kt_mian_id`) REFERENCES `kt_main` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kt_submain
-- ----------------------------
INSERT INTO `kt_submain` VALUES (1, 'กทม', 1, 1, 2566, 100);
INSERT INTO `kt_submain` VALUES (2, 'จ่ายตรง', 1, 1, 2566, 100);

-- ----------------------------
-- Table structure for kt_year
-- ----------------------------
DROP TABLE IF EXISTS `kt_year`;
CREATE TABLE `kt_year`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `year` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `duration_start` date NULL DEFAULT NULL,
  `duration_end` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kt_year
-- ----------------------------
INSERT INTO `kt_year` VALUES (1, '2566', '2022-10-01', '2023-09-30');
INSERT INTO `kt_year` VALUES (2, '2564', '2020-10-01', '2021-09-30');
INSERT INTO `kt_year` VALUES (3, '2565', '2021-10-01', '2022-09-30');
INSERT INTO `kt_year` VALUES (4, '2567', '2023-10-01', '2024-09-30');
INSERT INTO `kt_year` VALUES (5, '2568', '2024-10-01', '2025-09-30');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password_hash` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role` enum('ADMIN','USER') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'USER',
  `status` smallint NOT NULL DEFAULT 10,
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `cid` tinytext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `cid_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `hcode` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_unique_email`(`email` ASC) USING BTREE,
  UNIQUE INDEX `user_unique_username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 147 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'test', 'test', 'admin', 'SvoWfgWO7aLS3VQ3XW2SnZhckKWB8VxQ', '$2y$13$UPit3BHb7rsep8agGjZ3B.kXNUd1507nti8jkBv/gUKnNXPpJsCvK', NULL, 'admin@hotmail.com', 'ADMIN', 10, 1688536636, 1688536636, '', NULL, NULL);


SET FOREIGN_KEY_CHECKS = 1;
