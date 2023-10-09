DROP DATABASE IF EXISTS Careersort_db;
CREATE DATABASE Careersort_db;

use Careersort_db;

CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    first_name VARCHAR(50), -- name can be set later
    last_name VARCHAR(50)
);

CREATE TABLE Resumes (
    resume_id INT AUTO_INCREMENT PRIMARY KEY,
    objective TEXT,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

CREATE TABLE Contact_Info (
    contact_info_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    phone_number VARCHAR(15),
    resume_id INT NOT NULL,
    FOREIGN KEY (resume_id) REFERENCES Resumes(resume_id)
);

CREATE TABLE Work_Experiences (
    work_experience_id INT AUTO_INCREMENT PRIMARY KEY,
    tile VARCHAR(50) NOT NULL,
    description TEXT,
    start_date DATE,
    finish_date DATE,
    resume_id INT NOT NULL,
    FOREIGN KEY (resume_id) REFERENCES Resumes(resume_id)
);

CREATE TABLE Educations (
    education_id INT PRIMARY KEY AUTO_INCREMENT,
    institution_name VARCHAR(60) NOT NULL,
    start_date DATE NOT NULL,
    graduation_date DATE NOT NULL,
    resume_id INT NOT NULL,
    FOREIGN KEY (resume_id) REFERENCES Resumes(resume_id)
);

CREATE TABLE Skills (
    skill_id INT PRIMARY KEY AUTO_INCREMENT,
    skill_name VARCHAR(50) NOT NULL
);

CREATE TABLE Resume_Skillsets (
    resume_id INT,
    skill_id INT,
    PRIMARY KEY (resume_id, skill_id),
    FOREIGN KEY (resume_id) REFERENCES Resumes(resume_id),
    FOREIGN KEY (skill_id) REFERENCES Skills(skill_id)
);

CREATE TABLE Job_Postings (
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    job_title VARCHAR(100) NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    job_description TEXT,
    location VARCHAR(50),
    salary DECIMAL(10, 2),
    post_date DATE
);