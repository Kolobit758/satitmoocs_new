CREATE TABLE
    users (
        user_id INT PRIMARY KEY AUTO_INCREMENT,
        full_name VARCHAR(100),
        email VARCHAR(255),
        password_hash VARCHAR(255)
    );

CREATE TABLE
    empolyee_role (
        useripass VARCHAR(100) PRIMARY KEY,
        user_id INT,
        role INT,
        FOREIGN KEY (user_id) REFERENCES users (user_id)
    );

CREATE TABLE
    courses (
        course_id INT PRIMARY KEY AUTO_INCREMENT,
        course_name VARCHAR(100)
    );

CREATE TABLE
    employee_course (
        useripass VARCHAR(100),
        course_id INT,
        FOREIGN KEY (course_id) REFERENCES courses (course_id),
        FOREIGN KEY (useripass) REFERENCES empolyee_role (useripass)
    );

CREATE TABLE
    students (
        std_id INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT,
        course_id INT,
        user_level INT,
        FOREIGN KEY (user_id) REFERENCES users (user_id),
        FOREIGN KEY (course_id) REFERENCES courses (course_id)
    );

-- =========================
-- Chapters (บทในคอร์ส)
-- =========================
CREATE TABLE
    chapters (
        chapter_id INT PRIMARY KEY AUTO_INCREMENT,
        course_id INT,
        title VARCHAR(255),
        description TEXT,
        order_no INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (course_id) REFERENCES courses (course_id)
    ) ENGINE = InnoDB;

-- =========================
-- Course Contents (ไฟล์สื่อ หรือ กล่องส่งงาน)
-- =========================
CREATE TABLE
    course_contents (
        content_id INT PRIMARY KEY AUTO_INCREMENT,
        chapter_id INT,
        useripass VARCHAR(100),
        content_type ENUM ('assignment', 'material') NOT NULL,
        title VARCHAR(255),
        detail TEXT,
        is_visible BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (chapter_id) REFERENCES chapters (chapter_id),
        FOREIGN KEY (useripass) REFERENCES empolyee_role (useripass)
    ) ENGINE = InnoDB;

-- =========================
-- Assignments (กล่องส่งงาน)
-- =========================
CREATE TABLE
    assignments (
        assign_id INT PRIMARY KEY AUTO_INCREMENT,
        content_id INT UNIQUE,
        assign_title VARCHAR(255),
        assign_detail TEXT,
        start_date DATETIME,
        end_date DATETIME,
        max_score INT DEFAULT 100,
        is_visible BOOLEAN DEFAULT TRUE,
        FOREIGN KEY (content_id) REFERENCES course_contents (content_id)
    ) ENGINE = InnoDB;

-- =========================
-- Employee Uploads (ไฟล์ที่ครูอัพโหลด)
-- =========================
CREATE TABLE
    employee_uploads (
        upload_id INT PRIMARY KEY AUTO_INCREMENT,
        content_id INT UNIQUE,
        title VARCHAR(255),
        file_path TEXT,
        upload_type INT,
        is_visible BOOLEAN DEFAULT TRUE,
        FOREIGN KEY (content_id) REFERENCES course_contents (content_id)
    ) ENGINE = InnoDB;

-- =========================
-- Submissions (งานที่นักเรียนส่ง)
-- =========================
CREATE TABLE
    submissions (
        submission_id INT PRIMARY KEY AUTO_INCREMENT,
        assign_id INT,
        user_id INT,
        file_path TEXT,
        submission_text TEXT,
        submission_status TINYINT DEFAULT 0, -- 0=ยังไม่ส่ง,1=ส่งแล้ว,2=ส่งสาย
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (assign_id) REFERENCES assignments (assign_id),
        FOREIGN KEY (user_id) REFERENCES users (user_id)
    ) ENGINE = InnoDB;

-- =========================
-- Grades (การให้คะแนน)
-- =========================
CREATE TABLE
    grades (
        grade_id INT PRIMARY KEY AUTO_INCREMENT,
        submission_id INT,
        score INT,
        feedback TEXT,
        graded_by VARCHAR(100),
        graded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (submission_id) REFERENCES submissions (submission_id),
        FOREIGN KEY (graded_by) REFERENCES empolyee_role (useripass)
    ) ENGINE = InnoDB;

-- new DB form


CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) DEFAULT NULL,
  `course_level` int(11) NOT NULL,
  `course_img` varchar(255) NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `user_img` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `empolyee_role` (
  `useripass` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  PRIMARY KEY (`useripass`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `empolyee_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `chapters` (
  `chapter_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order_no` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`chapter_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `course_contents` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) DEFAULT NULL,
  `useripass` varchar(100) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `is_visible` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `content_type_int` int(11) DEFAULT NULL,
  PRIMARY KEY (`content_id`),
  KEY `chapter_id` (`chapter_id`),
  KEY `useripass` (`useripass`),
  CONSTRAINT `course_contents_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`chapter_id`),
  CONSTRAINT `course_contents_ibfk_2` FOREIGN KEY (`useripass`) REFERENCES `empolyee_role` (`useripass`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `assignments` (
  `assign_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) DEFAULT NULL,
  `assign_title` varchar(255) DEFAULT NULL,
  `assign_detail` text DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `max_score` int(11) DEFAULT 100,
  `is_visible` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`assign_id`),
  UNIQUE KEY `content_id` (`content_id`),
  CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`content_id`) REFERENCES `course_contents` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `employee_course` (
  `useripass` varchar(100) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  KEY `useripass` (`useripass`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `employee_course_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  CONSTRAINT `employee_course_ibfk_2` FOREIGN KEY (`useripass`) REFERENCES `empolyee_role` (`useripass`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `employee_uploads` (
  `upload_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `file_path` text DEFAULT NULL,
  `upload_type` int(11) DEFAULT NULL,
  `is_visible` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`upload_id`),
  UNIQUE KEY `content_id` (`content_id`),
  CONSTRAINT `employee_uploads_ibfk_1` FOREIGN KEY (`content_id`) REFERENCES `course_contents` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `student_courses` (
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_level` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`course_id`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `student_courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `student_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `submissions` (
  `submission_id` int(11) NOT NULL AUTO_INCREMENT,
  `assign_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_path` text DEFAULT NULL,
  `submission_text` text DEFAULT NULL,
  `submission_status` tinyint(4) DEFAULT 0,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`submission_id`),
  KEY `assign_id` (`assign_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assign_id`) REFERENCES `assignments` (`assign_id`),
  CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `graded_by` varchar(100) DEFAULT NULL,
  `graded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`grade_id`),
  KEY `submission_id` (`submission_id`),
  KEY `graded_by` (`graded_by`),
  CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`submission_id`),
  CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`graded_by`) REFERENCES `empolyee_role` (`useripass`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
