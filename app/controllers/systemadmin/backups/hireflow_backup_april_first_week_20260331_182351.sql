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
  PRIMARY KEY (`id`),
  UNIQUE KEY `applicant_id` (`applicant_id`,`job_id`),
  KEY `job_id` (`job_id`),
  CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `users` (`id`),
  CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`job_id`) REFERENCES `job_posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `applications`
--

LOCK TABLES `applications` WRITE;
/*!40000 ALTER TABLE `applications` DISABLE KEYS */;
INSERT INTO `applications` VALUES (1,4,1,'/uploads/john_resume.pdf',NULL,'Applied','2025-08-30 20:00:21'),(2,5,1,'/uploads/jane_resume.pdf',NULL,'Under Review','2025-08-30 20:00:21'),(3,4,2,'/uploads/john_resume_2.pdf',NULL,'Shortlisted','2025-08-30 20:00:21'),(7,46,1,'/uploads/resumes/resume_46_1765821750.pdf','fdf','Applied','2025-12-15 18:02:30'),(8,2,1,'/uploads/resumes/resume_2_1765821874.pdf','gdgfg','Applied','2025-12-15 18:04:34');
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
  `status` enum('Scheduled','Completed','Canceled','Rescheduled') DEFAULT 'Scheduled',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `application_id` (`application_id`),
  KEY `idx_scheduled_date` (`scheduled_date`),
  KEY `idx_interviewer_status` (`interviewer_id`,`status`),
  CONSTRAINT `interviews_ibfk_1` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`),
  CONSTRAINT `interviews_ibfk_2` FOREIGN KEY (`interviewer_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interviews`
--

LOCK TABLES `interviews` WRITE;
/*!40000 ALTER TABLE `interviews` DISABLE KEYS */;
INSERT INTO `interviews` VALUES (5,1,3,'Video','2025-09-05','10:00:00',60,NULL,'https://meet.google.com/abc-def-ghi','Scheduled',NULL,'2025-12-16 08:22:51','2025-12-16 08:22:51'),(6,3,3,'In-person','2025-09-03','14:00:00',45,NULL,'Conference Room A, 2nd Floor','Scheduled',NULL,'2025-12-16 08:22:51','2025-12-16 08:22:51'),(7,1,4,'Video','2025-09-06','09:30:00',60,NULL,'https://meet.google.com/xyz-123-abc','Scheduled',NULL,'2025-12-16 08:25:34','2025-12-16 08:25:34'),(8,2,5,'In-person','2025-09-07','11:00:00',45,NULL,'Conference Room B, 1st Floor','Scheduled',NULL,'2025-12-16 08:25:34','2025-12-16 08:25:34'),(9,3,2,'Video','2025-09-08','15:00:00',30,NULL,'https://meet.google.com/qwe-rty-uio','Completed',NULL,'2025-12-16 08:25:34','2025-12-16 08:25:34'),(10,7,46,'Phone','2025-09-09','10:15:00',20,NULL,'N/A','Scheduled',NULL,'2025-12-16 08:25:34','2025-12-16 08:25:34'),(11,8,4,'Video','2025-09-10','13:45:00',60,NULL,'https://meet.google.com/asd-fgh-jkl','Scheduled',NULL,'2025-12-16 08:25:34','2025-12-16 08:25:34'),(12,2,46,'In-person','2025-09-11','16:00:00',45,NULL,'HR Meeting Room, Ground Floor','',NULL,'2025-12-16 08:25:34','2025-12-16 08:25:34'),(13,1,5,'Video','2025-08-28','10:00:00',60,NULL,'https://meet.google.com/com-plt-001','Completed',NULL,'2025-12-16 08:26:40','2025-12-16 08:26:40'),(14,2,4,'In-person','2025-08-29','14:30:00',45,NULL,'Conference Room A, 2nd Floor','Completed',NULL,'2025-12-16 08:26:40','2025-12-16 08:26:40'),(15,3,46,'Phone','2025-08-30','09:15:00',30,NULL,'N/A','Completed',NULL,'2025-12-16 08:26:40','2025-12-16 08:26:40'),(16,7,2,'Video','2025-08-31','11:00:00',60,NULL,'https://meet.google.com/com-plt-002','Completed',NULL,'2025-12-16 08:26:40','2025-12-16 08:26:40'),(17,1,4,'Video','2025-12-06','10:00:00',60,NULL,'https://meet.google.com/past-001','Completed',NULL,'2025-12-16 08:49:16','2025-12-16 08:49:16'),(18,2,5,'In-person','2025-12-07','14:30:00',45,NULL,'Conference Room A, 2nd Floor','Completed',NULL,'2025-12-16 08:49:16','2025-12-16 08:49:16'),(19,3,46,'Phone','2025-12-08','09:15:00',30,NULL,'N/A','Completed',NULL,'2025-12-16 08:49:16','2025-12-16 08:49:16'),(20,7,2,'Video','2025-12-09','11:00:00',60,NULL,'https://meet.google.com/past-002','Completed',NULL,'2025-12-16 08:49:16','2025-12-16 08:49:16'),(21,8,4,'Video','2025-12-11','15:00:00',45,NULL,'https://meet.google.com/past-003','Completed',NULL,'2025-12-16 08:49:16','2025-12-16 08:49:16'),(22,1,5,'In-person','2025-12-13','10:30:00',60,NULL,'HR Meeting Room, Ground Floor','Completed',NULL,'2025-12-16 08:49:16','2025-12-16 08:49:16'),(23,2,46,'Video','2025-12-14','13:00:00',45,NULL,'https://meet.google.com/past-004','Completed',NULL,'2025-12-16 08:49:16','2025-12-16 08:49:16'),(24,3,2,'Phone','2025-12-15','16:00:00',20,NULL,'N/A','Completed',NULL,'2025-12-16 08:49:16','2025-12-16 08:49:16'),(25,1,4,'Video','2025-12-06','10:00:00',60,NULL,'https://meet.google.com/past-001','Completed',NULL,'2025-12-16 08:50:12','2025-12-16 08:50:12'),(26,2,5,'In-person','2025-12-07','14:30:00',45,NULL,'Conference Room A, 2nd Floor','Completed',NULL,'2025-12-16 08:50:12','2025-12-16 08:50:12'),(27,3,46,'Phone','2025-12-08','09:15:00',30,NULL,'N/A','Completed',NULL,'2025-12-16 08:50:12','2025-12-16 08:50:12'),(28,7,2,'Video','2025-12-09','11:00:00',60,NULL,'https://meet.google.com/past-002','Completed',NULL,'2025-12-16 08:50:12','2025-12-16 08:50:12'),(29,8,4,'Video','2025-12-11','15:00:00',45,NULL,'https://meet.google.com/past-003','Completed',NULL,'2025-12-16 08:50:12','2025-12-16 08:50:12'),(30,1,5,'In-person','2025-12-13','10:30:00',60,NULL,'HR Meeting Room, Ground Floor','Completed',NULL,'2025-12-16 08:50:12','2025-12-16 08:50:12'),(31,2,46,'Video','2025-12-14','13:00:00',45,NULL,'https://meet.google.com/past-004','Completed',NULL,'2025-12-16 08:50:12','2025-12-16 08:50:12'),(32,3,2,'Phone','2025-12-15','16:00:00',20,NULL,'N/A','Completed',NULL,'2025-12-16 08:50:12','2025-12-16 08:50:12');
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `hr_id` (`hr_id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `job_posts_ibfk_1` FOREIGN KEY (`hr_id`) REFERENCES `users` (`id`),
  CONSTRAINT `job_posts_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_posts`
--

LOCK TABLES `job_posts` WRITE;
/*!40000 ALTER TABLE `job_posts` DISABLE KEYS */;
INSERT INTO `job_posts` VALUES (1,2,'Software Engineer',2,'Looking for a skilled software developer',NULL,'IT','Colombo',NULL,'Full-time','2025-12-31','Open','2025-08-30 20:00:21'),(2,2,'Marketing Specialist',2,'Digital marketing expert needed',NULL,'Marketing','Kandy',NULL,'Full-time','2025-11-30','Open','2025-08-30 20:00:21'),(3,2,'Data Analyst',3,'Analyze business data and trends',NULL,'Analytics','Galle',NULL,'Full-time','2025-10-31','Open','2025-08-30 20:00:21'),(4,4,'Senior Software Engineer',2,'We are seeking an experienced Software Engineer to join our dynamic development team. You will be responsible for designing, developing, and maintaining high-quality software applications using modern technologies and best practices.','??? Bachelor\'s degree in Computer Science or related field\n??? 5+ years of experience in software development\n??? Proficiency in PHP, JavaScript, Python, or Java\n??? Experience with database design (MySQL, PostgreSQL)\n??? Knowledge of web frameworks (Laravel, React, Vue.js)\n??? Understanding of version control systems (Git)\n??? Strong problem-solving and analytical skills\n??? Excellent communication and teamwork abilities',NULL,'Colombo, Sri Lanka','$70,000 - $90,000','Full-time','2025-10-15','Open','2025-09-07 08:44:02'),(5,4,'Frontend Developer',2,'Join our creative team as a Frontend Developer and help us build beautiful, responsive, and user-friendly web applications. You will work closely with designers and backend developers to create exceptional user experiences.','??? Bachelor\'s degree in Computer Science, Web Development, or related field\n??? 3+ years of frontend development experience\n??? Expert knowledge of HTML5, CSS3, and JavaScript (ES6+)\n??? Experience with modern frameworks (React, Vue.js, Angular)\n??? Proficiency in CSS preprocessors (SASS, LESS)\n??? Understanding of responsive design principles\n??? Experience with build tools (Webpack, Gulp, npm)\n??? Knowledge of version control (Git)\n??? Eye for design and attention to detail',NULL,'Colombo, Sri Lanka','$50,000 - $70,000','Full-time','2025-09-30','Open','2025-09-07 08:44:02'),(6,4,'DevOps Engineer',2,'We are looking for a skilled DevOps Engineer to help us streamline our development and deployment processes. You will be responsible for maintaining our CI/CD pipelines, cloud infrastructure, and ensuring system reliability.','??? Bachelor\'s degree in Computer Science, Engineering, or related field\n??? 4+ years of experience in DevOps or system administration\n??? Experience with cloud platforms (AWS, Azure, Google Cloud)\n??? Proficiency in containerization (Docker, Kubernetes)\n??? Knowledge of CI/CD tools (Jenkins, GitLab CI, GitHub Actions)\n??? Experience with infrastructure as code (Terraform, CloudFormation)\n??? Scripting skills (Bash, Python, PowerShell)\n??? Understanding of monitoring tools (Prometheus, Grafana)\n??? Strong troubleshooting and problem-solving skills',NULL,'Remote','$65,000 - $85,000','Full-time','2025-10-01','Open','2025-09-07 08:44:02'),(7,4,'HR Business Partner',1,'Join our HR team as an HR Business Partner and play a key role in supporting our organizational growth. You will work closely with management to develop HR strategies, policies, and programs that align with business objectives.','??? Bachelor\'s degree in Human Resources, Business Administration, or related field\n??? 5+ years of HR experience with focus on business partnering\n??? Strong knowledge of employment law and HR best practices\n??? Experience in talent acquisition and performance management\n??? Excellent interpersonal and communication skills\n??? Proficiency in HRIS systems and MS Office suite\n??? Professional HR certification (SHRM, HRCI) preferred\n??? Ability to handle confidential information with discretion\n??? Strong analytical and problem-solving skills',NULL,'Colombo, Sri Lanka','$55,000 - $75,000','Full-time','2025-10-20','Open','2025-09-07 08:44:02'),(8,4,'Talent Acquisition Specialist',1,'We are seeking a dynamic Talent Acquisition Specialist to join our growing HR team. You will be responsible for identifying, attracting, and hiring top talent across various departments and skill levels.','??? Bachelor\'s degree in Human Resources, Psychology, or related field\n??? 3+ years of experience in recruitment and talent acquisition\n??? Experience with various recruitment channels (job boards, social media, networking)\n??? Proficiency in applicant tracking systems (ATS)\n??? Strong interviewing and assessment skills\n??? Knowledge of employment laws and regulations\n??? Excellent communication and negotiation skills\n??? Ability to work in a fast-paced environment\n??? Experience with technical recruitment preferred',NULL,'Colombo, Sri Lanka','$45,000 - $60,000','Full-time','2025-09-25','Open','2025-09-07 08:44:02'),(9,4,'Digital Marketing Manager',3,'We are looking for a creative and results-driven Digital Marketing Manager to lead our digital marketing initiatives. You will develop and execute comprehensive digital marketing strategies to increase brand awareness and drive customer acquisition.','??? Bachelor\'s degree in Marketing, Communications, or related field\n??? 4+ years of experience in digital marketing\n??? Proven experience with digital marketing channels (SEO, SEM, social media, email)\n??? Proficiency in marketing tools (Google Analytics, AdWords, Facebook Ads Manager)\n??? Experience with marketing automation platforms\n??? Strong analytical skills and data-driven mindset\n??? Excellent written and verbal communication skills\n??? Creative thinking and problem-solving abilities\n??? Experience with content management systems',NULL,'Colombo, Sri Lanka','$55,000 - $70,000','Full-time','2025-09-28','Open','2025-09-07 08:44:02'),(10,4,'Customer Success Manager',6,'Join our Customer Success team and help us build lasting relationships with our clients. You will be responsible for ensuring customer satisfaction, driving product adoption, and identifying growth opportunities.','??? Bachelor\'s degree in Business, Communications, or related field\n??? 3+ years of experience in customer success, account management, or related role\n??? Strong customer service and relationship management skills\n??? Experience with CRM systems (Salesforce, HubSpot)\n??? Excellent communication and presentation skills\n??? Problem-solving and conflict resolution abilities\n??? Data analysis skills to track customer metrics\n??? Ability to work collaboratively across teams\n??? Technical aptitude to understand our products',NULL,'Colombo, Sri Lanka','$45,000 - $60,000','Full-time','2025-10-05','Open','2025-09-07 08:44:02'),(11,4,'QA Engineer',8,'We are seeking a detail-oriented QA Engineer to join our quality assurance team. You will be responsible for testing our software applications, identifying bugs, and ensuring our products meet the highest quality standards.','??? Bachelor\'s degree in Computer Science, Engineering, or related field\n??? 3+ years of experience in software testing and quality assurance\n??? Experience with manual and automated testing methodologies\n??? Knowledge of testing tools (Selenium, TestRail, JIRA)\n??? Understanding of software development lifecycle (SDLC)\n??? Experience with API testing and database testing\n??? Strong analytical and problem-solving skills\n??? Excellent attention to detail\n??? Good communication skills for reporting issues',NULL,'Colombo, Sri Lanka','$45,000 - $60,000','Full-time','2025-10-12','Open','2025-09-07 08:44:02'),(12,4,'Senior Software Engineer',2,'We are seeking an experienced Software Engineer to join our dynamic development team. You will be responsible for designing, developing, and maintaining high-quality software applications using modern technologies and best practices.','??? Bachelor\'s degree in Computer Science or related field\n??? 5+ years of experience in software development\n??? Proficiency in PHP, JavaScript, Python, or Java\n??? Experience with database design (MySQL, PostgreSQL)\n??? Knowledge of web frameworks (Laravel, React, Vue.js)\n??? Understanding of version control systems (Git)\n??? Strong problem-solving and analytical skills\n??? Excellent communication and teamwork abilities',NULL,'Colombo, Sri Lanka','$70,000 - $90,000','Full-time','2025-10-15','Open','2025-09-07 08:44:43'),(13,4,'Frontend Developer',2,'Join our creative team as a Frontend Developer and help us build beautiful, responsive, and user-friendly web applications. You will work closely with designers and backend developers to create exceptional user experiences.','??? Bachelor\'s degree in Computer Science, Web Development, or related field\n??? 3+ years of frontend development experience\n??? Expert knowledge of HTML5, CSS3, and JavaScript (ES6+)\n??? Experience with modern frameworks (React, Vue.js, Angular)\n??? Proficiency in CSS preprocessors (SASS, LESS)\n??? Understanding of responsive design principles\n??? Experience with build tools (Webpack, Gulp, npm)\n??? Knowledge of version control (Git)\n??? Eye for design and attention to detail',NULL,'Colombo, Sri Lanka','$50,000 - $70,000','Full-time','2025-09-30','Open','2025-09-07 08:44:43'),(14,4,'Digital Marketing Manager',3,'We are looking for a creative and results-driven Digital Marketing Manager to lead our digital marketing initiatives. You will develop and execute comprehensive digital marketing strategies to increase brand awareness and drive customer acquisition.','??? Bachelor\'s degree in Marketing, Communications, or related field\n??? 4+ years of experience in digital marketing\n??? Proven experience with digital marketing channels (SEO, SEM, social media, email)\n??? Proficiency in marketing tools (Google Analytics, AdWords, Facebook Ads Manager)\n??? Experience with marketing automation platforms\n??? Strong analytical skills and data-driven mindset\n??? Excellent written and verbal communication skills\n??? Creative thinking and problem-solving abilities\n??? Experience with content management systems',NULL,'Colombo, Sri Lanka','$55,000 - $70,000','Full-time','2025-09-28','Open','2025-09-07 08:44:43'),(15,4,'HR Business Partner',1,'Join our HR team as an HR Business Partner and play a key role in supporting our organizational growth. You will work closely with management to develop HR strategies, policies, and programs that align with business objectives.','??? Bachelor\'s degree in Human Resources, Business Administration, or related field\n??? 5+ years of HR experience with focus on business partnering\n??? Strong knowledge of employment law and HR best practices\n??? Experience in talent acquisition and performance management\n??? Excellent interpersonal and communication skills\n??? Proficiency in HRIS systems and MS Office suite\n??? Professional HR certification (SHRM, HRCI) preferred\n??? Ability to handle confidential information with discretion\n??? Strong analytical and problem-solving skills',NULL,'Colombo, Sri Lanka','$55,000 - $75,000','Full-time','2025-10-20','Open','2025-09-07 08:44:43'),(16,4,'QA Engineer',8,'We are seeking a detail-oriented QA Engineer to join our quality assurance team. You will be responsible for testing our software applications, identifying bugs, and ensuring our products meet the highest quality standards.','??? Bachelor\'s degree in Computer Science, Engineering, or related field\n??? 3+ years of experience in software testing and quality assurance\n??? Experience with manual and automated testing methodologies\n??? Knowledge of testing tools (Selenium, TestRail, JIRA)\n??? Understanding of software development lifecycle (SDLC)\n??? Experience with API testing and database testing\n??? Strong analytical and problem-solving skills\n??? Excellent attention to detail\n??? Good communication skills for reporting issues',NULL,'Colombo, Sri Lanka','$45,000 - $60,000','Full-time','2025-10-12','Open','2025-09-07 08:44:43');
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,4,'Application Submitted','Your application for Senior Software Engineer position has been submitted successfully.','success',0,'2025-08-31 17:48:47'),(2,4,'Application Update','Your application for Senior Software Engineer has been shortlisted for interview.','info',0,'2025-08-31 17:48:47'),(3,2,'New Application','A new application has been received for the Marketing Specialist position.','info',0,'2025-08-31 17:48:47'),(4,3,'Interview Reminder','You have an interview scheduled with Priya Jayasinghe tomorrow at 2:00 PM.','warning',0,'2025-08-31 17:48:47'),(5,2,'Application Received','Your application for Senior Software Engineer has been received and is under review.','',0,'2025-09-07 08:44:43'),(6,4,'New Application','New application received for Senior Software Engineer position from Athsara Fernando.','',1,'2025-09-07 08:44:43'),(7,2,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-10-21 18:13:15'),(8,46,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-15 17:59:52'),(9,46,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-15 18:02:30'),(10,2,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-15 18:04:34'),(11,59,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-29 17:17:41'),(12,59,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-29 17:20:30'),(13,65,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-29 18:39:31'),(14,66,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-29 18:45:40'),(15,67,'Application Submitted','Your job application has been submitted successfully.','success',0,'2025-12-30 12:48:04');
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
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@hireflow.com','$2y$10$uF92QeHqRnXF.6XTcr.qbeVWsRVGEwbwrUvp8wJKUjnY6YJNdfB.K','Sineth Mendis',1,'0711145571','test, gggaddress1234hhfh46bbb','active','2026-03-31 12:52:54','2025-09-06 18:14:46','2026-03-31 16:22:54','profile_1_1774971887.jpg'),(2,'athsara@hireflow.com','$2y$10$S7m.XJbNWuTFLKgc5QdkIOjZ7ZfzCQY6dGITiBpaIXsWrGB/7Uc4.','Athsara Fernando',4,'','','active','2026-01-01 02:00:24','2025-09-06 15:10:51','2026-01-01 06:30:24',NULL),(3,'recruiter@hireflow.com','$2y$10$vlr0hoSSCCGfwaAm.taYOeezIkPNSRCC01Akl.MSiLkJG/KBGi6rK','Tehan Isum',3,'0712345678','','active','2025-12-20 13:13:58','2025-09-06 15:33:46','2025-12-29 13:48:13',NULL),(4,'hr@hireflow.com','$2y$10$UaLGajZ1lfRW0qR.CJHKZehd8w4U5tk1rA7bjAoZMy0wJQZHVb3MO','Hasindu Rodrigo',2,'0712345678','','active','2025-12-20 13:13:35','2025-09-06 17:22:34','2025-12-30 08:52:49',NULL),(5,'chamali.perera@gmail.com','Password@1','Chamali Perera',4,'+94772345678','','active','2025-10-16 11:21:39','2025-09-07 08:41:36','2025-12-29 13:48:12',NULL),(46,'johndoe@hireflow.com','$2y$10$PZQRIzlI0f2CqEGpWcDH4eLBxE/fQU5QqY2wzGRq68KOGEUScepnO','John Doe',4,'','','active','2025-12-15 13:29:26','2025-12-15 13:12:33','2025-12-29 13:48:11',NULL),(59,'jp@hireflow.com','$2y$10$eXQo5PiHsgIVKnji3dkMAuvF5Cyh0xA8Pz2gop0oBce/8Vzyk4rpe','John Piper',4,'','','active','2025-12-29 13:03:55','2025-12-29 12:47:04','2025-12-29 14:09:57',NULL),(65,'jm@hireflow.com','$2y$10$luvRgTtFsYihktQXyaNQQOOiJFf1YnN560.OCb576gYlu/NRKORYq','John Mcc',4,'','','active','2025-12-29 14:09:18','2025-12-29 14:08:53','2025-12-29 18:39:18',NULL),(66,'nd@hireflow.com','$2y$10$W1RQKmRWevnIsSxSWsWbwOO6sVsp30RzcKPwia9Q.YBs/NNoaaz/C','Nathan  Drane',4,'','','inactive','2025-12-29 14:15:27','2025-12-29 14:15:13','2025-12-29 14:20:15',NULL),(67,'jn@hireflow.com','$2y$10$JxHMlEgDMFp1pO.WIa8UoeH3fNGU9.xG6r0YE63c4DdR2W8QU03Tq','John Nate',4,'','','active','2025-12-30 09:04:40','2025-12-30 08:17:37','2025-12-30 13:34:40',NULL),(76,'testuser@hireflow.com','$2y$10$s2Sk1l8fM/TdmaxT3Wh6auMPipbJBv3fsXsveYg8PDphShoOit.Iu','Test User',3,'0712345675',NULL,'active',NULL,'2026-03-31 12:25:16','2026-03-31 12:25:16',NULL);
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

-- Dump completed on 2026-03-31 21:53:52
