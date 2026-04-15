-- MySQL dump 10.13  Distrib 9.2.0, for Win64 (x86_64)
--
-- Host: localhost    Database: hireflow_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_announcements_created_by` (`created_by`),
  KEY `fk_announcements_updated_by` (`updated_by`),
  CONSTRAINT `fk_announcements_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_announcements_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (2,'New Interview Scheduling Improvement','We released an update to the interview scheduler to improve calendar loading and reduce conflicts.\r\nPlease refresh your dashboard to see the latest changes.',1,1,'2026-04-13 14:30:00','2026-04-14 14:47:27'),(12,'New Interview Scheduling Improvement','We released an update to the interview scheduler to improve calendar loading and reduce conflicts.\r\nPlease refresh your dashboard to see the latest changes.',1,1,'2026-04-14 14:50:41','2026-04-14 14:50:56'),(13,'New Interview Scheduling Improvement','We released an update to the interview scheduler to improve calendar loading and reduce conflicts.\r\nPlease refresh your dashboard to see the latest changes.',1,NULL,'2026-04-14 14:51:05',NULL),(14,'New Interview Scheduling Improvement','We released an update to the interview scheduler to improve calendar loading and reduce conflicts.\r\nPlease refresh your dashboard to see the latest changes.',1,NULL,'2026-04-14 14:51:13',NULL),(15,'New Interview Scheduling Improvement','We released an update to the interview scheduler to improve calendar loading and reduce conflicts.\r\nPlease refresh your dashboard to see the latest changes.',1,NULL,'2026-04-14 15:28:01',NULL);
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application_form_fields`
--

DROP TABLE IF EXISTS `application_form_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application_form_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `field_category` varchar(100) NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `field_label` varchar(200) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_options` text DEFAULT NULL,
  `is_required` tinyint(1) DEFAULT 0,
  `is_enabled` tinyint(1) DEFAULT 1,
  `is_deleted` tinyint(1) DEFAULT 0,
  `field_order` int(11) DEFAULT 0,
  `validation_rules` text DEFAULT NULL,
  `placeholder` varchar(200) DEFAULT NULL,
  `help_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_form_id` (`form_id`),
  KEY `idx_field_category` (`field_category`),
  KEY `idx_field_order` (`form_id`,`field_order`),
  KEY `idx_is_deleted` (`is_deleted`),
  CONSTRAINT `application_form_fields_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `application_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_form_fields`
--

LOCK TABLES `application_form_fields` WRITE;
/*!40000 ALTER TABLE `application_form_fields` DISABLE KEYS */;
INSERT INTO `application_form_fields` VALUES (1,1,'personal_info','first_name','First Name','text',NULL,1,1,0,1,'required|min:2|max:50','Enter your first name',NULL,'2026-04-13 18:18:06','2026-04-13 18:18:06'),(2,1,'personal_info','last_name','Last Name','text',NULL,1,1,0,2,'required|min:2|max:50','Enter your last name',NULL,'2026-04-13 18:18:15','2026-04-13 18:18:15'),(3,1,'personal_info','email','Email Address','email',NULL,1,1,0,3,'required|email','your.email@example.com',NULL,'2026-04-13 18:18:23','2026-04-13 18:18:23'),(4,1,'personal_info','phone','Phone Number','tel',NULL,1,1,0,4,'required|phone','+94XXXXXXXXX',NULL,'2026-04-13 18:18:31','2026-04-13 18:18:31'),(5,1,'personal_info','city','Current City','select','[\"Colombo\",\"Mount Lavinia\",\"Kesbewa\",\"Maharagama\",\"Moratuwa\",\"Ratnapura\",\"Negombo\",\"Kandy\",\"Sri Jayewardenepura Kotte\",\"Kalmunai\",\"Trincomalee\",\"Galle\",\"Jaffna\",\"Athurugiriya\",\"Weligama\",\"Matara\",\"Kolonnawa\",\"Gampaha\",\"Puttalam\",\"Badulla\",\"Kalutara\",\"Bentota\",\"Mannar\",\"Kurunegala\"]',1,1,0,5,'required',NULL,NULL,'2026-04-13 18:18:39','2026-04-13 18:18:39'),(6,1,'personal_info','province','Province','select','[\"Western\",\"Central\",\"Southern\",\"Northern\",\"Eastern\",\"North Western\",\"North Central\",\"Uva\",\"Sabaragamuwa\"]',1,1,0,6,'required',NULL,NULL,'2026-04-13 18:18:47','2026-04-13 18:18:47'),(7,1,'personal_info','gender','Gender','select','[\"Male\",\"Female\",\"Other\",\"Prefer not to say\"]',0,1,0,7,'',NULL,NULL,'2026-04-13 18:18:56','2026-04-13 18:18:56'),(8,1,'education','highest_qualification','Highest Qualification','select','[\"High School\",\"Diploma\",\"Bachelor\'s Degree\",\"Master\'s Degree\",\"PhD\",\"Professional Certification\"]',1,1,0,8,'required',NULL,NULL,'2026-04-13 18:19:04','2026-04-13 18:19:04'),(9,1,'education','degree','Degree / Field of Study','text',NULL,1,1,0,9,'required|max:200','e.g., BSc Computer Science',NULL,'2026-04-13 18:19:12','2026-04-13 18:19:12'),(10,1,'work_experience','job_title','Job Title','text',NULL,1,1,0,10,'required|max:200','e.g., Senior Software Engineer',NULL,'2026-04-13 18:19:20','2026-04-13 18:19:20'),(11,1,'work_experience','company_name','Company Name','text',NULL,1,1,0,11,'required|max:200','e.g., ABC Technologies',NULL,'2026-04-13 18:19:28','2026-04-13 18:19:28'),(12,2,'personal_info','first_name','First Name','text',NULL,1,1,0,1,'required|min:2|max:50','Enter your first name',NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(13,2,'personal_info','last_name','Last Name','text',NULL,1,1,0,2,'required|min:2|max:50','Enter your last name',NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(14,2,'personal_info','email','Email Address','email',NULL,1,1,0,3,'required|email','your.email@example.com',NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(15,2,'personal_info','phone','Phone Number','tel',NULL,1,1,0,4,'required|phone','+94XXXXXXXXX',NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(16,2,'personal_info','city','Current City','select','[\"Colombo\",\"Mount Lavinia\",\"Kesbewa\",\"Maharagama\",\"Moratuwa\",\"Ratnapura\",\"Negombo\",\"Kandy\",\"Sri Jayewardenepura Kotte\",\"Kalmunai\",\"Trincomalee\",\"Galle\",\"Jaffna\",\"Athurugiriya\",\"Weligama\",\"Matara\",\"Kolonnawa\",\"Gampaha\",\"Puttalam\",\"Badulla\",\"Kalutara\",\"Bentota\",\"Mannar\",\"Kurunegala\"]',1,1,0,5,'required',NULL,NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(17,2,'personal_info','province','Province','select','[\"Western\",\"Central\",\"Southern\",\"Northern\",\"Eastern\",\"North Western\",\"North Central\",\"Uva\",\"Sabaragamuwa\"]',1,1,0,6,'required',NULL,NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(18,2,'personal_info','gender','Gender','select','[\"Male\",\"Female\",\"Other\",\"Prefer not to say\"]',0,1,0,7,'',NULL,NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(19,2,'education','highest_qualification','Highest Qualification','select','[\"High School\",\"Diploma\",\"Bachelor\'s Degree\",\"Master\'s Degree\",\"PhD\",\"Professional Certification\"]',1,1,0,8,'required',NULL,NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(20,2,'education','degree','Degree / Field of Study','text',NULL,1,1,0,9,'required|max:200','e.g., BSc Computer Science',NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(21,2,'work_experience','job_title','Job Title','text',NULL,1,1,0,10,'required|max:200','e.g., Senior Software Engineer',NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(22,2,'work_experience','company_name','Company Name','text',NULL,1,1,0,11,'required|max:200','e.g., ABC Technologies',NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(23,2,'work_experience','start_date','Start Date','date',NULL,1,1,0,12,'required|date',NULL,NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(24,2,'skills','technical_skills','Technical Skills','textarea',NULL,1,1,0,13,'required','e.g., PHP, JavaScript, Python, SQL (comma separated)','Enter skills separated by commas','2026-04-13 18:26:34','2026-04-13 18:26:34'),(25,2,'documents','resume_upload','Resume / CV Upload','file',NULL,1,1,0,14,'required|file|mimes:pdf,doc,docx|max:5120',NULL,'Accepted formats: PDF, DOC, DOCX (Max 5MB)','2026-04-13 18:26:34','2026-04-13 18:26:34'),(26,2,'availability','notice_period','Notice Period','select','[\"Immediate\",\"1 Week\",\"2 Weeks\",\"1 Month\",\"2 Months\",\"3 Months\"]',1,1,0,15,'required',NULL,NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(27,2,'availability','expected_salary','Expected Salary (Monthly)','text',NULL,1,1,0,16,'required|max:100','e.g., LKR 100,000 - 150,000','You can provide a range','2026-04-13 18:26:34','2026-04-13 18:26:34'),(28,2,'declarations','terms_agreement','I agree to the company\'s terms and conditions','checkbox',NULL,1,1,0,17,'required|accepted',NULL,NULL,'2026-04-13 18:26:34','2026-04-13 18:26:34'),(29,3,'personal_info','first_name','First Name','text',NULL,1,1,0,1,'required|min:2|max:50','Enter your first name',NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(30,3,'personal_info','last_name','Last Name','text',NULL,1,1,0,2,'required|min:2|max:50','Enter your last name',NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(31,3,'personal_info','email','Email Address','email',NULL,1,1,0,3,'required|email','your.email@example.com',NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(32,3,'personal_info','phone','Phone Number','tel',NULL,1,1,0,4,'required|phone','+94XXXXXXXXX',NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(33,3,'personal_info','city','Current City','select','[\"Colombo\",\"Mount Lavinia\",\"Kesbewa\",\"Maharagama\",\"Moratuwa\",\"Ratnapura\",\"Negombo\",\"Kandy\",\"Sri Jayewardenepura Kotte\",\"Kalmunai\",\"Trincomalee\",\"Galle\",\"Jaffna\",\"Athurugiriya\",\"Weligama\",\"Matara\",\"Kolonnawa\",\"Gampaha\",\"Puttalam\",\"Badulla\",\"Kalutara\",\"Bentota\",\"Mannar\",\"Kurunegala\"]',1,1,0,5,'required',NULL,NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(34,3,'personal_info','province','Province','select','[\"Western\",\"Central\",\"Southern\",\"Northern\",\"Eastern\",\"North Western\",\"North Central\",\"Uva\",\"Sabaragamuwa\"]',1,1,0,6,'required',NULL,NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(35,3,'personal_info','gender','Gender','select','[\"Male\",\"Female\",\"Other\",\"Prefer not to say\"]',0,1,0,7,'',NULL,NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(36,3,'education','highest_qualification','Highest Qualification','select','[\"High School\",\"Diploma\",\"Bachelor\'s Degree\",\"Master\'s Degree\",\"PhD\",\"Professional Certification\"]',1,1,0,8,'required',NULL,NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(37,3,'education','degree','Degree / Field of Study','text',NULL,1,1,0,9,'required|max:200','e.g., BSc Computer Science',NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(38,3,'work_experience','job_title','Job Title','text',NULL,1,1,0,10,'required|max:200','e.g., Senior Software Engineer',NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(39,3,'work_experience','company_name','Company Name','text',NULL,1,1,0,11,'required|max:200','e.g., ABC Technologies',NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(40,3,'work_experience','start_date','Start Date','date',NULL,1,1,0,12,'required|date',NULL,NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(41,3,'skills','technical_skills','Technical Skills','textarea',NULL,1,1,0,13,'required','e.g., PHP, JavaScript, Python, SQL (comma separated)','Enter skills separated by commas','2026-04-13 18:27:10','2026-04-13 18:27:10'),(42,3,'documents','resume_upload','Resume / CV Upload','file',NULL,1,1,0,14,'required|file|mimes:pdf,doc,docx|max:5120',NULL,'Accepted formats: PDF, DOC, DOCX (Max 5MB)','2026-04-13 18:27:10','2026-04-13 18:27:10'),(43,3,'availability','notice_period','Notice Period','select','[\"Immediate\",\"1 Week\",\"2 Weeks\",\"1 Month\",\"2 Months\",\"3 Months\"]',1,1,0,15,'required',NULL,NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(44,3,'availability','expected_salary','Expected Salary (Monthly)','text',NULL,1,1,0,16,'required|max:100','e.g., LKR 100,000 - 150,000','You can provide a range','2026-04-13 18:27:10','2026-04-13 18:27:10'),(45,3,'declarations','terms_agreement','I agree to the company\'s terms and conditions','checkbox',NULL,1,1,0,17,'required|accepted',NULL,NULL,'2026-04-13 18:27:10','2026-04-13 18:27:10'),(46,4,'personal_info','first_name','First Name','text',NULL,1,1,0,1,'required|min:2|max:50','Enter your first name',NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(47,4,'personal_info','last_name','Last Name','text',NULL,1,1,0,2,'required|min:2|max:50','Enter your last name',NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(48,4,'personal_info','email','Email Address','email',NULL,1,1,0,3,'required|email','your.email@example.com',NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(49,4,'personal_info','phone','Phone Number','tel',NULL,1,1,0,4,'required|phone','+94XXXXXXXXX',NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(50,4,'personal_info','city','Current City','select','[\"Colombo\",\"Mount Lavinia\",\"Kesbewa\",\"Maharagama\",\"Moratuwa\",\"Ratnapura\",\"Negombo\",\"Kandy\",\"Sri Jayewardenepura Kotte\",\"Kalmunai\",\"Trincomalee\",\"Galle\",\"Jaffna\",\"Athurugiriya\",\"Weligama\",\"Matara\",\"Kolonnawa\",\"Gampaha\",\"Puttalam\",\"Badulla\",\"Kalutara\",\"Bentota\",\"Mannar\",\"Kurunegala\"]',1,1,0,5,'required',NULL,NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(51,4,'personal_info','province','Province','select','[\"Western\",\"Central\",\"Southern\",\"Northern\",\"Eastern\",\"North Western\",\"North Central\",\"Uva\",\"Sabaragamuwa\"]',1,1,0,6,'required',NULL,NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(52,4,'personal_info','gender','Gender','select','[\"Male\",\"Female\",\"Other\",\"Prefer not to say\"]',0,1,0,7,'',NULL,NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(53,4,'education','highest_qualification','Highest Qualification','select','[\"High School\",\"Diploma\",\"Bachelor\'s Degree\",\"Master\'s Degree\",\"PhD\",\"Professional Certification\"]',1,1,0,8,'required',NULL,NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(54,4,'education','degree','Degree / Field of Study','text',NULL,1,1,0,9,'required|max:200','e.g., BSc Computer Science',NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(55,4,'work_experience','job_title','Job Title','text',NULL,1,1,0,10,'required|max:200','e.g., Senior Software Engineer',NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(56,4,'work_experience','company_name','Company Name','text',NULL,1,1,0,11,'required|max:200','e.g., ABC Technologies',NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(57,4,'work_experience','start_date','Start Date','date',NULL,1,1,0,12,'required|date',NULL,NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(58,4,'skills','technical_skills','Technical Skills','textarea',NULL,1,1,0,13,'required','e.g., PHP, JavaScript, Python, SQL (comma separated)','Enter skills separated by commas','2026-04-13 18:31:49','2026-04-13 18:31:49'),(59,4,'documents','resume_upload','Resume / CV Upload','file',NULL,1,1,0,14,'required|file|mimes:pdf,doc,docx|max:5120',NULL,'Accepted formats: PDF, DOC, DOCX (Max 5MB)','2026-04-13 18:31:49','2026-04-13 18:31:49'),(60,4,'availability','notice_period','Notice Period','select','[\"Immediate\",\"1 Week\",\"2 Weeks\",\"1 Month\",\"2 Months\",\"3 Months\"]',1,1,0,15,'required',NULL,NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49'),(61,4,'availability','expected_salary','Expected Salary (Monthly)','text',NULL,1,1,0,16,'required|max:100','e.g., LKR 100,000 - 150,000','You can provide a range','2026-04-13 18:31:49','2026-04-13 18:31:49'),(62,4,'declarations','terms_agreement','I agree to the company\'s terms and conditions','checkbox',NULL,1,1,0,17,'required|accepted',NULL,NULL,'2026-04-13 18:31:49','2026-04-13 18:31:49');
/*!40000 ALTER TABLE `application_form_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application_forms`
--

DROP TABLE IF EXISTS `application_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_post_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `form_title` varchar(200) NOT NULL,
  `form_description` text DEFAULT NULL,
  `status` enum('active','inactive','draft') DEFAULT 'draft',
  `is_deleted` tinyint(1) DEFAULT 0,
  `total_fields` int(11) DEFAULT 0,
  `submission_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `published_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_form_per_job` (`job_post_id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_job_post_id` (`job_post_id`),
  KEY `idx_is_deleted` (`is_deleted`),
  CONSTRAINT `application_forms_ibfk_1` FOREIGN KEY (`job_post_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `application_forms_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_forms`
--

LOCK TABLES `application_forms` WRITE;
/*!40000 ALTER TABLE `application_forms` DISABLE KEYS */;
INSERT INTO `application_forms` VALUES (1,12,3,'Application Form - Senior Software Engineer','Please fill out this application form for the position of Senior Software Engineer. Ensure all required fields are completed accurately.','draft',0,0,0,'2026-04-13 18:17:58','2026-04-13 18:17:58',NULL),(2,13,3,'Application Form - Frontend Developer','Please fill out this application form for the position of Frontend Developer. Ensure all required fields are completed accurately.','draft',0,17,0,'2026-04-13 18:26:34','2026-04-13 18:26:34',NULL),(3,15,3,'Application Form - HR Business Partner','Please fill out this application form for the position of HR Business Partner. Ensure all required fields are completed accurately.','active',0,17,0,'2026-04-13 18:27:10','2026-04-13 18:27:15','2026-04-13 18:27:15'),(4,17,3,'Application Form - dssdd','Please fill out this application form for the position of dssdd. Ensure all required fields are completed accurately.','active',0,17,0,'2026-04-13 18:31:49','2026-04-13 18:31:52','2026-04-13 18:31:52');
/*!40000 ALTER TABLE `application_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `applications`
--

DROP TABLE IF EXISTS `applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `resume_path` varchar(255) NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `status` enum('Applied','Under Review','Shortlisted','Interview Scheduled','Rejected','Offered') DEFAULT 'Applied',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `form_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Stores form field responses as JSON' CHECK (json_valid(`form_data`)),
  `form_id` int(11) DEFAULT NULL COMMENT 'Reference to the application form used',
  PRIMARY KEY (`id`),
  UNIQUE KEY `applicant_id` (`applicant_id`,`job_id`),
  KEY `job_id` (`job_id`),
  KEY `idx_form_id` (`form_id`),
  CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`),
  CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` VALUES (1,4,1,'/uploads/john_resume.pdf',NULL,'Applied','2025-08-30 20:00:21',NULL,NULL),(2,5,1,'/uploads/jane_resume.pdf',NULL,'Under Review','2025-08-30 20:00:21',NULL,NULL),(3,4,2,'/uploads/john_resume_2.pdf',NULL,'Shortlisted','2025-08-30 20:00:21',NULL,NULL),(7,46,1,'/uploads/resumes/resume_46_1765821750.pdf','fdf','Applied','2025-12-15 18:02:30',NULL,NULL),(8,2,1,'/uploads/resumes/resume_2_1765821874.pdf','gdgfg','Applied','2025-12-15 18:04:34',NULL,NULL),(14,2,17,'/uploads/resumes/resume_2_1776105211_26a6fb.pdf','Submitted via dynamic application form: Application Form - dssdd\nNotice Period: 1 Week\nExpected Salary (Monthly): 150000\nI agree to the company\'s terms and conditions: Yes\nHighest Qualification: Diploma\nDegree / Field of Study: CS\nFirst Name: Athsara\nLast Name: Fernando\nEmail Address: athsara@hireflow.com\nPhone Number: 0111111111\nCurrent City: Maharagama\nProvince: Western\nGender: Male\nTechnical Skills: PHP\nJob Title: SE\nCompany Name: ABC\nStart Date: 2026-04-03','Interview Scheduled','2026-04-13 18:33:31',NULL,NULL);
/*!40000 ALTER TABLE `applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `head_of_department` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `head_of_department` (`head_of_department`),
  CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`head_of_department`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Human Resources','Manages recruitment, employee relations, and HR policies',2,'2025-08-31 17:55:27','2025-08-31 17:55:27'),(2,'Information Technology','Handles software development, system administration, and technical support',2,'2025-08-31 17:55:27','2025-08-31 17:55:27'),(3,'Marketing','Responsible for brand management, digital marketing, and customer outreach',2,'2025-08-31 17:55:27','2025-08-31 17:55:27'),(4,'Finance','Manages company finances, budgeting, and financial reporting',2,'2025-08-31 17:55:27','2025-08-31 17:55:27'),(5,'Operations','Oversees daily operations, process improvement, and logistics',2,'2025-08-31 17:55:27','2025-08-31 17:55:27'),(6,'Customer Support','Customer service and technical support roles',1,'2025-09-07 08:41:36','2025-09-07 08:41:36'),(7,'Research & Development','Product research, innovation, and development',1,'2025-09-07 08:41:36','2025-09-07 08:41:36'),(8,'Quality Assurance','Testing, quality control, and process improvement',1,'2025-09-07 08:41:36','2025-09-07 08:41:36');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interview_evaluations`
--

DROP TABLE IF EXISTS `interview_evaluations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interview_evaluations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interview_id` int(11) NOT NULL,
  `technical_skills` tinyint(4) NOT NULL,
  `problem_solving` tinyint(4) NOT NULL,
  `communication` tinyint(4) NOT NULL,
  `cultural_fit` tinyint(4) NOT NULL,
  `experience_relevance` tinyint(4) NOT NULL,
  `manager_points` tinyint(4) NOT NULL,
  `interview_notes` text DEFAULT NULL,
  `recommendation` enum('Hire','Reject','Pending') NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_interview_evaluations_interview` (`interview_id`),
  KEY `fk_interview_evaluations_created_by` (`created_by`),
  KEY `fk_interview_evaluations_updated_by` (`updated_by`),
  KEY `fk_interview_evaluations_deleted_by` (`deleted_by`),
  KEY `idx_interview_evaluations_recommendation` (`recommendation`,`is_deleted`),
  KEY `idx_interview_evaluations_deleted` (`is_deleted`,`deleted_at`),
  CONSTRAINT `fk_interview_evaluations_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_interview_evaluations_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_interview_evaluations_interview` FOREIGN KEY (`interview_id`) REFERENCES `interviews` (`id`),
  CONSTRAINT `fk_interview_evaluations_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`),
  CONSTRAINT `chk_technical_skills_range` CHECK (`technical_skills` between 1 and 10),
  CONSTRAINT `chk_problem_solving_range` CHECK (`problem_solving` between 1 and 10),
  CONSTRAINT `chk_communication_range` CHECK (`communication` between 1 and 10),
  CONSTRAINT `chk_cultural_fit_range` CHECK (`cultural_fit` between 1 and 10),
  CONSTRAINT `chk_experience_relevance_range` CHECK (`experience_relevance` between 1 and 10),
  CONSTRAINT `chk_manager_points_range` CHECK (`manager_points` between 1 and 50)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interview_evaluations`
--

LOCK TABLES `interview_evaluations` WRITE;
/*!40000 ALTER TABLE `interview_evaluations` DISABLE KEYS */;
INSERT INTO `interview_evaluations` VALUES (1,123,10,10,10,10,10,40,'gfg','Pending',3,3,0,NULL,NULL,'2026-04-13 15:11:25','2026-04-13 15:12:05');
/*!40000 ALTER TABLE `interview_evaluations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interviews`
--

DROP TABLE IF EXISTS `interviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `interviewer_id` int(11) NOT NULL,
  `interview_type` enum('Phone','Video','In-person','Panel') DEFAULT 'Video',
  `scheduled_date` date NOT NULL,
  `scheduled_time` time NOT NULL,
  `duration_minutes` int(11) DEFAULT 60,
  `location` varchar(255) DEFAULT NULL,
  `meeting_link` varchar(500) DEFAULT NULL,
  `status` enum('Pending','Scheduled','Completed','Canceled','Rescheduled') NOT NULL DEFAULT 'Scheduled',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `application_id` (`application_id`),
  KEY `idx_scheduled_date` (`scheduled_date`),
  KEY `idx_interviewer_status` (`interviewer_id`,`status`),
  CONSTRAINT `interviews_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`),
  CONSTRAINT `interviews_ibfk_2` FOREIGN KEY (`interviewer_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interviews`
--

LOCK TABLES `interviews` WRITE;
/*!40000 ALTER TABLE `interviews` DISABLE KEYS */;
INSERT INTO `interviews` VALUES (5,1,3,'Video','2026-03-25','10:00:00',60,NULL,'https://meet.google.com/abc-def-ghi','Scheduled',NULL,'2025-12-16 08:22:51','2026-04-13 14:21:48'),(6,3,3,'In-person','2026-03-25','14:00:00',45,NULL,'Conference Room A, 2nd Floor','Scheduled',NULL,'2025-12-16 08:22:51','2026-04-13 14:21:50'),(7,1,4,'Video','2026-03-30','09:30:00',60,NULL,'https://meet.google.com/xyz-123-abc','Scheduled',NULL,'2025-12-16 08:25:34','2026-04-13 14:22:33'),(8,2,5,'In-person','2026-03-25','11:00:00',45,NULL,'Conference Room B, 1st Floor','Scheduled',NULL,'2025-12-16 08:25:34','2026-04-13 14:21:46'),(9,3,2,'Video','2026-03-30','15:00:00',30,NULL,'https://meet.google.com/qwe-rty-uio','Scheduled',NULL,'2025-12-16 08:25:34','2026-04-13 14:22:39'),(10,7,46,'Phone','2026-04-10','10:15:00',20,NULL,'N/A','Scheduled',NULL,'2025-12-16 08:25:34','2026-04-13 14:23:32'),(11,8,4,'Video','2026-04-10','13:45:00',60,NULL,'https://meet.google.com/asd-fgh-jkl','Scheduled',NULL,'2025-12-16 08:25:34','2026-04-13 14:23:37'),(12,2,46,'In-person','2026-03-30','16:00:00',45,NULL,'HR Meeting Room, Ground Floor','Scheduled',NULL,'2025-12-16 08:25:34','2026-04-15 04:04:01'),(13,1,5,'Video','2026-03-25','10:00:00',60,NULL,'https://meet.google.com/com-plt-001','Scheduled',NULL,'2025-12-16 08:26:40','2026-04-13 14:21:32'),(14,2,4,'In-person','2026-03-25','14:30:00',45,NULL,'Conference Room A, 2nd Floor','Scheduled',NULL,'2025-12-16 08:26:40','2026-04-13 14:21:37'),(15,3,46,'Phone','2026-03-25','09:15:00',30,NULL,'N/A','Scheduled',NULL,'2025-12-16 08:26:40','2026-04-13 14:21:40'),(16,7,2,'Video','2026-03-25','11:00:00',60,NULL,'https://meet.google.com/com-plt-002','Scheduled',NULL,'2025-12-16 08:26:40','2026-04-13 14:21:43'),(17,1,4,'Video','2026-04-10','10:00:00',60,NULL,'https://meet.google.com/past-001','Scheduled',NULL,'2025-12-16 08:49:16','2026-04-13 14:23:40'),(18,2,5,'In-person','2026-03-30','14:30:00',45,NULL,'Conference Room A, 2nd Floor','Scheduled',NULL,'2025-12-16 08:49:16','2026-04-13 14:23:21'),(19,3,46,'Phone','2025-12-08','09:15:00',30,NULL,'N/A','Scheduled',NULL,'2025-12-16 08:49:16','2026-04-13 14:01:13'),(20,7,2,'Video','2025-12-09','11:00:00',60,NULL,'https://meet.google.com/past-002','Scheduled',NULL,'2025-12-16 08:49:16','2026-04-13 14:01:13'),(21,8,4,'Video','2026-03-30','15:00:00',45,NULL,'https://meet.google.com/past-003','Scheduled',NULL,'2025-12-16 08:49:16','2026-04-13 14:22:43'),(22,1,5,'In-person','2025-12-13','10:30:00',60,NULL,'HR Meeting Room, Ground Floor','Scheduled',NULL,'2025-12-16 08:49:16','2026-04-13 14:01:13'),(23,2,46,'Video','2025-12-14','13:00:00',45,NULL,'https://meet.google.com/past-004','Scheduled',NULL,'2025-12-16 08:49:16','2026-04-13 14:01:13'),(24,3,2,'Phone','2025-12-15','16:00:00',20,NULL,'N/A','Scheduled',NULL,'2025-12-16 08:49:16','2026-04-13 14:01:13'),(25,1,4,'Video','2026-04-10','10:00:00',60,NULL,'https://meet.google.com/past-001','Scheduled',NULL,'2025-12-16 08:50:12','2026-04-13 14:23:42'),(26,2,5,'In-person','2026-04-10','14:30:00',45,NULL,'Conference Room A, 2nd Floor','Scheduled',NULL,'2025-12-16 08:50:12','2026-04-13 14:23:45'),(27,3,46,'Phone','2025-12-08','09:15:00',30,NULL,'N/A','Scheduled',NULL,'2025-12-16 08:50:12','2026-04-13 14:01:13'),(28,7,2,'Video','2025-12-09','11:00:00',60,NULL,'https://meet.google.com/past-002','Scheduled',NULL,'2025-12-16 08:50:12','2026-04-13 14:01:13'),(29,8,4,'Video','2025-12-11','15:00:00',45,NULL,'https://meet.google.com/past-003','Scheduled',NULL,'2025-12-16 08:50:12','2026-04-13 14:01:13'),(30,1,5,'In-person','2025-12-13','10:30:00',60,NULL,'HR Meeting Room, Ground Floor','Scheduled',NULL,'2025-12-16 08:50:12','2026-04-13 14:01:13'),(31,2,46,'Video','2025-12-14','13:00:00',45,NULL,'https://meet.google.com/past-004','Scheduled',NULL,'2025-12-16 08:50:12','2026-04-13 14:01:13'),(32,3,2,'Phone','2025-12-15','16:00:00',20,NULL,'N/A','Scheduled',NULL,'2025-12-16 08:50:12','2026-04-13 14:01:13'),(55,1,3,'','2026-03-01','10:00:00',60,'Conference Room A',NULL,'Scheduled','Recent technical interview','2026-04-13 13:53:28','2026-04-13 14:25:23'),(56,2,2,'','2026-04-12','11:00:00',60,'HR Office',NULL,'Scheduled','Recent HR interview','2026-04-13 13:53:28','2026-04-13 14:01:13'),(57,3,3,'','2026-03-01','14:30:00',60,'Online',NULL,'Scheduled','Recent QA interview','2026-04-13 13:53:28','2026-04-13 14:25:12'),(58,7,1,'Panel','2026-04-10','16:00:00',60,'Main Conference Room',NULL,'Scheduled','Panel interview','2026-04-13 13:53:28','2026-04-13 13:53:28'),(59,8,2,'','2026-04-09','09:30:00',60,'HR Office',NULL,'Scheduled','Initial screening','2026-04-13 13:53:28','2026-04-13 14:01:13'),(60,1,1,'','2026-04-05','13:00:00',60,'Conference Room B',NULL,'Scheduled','Backend interview','2026-04-13 13:53:28','2026-04-13 14:01:13'),(61,2,2,'','2026-04-03','15:00:00',60,'HR Office',NULL,'Scheduled','Soft skills interview','2026-04-13 13:53:28','2026-04-13 14:01:13'),(62,3,3,'','2026-04-01','10:30:00',60,'Online',NULL,'Scheduled','Automation testing','2026-04-13 13:53:28','2026-04-13 13:58:00'),(63,7,2,'','2026-03-01','11:00:00',60,'HR Office',NULL,'Scheduled','Initial round','2026-04-13 13:53:28','2026-04-13 14:24:58'),(64,8,1,'Panel','2026-03-28','14:00:00',60,'Main Conference Room',NULL,'Scheduled','Panel round','2026-04-13 13:53:28','2026-04-13 13:53:28'),(65,1,3,'','2026-03-25','10:00:00',60,'Online',NULL,'Scheduled','QA technical','2026-04-13 13:53:28','2026-04-13 14:01:13'),(66,2,2,'','2026-03-22','12:30:00',60,'HR Office',NULL,'Scheduled','HR round','2026-04-13 13:53:28','2026-04-13 14:01:13'),(67,3,1,'','2026-03-20','09:00:00',60,'Conference Room A',NULL,'Scheduled','System design','2026-04-13 13:53:28','2026-04-13 14:01:13'),(68,7,3,'','2026-03-18','15:30:00',60,'Online',NULL,'Scheduled','Testing tools','2026-04-13 13:53:28','2026-04-13 14:01:13'),(69,8,2,'','2026-03-15','11:00:00',60,'HR Office',NULL,'Scheduled','Screening','2026-04-13 13:53:28','2026-04-13 14:01:13'),(70,1,1,'Panel','2026-03-10','10:00:00',60,'Main Conference Room',NULL,'Scheduled','Panel round','2026-04-13 13:53:28','2026-04-13 14:01:13'),(71,2,2,'','2026-03-05','14:00:00',60,'HR Office',NULL,'Scheduled','Culture fit','2026-04-13 13:53:28','2026-04-13 14:01:13'),(72,3,3,'','2026-03-01','09:30:00',60,'Online',NULL,'Scheduled','Backend systems','2026-04-13 13:53:28','2026-04-13 14:01:13'),(73,7,1,'','2026-02-25','13:30:00',60,'Conference Room B',NULL,'Scheduled','API design','2026-04-13 13:53:28','2026-04-13 14:01:13'),(74,8,2,'','2026-02-20','10:00:00',60,'HR Office',NULL,'Scheduled','Initial screening','2026-04-13 13:53:28','2026-04-13 14:01:13'),(75,1,3,'','2026-04-13','09:00:00',60,'Conference Room A',NULL,'Completed','Morning technical round','2026-04-13 14:09:05','2026-04-13 14:09:05'),(76,2,2,'','2026-04-13','10:30:00',60,'HR Office',NULL,'Scheduled','Behavioral assessment','2026-04-13 14:09:05','2026-04-13 14:09:05'),(77,3,1,'','2026-03-01','12:00:00',60,'Online',NULL,'Scheduled','Frontend evaluation','2026-04-13 14:09:05','2026-04-13 14:25:20'),(78,7,3,'Panel','2026-04-13','14:00:00',60,'Main Conference Room',NULL,'Scheduled','Panel discussion','2026-04-13 14:09:05','2026-04-13 14:09:05'),(79,8,2,'','2026-04-13','16:00:00',60,'HR Office',NULL,'Scheduled','Initial screening','2026-04-13 14:09:05','2026-04-13 14:09:05'),(80,1,2,'','2026-04-12','09:30:00',60,'HR Office',NULL,'Completed','HR interview round 1','2026-04-13 14:09:05','2026-04-13 14:09:05'),(81,2,3,'','2026-04-12','11:00:00',60,'Conference Room B',NULL,'Completed','System design discussion','2026-04-13 14:09:05','2026-04-13 14:09:05'),(82,3,1,'','2026-04-12','13:30:00',60,'Online',NULL,'Completed','Backend coding test','2026-04-13 14:09:05','2026-04-13 14:09:05'),(83,7,2,'Panel','2026-04-12','15:00:00',60,'Main Conference Room',NULL,'Completed','Panel evaluation','2026-04-13 14:09:05','2026-04-13 14:09:05'),(84,1,3,'','2026-04-11','10:00:00',60,'Online',NULL,'Completed','API testing round','2026-04-13 14:09:05','2026-04-13 14:09:05'),(85,2,2,'','2026-04-11','11:30:00',60,'HR Office',NULL,'Completed','Soft skills check','2026-04-13 14:09:05','2026-04-13 14:09:05'),(86,3,3,'','2026-04-11','14:30:00',60,'Conference Room A',NULL,'Completed','QA automation test','2026-04-13 14:09:05','2026-04-13 14:09:05'),(87,8,1,'','2026-03-01','16:00:00',60,'HR Office',NULL,'Completed','Initial screening follow-up','2026-04-13 14:09:05','2026-04-13 14:25:06'),(88,1,1,'','2026-04-10','09:00:00',60,'HR Office',NULL,'Completed','Initial screening','2026-04-13 14:09:05','2026-04-13 14:09:05'),(89,2,3,'','2026-04-10','10:30:00',60,'Conference Room A',NULL,'Completed','Coding challenge','2026-04-13 14:09:05','2026-04-13 14:09:05'),(90,3,2,'','2026-04-10','12:00:00',60,'HR Office',NULL,'Completed','Cultural fit discussion','2026-04-13 14:09:05','2026-04-13 14:09:05'),(91,7,1,'Panel','2026-04-10','14:00:00',60,'Main Conference Room',NULL,'Completed','Final panel interview','2026-04-13 14:09:05','2026-04-13 14:09:05'),(92,8,3,'','2026-04-10','16:30:00',60,'Online',NULL,'Completed','System architecture review','2026-04-13 14:09:05','2026-04-13 14:09:05'),(93,1,3,'','2026-04-13','09:00:00',60,'Conference Room A',NULL,'Completed','Morning technical','2026-04-13 14:11:03','2026-04-13 14:11:03'),(94,2,2,'','2026-03-01','10:30:00',60,'HR Office',NULL,'Scheduled','HR evaluation','2026-04-13 14:11:03','2026-04-13 14:25:17'),(95,3,1,'','2026-04-13','12:00:00',60,'Online',NULL,'Scheduled','Frontend test','2026-04-13 14:11:03','2026-04-13 14:11:03'),(96,7,3,'Panel','2026-04-13','14:00:00',60,'Main Conference Room',NULL,'Scheduled','Panel round','2026-04-13 14:11:03','2026-04-13 14:11:03'),(97,8,2,'','2026-04-13','16:00:00',60,'HR Office',NULL,'Scheduled','Initial screening','2026-04-13 14:11:03','2026-04-13 14:11:03'),(98,1,2,'','2026-04-12','09:30:00',60,'HR Office',NULL,'Completed','HR round 1','2026-04-13 14:11:03','2026-04-13 14:11:03'),(99,2,3,'','2026-04-12','10:30:00',60,'Conference Room B',NULL,'Completed','System design','2026-04-13 14:11:03','2026-04-13 14:11:03'),(100,3,1,'','2026-04-12','12:30:00',60,'Online',NULL,'Completed','Backend test','2026-04-13 14:11:03','2026-04-13 14:11:03'),(101,7,2,'Panel','2026-04-12','15:00:00',60,'Main Conference Room',NULL,'Completed','Panel interview','2026-04-13 14:11:03','2026-04-13 14:11:03'),(102,8,3,'','2026-04-12','17:00:00',60,'Online',NULL,'Completed','Architecture review','2026-04-13 14:11:03','2026-04-13 14:11:03'),(103,1,3,'','2026-04-11','10:00:00',60,'Online',NULL,'Completed','API testing','2026-04-13 14:11:03','2026-04-13 14:11:03'),(104,2,2,'','2026-03-01','11:30:00',60,'HR Office',NULL,'Completed','Soft skills','2026-04-13 14:11:03','2026-04-13 14:25:03'),(105,3,3,'','2026-04-11','14:30:00',60,'Conference Room A',NULL,'Completed','QA automation','2026-04-13 14:11:03','2026-04-13 14:11:03'),(106,7,1,'','2026-04-11','16:00:00',60,'HR Office',NULL,'Completed','Initial round','2026-04-13 14:11:03','2026-04-13 14:11:03'),(107,1,1,'','2026-04-10','09:00:00',60,'HR Office',NULL,'Completed','Screening','2026-04-13 14:11:03','2026-04-13 14:11:03'),(108,2,3,'','2026-04-10','10:00:00',60,'Conference Room A',NULL,'Completed','Coding test','2026-04-13 14:11:03','2026-04-13 14:11:03'),(109,3,2,'','2026-04-10','11:00:00',60,'HR Office',NULL,'Completed','Culture fit','2026-04-13 14:11:03','2026-04-13 14:11:03'),(110,7,1,'Panel','2026-04-10','13:00:00',60,'Main Conference Room',NULL,'Completed','Final panel','2026-04-13 14:11:03','2026-04-13 14:11:03'),(111,8,3,'','2026-04-10','16:30:00',60,'Online',NULL,'Completed','System review','2026-04-13 14:11:03','2026-04-13 14:11:03'),(112,1,2,'','2026-04-09','11:00:00',60,'HR Office',NULL,'Completed','HR discussion','2026-04-13 14:11:03','2026-04-13 14:11:03'),(113,7,3,'','2026-04-09','15:00:00',60,'Online',NULL,'Completed','Backend check','2026-04-13 14:11:03','2026-04-13 14:11:03'),(114,2,2,'','2026-04-05','10:00:00',60,'Conference Room B',NULL,'Completed','System design','2026-04-13 14:11:03','2026-04-13 14:11:03'),(115,3,1,'','2026-04-05','14:00:00',60,'HR Office',NULL,'Completed','Soft skills','2026-04-13 14:11:03','2026-04-13 14:11:03'),(116,1,3,'','2026-04-03','09:30:00',60,'Online',NULL,'Completed','API review','2026-04-13 14:11:03','2026-04-13 14:11:03'),(117,2,2,'','2026-04-01','12:00:00',60,'HR Office',NULL,'Completed','HR screening','2026-04-13 14:11:03','2026-04-13 14:11:03'),(118,3,3,'','2026-03-30','11:00:00',60,'Online',NULL,'Completed','Testing round','2026-04-13 14:11:03','2026-04-13 14:11:03'),(119,7,1,'Panel','2026-03-30','14:00:00',60,'Main Conference Room',NULL,'Completed','Panel discussion','2026-04-13 14:11:03','2026-04-13 14:11:03'),(120,1,2,'','2026-03-25','10:00:00',60,'Online',NULL,'Completed','QA test','2026-04-13 14:11:03','2026-04-13 14:11:03'),(121,2,3,'','2026-03-20','09:00:00',60,'HR Office',NULL,'Completed','HR round','2026-04-13 14:11:03','2026-04-13 14:11:03'),(122,3,1,'','2026-03-10','13:00:00',60,'Conference Room B',NULL,'Completed','System design','2026-04-13 14:11:03','2026-04-13 14:11:03'),(123,14,4,'Video','2026-04-16','00:07:00',60,'','','Completed',NULL,'2026-04-13 18:38:06','2026-04-13 18:41:25');
/*!40000 ALTER TABLE `interviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_posts`
--

DROP TABLE IF EXISTS `job_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hr_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `salary_range` varchar(100) DEFAULT NULL,
  `employment_type` enum('Full-time','Part-time','Contract','Internship') DEFAULT 'Full-time',
  `deadline` date DEFAULT NULL,
  `status` enum('Open','Closed','Draft') DEFAULT 'Draft',
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `hr_id` (`hr_id`),
  KEY `department_id` (`department_id`),
  KEY `idx_is_deleted` (`is_deleted`),
  KEY `idx_status_deleted` (`status`,`is_deleted`),
  CONSTRAINT `job_posts_ibfk_1` FOREIGN KEY (`hr_id`) REFERENCES `users` (`id`),
  CONSTRAINT `job_posts_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_posts`
--

LOCK TABLES `job_posts` WRITE;
/*!40000 ALTER TABLE `job_posts` DISABLE KEYS */;
INSERT INTO `job_posts` VALUES (1,2,'Software Engineer',2,'Looking for a skilled software developer',NULL,'IT','Colombo',NULL,'Full-time','2025-12-31','Open',0,'2025-08-30 20:00:21'),(2,2,'Marketing Specialist',2,'Digital marketing expert needed',NULL,'Marketing','Kandy',NULL,'Full-time','2025-11-30','Open',0,'2025-08-30 20:00:21'),(3,2,'Data Analyst',3,'Analyze business data and trends',NULL,'Analytics','Galle',NULL,'Full-time','2025-10-31','Open',0,'2025-08-30 20:00:21'),(4,4,'Senior Software Engineer',2,'We are seeking an experienced Software Engineer to join our dynamic development team. You will be responsible for designing, developing, and maintaining high-quality software applications using modern technologies and best practices.','??? Bachelor\'s degree in Computer Science or related field\n??? 5+ years of experience in software development\n??? Proficiency in PHP, JavaScript, Python, or Java\n??? Experience with database design (MySQL, PostgreSQL)\n??? Knowledge of web frameworks (Laravel, React, Vue.js)\n??? Understanding of version control systems (Git)\n??? Strong problem-solving and analytical skills\n??? Excellent communication and teamwork abilities',NULL,'Colombo, Sri Lanka','$70,000 - $90,000','Full-time','2025-10-15','Open',0,'2025-09-07 08:44:02'),(5,4,'Frontend Developer',2,'Join our creative team as a Frontend Developer and help us build beautiful, responsive, and user-friendly web applications. You will work closely with designers and backend developers to create exceptional user experiences.','??? Bachelor\'s degree in Computer Science, Web Development, or related field\n??? 3+ years of frontend development experience\n??? Expert knowledge of HTML5, CSS3, and JavaScript (ES6+)\n??? Experience with modern frameworks (React, Vue.js, Angular)\n??? Proficiency in CSS preprocessors (SASS, LESS)\n??? Understanding of responsive design principles\n??? Experience with build tools (Webpack, Gulp, npm)\n??? Knowledge of version control (Git)\n??? Eye for design and attention to detail',NULL,'Colombo, Sri Lanka','$50,000 - $70,000','Full-time','2025-09-30','Open',0,'2025-09-07 08:44:02'),(6,4,'DevOps Engineer',2,'We are looking for a skilled DevOps Engineer to help us streamline our development and deployment processes. You will be responsible for maintaining our CI/CD pipelines, cloud infrastructure, and ensuring system reliability.','??? Bachelor\'s degree in Computer Science, Engineering, or related field\n??? 4+ years of experience in DevOps or system administration\n??? Experience with cloud platforms (AWS, Azure, Google Cloud)\n??? Proficiency in containerization (Docker, Kubernetes)\n??? Knowledge of CI/CD tools (Jenkins, GitLab CI, GitHub Actions)\n??? Experience with infrastructure as code (Terraform, CloudFormation)\n??? Scripting skills (Bash, Python, PowerShell)\n??? Understanding of monitoring tools (Prometheus, Grafana)\n??? Strong troubleshooting and problem-solving skills',NULL,'Remote','$65,000 - $85,000','Full-time','2025-10-01','Open',0,'2025-09-07 08:44:02'),(7,4,'HR Business Partner',1,'Join our HR team as an HR Business Partner and play a key role in supporting our organizational growth. You will work closely with management to develop HR strategies, policies, and programs that align with business objectives.','??? Bachelor\'s degree in Human Resources, Business Administration, or related field\n??? 5+ years of HR experience with focus on business partnering\n??? Strong knowledge of employment law and HR best practices\n??? Experience in talent acquisition and performance management\n??? Excellent interpersonal and communication skills\n??? Proficiency in HRIS systems and MS Office suite\n??? Professional HR certification (SHRM, HRCI) preferred\n??? Ability to handle confidential information with discretion\n??? Strong analytical and problem-solving skills',NULL,'Colombo, Sri Lanka','$55,000 - $75,000','Full-time','2025-10-20','Open',0,'2025-09-07 08:44:02'),(8,4,'Talent Acquisition Specialist',1,'We are seeking a dynamic Talent Acquisition Specialist to join our growing HR team. You will be responsible for identifying, attracting, and hiring top talent across various departments and skill levels.','??? Bachelor\'s degree in Human Resources, Psychology, or related field\n??? 3+ years of experience in recruitment and talent acquisition\n??? Experience with various recruitment channels (job boards, social media, networking)\n??? Proficiency in applicant tracking systems (ATS)\n??? Strong interviewing and assessment skills\n??? Knowledge of employment laws and regulations\n??? Excellent communication and negotiation skills\n??? Ability to work in a fast-paced environment\n??? Experience with technical recruitment preferred',NULL,'Colombo, Sri Lanka','$45,000 - $60,000','Full-time','2025-09-25','Open',0,'2025-09-07 08:44:02'),(9,4,'Digital Marketing Manager',3,'We are looking for a creative and results-driven Digital Marketing Manager to lead our digital marketing initiatives. You will develop and execute comprehensive digital marketing strategies to increase brand awareness and drive customer acquisition.','??? Bachelor\'s degree in Marketing, Communications, or related field\n??? 4+ years of experience in digital marketing\n??? Proven experience with digital marketing channels (SEO, SEM, social media, email)\n??? Proficiency in marketing tools (Google Analytics, AdWords, Facebook Ads Manager)\n??? Experience with marketing automation platforms\n??? Strong analytical skills and data-driven mindset\n??? Excellent written and verbal communication skills\n??? Creative thinking and problem-solving abilities\n??? Experience with content management systems',NULL,'Colombo, Sri Lanka','$55,000 - $70,000','Full-time','2025-09-28','Open',0,'2025-09-07 08:44:02'),(10,4,'Customer Success Manager',6,'Join our Customer Success team and help us build lasting relationships with our clients. You will be responsible for ensuring customer satisfaction, driving product adoption, and identifying growth opportunities.','??? Bachelor\'s degree in Business, Communications, or related field\n??? 3+ years of experience in customer success, account management, or related role\n??? Strong customer service and relationship management skills\n??? Experience with CRM systems (Salesforce, HubSpot)\n??? Excellent communication and presentation skills\n??? Problem-solving and conflict resolution abilities\n??? Data analysis skills to track customer metrics\n??? Ability to work collaboratively across teams\n??? Technical aptitude to understand our products',NULL,'Colombo, Sri Lanka','$45,000 - $60,000','Full-time','2025-10-05','Open',0,'2025-09-07 08:44:02'),(11,4,'QA Engineer',8,'We are seeking a detail-oriented QA Engineer to join our quality assurance team. You will be responsible for testing our software applications, identifying bugs, and ensuring our products meet the highest quality standards.','??? Bachelor\'s degree in Computer Science, Engineering, or related field\n??? 3+ years of experience in software testing and quality assurance\n??? Experience with manual and automated testing methodologies\n??? Knowledge of testing tools (Selenium, TestRail, JIRA)\n??? Understanding of software development lifecycle (SDLC)\n??? Experience with API testing and database testing\n??? Strong analytical and problem-solving skills\n??? Excellent attention to detail\n??? Good communication skills for reporting issues',NULL,'Colombo, Sri Lanka','$45,000 - $60,000','Full-time','2025-10-12','Open',0,'2025-09-07 08:44:02'),(12,4,'Senior Software Engineer',2,'We are seeking an experienced Software Engineer to join our dynamic development team. You will be responsible for designing, developing, and maintaining high-quality software applications using modern technologies and best practices.','??? Bachelor\'s degree in Computer Science or related field\n??? 5+ years of experience in software development\n??? Proficiency in PHP, JavaScript, Python, or Java\n??? Experience with database design (MySQL, PostgreSQL)\n??? Knowledge of web frameworks (Laravel, React, Vue.js)\n??? Understanding of version control systems (Git)\n??? Strong problem-solving and analytical skills\n??? Excellent communication and teamwork abilities',NULL,'Colombo, Sri Lanka','$70,000 - $90,000','Full-time','2025-10-15','Open',0,'2025-09-07 08:44:43'),(13,4,'Frontend Developer',2,'Join our creative team as a Frontend Developer and help us build beautiful, responsive, and user-friendly web applications. You will work closely with designers and backend developers to create exceptional user experiences.','??? Bachelor\'s degree in Computer Science, Web Development, or related field\n??? 3+ years of frontend development experience\n??? Expert knowledge of HTML5, CSS3, and JavaScript (ES6+)\n??? Experience with modern frameworks (React, Vue.js, Angular)\n??? Proficiency in CSS preprocessors (SASS, LESS)\n??? Understanding of responsive design principles\n??? Experience with build tools (Webpack, Gulp, npm)\n??? Knowledge of version control (Git)\n??? Eye for design and attention to detail',NULL,'Colombo, Sri Lanka','$50,000 - $70,000','Full-time','2025-09-30','Open',0,'2025-09-07 08:44:43'),(14,4,'Digital Marketing Manager',3,'We are looking for a creative and results-driven Digital Marketing Manager to lead our digital marketing initiatives. You will develop and execute comprehensive digital marketing strategies to increase brand awareness and drive customer acquisition.','??? Bachelor\'s degree in Marketing, Communications, or related field\n??? 4+ years of experience in digital marketing\n??? Proven experience with digital marketing channels (SEO, SEM, social media, email)\n??? Proficiency in marketing tools (Google Analytics, AdWords, Facebook Ads Manager)\n??? Experience with marketing automation platforms\n??? Strong analytical skills and data-driven mindset\n??? Excellent written and verbal communication skills\n??? Creative thinking and problem-solving abilities\n??? Experience with content management systems',NULL,'Colombo, Sri Lanka','$55,000 - $70,000','Full-time','2025-09-28','Open',0,'2025-09-07 08:44:43'),(15,4,'HR Business Partner',1,'Join our HR team as an HR Business Partner and play a key role in supporting our organizational growth. You will work closely with management to develop HR strategies, policies, and programs that align with business objectives.','??? Bachelor\'s degree in Human Resources, Business Administration, or related field\n??? 5+ years of HR experience with focus on business partnering\n??? Strong knowledge of employment law and HR best practices\n??? Experience in talent acquisition and performance management\n??? Excellent interpersonal and communication skills\n??? Proficiency in HRIS systems and MS Office suite\n??? Professional HR certification (SHRM, HRCI) preferred\n??? Ability to handle confidential information with discretion\n??? Strong analytical and problem-solving skills',NULL,'Colombo, Sri Lanka','$55,000 - $75,000','Full-time','2025-10-20','Open',0,'2025-09-07 08:44:43'),(16,4,'QA Engineer',8,'We are seeking a detail-oriented QA Engineer to join our quality assurance team. You will be responsible for testing our software applications, identifying bugs, and ensuring our products meet the highest quality standards.','??? Bachelor\'s degree in Computer Science, Engineering, or related field\n??? 3+ years of experience in software testing and quality assurance\n??? Experience with manual and automated testing methodologies\n??? Knowledge of testing tools (Selenium, TestRail, JIRA)\n??? Understanding of software development lifecycle (SDLC)\n??? Experience with API testing and database testing\n??? Strong analytical and problem-solving skills\n??? Excellent attention to detail\n??? Good communication skills for reporting issues',NULL,'Colombo, Sri Lanka','$45,000 - $60,000','Full-time','2025-10-12','Open',0,'2025-09-07 08:44:43'),(17,4,'dssdd',1,'dsfdfs','fsf',NULL,'Remote','','Full-time',NULL,'Open',0,'2026-04-13 18:30:20');
/*!40000 ALTER TABLE `job_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','success','warning','error') DEFAULT 'info',
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,4,'Application Submitted','Your application for Senior Software Engineer position has been submitted successfully.','success',0,'2025-08-31 17:48:47'),(2,4,'Application Update','Your application for Senior Software Engineer has been shortlisted for interview.','info',0,'2025-08-31 17:48:47'),(3,2,'New Application','A new application has been received for the Marketing Specialist position.','info',0,'2025-08-31 17:48:47'),(4,3,'Interview Reminder','You have an interview scheduled with Priya Jayasinghe tomorrow at 2:00 PM.','warning',0,'2025-08-31 17:48:47'),(5,2,'Application Received','Your application for Senior Software Engineer has been received and is under review.','',0,'2025-09-07 08:44:43'),(6,4,'New Application','New application received for Senior Software Engineer position from Athsara Fernando.','',1,'2025-09-07 08:44:43'),(7,2,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-10-21 18:13:15'),(8,46,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-15 17:59:52'),(9,46,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-15 18:02:30'),(10,2,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-15 18:04:34'),(11,59,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-29 17:17:41'),(12,59,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-29 17:20:30'),(13,65,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-29 18:39:31'),(14,66,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-29 18:45:40'),(15,67,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-30 12:48:04'),(16,2,'Application Submitted','Your job application has been submitted successfully.','success',0,'2026-04-13 18:33:31');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'System Admin','System management and configuration','2025-08-30 20:00:21'),(2,'HR Admin','HR operations and job management','2025-08-30 20:00:21'),(3,'Recruitment Manager','Candidate evaluation and interviews','2025-08-30 20:00:21'),(4,'Applicant','Job seekers and candidates','2025-08-30 20:00:21');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `saved_jobs`
--

DROP TABLE IF EXISTS `saved_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `saved_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `note` text DEFAULT NULL,
  `saved_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_saved_job` (`applicant_id`,`job_id`),
  KEY `idx_saved_jobs_applicant` (`applicant_id`),
  KEY `idx_saved_jobs_job` (`job_id`),
  CONSTRAINT `fk_saved_jobs_applicant` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_saved_jobs_job` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `saved_jobs`
--

LOCK TABLES `saved_jobs` WRITE;
/*!40000 ALTER TABLE `saved_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `saved_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`),
  KEY `updated_by` (`updated_by`),
  CONSTRAINT `system_settings_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (1,'site_name','HireFlow','Name of the recruitment system',1,'2025-08-31 17:48:05'),(2,'max_file_size','5242880','Maximum file upload size in bytes (5MB)',1,'2025-08-31 17:48:05'),(3,'allowed_file_types','pdf,doc,docx','Allowed file types for resume upload',1,'2025-08-31 17:48:05'),(4,'session_timeout','3600','Session timeout in seconds',1,'2025-08-31 17:48:05'),(5,'email_notifications','true','Enable/disable email notifications',1,'2025-08-31 17:48:05');
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_email` varchar(100) DEFAULT NULL,
  `delete_reason` varchar(255) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `password_reset_expires` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  KEY `idx_users_deleted_at` (`deleted_at`),
  KEY `idx_users_deleted_by` (`deleted_by`),
  CONSTRAINT `fk_users_deleted_by` FOREIGN KEY (`deleted_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@hireflow.com','$2y$10$jttBxTSRh.2D5aH.MQk/xO1Rp5vvThKouEYDHRXzEHTJGEpWLbhae','Sineth Mendis',1,'0413125573','test, gggaddress1234hhfh46bbb','active',NULL,NULL,NULL,NULL,'2026-04-15 04:40:27','2025-09-06 18:14:46','2026-04-15 08:10:27','profile_1_1774971887.jpg',NULL,NULL),(2,'athsara@hireflow.com','$2y$10$S7m.XJbNWuTFLKgc5QdkIOjZ7ZfzCQY6dGITiBpaIXsWrGB/7Uc4.','Athsara Fernando',4,'','','active',NULL,NULL,NULL,NULL,'2026-04-15 01:52:47','2025-09-06 15:10:51','2026-04-15 05:22:47',NULL,NULL,NULL),(3,'recruiter@hireflow.com','$2y$10$vlr0hoSSCCGfwaAm.taYOeezIkPNSRCC01Akl.MSiLkJG/KBGi6rK','Tehan Isum',3,'0712345678','','active',NULL,NULL,NULL,NULL,'2026-04-14 09:52:36','2025-09-06 15:33:46','2026-04-14 13:22:36',NULL,NULL,NULL),(4,'hr@hireflow.com','$2y$10$UaLGajZ1lfRW0qR.CJHKZehd8w4U5tk1rA7bjAoZMy0wJQZHVb3MO','Hasindu Rodrigo',2,'0712345678','','active',NULL,NULL,NULL,NULL,'2026-04-14 09:52:11','2025-09-06 17:22:34','2026-04-14 13:22:12',NULL,NULL,NULL),(5,'chamali.perera@gmail.com','Password@1','Chamali Perera',4,'+94772345678','','active',NULL,NULL,NULL,NULL,'2025-10-16 11:21:39','2025-09-07 08:41:36','2025-12-29 13:48:12',NULL,NULL,NULL),(46,'johndoe@hireflow.com','$2y$10$PZQRIzlI0f2CqEGpWcDH4eLBxE/fQU5QqY2wzGRq68KOGEUScepnO','John Doe',4,'','','active',NULL,NULL,NULL,NULL,'2025-12-15 13:29:26','2025-12-15 13:12:33','2025-12-29 13:48:11',NULL,NULL,NULL),(59,'jp@hireflow.com','$2y$10$eXQo5PiHsgIVKnji3dkMAuvF5Cyh0xA8Pz2gop0oBce/8Vzyk4rpe','John Piper',4,'','','active',NULL,NULL,NULL,NULL,'2025-12-29 13:03:55','2025-12-29 12:47:04','2025-12-29 14:09:57',NULL,NULL,NULL),(65,'jm@hireflow.com','$2y$10$luvRgTtFsYihktQXyaNQQOOiJFf1YnN560.OCb576gYlu/NRKORYq','John Mcc',4,'','','active',NULL,NULL,NULL,NULL,'2025-12-29 14:09:18','2025-12-29 14:08:53','2025-12-29 18:39:18',NULL,NULL,NULL),(66,'nd@hireflow.com','$2y$10$W1RQKmRWevnIsSxSWsWbwOO6sVsp30RzcKPwia9Q.YBs/NNoaaz/C','Nathan  Drane',4,'','','inactive',NULL,NULL,NULL,NULL,'2025-12-29 14:15:27','2025-12-29 14:15:13','2026-04-10 05:05:49',NULL,NULL,NULL),(67,'jn@hireflow.com','$2y$10$JxHMlEgDMFp1pO.WIa8UoeH3fNGU9.xG6r0YE63c4DdR2W8QU03Tq','John Nate',4,'','','inactive',NULL,NULL,NULL,NULL,'2025-12-30 09:04:40','2025-12-30 08:17:37','2026-04-10 03:07:18',NULL,NULL,NULL),(76,'testuser@hireflow.com','$2y$10$s2Sk1l8fM/TdmaxT3Wh6auMPipbJBv3fsXsveYg8PDphShoOit.Iu','Test User',3,'0712345675',NULL,'inactive',NULL,NULL,NULL,NULL,'2026-04-01 05:02:37','2026-03-31 12:25:16','2026-04-10 03:07:16',NULL,NULL,NULL),(80,'dulshansineth03@gmail.com','$2y$10$4s5O.kWpFfB0w7pYshI7uuc6gsppdm2i02NdkXqVPsYzZVX7p3Zke','Sineth Mendis',2,'0123456789','','inactive',NULL,NULL,NULL,NULL,'2026-04-12 00:58:09','2026-04-10 04:40:13','2026-04-15 04:49:49',NULL,'47aec645fc1ea5fc795903d253690b343d0a2190c6d36f3ee4cc563230302bef','2026-04-15 09:36:24'),(90,'dulshansineth033@gmail.com','$2y$10$iq2sZ6Dp6gaoiG1.ND2/0uYsjcqFO0rRKJx7ccjvNE4V0lVmz/ate','Sineth Mendis',2,'0123456789',NULL,'active',NULL,NULL,NULL,NULL,NULL,'2026-04-15 05:58:32','2026-04-15 05:58:32',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-15 15:00:32
