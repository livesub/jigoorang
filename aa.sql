-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: jigoorang
-- ------------------------------------------------------
-- Server version	8.0.27-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `baesongjis`
--

DROP TABLE IF EXISTS `baesongjis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `baesongjis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
  `ad_subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '배송지명',
  `ad_default` int NOT NULL DEFAULT '0' COMMENT '기본배송지',
  `ad_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 이름',
  `ad_tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 전화번호',
  `ad_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 휴대폰번호',
  `ad_zip1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 우편번호',
  `ad_addr1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 기본주소',
  `ad_addr2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 상세주소',
  `ad_addr3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 주소 참고 항목',
  `ad_jibeon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 지번주소',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `baesongjis_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='배송지이력관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `baesongjis`
--

LOCK TABLES `baesongjis` WRITE;
/*!40000 ALTER TABLE `baesongjis` DISABLE KEYS */;
INSERT INTO `baesongjis` VALUES (2,'ysz@yongsanzip.com','',1,'dsdfbsfbsf','','3425423523','07545','서울 강서구 양천로67길 3','465456645','(염창동)','R','2021-12-31 03:09:50','2021-12-31 03:09:50'),(3,'ysz@yongsanzip.com','',0,'hjbbhjhb','','8887','07602','서울 강서구 양천로6길 15','555555555555555','(방화동)','R','2021-12-31 03:15:12','2021-12-31 03:15:12'),(4,'livesub@naver.com','',1,'기본 배송비','','00222223333','07233','서울 영등포구 의사당대로 1','54546554654','(여의도동)','R','2022-01-04 02:44:20','2022-01-04 02:44:20');
/*!40000 ALTER TABLE `baesongjis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `b_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '제목',
  `b_display` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT '출력 여부 : N=>미출력,Y=>출력',
  `b_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '링크경로',
  `b_target` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT '타겟 : N=>현재창,Y=>새창',
  `b_pc_img` text COLLATE utf8mb4_unicode_ci COMMENT 'pc 이미지(원본@@썸네일1@@썸네일2..)',
  `b_pc_ori_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'pc 이미지파일이름',
  `b_mobile_img` text COLLATE utf8mb4_unicode_ci COMMENT 'mobile 이미지(원본@@썸네일1@@썸네일2..)',
  `b_mobile_ori_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'mobile 이미지파일이름',
  `b_type` enum('1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '분류 : 1=>상단,2=>하단',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banners_b_display_b_type_index` (`b_display`,`b_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='배너관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `board_datas_comment_tables`
--

DROP TABLE IF EXISTS `board_datas_comment_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `board_datas_comment_tables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `bm_tb_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '테이블명',
  `bdt_id` int NOT NULL COMMENT '부모글 순번',
  `bdct_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '작성자 아이디',
  `bdct_uname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '작성자 이름',
  `bdct_memo` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '내용',
  `bdct_grp` int DEFAULT '0' COMMENT '댓글 그룹 판단-대댓글 표현',
  `bdct_sort` int DEFAULT '0' COMMENT '댓글 정렬-대댓글 표현',
  `bdct_depth` int DEFAULT '0' COMMENT '댓글 깊이-대댓글 표현',
  `bdct_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '작성자 ip',
  `bdct_del` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT '삭제 여부 : N=>미삭제,Y=>삭제(답글이 있을때 사용)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `board_datas_comment_tables_bdct_grp_bdct_sort_bdct_depth_index` (`bdct_grp`,`bdct_sort`,`bdct_depth`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='각 게시판 덧글';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `board_datas_comment_tables`
--

LOCK TABLES `board_datas_comment_tables` WRITE;
/*!40000 ALTER TABLE `board_datas_comment_tables` DISABLE KEYS */;
/*!40000 ALTER TABLE `board_datas_comment_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `board_datas_tables`
--

DROP TABLE IF EXISTS `board_datas_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `board_datas_tables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `bm_tb_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '테이블명',
  `bdt_grp` int DEFAULT '0' COMMENT '그룹 판단',
  `bdt_sort` int DEFAULT '0' COMMENT '정렬',
  `bdt_depth` int DEFAULT '0' COMMENT '깊이',
  `bdt_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '작성자 ip',
  `bdt_chk_secret` tinyint NOT NULL DEFAULT '0' COMMENT '비밀글 사용 체크',
  `bdt_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '작성자 아이디',
  `bdt_uname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '작성자 이름',
  `bdt_upw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '작성자 비밀번호',
  `bdt_subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '제목',
  `bdt_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '내용',
  `bdt_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '카테고리값',
  `bdt_hit` int NOT NULL DEFAULT '0' COMMENT '조회수',
  `bdt_comment_cnt` int NOT NULL DEFAULT '0' COMMENT '댓글수',
  `bdt_ori_file_name1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '원본 첨부파일 이름1',
  `bdt_file1` text COLLATE utf8mb4_unicode_ci COMMENT '첨부파일1(원본@@썸네일1@@썸네일2..)',
  `bdt_ori_file_name2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '원본 첨부파일 이름2',
  `bdt_file2` text COLLATE utf8mb4_unicode_ci COMMENT '첨부파일2(원본@@썸네일1@@썸네일2..)',
  `bdt_ori_file_name3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '원본 첨부파일 이름3',
  `bdt_file3` text COLLATE utf8mb4_unicode_ci COMMENT '첨부파일3(원본@@썸네일1@@썸네일2..)',
  `bdt_ori_file_name4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '원본 첨부파일 이름4',
  `bdt_file4` text COLLATE utf8mb4_unicode_ci COMMENT '첨부파일4(원본@@썸네일1@@썸네일2..)',
  `bdt_ori_file_name5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '원본 첨부파일 이름5',
  `bdt_file5` text COLLATE utf8mb4_unicode_ci COMMENT '첨부파일5(원본@@썸네일1@@썸네일2..)',
  `bdt_down_cnt` int NOT NULL DEFAULT '0' COMMENT '첨부 다운로드 횟수',
  `bdt_del` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT '삭제 여부 : N=>미삭제,Y=>삭제(답글이 있을때 사용)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `board_datas_tables_id_unique` (`id`),
  KEY `board_datas_tables_bm_tb_name_bdt_grp_bdt_sort_bdt_depth_index` (`bm_tb_name`,`bdt_grp`,`bdt_sort`,`bdt_depth`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='각 게시판 게시물';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `board_datas_tables`
--

LOCK TABLES `board_datas_tables` WRITE;
/*!40000 ALTER TABLE `board_datas_tables` DISABLE KEYS */;
/*!40000 ALTER TABLE `board_datas_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boardmanagers`
--

DROP TABLE IF EXISTS `boardmanagers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `boardmanagers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `bm_tb_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '테이블명',
  `bm_tb_subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '게시판 이름',
  `bm_type` int NOT NULL DEFAULT '1' COMMENT '게시판 종류 : 1=>일반게시판, 2=>갤러리게시판',
  `bm_skin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '게시판 스킨',
  `bm_record_num` int NOT NULL DEFAULT '10' COMMENT '한 페이지 게시물 갯수',
  `bm_page_num` int DEFAULT '10' COMMENT '한 페이지 출력될 페이지 갯수',
  `bm_subject_len` smallint NOT NULL DEFAULT '50' COMMENT '출력될 제목 길이',
  `bm_list_chk` smallint NOT NULL DEFAULT '100' COMMENT '리스트 가능 권한(100 손님)',
  `bm_write_chk` smallint NOT NULL DEFAULT '100' COMMENT '쓰기 가능 권한(100 손님)',
  `bm_view_chk` smallint NOT NULL DEFAULT '100' COMMENT '보기 가능 권한(100 손님)',
  `bm_modify_chk` smallint NOT NULL DEFAULT '100' COMMENT '수정 가능 권한(100 손님)',
  `bm_reply_chk` smallint NOT NULL DEFAULT '100' COMMENT '답글 가능 권한(100 손님)',
  `bm_delete_chk` smallint NOT NULL DEFAULT '100' COMMENT '삭제 가능 권한(100 손님)',
  `bm_coment_type` tinyint NOT NULL DEFAULT '1' COMMENT '댓글사용여부1=>사용',
  `bm_secret_type` tinyint NOT NULL DEFAULT '0' COMMENT '비밀글사용여부0=>비사용,1=>사용',
  `bm_category_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '카테고리 키값',
  `bm_category_ment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '카테고리 이름값',
  `bm_file_num` tinyint NOT NULL DEFAULT '1' COMMENT '첨부파일 사용개수',
  `bm_resize_file_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '첨부자료(이미지시) 리사이징 개수',
  `bm_resize_width_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '리사이징될 가로 길이(리사이징 개수와 같아야함%%구분)',
  `bm_resize_height_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '리사이징될 높이 길이(리사이징 개수와 같아야함%%구분)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `boardmanagers_bm_tb_name_unique` (`bm_tb_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='게시판 환경 설정';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boardmanagers`
--

LOCK TABLES `boardmanagers` WRITE;
/*!40000 ALTER TABLE `boardmanagers` DISABLE KEYS */;
/*!40000 ALTER TABLE `boardmanagers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorys`
--

DROP TABLE IF EXISTS `categorys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categorys` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `ca_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '카테고리',
  `ca_name_kr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '카테고리 한글명',
  `ca_name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '카테고리 영어명',
  `ca_display` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT '출력 여부 : N=>미출력,Y=>출력',
  `ca_rank` int NOT NULL DEFAULT '0' COMMENT '출력순서: 높을수록 먼저 나옴',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categorys_ca_id_unique` (`ca_id`),
  KEY `categorys_ca_id_index` (`ca_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='카테고리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorys`
--

LOCK TABLES `categorys` WRITE;
/*!40000 ALTER TABLE `categorys` DISABLE KEYS */;
/*!40000 ALTER TABLE `categorys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_sends`
--

DROP TABLE IF EXISTS `email_sends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_sends` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `email_id` int NOT NULL COMMENT 'email 순번',
  `email_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '회원 email',
  `email_send_chk` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT '이메일 발송 여부 : N=>실패,Y=>성공',
  `email_receive_chk` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT '이메일 확인 여부 : N=>미확인,Y=>확인',
  `email_receive_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이메일 확인 용도(이메일에 함께 보냄)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='이메일 발송 관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_sends`
--

LOCK TABLES `email_sends` WRITE;
/*!40000 ALTER TABLE `email_sends` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_sends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emails`
--

DROP TABLE IF EXISTS `emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `emails` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `email_subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '제목',
  `email_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '내용',
  `email_file1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '첨부 변경 파일이름',
  `email_ori_file1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '첨부 원본 파일이름',
  `email_file2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '첨부 변경 파일이름',
  `email_ori_file2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '첨부 원본 파일이름',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='이메일 내용 관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emails`
--

LOCK TABLES `emails` WRITE;
/*!40000 ALTER TABLE `emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exp_application_list`
--

DROP TABLE IF EXISTS `exp_application_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exp_application_list` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '신청 유저 아이디',
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '신청자 이름',
  `exp_id` int NOT NULL COMMENT '체험단 아이디',
  `item_id` int NOT NULL COMMENT '상품 아이디',
  `sca_id` int NOT NULL COMMENT '카테고리 아이디',
  `ad_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '수령인',
  `ad_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '핸드폰 번호',
  `ad_zip1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '신청인 우편번호',
  `ad_addr1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '신청인 기본주소',
  `ad_addr2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '신청인 상세주소',
  `ad_addr3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '신청인 주소참고항목',
  `ad_jibeon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '신청인 지번주소',
  `shipping_memo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '배송메모',
  `reason_memo` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '참여하는 이유항목',
  `access_yn` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '승인 여부',
  `write_yn` enum('y','n') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '리뷰 작성 여부(임시저장시 n)',
  `promotion_yn` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y' COMMENT '약관동의 여부',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='체험단 신청 정보';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exp_application_list`
--

LOCK TABLES `exp_application_list` WRITE;
/*!40000 ALTER TABLE `exp_application_list` DISABLE KEYS */;
INSERT INTO `exp_application_list` VALUES (1,'livesub@naver.com','바람개비',24,1,1010,'기본 배송비','00222223333','07233','서울 영등포구 의사당대로 1','54546554654','(여의도동)','R','kkkkkk','sfagsfg\r\nsfsf\r\ngSF\r\ngsfg\r\n s\r\ng s\r\ng \r\nsg \r\nsdg\r\ns\r\n gs\r\ng s\r\ndg','y','n','y','2022-01-04 03:25:53','2022-01-04 03:25:53');
/*!40000 ALTER TABLE `exp_application_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exp_list`
--

DROP TABLE IF EXISTS `exp_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exp_list` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '체험단 제목',
  `main_image_name` text COLLATE utf8mb4_unicode_ci COMMENT '이미지(원본@@썸네일1@@썸네일2..)',
  `main_image_ori_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '이미지파일이름',
  `item_id` int NOT NULL COMMENT '연계할 상품 아이디',
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '연계할 상품 이름',
  `exp_limit_personnel` int NOT NULL COMMENT '체험단 인원',
  `exp_date_start` date NOT NULL COMMENT '모집 기간 시작일',
  `exp_date_end` date NOT NULL COMMENT '모집 기간 종료일',
  `exp_review_start` date NOT NULL COMMENT '평가 가능 기간 시작일',
  `exp_review_end` date NOT NULL COMMENT '평가 가능 기간 종료일',
  `exp_release_date` date NOT NULL COMMENT '당첨자 발표일',
  `exp_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '체험단 내용',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exp_list`
--

LOCK TABLES `exp_list` WRITE;
/*!40000 ALTER TABLE `exp_list` DISABLE KEYS */;
INSERT INTO `exp_list` VALUES (19,'제1기 체험단 모집','61b027b99c43cthumb_eval_01.png@@thumb-61b027b99c43cthumb_eval_01_360x180.png@@thumb-61b027b99c43cthumb_eval_01_260x80.png','thumb_eval_01.png',1,'칫솔',10,'2021-12-01','2021-12-31','2021-12-27','2021-12-31','2021-12-31','<p><iframe src=\"https://www.youtube.com/embed/YniCNsMaGUo\" title=\"YouTube video player\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen=\"\" width=\"560\" height=\"315\" frameborder=\"0\"></iframe></p><p>\r\n\r\n\r\n<a href=\"https://youtu.be/fs0vfsOCmCk\">https://youtu.be/fs0vfsOCmCk</a>\r\n\r\n\r\n&nbsp;</p><p><img src=\"http://localhost:8000/data/exp_list/editor/20211208123359143151211.jpg\" title=\"list_img.jpg\"><br style=\"clear:both;\">&nbsp;</p>','2021-12-08 03:34:17','2021-12-30 23:12:05'),(20,'tyest','61c92f899ad24thumb_eval_01.png@@thumb-61c92f899ad24thumb_eval_01_360x180.png@@thumb-61c92f899ad24thumb_eval_01_260x80.png','thumb_eval_01.png',2,'치약',10,'2021-12-15','2021-12-31','2021-12-29','2021-12-31','2021-12-31','<p>sdvfsv</p><p>sd</p><p>vs</p><p>dv</p><p>sdv</p><p>&nbsp;</p>','2021-12-20 23:52:05','2021-12-30 23:12:19'),(21,'456464','61c9441902b78thumb_eval_01.png@@thumb-61c9441902b78thumb_eval_01_360x180.png@@thumb-61c9441902b78thumb_eval_01_260x100.png','thumb_eval_01.png',1,'칫솔',10,'2021-12-27','2021-12-31','2021-12-28','2021-12-31','2021-12-29','<p><img src=\"http://localhost:8000/data/exp_list/editor/20211227153038408619699.png\" title=\"main_D_pc4.png\" style=\"border-color: rgb(0, 0, 0);\" ><br style=\"clear:both;\"><img src=\"http://localhost:8000/data/exp_list/editor/20211227153038800036678.png\" title=\"main_D_pc6.png\"><br style=\"clear:both;\"><img src=\"http://localhost:8000/data/exp_list/editor/202112271530381567539527.png\" title=\"main_D_pc5.png\"><br style=\"clear:both;\"><img src=\"http://localhost:8000/data/exp_list/editor/202112271530381780220767.png\" title=\"main-A_pc.png\"><br style=\"clear:both;\"><img src=\"http://localhost:8000/data/exp_list/editor/202112271530381147622682.png\" title=\"main-C_pc.png\"><br style=\"clear:both;\"><img src=\"http://localhost:8000/data/exp_list/editor/202112271530381456977041.png\" title=\"main-B_pc.png\"><br style=\"clear:both;\"><img src=\"http://localhost:8000/data/exp_list/editor/202112271530381535114088.png\" title=\"main_D_pc7.png\"><br style=\"clear:both;\"><img src=\"http://localhost:8000/data/exp_list/editor/20211227153039913176226.png\" title=\"main_D_pc8.png\"><br style=\"clear:both;\"><img src=\"http://localhost:8000/data/exp_list/editor/202112271530391706109356.png\" title=\"main_D_pc9.png\"><br style=\"clear:both;\"><img src=\"http://localhost:8000/data/exp_list/editor/202112271530391351196573.png\" title=\"main_D_pc (2).png\"><br style=\"clear:both;\">fbf</p><p>bsf</p><p>b</p><p>sfb</p><p>sf</p><p>bsf</p><p>bsf</p><p>&nbsp;</p>','2021-12-27 04:42:01','2021-12-30 23:12:40'),(22,'sfdgsfdbsfb','61cacd18d9f66.jpg@@thumb-61cacd18d9f66_360x180.jpg@@thumb-61cacd18d9f66_260x100.jpg','거북이.jpg',1,'칫솔',3,'2021-12-07','2021-12-31','2021-12-09','2021-12-31','2021-12-31','<p>sfbdfbfdbdfbfsd</p>','2021-12-28 08:38:48','2021-12-30 23:26:34'),(23,'제3기 체험단 모집','61cd616205262.jpg@@thumb-61cd616205262_360x180.jpg@@thumb-61cd616205262_260x100.jpg','강아지.jpg',2,'치약',10,'2021-12-30','2021-12-31','2021-12-31','2022-01-02','2022-01-01','<p>ㅋㅍㅋ</p><p>ㅍㅇㅁㅍㅇㅁ</p><p>ㅍㅇㅁ</p><p>ㅍㅁ</p><p>ㅍ</p><p>ㅁㅍㅇ</p>','2021-12-30 07:36:02','2021-12-31 00:33:08'),(24,'dgnbddff','61d260dc45422.jpg@@thumb-61d260dc45422_360x180.jpg@@thumb-61d260dc45422_260x100.jpg','강아지.jpg',1,'칫솔',10,'2022-01-03','2022-01-06','2022-01-03','2022-01-13','2022-01-05','<p>sfgsf</p><p>b</p><p>sfb</p><p>fdb</p><p>f</p>','2022-01-03 02:35:08','2022-01-03 02:35:08');
/*!40000 ALTER TABLE `exp_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `ca_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '카테고리',
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품코드',
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품명',
  `item_display` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT '출력 여부 : N=>미출력,Y=>출력',
  `item_rank` int NOT NULL DEFAULT '0' COMMENT '출력순서: 높을수록 먼저 나옴',
  `item_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '내용',
  `item_img` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름(원본@@썸네일1@@썸네일2..)',
  `item_ori_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `items_item_code_unique` (`item_code`),
  KEY `items_ca_id_item_code_index` (`ca_id`,`item_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='상품관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membervisits`
--

DROP TABLE IF EXISTS `membervisits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membervisits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `mv_id` int NOT NULL DEFAULT '0' COMMENT '순번',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '유저 아이디',
  `mv_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '아이피',
  `mv_referer` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '방문전 사이트',
  `mv_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'agent',
  `mv_browser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'browser',
  `mv_os` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'os',
  `mv_device` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'device',
  `mv_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'city',
  `mv_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'country',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='회원 접속 통계';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membervisits`
--

LOCK TABLES `membervisits` WRITE;
/*!40000 ALTER TABLE `membervisits` DISABLE KEYS */;
/*!40000 ALTER TABLE `membervisits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menuses`
--

DROP TABLE IF EXISTS `menuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `menu_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '메뉴 카테고리',
  `menu_name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '메뉴 카테고리 영어명',
  `menu_name_kr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '메뉴 카테고리 한글명',
  `menu_page_type` enum('P','B','I') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'P' COMMENT '메뉴 페이지 타입 : P=>일반 HTML,B=>게시판페이지,I=>상품페이지',
  `menu_display` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT '메뉴 출력 여부 : N=>미출력,Y=>출력',
  `menu_rank` int NOT NULL DEFAULT '0' COMMENT '메뉴 출력순서: 높을수록 먼저 나옴',
  `menu_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '내용',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menuses_menu_id_unique` (`menu_id`),
  UNIQUE KEY `menuses_menu_name_en_unique` (`menu_name_en`),
  KEY `menuses_menu_id_index` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='메뉴 관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menuses`
--

LOCK TABLES `menuses` WRITE;
/*!40000 ALTER TABLE `menuses` DISABLE KEYS */;
/*!40000 ALTER TABLE `menuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_22_015115_create_short_urls_table',1),(5,'2019_12_22_015214_create_short_url_visits_table',1),(6,'2020_02_11_224848_update_short_url_table_for_version_two_zero_zero',1),(7,'2020_02_12_008432_update_short_url_visits_table_for_version_two_zero_zero',1),(8,'2020_04_10_224546_update_short_url_table_for_version_three_zero_zero',1),(9,'2021_07_15_091442_create_boardmanagers_table',1),(10,'2021_07_15_120814_create_board_datas_tables_table',1),(11,'2021_07_15_120846_create_board_datas_comment_tables_table',1),(12,'2021_08_03_143341_create_categorys_table',1),(13,'2021_08_04_133642_create_items_table',1),(14,'2021_08_11_164058_create_menuses_table',1),(15,'2021_08_18_142718_create_emails_table',1),(16,'2021_08_18_154508_create_email_sends_table',1),(17,'2021_08_27_134822_create_visits_table',1),(18,'2021_08_30_110635_create_membervisits_table',1),(19,'2021_08_31_122655_create_shopcategorys_table',1),(20,'2021_09_02_171337_create_popups_table',1),(21,'2021_09_13_142951_create_shopitems_table',1),(22,'2021_09_15_132132_create_shopitemoptions_table',1),(23,'2021_09_27_140029_create_shopsettings_table',1),(24,'2021_09_29_145910_create_shop_uniqids_table',1),(25,'2021_09_30_085239_create_shopcarts_table',1),(26,'2021_10_08_105217_create_baesongjis_table',1),(27,'2021_10_15_103436_create_shoppoints_table',1),(28,'2021_10_18_102313_create_sendcosts_table',1),(29,'2021_10_22_091756_create_wishs_table',1),(30,'2021_10_22_140657_create_shoppostlogs_table',1),(31,'2021_10_25_155920_create_shoporders_table',1),(32,'2021_10_27_100626_create_shopordertemps_table',1),(33,'2021_10_29_141849_create_short_links_table',1),(34,'2021_11_08_094727_create_banners_table',1),(35,'2021_11_09_163313_create_exp_list_table',1),(36,'2021_11_11_153702_create_rating_item_table',1),(37,'2021_11_17_125918_create_exp_application_list',1),(38,'2021_11_24_140732_create_review_saves_table',1),(39,'2021_11_30_135225_create_review_save_imgs_table',1),(41,'2021_12_14_100403_create_qnas_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `pw_user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
  `pw_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_pw_user_id_index` (`pw_user_id`),
  KEY `password_resets_pw_token_index` (`pw_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='비밀번호 초기화';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `popups`
--

DROP TABLE IF EXISTS `popups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `popups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `pop_disable_hours` int NOT NULL DEFAULT '0' COMMENT '다시 보지 않음을 선택할 시 몇 시간동안 보여주지 않을지 설정',
  `pop_start_time` datetime NOT NULL COMMENT '시작일시',
  `pop_end_time` datetime NOT NULL COMMENT '종료일시',
  `pop_left` int NOT NULL DEFAULT '0' COMMENT '팝업레이어 좌측 위치',
  `pop_top` int NOT NULL DEFAULT '0' COMMENT '팝업레이어 상단 위치',
  `pop_width` int NOT NULL DEFAULT '0' COMMENT '팝업레이어 넓이',
  `pop_height` int NOT NULL DEFAULT '0' COMMENT '팝업레이어 높이',
  `pop_subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '제목',
  `pop_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '내용',
  `pop_display` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT '출력 여부 : N=>미출력,Y=>출력',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='팝업 관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `popups`
--

LOCK TABLES `popups` WRITE;
/*!40000 ALTER TABLE `popups` DISABLE KEYS */;
/*!40000 ALTER TABLE `popups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qnas`
--

DROP TABLE IF EXISTS `qnas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qnas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `qna_cate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '문의 카테고리',
  `qna_subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '글제목',
  `order_id` bigint NOT NULL COMMENT '주문서번호',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이름',
  `qna_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '내용',
  `qna_answer` text COLLATE utf8mb4_unicode_ci COMMENT '답변',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qnas_qna_cate_user_id_order_id_index` (`qna_cate`,`user_id`,`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='1:1 문의';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qnas`
--

LOCK TABLES `qnas` WRITE;
/*!40000 ALTER TABLE `qnas` DISABLE KEYS */;
INSERT INTO `qnas` VALUES (1,'상품 관련','5446',0,'ysz@yongsanzip.com','','5464654','답변등록답변등록!!!답변등록!!!\r\n답변등록!!!\r\n답변등록!!!\r\n답변등록!!!답변등록!!!답변등록!!!!!!','2021-12-14 02:27:51','2021-12-14 03:20:17'),(2,'배송 관련','문의 하기문의 하기문의 하기문의 하기',0,'ysz@yongsanzip.com','','ansd zd Za sfaf SAf ansd zd Za sfaf SAf ansd zd Za sfaf SAf ansd zd Za sfaf SAf ansd zd Za sfaf SAf ansd zd Za sfaf SAf ansd zd Za sfaf SAf ansd zd Za sfaf SAf ansd zd Za sfaf SAf ansd zd Za sfaf SAf ansd zd Za sfaf SAf','11111111\r\nㅍㄴㅇ\r\nㅍ\r\nㄴㅇㅍ\r\nㄴㅇ\r\nㅍ\r\nㄴㅇㅍ\r\nㄴㅇㅍ\r\nㄴ','2021-12-14 02:28:27','2021-12-14 03:19:28'),(3,'기타 문의','기타 문의 기타 문의 기타 문의 기타 문의 기타 문의 기타 문의',0,'ysz@yongsanzip.com','','기타 문의 기타 문의 기타 문의 기타 문의\r\n\r\n 기타 문의 기타 문의\r\n 기타 문의 기타 문의\r\n 기타 문의 기타 문의 기타 문의 기타 문의\r\n 기타 문의 기타 문의\r\nㅍ\r\n 기타 문의 기타 문의 기타 문의 기타 문의\r\n 기타 문의 기타 문의ㅍ\r\n 기타 문의 기타 문의\r\n 기타 문의 기타 문의 기타 문의 기타 문의\r\n 기타 문의 기타 문의','6555555555555555555555555','2021-12-14 04:08:27','2021-12-14 06:57:13'),(4,'포인트 관련','sfbsssbsbsbs s sd sdg sd g',0,'ysz@yongsanzip.com','','sgsfg sgs gsa d\r\nsd gs\r\nd g\r\nsd g\r\nsd\r\ng s\r\ndg \r\nsdg\r\n sd','fvsfsfv22dgf2ngd2ngf2ngf','2021-12-14 04:21:26','2021-12-14 08:12:59'),(5,'취소/교환/반품 관련','취소취소취소취소',0,'ysz@yongsanzip.com','용산집','취소\r\n취소취소취소취소\r\n취소\r\n취소취소취소ㅍ\r\n\r\n취소취소\r\n취소',NULL,'2021-12-14 08:23:26','2021-12-14 08:23:26'),(6,'상품 관련','54565464',0,'ysz@yongsanzip.com','용산집','54644',NULL,'2021-12-17 02:18:06','2021-12-17 02:18:06'),(7,'포인트 관련','54644',0,'ysz@yongsanzip.com','용산집','6546654',NULL,'2021-12-17 02:18:30','2021-12-17 02:18:30'),(8,'기타 문의','4564',0,'ysz@yongsanzip.com','용산집','56646',NULL,'2021-12-17 02:52:27','2021-12-17 02:52:27'),(9,'주문/결제 관련','uuuuu5464',0,'ysz@yongsanzip.com','용산집','uuuu',NULL,'2021-12-17 03:13:51','2021-12-17 03:13:51'),(10,'기타 문의','fbdbfd',0,'ysz@yongsanzip.com','용산집','sfbsfbsfb',NULL,'2021-12-24 02:11:28','2021-12-24 02:11:28'),(11,'배송 관련','ssvsdvsd',0,'ysz@yongsanzip.com','용산집','sfbssfbsfbs',NULL,'2021-12-24 02:16:13','2021-12-24 02:16:13'),(12,'상품 관련','LIVESUB',0,'livesub@naver.com','바람개비','ASDVSDAVSD\r\nVDS\r\nVSD\r\nV\r\nSDV\r\nSD\r\nVSD\r\nV\r\nSD\r\nVSD\r\nV\r\nSD',NULL,'2022-01-03 03:45:30','2022-01-03 03:45:30'),(13,'상품 관련','45',0,'ysz@yongsanzip.com','용산집','4464',NULL,'2022-01-03 04:09:51','2022-01-03 04:09:51'),(14,'상품 관련','45',0,'ysz@yongsanzip.com','용산집','4464',NULL,'2022-01-03 04:16:35','2022-01-03 04:16:35'),(15,'상품 관련','45',0,'ysz@yongsanzip.com','용산집','4464',NULL,'2022-01-03 04:17:16','2022-01-03 04:17:16'),(16,'상품 관련','45',0,'ysz@yongsanzip.com','용산집','4464',NULL,'2022-01-03 04:20:03','2022-01-03 04:20:03'),(17,'상품 관련','45',0,'ysz@yongsanzip.com','용산집','4464',NULL,'2022-01-03 04:20:19','2022-01-03 04:20:19'),(18,'상품 관련','45',0,'ysz@yongsanzip.com','용산집','4464',NULL,'2022-01-03 04:20:53','2022-01-03 04:20:53'),(19,'상품 관련','45',0,'ysz@yongsanzip.com','용산집','4464',NULL,'2022-01-03 04:21:55','2022-01-03 04:21:55'),(20,'상품 관련','45',0,'ysz@yongsanzip.com','용산집','4464',NULL,'2022-01-03 04:22:35','2022-01-03 04:22:35'),(21,'상품 관련','45',0,'ysz@yongsanzip.com','용산집','4464',NULL,'2022-01-03 04:22:44','2022-01-03 04:22:44'),(22,'상품 관련','546466464',0,'ysz@yongsanzip.com','용산집','664',NULL,'2022-01-03 04:24:36','2022-01-03 04:24:36'),(23,'주문/결제 관련','5464',0,'ysz@yongsanzip.com','용산집','546464',NULL,'2022-01-03 04:24:54','2022-01-03 04:24:54');
/*!40000 ALTER TABLE `qnas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rating_item`
--

DROP TABLE IF EXISTS `rating_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rating_item` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sca_id` int NOT NULL COMMENT '카테고리 아이디',
  `item_name1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '정량 평가 항목 1',
  `item_name2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '정량 평가 항목 2',
  `item_name3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '정량 평가 항목 3',
  `item_name4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '정량 평가 항목 4',
  `item_name5` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '정량 평가 항목 5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating_item`
--

LOCK TABLES `rating_item` WRITE;
/*!40000 ALTER TABLE `rating_item` DISABLE KEYS */;
INSERT INTO `rating_item` VALUES (1,1010,'내용','내용','내용','내용','내용','2021-12-09 03:35:21','2021-12-10 06:55:04'),(2,1030,'hbbbhj1','bjhb1','bhjbb1','bhjb1','bhjb1','2021-12-16 23:43:44','2021-12-16 23:48:45'),(3,1020,'2','2','jjj85555586111','ffff02005511199','사용후 만족도','2021-12-16 23:49:45','2021-12-27 01:52:36');
/*!40000 ALTER TABLE `rating_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_save_imgs`
--

DROP TABLE IF EXISTS `review_save_imgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_save_imgs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `rs_id` int NOT NULL DEFAULT '0' COMMENT '리뷰 순번',
  `review_img` text COLLATE utf8mb4_unicode_ci COMMENT '리뷰 첨부 파일이름1(원본@@썸네일1@@썸네일2..)',
  `review_img_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '리뷰 원본파일이름1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `review_save_imgs_rs_id_index` (`rs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='리뷰 이미지 첨부 파일 모음';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_save_imgs`
--

LOCK TABLES `review_save_imgs` WRITE;
/*!40000 ALTER TABLE `review_save_imgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_save_imgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_saves`
--

DROP TABLE IF EXISTS `review_saves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_saves` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `exp_id` int NOT NULL DEFAULT '0' COMMENT '체험단 id',
  `exp_app_id` int NOT NULL DEFAULT '0' COMMENT '체험단 신청 id',
  `sca_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '카테고리',
  `cart_id` int NOT NULL DEFAULT '0' COMMENT '장바구니 id',
  `order_id` bigint NOT NULL DEFAULT '0' COMMENT '주문서번호',
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '상품코드',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '신청 유저 아이디',
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '신청 유저 이름',
  `score1` double(8,2) NOT NULL COMMENT '정량평가 점수1',
  `score2` double(8,2) NOT NULL COMMENT '정량평가 점수2',
  `score3` double(8,2) NOT NULL COMMENT '정량평가 점수3',
  `score4` double(8,2) NOT NULL COMMENT '정량평가 점수4',
  `score5` double(8,2) NOT NULL COMMENT '정량평가 점수5',
  `average` double(8,2) NOT NULL COMMENT '정량평가 평균점수',
  `review_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '리뷰 내용',
  `temporary_yn` enum('y','n') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'y' COMMENT '임시저장여부(y=>임시저장, n=>저장)',
  `review_blind` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT '블라인드처리유무(N=>아님, Y=>블라인드)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `review_saves_exp_id_exp_app_id_sca_id_item_code_user_id_index` (`exp_id`,`exp_app_id`,`sca_id`,`item_code`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='리뷰 저장 관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_saves`
--

LOCK TABLES `review_saves` WRITE;
/*!40000 ALTER TABLE `review_saves` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_saves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sendcosts`
--

DROP TABLE IF EXISTS `sendcosts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sendcosts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `sc_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '지역명',
  `sc_zip1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '우편번호 시작',
  `sc_zip2` char(5) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '우편번호 끝',
  `sc_price` int NOT NULL DEFAULT '0' COMMENT '추가배송비',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sendcosts_sc_zip1_sc_zip2_index` (`sc_zip1`,`sc_zip2`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='추가 배송비 관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sendcosts`
--

LOCK TABLES `sendcosts` WRITE;
/*!40000 ALTER TABLE `sendcosts` DISABLE KEYS */;
INSERT INTO `sendcosts` VALUES (1,'인천광역시 중구','22386','22388',5000,NULL,NULL),(2,'인천광역시 강화군','23004','23010',5000,NULL,NULL),(3,'인천광역시 옹진군','23101','23116',5000,NULL,NULL);
/*!40000 ALTER TABLE `sendcosts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_uniqids`
--

DROP TABLE IF EXISTS `shop_uniqids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shop_uniqids` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `uq_id` bigint NOT NULL COMMENT 'unique 키',
  `uq_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이피',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shop_uniqids_uq_id_unique` (`uq_id`),
  KEY `shop_uniqids_uq_id_index` (`uq_id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='장바구니 unique 키';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_uniqids`
--

LOCK TABLES `shop_uniqids` WRITE;
/*!40000 ALTER TABLE `shop_uniqids` DISABLE KEYS */;
INSERT INTO `shop_uniqids` VALUES (1,2021120910370942,'127.0.0.1','2021-12-09 01:37:09','2021-12-09 01:37:09'),(2,2021120910420815,'127.0.0.1','2021-12-09 01:42:08','2021-12-09 01:42:08'),(3,2021121013485501,'127.0.0.1','2021-12-10 04:48:55','2021-12-10 04:48:55'),(4,2021121308550072,'127.0.0.1','2021-12-12 23:55:00','2021-12-12 23:55:00'),(5,2021122008523845,'127.0.0.1','2021-12-19 23:52:38','2021-12-19 23:52:38'),(6,2021122009154018,'127.0.0.1','2021-12-20 00:15:40','2021-12-20 00:15:40'),(7,2021122009183328,'127.0.0.1','2021-12-20 00:18:33','2021-12-20 00:18:33'),(8,2021122010445570,'127.0.0.1','2021-12-20 01:44:55','2021-12-20 01:44:55'),(9,2021122010454210,'127.0.0.1','2021-12-20 01:45:42','2021-12-20 01:45:42'),(10,2021122011200932,'127.0.0.1','2021-12-20 02:20:09','2021-12-20 02:20:09'),(11,2021122011595644,'127.0.0.1','2021-12-20 02:59:56','2021-12-20 02:59:56'),(12,2021122012314520,'127.0.0.1','2021-12-20 03:31:45','2021-12-20 03:31:45'),(13,2021122012380698,'127.0.0.1','2021-12-20 03:38:06','2021-12-20 03:38:06'),(14,2021122012461984,'127.0.0.1','2021-12-20 03:46:19','2021-12-20 03:46:19'),(15,2021122012542661,'127.0.0.1','2021-12-20 03:54:26','2021-12-20 03:54:26'),(16,2021122013475942,'127.0.0.1','2021-12-20 04:47:59','2021-12-20 04:47:59'),(17,2021122013482434,'127.0.0.1','2021-12-20 04:48:24','2021-12-20 04:48:24'),(18,2021122014361783,'127.0.0.1','2021-12-20 05:36:17','2021-12-20 05:36:17'),(19,2021122014434430,'127.0.0.1','2021-12-20 05:43:44','2021-12-20 05:43:44'),(20,2021122014505013,'127.0.0.1','2021-12-20 05:50:50','2021-12-20 05:50:50'),(21,2021122014553897,'127.0.0.1','2021-12-20 05:55:38','2021-12-20 05:55:38'),(22,2021122015211480,'127.0.0.1','2021-12-20 06:21:14','2021-12-20 06:21:14'),(23,2021122015214717,'127.0.0.1','2021-12-20 06:21:47','2021-12-20 06:21:47'),(24,2021122015220205,'127.0.0.1','2021-12-20 06:22:02','2021-12-20 06:22:02'),(25,2021122015221241,'127.0.0.1','2021-12-20 06:22:12','2021-12-20 06:22:12'),(26,2021122015311089,'127.0.0.1','2021-12-20 06:31:10','2021-12-20 06:31:10'),(27,2021122015312270,'127.0.0.1','2021-12-20 06:31:22','2021-12-20 06:31:22'),(28,2021122015325656,'127.0.0.1','2021-12-20 06:32:56','2021-12-20 06:32:56'),(29,2021122015340612,'127.0.0.1','2021-12-20 06:34:06','2021-12-20 06:34:06'),(30,2021122015512784,'127.0.0.1','2021-12-20 06:51:27','2021-12-20 06:51:27'),(31,2021122015515078,'127.0.0.1','2021-12-20 06:51:50','2021-12-20 06:51:50'),(32,2021122015521423,'127.0.0.1','2021-12-20 06:52:14','2021-12-20 06:52:14'),(33,2021122015523262,'127.0.0.1','2021-12-20 06:52:32','2021-12-20 06:52:32'),(34,2021122016285515,'127.0.0.1','2021-12-20 07:28:55','2021-12-20 07:28:55'),(35,2021122109532516,'127.0.0.1','2021-12-21 00:53:25','2021-12-21 00:53:25'),(36,2021122109540388,'127.0.0.1','2021-12-21 00:54:03','2021-12-21 00:54:03'),(37,2021122110012458,'127.0.0.1','2021-12-21 01:01:24','2021-12-21 01:01:24'),(38,2021122110082297,'127.0.0.1','2021-12-21 01:08:22','2021-12-21 01:08:22'),(39,2021122110210182,'127.0.0.1','2021-12-21 01:21:01','2021-12-21 01:21:01'),(40,2021122111125524,'127.0.0.1','2021-12-21 02:12:55','2021-12-21 02:12:55'),(41,2021122111131947,'127.0.0.1','2021-12-21 02:13:19','2021-12-21 02:13:19'),(42,2021122111194424,'127.0.0.1','2021-12-21 02:19:44','2021-12-21 02:19:44'),(43,2021122112595962,'127.0.0.1','2021-12-21 03:59:59','2021-12-21 03:59:59'),(44,2021122113002021,'127.0.0.1','2021-12-21 04:00:20','2021-12-21 04:00:20'),(45,2021122113004073,'127.0.0.1','2021-12-21 04:00:40','2021-12-21 04:00:40'),(46,2021122114071713,'127.0.0.1','2021-12-21 05:07:17','2021-12-21 05:07:17'),(47,2021122114073835,'127.0.0.1','2021-12-21 05:07:38','2021-12-21 05:07:38'),(48,2021122408144105,'127.0.0.1','2021-12-23 23:14:41','2021-12-23 23:14:41'),(49,2021122408151012,'127.0.0.1','2021-12-23 23:15:10','2021-12-23 23:15:10');
/*!40000 ALTER TABLE `shop_uniqids` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopcarts`
--

DROP TABLE IF EXISTS `shopcarts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopcarts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `od_id` bigint NOT NULL COMMENT '장바구니 unique 키 = 주문 완료후 주문번호로 업뎃',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품코드',
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품명',
  `item_sc_type` tinyint NOT NULL DEFAULT '0' COMMENT '배송비 유형',
  `item_sc_method` tinyint NOT NULL DEFAULT '0' COMMENT '배송비결제 타입',
  `de_send_cost` int NOT NULL DEFAULT '0' COMMENT '기본 배송비',
  `item_sc_price` int NOT NULL DEFAULT '0' COMMENT '각 상품 배송비',
  `item_sc_minimum` int NOT NULL DEFAULT '0' COMMENT '배송비 상세조건:주문금액',
  `item_sc_qty` int NOT NULL DEFAULT '0' COMMENT '배송비 상세조건:주문수량',
  `sct_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '장바구니 상태',
  `sct_history` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '기록',
  `sct_price` int NOT NULL DEFAULT '0' COMMENT '판매가격',
  `sct_point` int NOT NULL DEFAULT '0' COMMENT '포인트',
  `sct_point_use` tinyint NOT NULL DEFAULT '0' COMMENT '포인트사용여부',
  `sct_stock_use` tinyint NOT NULL DEFAULT '0' COMMENT '재고 차감을 했는지 여부',
  `sct_option` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품명 또는 옵션명',
  `sct_qty` int NOT NULL DEFAULT '0' COMMENT '수량',
  `sio_id` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '옵션항목 조합',
  `sio_type` tinyint NOT NULL DEFAULT '0' COMMENT '옵션타입 : 0=>선택옵션,1=>추가옵션',
  `sio_price` int NOT NULL DEFAULT '0' COMMENT '옵션 추가금액',
  `sct_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이피',
  `sct_send_cost` tinyint NOT NULL DEFAULT '0' COMMENT '배송비 : 1=>착불,2=>무료,3=>선불',
  `sct_direct` tinyint NOT NULL DEFAULT '0' COMMENT '바로구매 체크 : 0=>담기,1=>바로구매',
  `sct_select` tinyint NOT NULL DEFAULT '0' COMMENT '구매진행 체크',
  `sct_select_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '담긴 상품 중 주문하기를 실행한 시각',
  `review_yn` enum('y','n') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '리부작성여부(임시저장시 n)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shopcarts_od_id_item_code_sct_status_index` (`od_id`,`item_code`,`sct_status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='장바구니';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopcarts`
--

LOCK TABLES `shopcarts` WRITE;
/*!40000 ALTER TABLE `shopcarts` DISABLE KEYS */;
INSERT INTO `shopcarts` VALUES (1,2021122114073835,'ysz@yongsanzip.com','sitem_1638922757','칫솔',0,0,2500,4000,0,0,'취소','',5000,50,0,0,'칫솔',0,'',0,0,'127.0.0.1',0,0,1,'2021-12-21 14:07:38','n','2021-12-21 05:07:17','2021-12-21 05:07:17'),(2,2021122114073835,'ysz@yongsanzip.com','sitem_1639957980','치약',0,0,2500,0,0,0,'입력수량취소','',5000,53,0,0,'SIZE:XXL / 색상:빨',2,'XXL빨',0,300,'127.0.0.1',0,0,1,'2021-12-21 14:07:38','n','2021-12-21 05:07:35','2021-12-21 05:07:35'),(3,2021122114073835,'ysz@yongsanzip.com','sitem_1639957980','치약',0,0,2500,0,0,0,'입력수량취소','',5000,53,0,0,'SIZE:XXL / 색상:파',2,'XXL파',0,300,'127.0.0.1',0,0,1,'2021-12-21 14:07:38','n','2021-12-21 05:07:35','2021-12-21 05:07:35'),(4,2021122114073835,'ysz@yongsanzip.com','sitem_1639957980','치약',0,0,2500,0,0,0,'입력수량취소','',5000,53,0,0,'SIZE:XXL / 색상:노',2,'XXL노',0,300,'127.0.0.1',0,0,1,'2021-12-21 14:07:38','n','2021-12-21 05:07:35','2021-12-21 05:07:35'),(5,2021122408144105,'ysz@yongsanzip.com','sitem_1639957980','치약',0,0,2500,0,0,0,'쇼핑','',5000,53,0,0,'SIZE:XXL / 색상:빨',1,'XXL빨',0,300,'127.0.0.1',0,0,0,'2021-12-24 08:15:10','n','2021-12-23 23:15:08','2021-12-23 23:15:37');
/*!40000 ALTER TABLE `shopcarts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopcategorys`
--

DROP TABLE IF EXISTS `shopcategorys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopcategorys` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `sca_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '카테고리',
  `sca_name_kr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '카테고리 한글명',
  `sca_name_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '카테고리 영어명',
  `sca_display` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT '출력 여부 : N=>미출력,Y=>출력',
  `sca_rank` int NOT NULL DEFAULT '0' COMMENT '출력순서: 높을수록 먼저 나옴',
  `sca_img_ori_file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '원본 첨부파일 이름',
  `sca_img` text COLLATE utf8mb4_unicode_ci COMMENT '첨부파일(원본@@썸네일1@@썸네일2..)',
  `sca_rank_dispaly` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT '랭킹 출력 여부 : N=>미출력,Y=>출력',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shopcategorys_sca_id_unique` (`sca_id`),
  KEY `shopcategorys_sca_id_index` (`sca_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='shop 카테고리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopcategorys`
--

LOCK TABLES `shopcategorys` WRITE;
/*!40000 ALTER TABLE `shopcategorys` DISABLE KEYS */;
INSERT INTO `shopcategorys` VALUES (1,'10','욕실','','Y',0,NULL,NULL,'N','2021-12-07 23:58:50','2021-12-07 23:58:50'),(3,'1010','칫솔','','Y',0,NULL,NULL,'N','2021-12-07 23:59:08','2021-12-10 04:38:31'),(4,'1020','치약','','Y',0,NULL,NULL,'N','2021-12-07 23:59:19','2021-12-10 04:38:30'),(5,'1030','치실','','Y',0,NULL,NULL,'N','2021-12-07 23:59:27','2021-12-10 04:38:30');
/*!40000 ALTER TABLE `shopcategorys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopitemoptions`
--

DROP TABLE IF EXISTS `shopitemoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopitemoptions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `sio_id` text COLLATE utf8mb4_unicode_ci COMMENT '옵션항목 조합',
  `sio_type` tinyint NOT NULL DEFAULT '0' COMMENT '옵션타입 : 0=>선택옵션,1=>추가옵션',
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품코드',
  `sio_price` int NOT NULL DEFAULT '0' COMMENT '옵션 추가금액',
  `sio_stock_qty` int NOT NULL DEFAULT '0' COMMENT '옵션 재고수량',
  `sio_noti_qty` int NOT NULL DEFAULT '0' COMMENT '옵션 통보수량',
  `sio_use` tinyint NOT NULL DEFAULT '0' COMMENT '옵션사용여부',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shopitemoptions_item_code_index` (`item_code`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='shop 옵션관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopitemoptions`
--

LOCK TABLES `shopitemoptions` WRITE;
/*!40000 ALTER TABLE `shopitemoptions` DISABLE KEYS */;
INSERT INTO `shopitemoptions` VALUES (31,'XXL빨',0,'sitem_1639957980',300,22,0,1,'2021-12-20 02:54:06','2021-12-21 05:09:43'),(32,'XXL파',0,'sitem_1639957980',300,7,0,1,'2021-12-20 02:54:06','2021-12-21 05:09:43'),(33,'XXL노',0,'sitem_1639957980',300,7,0,1,'2021-12-20 02:54:06','2021-12-21 05:09:43'),(34,'XL빨',0,'sitem_1639957980',300,2,0,1,'2021-12-20 02:54:06','2021-12-20 03:12:42'),(35,'XL파',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06'),(36,'XL노',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06'),(37,'L빨',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06'),(38,'L파',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06'),(39,'L노',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06'),(40,'M빨',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06'),(41,'M파',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06'),(42,'M노',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06'),(43,'S빨',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06'),(44,'S파',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06'),(45,'S노',0,'sitem_1639957980',300,5,0,1,'2021-12-20 02:54:06','2021-12-20 02:54:06');
/*!40000 ALTER TABLE `shopitemoptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopitems`
--

DROP TABLE IF EXISTS `shopitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopitems` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `sca_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '카테고리',
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품코드',
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품명',
  `item_basic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '기본 설명',
  `item_manufacture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '제조사',
  `item_origin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '원산지',
  `item_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '브랜드',
  `item_model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '모델',
  `item_option_subject` text COLLATE utf8mb4_unicode_ci COMMENT '상품선택옵션 콤마로 저장',
  `item_supply_subject` text COLLATE utf8mb4_unicode_ci COMMENT '상품추가옵션 콤마로 저장',
  `item_type1` tinyint NOT NULL DEFAULT '0' COMMENT '상품유형:NEW',
  `item_type2` tinyint NOT NULL DEFAULT '0' COMMENT '상품유형:BIG SALE',
  `item_type3` tinyint NOT NULL DEFAULT '0' COMMENT '상품유형:HOT',
  `item_type4` tinyint NOT NULL DEFAULT '0' COMMENT '상품유형:여분',
  `item_special` tinyint NOT NULL DEFAULT '0' COMMENT '기획전1표시',
  `item_special2` tinyint NOT NULL DEFAULT '0' COMMENT '기획전2표시',
  `item_new_arrival` tinyint NOT NULL DEFAULT '0' COMMENT 'new arrival',
  `item_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품내용',
  `item_content2` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품추가내용',
  `item_content3` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품추가내용',
  `item_content4` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품추가내용',
  `item_content5` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품추가내용',
  `item_cust_price` int NOT NULL DEFAULT '0' COMMENT '시중가격',
  `item_price` int NOT NULL DEFAULT '0' COMMENT '판매가격',
  `item_point_type` tinyint NOT NULL DEFAULT '0' COMMENT '포인트 유형',
  `item_point` int NOT NULL DEFAULT '0' COMMENT '포인트',
  `item_supply_point` int NOT NULL DEFAULT '0' COMMENT '추가옵션상품 포인트',
  `item_use` tinyint NOT NULL DEFAULT '1' COMMENT '판매가능',
  `item_nocoupon` tinyint NOT NULL DEFAULT '0' COMMENT '쿠폰적용안함',
  `item_soldout` tinyint NOT NULL DEFAULT '0' COMMENT '상품품절',
  `item_stock_qty` int NOT NULL DEFAULT '0' COMMENT '재고수량',
  `item_sc_type` tinyint NOT NULL DEFAULT '0' COMMENT '배송비 유형',
  `item_sc_method` tinyint NOT NULL DEFAULT '0' COMMENT '배송비결제 타입',
  `item_sc_price` int NOT NULL DEFAULT '0' COMMENT '기본배송비',
  `item_sc_minimum` int NOT NULL DEFAULT '0' COMMENT '배송비 상세조건:주문금액',
  `item_sc_qty` int NOT NULL DEFAULT '0' COMMENT '배송비 상세조건:주문수량',
  `item_tel_inq` tinyint NOT NULL DEFAULT '0' COMMENT '전화문의',
  `item_display` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y' COMMENT '출력 여부 : N=>미출력,Y=>출력',
  `item_rank` int NOT NULL DEFAULT '0' COMMENT '출력순서: 높을수록 먼저 나옴',
  `item_img1` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름1(원본@@썸네일1@@썸네일2..)',
  `item_ori_img1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름1',
  `item_img2` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름2(원본@@썸네일1@@썸네일2..)',
  `item_ori_img2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름2',
  `item_img3` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름3(원본@@썸네일1@@썸네일2..)',
  `item_ori_img3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름3',
  `item_img4` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름4(원본@@썸네일1@@썸네일2..)',
  `item_ori_img4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름4',
  `item_img5` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름5(원본@@썸네일1@@썸네일2..)',
  `item_ori_img5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름5',
  `item_img6` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름6(원본@@썸네일1@@썸네일2..)',
  `item_ori_img6` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름6',
  `item_img7` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름7(원본@@썸네일1@@썸네일2..)',
  `item_ori_img7` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름7',
  `item_img8` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름8(원본@@썸네일1@@썸네일2..)',
  `item_ori_img8` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름8',
  `item_img9` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름9(원본@@썸네일1@@썸네일2..)',
  `item_ori_img9` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름9',
  `item_img10` text COLLATE utf8mb4_unicode_ci COMMENT '상품 변경파일이름10(원본@@썸네일1@@썸네일2..)',
  `item_ori_img10` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '상품 원본파일이름10',
  `item_del` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N' COMMENT '상품삭제:Y=>삭제',
  `item_average` double(8,2) NOT NULL COMMENT '정량평가 평균점수',
  `review_cnt` int NOT NULL DEFAULT '0' COMMENT '리뷰 갯수',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shopitems_item_code_unique` (`item_code`),
  KEY `shopitems_sca_id_item_code_item_average_index` (`sca_id`,`item_code`,`item_average`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='shop 상품관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopitems`
--

LOCK TABLES `shopitems` WRITE;
/*!40000 ALTER TABLE `shopitems` DISABLE KEYS */;
INSERT INTO `shopitems` VALUES (1,'1010','sitem_1638922757','칫솔','칫솔 입니다. 칫솔 입니다. 칫솔 입니다. 칫솔 입니다.',NULL,NULL,NULL,NULL,NULL,NULL,4,0,0,0,1,1,1,'<p>솔</p><p>&nbsp;</p><p><img src=\"http://localhost:8000/data/shopitem/editor/202112080921101641652423.jpg\" title=\"chisol.jpg\"><br style=\"clear:both;\">&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>','<p><span style=\"font-family: &quot;Noto Sans CJK KR&quot;; font-size: medium;\">성분</span>&nbsp;</p>','<p><span style=\"font-family: &quot;Noto Sans CJK KR&quot;; font-size: medium;\">포장</span>&nbsp;</p>','<p>&nbsp;</p>','<p>&nbsp;</p>',0,5000,0,1,0,1,0,0,14,0,0,4000,0,0,0,'Y',0,'61baf66eedd72chisol.jpg@@thumb-61baf66eedd72chisol_600x500.jpg@@thumb-61baf66eedd72chisol_500x250.jpg@@thumb-61baf66eedd72chisol_100x80.jpg','chisol.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'N',2.30,2,'2021-12-08 00:22:15','2021-12-21 05:27:27'),(2,'1020','sitem_1639957980','치약','치약 치약 치약 치약 치약 치약',NULL,NULL,NULL,NULL,'SIZE,색상',NULL,0,0,0,0,0,0,0,'<p>치약&nbsp;&nbsp;</p><p>치약&nbsp;&nbsp;</p><p>치약&nbsp;치약&nbsp;&nbsp;</p><p>치약&nbsp;&nbsp;</p><p>치약&nbsp;&nbsp;</p>','<p>&nbsp;</p>','<p>&nbsp;</p>','<p>&nbsp;</p>','<p>&nbsp;</p>',7000,5000,0,1,0,1,0,0,90,0,0,0,0,0,0,'Y',0,'61bfc62d4de55.jpg@@thumb-61bfc62d4de55_600x500.jpg@@thumb-61bfc62d4de55_500x250.jpg@@thumb-61bfc62d4de55_100x80.jpg','거북이.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'N',3.60,2,'2021-12-19 23:54:21','2021-12-19 23:55:14'),(3,'1020','sitem_1641256247','ttttt','4565656',NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,0,0,0,0,'<p>fb</p><p>sbfdb</p><p>sdb</p><p>sf</p><p>bs</p><p>b</p><p>sfb</p><p>s</p><p>bsf</p><p>&nbsp;</p>','<p>&nbsp;</p>','<p>&nbsp;</p>','<p>&nbsp;</p>','<p>&nbsp;</p>',0,0,0,1,0,1,0,0,99999,0,0,0,0,0,0,'Y',0,'61d3965d645c9.jpg@@thumb-61d3965d645c9_600x520.jpg@@thumb-61d3965d645c9_290x250.jpg@@thumb-61d3965d645c9_160x140.jpg@@thumb-61d3965d645c9_110x96.jpg','강아지.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'N',0.00,0,'2022-01-04 00:31:08','2022-01-04 00:35:41');
/*!40000 ALTER TABLE `shopitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoporders`
--

DROP TABLE IF EXISTS `shoporders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shoporders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `order_id` bigint NOT NULL COMMENT '주문서번호',
  `od_id` bigint NOT NULL COMMENT '장바구니 unique 키',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
  `od_deposit_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '입금자',
  `ad_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 이름',
  `ad_tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 전화번호',
  `ad_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 휴대폰번호',
  `ad_zip1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 우편번호',
  `ad_addr1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 기본주소',
  `ad_addr2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 상세주소',
  `ad_addr3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '받으시는 분 주소 참고 항목',
  `ad_jibeon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '받으시는 분 지번주소',
  `od_memo` text COLLATE utf8mb4_unicode_ci COMMENT '전하실말씀',
  `od_cart_count` int NOT NULL DEFAULT '0' COMMENT '장바구니 상품 개수',
  `od_cart_price` int NOT NULL DEFAULT '0' COMMENT '주문상품 총금액',
  `de_send_cost` int NOT NULL DEFAULT '0' COMMENT '기본 배송비',
  `de_send_cost_free` int NOT NULL DEFAULT '0' COMMENT '기본 배송비 무료 정책',
  `od_send_cost` int NOT NULL DEFAULT '0' COMMENT '각 상품 배송비',
  `od_send_cost2` int NOT NULL DEFAULT '0' COMMENT '추가배송비',
  `od_receipt_price` int NOT NULL DEFAULT '0' COMMENT '결제금액',
  `od_cancel_price` int NOT NULL DEFAULT '0' COMMENT '취소금액',
  `od_receipt_point` int NOT NULL DEFAULT '0' COMMENT '결제시 사용 포인트',
  `od_refund_price` int NOT NULL DEFAULT '0' COMMENT '반품, 품절 금액',
  `od_receipt_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '결제일시',
  `od_shop_memo` text COLLATE utf8mb4_unicode_ci COMMENT '상점메모',
  `od_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '주문상태',
  `od_settle_case` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '결제방식',
  `od_pg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '간편결제 방식',
  `od_tno` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '거래번호',
  `imp_uid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아임포트 코드',
  `imp_apply_num` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아임포트 승인번호',
  `imp_card_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '카드사에서 전달 받는 값(카드사명칭)',
  `imp_card_quota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '카드사에서 전달 받는 값(할부개월수)',
  `imp_card_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '카드사에서 전달 받는 값(카드번호)',
  `od_delivery_company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '배송회사',
  `od_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '운송장번호',
  `od_misu` int NOT NULL DEFAULT '0' COMMENT '미수금',
  `od_mod_history` text COLLATE utf8mb4_unicode_ci COMMENT '상태변경 히스토리',
  `od_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '주문자IP',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shoporders_order_id_od_id_user_id_index` (`order_id`,`od_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='주문서';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoporders`
--

LOCK TABLES `shoporders` WRITE;
/*!40000 ALTER TABLE `shoporders` DISABLE KEYS */;
INSERT INTO `shoporders` VALUES (1,2021122114073835,2021122114071713,'ysz@yongsanzip.com','용산집','용산집','546456456','0111111222','23105','인천 옹진군 대청면 대청남로 2','555646464',NULL,NULL,NULL,2,34400,0,30000,4000,5000,66700,29900,0,0,'2021-12-21 14:09:19','','취소','card','html5_inicis','','imp_713272951610','00578316','현대카드','0','949086*********3',NULL,NULL,-29900,'2021-12-21 14:09:43 칫솔 입력수량취소 2 -> 1\n2021-12-21 14:09:43 SIZE:XXL / 색상:빨 입력수량취소 3 -> 2\n2021-12-21 14:09:43 SIZE:XXL / 색상:파 입력수량취소 3 -> 2\n2021-12-21 14:09:43 SIZE:XXL / 색상:노 입력수량취소 3 -> 2\n2021-12-21 14:26:17 칫솔 주문취소 1 -> 0\n2021-12-21 14:27:27 칫솔 주문취소 1 -> 0\n','127.0.0.1','2021-12-21 05:09:19','2021-12-21 05:09:19');
/*!40000 ALTER TABLE `shoporders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopordertemps`
--

DROP TABLE IF EXISTS `shopordertemps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopordertemps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `order_id` bigint NOT NULL COMMENT '주문서번호',
  `od_id` bigint NOT NULL COMMENT '장바구니 unique 키',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
  `od_cart_price` int NOT NULL DEFAULT '0' COMMENT '주문상품 총금액',
  `de_send_cost` int NOT NULL DEFAULT '0' COMMENT '기본 배송비',
  `de_send_cost_free` int NOT NULL DEFAULT '0' COMMENT '기본 배송비 무료 정책',
  `od_send_cost` int NOT NULL DEFAULT '0' COMMENT '각 상품 배송비',
  `od_send_cost2` int NOT NULL DEFAULT '0' COMMENT '추가배송비',
  `od_receipt_price` int NOT NULL DEFAULT '0' COMMENT '결제금액',
  `od_receipt_point` int NOT NULL DEFAULT '0' COMMENT '결제 포인트',
  `tot_item_point` int NOT NULL DEFAULT '0' COMMENT '각 상품의 포인트 합',
  `ad_zip1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '받으시는 분 우편번호',
  `od_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '주문자IP',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shopordertemps_order_id_od_id_user_id_index` (`order_id`,`od_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='결제전주문검증';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopordertemps`
--

LOCK TABLES `shopordertemps` WRITE;
/*!40000 ALTER TABLE `shopordertemps` DISABLE KEYS */;
INSERT INTO `shopordertemps` VALUES (1,2021120910420815,2021120910370942,'ysz@yongsanzip.com',5000,2500,0,0,0,7500,0,50,'46760','127.0.0.1','2021-12-09 01:42:51','2021-12-09 01:42:51'),(2,2021122009183328,2021121013485501,'ysz@yongsanzip.com',68600,0,30000,0,0,68600,50,686,'4150','127.0.0.1','2021-12-20 00:19:01','2021-12-20 00:19:01'),(3,2021122012542661,2021122010445570,'ysz@yongsanzip.com',57700,0,30000,0,0,57700,56700,577,'7237','127.0.0.1','2021-12-20 01:46:42','2021-12-20 01:46:42'),(4,2021122016285515,2021122013475942,'ysz@yongsanzip.com',57700,0,30000,4000,5000,66700,0,577,'23105','127.0.0.1','2021-12-20 04:48:36','2021-12-20 04:48:36'),(5,2021122110210182,2021122109532516,'ysz@yongsanzip.com',57700,0,30000,4000,5000,66700,0,577,'23105','127.0.0.1','2021-12-21 00:54:36','2021-12-21 00:54:36'),(6,2021122111194424,2021122111125524,'ysz@yongsanzip.com',57700,0,30000,4000,5000,66700,0,577,'23105','127.0.0.1','2021-12-21 02:13:34','2021-12-21 02:13:34'),(7,2021122113004073,2021122112595962,'ysz@yongsanzip.com',57700,0,30000,4000,5000,66700,0,577,'23105','127.0.0.1','2021-12-21 04:00:34','2021-12-21 04:00:34'),(8,2021122114073835,2021122114071713,'ysz@yongsanzip.com',57700,0,30000,4000,5000,66700,0,577,'23105','127.0.0.1','2021-12-21 05:07:52','2021-12-21 05:07:52');
/*!40000 ALTER TABLE `shopordertemps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoppoints`
--

DROP TABLE IF EXISTS `shoppoints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shoppoints` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
  `po_content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '적립 내용',
  `po_point` int NOT NULL DEFAULT '0' COMMENT '적립금액',
  `po_use_point` int NOT NULL DEFAULT '0' COMMENT '사용금액',
  `po_user_point` int NOT NULL DEFAULT '0' COMMENT '적립전 회원 포인트',
  `po_type` tinyint NOT NULL DEFAULT '1' COMMENT '적립금 지금 유형 : 1=>회원가입,3=>구매평,5=>체험단평,7=>사용,8=>적립',
  `po_write_id` int NOT NULL DEFAULT '0' COMMENT '적립금 지급 유형 글번호',
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '주문번호',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shoppoints_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=285 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='포인트 관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppoints`
--

LOCK TABLES `shoppoints` WRITE;
/*!40000 ALTER TABLE `shoppoints` DISABLE KEYS */;
INSERT INTO `shoppoints` VALUES (1,'livesubkim@gmail.com','회원 가입 적립',3000,0,0,1,0,'','2021-12-08 01:26:46','2021-12-08 01:26:46'),(76,'ysz@yongsanzip.com','회원 가입 적립',300000,0,0,1,0,'','2021-12-20 05:37:15','2021-12-20 05:37:15'),(213,'ysz@yongsanzip.com','구매 적립',577,0,300000,8,0,'2021122114073835','2021-12-21 05:09:19','2021-12-21 05:09:19'),(214,'ysz@yongsanzip.com','구매 적립 취소',-50,0,300577,9,0,'2021122114073835','2021-12-21 05:09:43','2021-12-21 05:09:43'),(215,'ysz@yongsanzip.com','구매 적립 취소',-53,0,300527,9,0,'2021122114073835','2021-12-21 05:09:43','2021-12-21 05:09:43'),(216,'ysz@yongsanzip.com','구매 적립 취소',-53,0,300474,9,0,'2021122114073835','2021-12-21 05:09:43','2021-12-21 05:09:43'),(217,'ysz@yongsanzip.com','구매 적립 취소',-53,0,300421,9,0,'2021122114073835','2021-12-21 05:09:43','2021-12-21 05:09:43'),(218,'ysz@yongsanzip.com','구매 적립 취소',-50,0,300368,9,0,'2021122114073835','2021-12-21 05:27:27','2021-12-21 05:27:27'),(228,'livesub@naver.com','회원 가입 적립',3000,0,0,1,0,'','2021-12-23 07:54:24','2021-12-23 07:54:24'),(229,'ysz@yongsanzip.com','평가단 평가 적립',100,0,300318,5,0,'0','2021-12-27 05:24:26','2021-12-27 05:24:26'),(230,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,300418,14,0,'0','2021-12-27 05:24:26','2021-12-27 05:24:26'),(231,'ysz@yongsanzip.com','상품 평가 적립',200,0,300518,2,0,'0','2021-12-28 01:09:06','2021-12-28 01:09:06'),(232,'ysz@yongsanzip.com','상품 평가 적립',200,0,300718,2,0,'0','2021-12-28 01:09:44','2021-12-28 01:09:44'),(233,'ysz@yongsanzip.com','평가단 평가 적립',200,0,300918,5,0,'0','2021-12-28 03:35:29','2021-12-28 03:35:29'),(234,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,301118,14,0,'0','2021-12-28 03:35:29','2021-12-28 03:35:29'),(235,'ysz@yongsanzip.com','상품 평가 적립',200,0,301218,2,0,'0','2021-12-28 04:23:02','2021-12-28 04:23:02'),(236,'ysz@yongsanzip.com','상품 포토 리뷰 적립',100,0,301418,12,0,'0','2021-12-28 04:23:02','2021-12-28 04:23:02'),(237,'ysz@yongsanzip.com','평가단 평가 적립',200,0,301518,5,0,'0','2021-12-28 04:32:08','2021-12-28 04:32:08'),(238,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,301718,14,0,'0','2021-12-28 04:32:08','2021-12-28 04:32:08'),(239,'ysz@yongsanzip.com','상품 평가 적립',200,0,301818,2,0,'0','2021-12-28 04:35:31','2021-12-28 04:35:31'),(240,'ysz@yongsanzip.com','상품 평가 적립',200,0,302018,2,0,'0','2021-12-28 04:36:30','2021-12-28 04:36:30'),(241,'ysz@yongsanzip.com','평가단 평가 적립',200,0,302218,5,0,'0','2021-12-28 04:40:02','2021-12-28 04:40:02'),(242,'ysz@yongsanzip.com','평가단 평가 적립',200,0,302418,5,0,'0','2021-12-28 04:53:21','2021-12-28 04:53:21'),(243,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,302618,14,0,'0','2021-12-28 04:53:21','2021-12-28 04:53:21'),(244,'ysz@yongsanzip.com','상품 평가 적립',200,0,302718,2,0,'0','2021-12-28 07:32:43','2021-12-28 07:32:43'),(245,'ysz@yongsanzip.com','평가단 평가 적립',200,0,302918,5,0,'0','2021-12-29 23:51:12','2021-12-29 23:51:12'),(246,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,303118,14,0,'0','2021-12-29 23:51:12','2021-12-29 23:51:12'),(247,'ysz@yongsanzip.com','평가단 평가 적립',200,0,303218,5,0,'0','2021-12-30 04:15:20','2021-12-30 04:15:20'),(248,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,303418,14,0,'0','2021-12-30 04:15:20','2021-12-30 04:15:20'),(249,'ysz@yongsanzip.com','상품 평가 적립',200,0,303518,2,0,'0','2021-12-30 05:38:35','2021-12-30 05:38:35'),(250,'ysz@yongsanzip.com','상품 포토 리뷰 적립',100,0,303718,12,0,'0','2021-12-30 05:38:35','2021-12-30 05:38:35'),(251,'ysz@yongsanzip.com','평가단 평가 적립',200,0,303818,5,0,'0','2021-12-31 00:32:35','2021-12-31 00:32:35'),(252,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,304018,14,0,'0','2021-12-31 00:32:35','2021-12-31 00:32:35'),(253,'ysz@yongsanzip.com','평가단 평가 적립',200,0,304118,5,0,'0','2021-12-31 00:33:56','2021-12-31 00:33:56'),(254,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,304318,14,0,'0','2021-12-31 00:33:56','2021-12-31 00:33:56'),(255,'ysz@yongsanzip.com','상품 평가 적립',200,0,304418,2,0,'0','2021-12-31 00:34:30','2021-12-31 00:34:30'),(256,'ysz@yongsanzip.com','상품 평가 적립',200,0,304618,2,0,'0','2021-12-31 00:41:18','2021-12-31 00:41:18'),(257,'ysz@yongsanzip.com','상품 평가 적립',200,0,304818,2,0,'0','2021-12-31 00:52:22','2021-12-31 00:52:22'),(258,'ysz@yongsanzip.com','상품 평가 적립',200,0,305018,2,0,'0','2021-12-31 00:54:38','2021-12-31 00:54:38'),(259,'ysz@yongsanzip.com','상품 포토 리뷰 적립',100,0,305218,12,0,'0','2021-12-31 00:54:38','2021-12-31 00:54:38'),(260,'ysz@yongsanzip.com','상품 평가 적립',200,0,305318,2,0,'0','2021-12-31 00:57:19','2021-12-31 00:57:19'),(261,'ysz@yongsanzip.com','상품 포토 리뷰 적립',100,0,305518,12,0,'0','2021-12-31 00:57:19','2021-12-31 00:57:19'),(262,'ysz@yongsanzip.com','상품 평가 적립',200,0,305618,2,0,'0','2021-12-31 00:58:14','2021-12-31 00:58:14'),(263,'ysz@yongsanzip.com','상품 포토 리뷰 적립',100,0,305818,12,0,'2021122114073835','2021-12-31 00:58:14','2021-12-31 00:58:14'),(264,'ysz@yongsanzip.com','상품 평가 적립',200,0,305918,2,0,'0','2021-12-31 01:25:16','2021-12-31 01:25:16'),(265,'ysz@yongsanzip.com','상품 포토 리뷰 적립',100,0,306118,12,0,'2021122114073835','2021-12-31 01:25:16','2021-12-31 01:25:16'),(266,'ysz@yongsanzip.com','상품 평가 적립',200,0,306218,2,0,'0','2021-12-31 02:08:39','2021-12-31 02:08:39'),(267,'ysz@yongsanzip.com','평가단 평가 적립',200,0,306418,5,2,'0','2021-12-31 04:33:46','2021-12-31 04:33:46'),(268,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,306618,14,2,'0','2021-12-31 04:33:46','2021-12-31 04:33:46'),(269,'ysz@yongsanzip.com','평가단 평가 적립',200,0,306718,5,1,'0','2021-12-31 04:36:52','2021-12-31 04:36:52'),(270,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,306918,14,1,'0','2021-12-31 04:36:52','2021-12-31 04:36:52'),(271,'ysz@yongsanzip.com','상품 평가 적립',200,0,307018,2,4,'2021122114073835','2021-12-31 04:38:09','2021-12-31 04:38:09'),(272,'ysz@yongsanzip.com','상품 포토 리뷰 적립',100,0,307218,12,4,'2021122114073835','2021-12-31 04:38:09','2021-12-31 04:38:09'),(273,'ysz@yongsanzip.com','상품 평가 적립',200,0,307318,2,3,'2021122114073835','2021-12-31 04:39:48','2021-12-31 04:39:48'),(274,'ysz@yongsanzip.com','상품 포토 리뷰 적립',100,0,307518,12,3,'2021122114073835','2021-12-31 04:39:48','2021-12-31 04:39:48'),(275,'ysz@yongsanzip.com','상품 평가 취소',-200,0,307618,3,0,'0','2022-01-03 00:53:43','2022-01-03 00:53:43'),(276,'ysz@yongsanzip.com','상품 포토 리뷰 취소',-100,0,307418,13,0,'0','2022-01-03 00:53:43','2022-01-03 00:53:43'),(277,'ysz@yongsanzip.com','상품 평가 적립',200,0,307318,2,0,'0','2022-01-03 00:55:56','2022-01-03 00:55:56'),(278,'ysz@yongsanzip.com','상품 포토 리뷰 적립',100,0,307518,12,0,'0','2022-01-03 00:55:56','2022-01-03 00:55:56'),(279,'ysz@yongsanzip.com','평가단 평가 취소',-200,0,307618,6,2,'0','2022-01-03 02:57:43','2022-01-03 02:57:43'),(280,'ysz@yongsanzip.com','평가단 포토 리뷰 취소',-100,0,307418,15,2,'0','2022-01-03 02:57:43','2022-01-03 02:57:43'),(281,'ysz@yongsanzip.com','평가단 평가 적립',200,0,307318,5,2,'0','2022-01-03 02:58:27','2022-01-03 02:58:27'),(282,'ysz@yongsanzip.com','평가단 포토 리뷰 적립',100,0,307518,14,2,'0','2022-01-03 02:58:27','2022-01-03 02:58:27'),(283,'livesub@naver.com','평가단 평가 적립',200,0,3000,5,8,'0','2022-01-04 02:45:43','2022-01-04 02:45:43'),(284,'livesub@naver.com','평가단 포토 리뷰 적립',100,0,3200,14,8,'0','2022-01-04 02:45:43','2022-01-04 02:45:43');
/*!40000 ALTER TABLE `shoppoints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shoppostlogs`
--

DROP TABLE IF EXISTS `shoppostlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shoppostlogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `oid` bigint NOT NULL COMMENT '장바구니 unique 키',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
  `post_data` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '기록',
  `ol_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'code',
  `ol_msg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '메세지',
  `ol_ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'ip',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shoppostlogs_oid_index` (`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='주문요청기록 로그';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppostlogs`
--

LOCK TABLES `shoppostlogs` WRITE;
/*!40000 ALTER TABLE `shoppostlogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `shoppostlogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shopsettings`
--

DROP TABLE IF EXISTS `shopsettings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopsettings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '회사명',
  `company_saupja_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '사업자 등록번호',
  `company_owner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '대표자명',
  `company_tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '대표전화번호',
  `company_fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '팩스번호',
  `company_tongsin_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '통신판매업 신고 번호',
  `company_buga_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '부가통신 사업자번호',
  `company_zip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '사업장 우편번호',
  `company_addr` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '사업장 주소',
  `company_info_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '정보관리책임자명',
  `company_info_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '정보책임자이메일',
  `company_bank_use` tinyint NOT NULL DEFAULT '1' COMMENT '무통장입금사용:0=>사용안함,1=>사용함',
  `company_bank_account` text COLLATE utf8mb4_unicode_ci COMMENT '은행계좌번호',
  `company_use_point` tinyint NOT NULL DEFAULT '1' COMMENT '포인트 사용',
  `member_reg_point` int NOT NULL DEFAULT '0' COMMENT '신규가입 포인트 금액',
  `de_send_cost` int NOT NULL DEFAULT '0' COMMENT '기본배송비',
  `de_send_cost_free` int NOT NULL DEFAULT '0' COMMENT '기본배송비 무료정책',
  `de_ment_change` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '기획전1 멘트 변경',
  `de_ment_change2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '기획전2 멘트 변경',
  `shop_img_width` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '이미지리사이징-넓이',
  `shop_img_height` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '이미지리사이징-높이',
  `text_point` int NOT NULL DEFAULT '0' COMMENT '텍스트 리뷰 포인트',
  `photo_point` int NOT NULL DEFAULT '0' COMMENT '포토 리뷰 포인트',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='shop 환경 설정';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shopsettings`
--

LOCK TABLES `shopsettings` WRITE;
/*!40000 ALTER TABLE `shopsettings` DISABLE KEYS */;
INSERT INTO `shopsettings` VALUES (1,'지구랭','123-45-67890','대표자명','02-123-4567','02-123-4568','제 OO구 - 123호','12345호','01251','OO도 OO시 OO구 OO동 123-45','정보책임자명','jigoorang_hehe@naver.com',0,NULL,1,3000,2500,30000,'기획전111','기획전222','600%%290%%160%%110','520%%250%%140%%96',200,100,'2021-12-08 00:18:48','2022-01-04 00:33:40');
/*!40000 ALTER TABLE `shopsettings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `short_links`
--

DROP TABLE IF EXISTS `short_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `short_links` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '식별 코드',
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '원래 주소 값(이동할 링크)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `short_links`
--

LOCK TABLES `short_links` WRITE;
/*!40000 ALTER TABLE `short_links` DISABLE KEYS */;
INSERT INTO `short_links` VALUES (13,'fJ6r7R','http://localhost:8000/sendPwChange/Mw==?expires=1640219642&signature=03bc4b2581afe884490c83881a396dcf4715e7b2e3f09aa1b0f694ae7e0caa0e','2021-12-23 00:29:02','2021-12-23 00:29:02'),(14,'gAEOtI','http://localhost:8000/sendPwChange/Mw==?expires=1640220167&signature=c4756051182eb725e983ba2d210f1444a007ea4429ab3f042d15afbe1737e62e','2021-12-23 00:37:47','2021-12-23 00:37:47'),(15,'2pFEuY','http://localhost:8000/sendPwChange/Mw==?expires=1640221274&signature=2564db416f0fb1d21d50b0d568ac7bccc446a702ef8227ec254b7c7db25baf73','2021-12-23 00:56:14','2021-12-23 00:56:14'),(16,'4wBpkJ','http://localhost:8000/sendPwChange/Mw==?expires=1640221387&signature=344baf720de49f1512d4cb7c8af97827114b0ed040e9aed4974075ac3574863f','2021-12-23 00:58:07','2021-12-23 00:58:07');
/*!40000 ALTER TABLE `short_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `short_url_visits`
--

DROP TABLE IF EXISTS `short_url_visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `short_url_visits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `short_url_id` bigint unsigned NOT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operating_system` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `operating_system_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referer_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `device_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visited_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `short_url_visits_short_url_id_foreign` (`short_url_id`),
  CONSTRAINT `short_url_visits_short_url_id_foreign` FOREIGN KEY (`short_url_id`) REFERENCES `short_urls` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `short_url_visits`
--

LOCK TABLES `short_url_visits` WRITE;
/*!40000 ALTER TABLE `short_url_visits` DISABLE KEYS */;
/*!40000 ALTER TABLE `short_url_visits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `short_urls`
--

DROP TABLE IF EXISTS `short_urls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `short_urls` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `destination_url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_short_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `single_use` tinyint(1) NOT NULL,
  `track_visits` tinyint(1) NOT NULL,
  `redirect_status_code` int NOT NULL DEFAULT '301',
  `track_ip_address` tinyint(1) NOT NULL DEFAULT '0',
  `track_operating_system` tinyint(1) NOT NULL DEFAULT '0',
  `track_operating_system_version` tinyint(1) NOT NULL DEFAULT '0',
  `track_browser` tinyint(1) NOT NULL DEFAULT '0',
  `track_browser_version` tinyint(1) NOT NULL DEFAULT '0',
  `track_referer_url` tinyint(1) NOT NULL DEFAULT '0',
  `track_device_type` tinyint(1) NOT NULL DEFAULT '0',
  `activated_at` timestamp NULL DEFAULT '2021-12-07 23:53:53',
  `deactivated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `short_urls_url_key_unique` (`url_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `short_urls`
--

LOCK TABLES `short_urls` WRITE;
/*!40000 ALTER TABLE `short_urls` DISABLE KEYS */;
/*!40000 ALTER TABLE `short_urls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '비밀번호',
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이름',
  `user_tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '집 전화번호',
  `user_birth` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '생년월일',
  `user_gender` enum('M','W') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '성별',
  `user_promotion_agree` enum('N','Y') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '프로모션 관련 동의 사항',
  `user_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '휴대 전화번호',
  `user_imagepath` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '프로필사진 변경파일이름',
  `user_ori_imagepath` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '프로필사진 원본파일이름',
  `user_thumb_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '썸네일 파일 이름',
  `user_confirm_code` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '이메일 확인',
  `user_activated` tinyint(1) NOT NULL DEFAULT '0' COMMENT '가입 확인',
  `user_level` int NOT NULL DEFAULT '10' COMMENT '사용자 레벨',
  `user_type` enum('N','Y') COLLATE utf8mb4_unicode_ci DEFAULT 'N' COMMENT '탈퇴여부:Y=>탈퇴',
  `user_platform_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '소셜 로그인 방식',
  `user_email_verified_at` timestamp NULL DEFAULT NULL,
  `user_zip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '우편번호',
  `user_addr1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '주소',
  `user_addr2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상세주소',
  `user_addr3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '참고 항목',
  `user_addr_jibeon` char(2) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '지번:J=>지번, R=>도로명',
  `user_point` int NOT NULL DEFAULT '0' COMMENT '포인트',
  `withdraw_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '탈퇴 사유',
  `withdraw_content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '탈퇴 사유내용',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blacklist` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '블랙리스트',
  `site_access_no` enum('n','y') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'n' COMMENT '사이트 접근 불가',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_user_id_unique` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='회원관리';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'ysz@yongsanzip.com','$2y$10$3YcHeop..DGc0eSKkRDXweRVbI5wZolyfSQSNHbxmGmmu8IllPNWi','용산집','','','W','N','010953361501',NULL,NULL,NULL,NULL,1,1,'N',NULL,NULL,'07545','서울 강서구 양천로67길 3','465456645','(염창동)','R',307618,'','','OrFKxShz5346qsdtqLKfxMN74gt1jKBmeTo6m11Wbxk4hzRNpaCwOgm1VYBO','n','n','2021-12-08 06:48:16','2021-12-22 08:30:42'),(25,'livesub@naver.com','$2y$10$Jb8Gqf/rQHFkpG/OXd44O.tuHexQtX7HYr5UfsSancMdT6f32hq9.','바람개비','','721115','W','N','01095336150',NULL,NULL,NULL,NULL,1,3,'N','kakao',NULL,'07233','서울 영등포구 의사당대로 1','54546554654','(여의도동)','R',3300,NULL,'','or7iWdvDvGitnJKbyyZB3ZfO4uHbuWfEF7zWbPrLGkZOLPQPtWbhwkOwvaJh','n','n','2021-12-30 23:36:59','2022-01-04 02:29:01');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visits` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `vi_id` int NOT NULL DEFAULT '0' COMMENT '순번',
  `vi_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '아이피',
  `vi_referer` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '방문전 사이트',
  `vi_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'agent',
  `vi_browser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'browser',
  `vi_os` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'os',
  `vi_device` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'device',
  `vi_city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'city',
  `vi_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'country',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='접속 통계';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
INSERT INTO `visits` VALUES (1,1,'127.0.0.1','http://localhost:8000/exp/list/detail/19','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.45 Safari/537.36','Chrome','X11','Linux','Seoul','KR','2021-12-13 05:21:45','2021-12-13 05:21:45');
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishs`
--

DROP TABLE IF EXISTS `wishs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT '순번',
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '아이디',
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '상품코드',
  `wi_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '아이피',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishs_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='wish';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishs`
--

LOCK TABLES `wishs` WRITE;
/*!40000 ALTER TABLE `wishs` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-04 13:47:04
