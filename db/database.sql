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

CREATE TABLE
    assignments (
        assign_id INT PRIMARY KEY AUTO_INCREMENT,
        course_id INT,
        useripass VARCHAR(100),
        assign_name VARCHAR(100),
        detail TEXT,
        FOREIGN KEY (course_id) REFERENCES courses (course_id),
        FOREIGN KEY (useripass) REFERENCES empolyee_role (useripass)
    );

CREATE TABLE
    submissions (
        submission_id INT PRIMARY KEY AUTO_INCREMENT,
        assign_id INT,
        user_id INT,
        upload TEXT,
        submission_text TEXT,
        assign_status INT,
        FOREIGN KEY (assign_id) REFERENCES assignments (assign_id),
        FOREIGN KEY (user_id) REFERENCES users (user_id)
    );

CREATE TABLE
    employee_uploads (
        upload_id INT PRIMARY KEY AUTO_INCREMENT,
        course_id INT,
        upload TEXT,
        upload_type INT,
        FOREIGN KEY (course_id) REFERENCES courses (course_id)
    );