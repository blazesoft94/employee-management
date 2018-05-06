-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2015 at 08:34 AM
-- Server version: 5.5.44-37.3-log
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `techwbzd_eoffice`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE IF NOT EXISTS `announcement` (
  `ann_id` int(11) NOT NULL AUTO_INCREMENT,
  `display_from` date NOT NULL,
  `display_to` date NOT NULL,
  `title` varchar(1000) NOT NULL,
  `content` text NOT NULL,
  `created_date` date NOT NULL,
  `modify_date` date NOT NULL,
  PRIMARY KEY (`ann_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `appreciation`
--

CREATE TABLE IF NOT EXISTS `appreciation` (
  `app_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_img` varchar(250) NOT NULL,
  `app_name` varchar(1000) NOT NULL,
  `app_designation` varchar(1000) NOT NULL,
  `app_details` text NOT NULL,
  `display_date` date NOT NULL,
  `created_date` date NOT NULL,
  `modify_date` date NOT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `emp_id` varchar(50) NOT NULL,
  `signin_date` varchar(20) NOT NULL,
  `signin_time` varchar(50) NOT NULL,
  `signin_late_note` varchar(255) NOT NULL,
  `signout_time` varchar(50) NOT NULL,
  `signout_late_note` varchar(255) NOT NULL,
  `working_hours` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  `pre_experience` text NOT NULL,
  `punchin_type` varchar(255) NOT NULL,
  `punchout_type` varchar(255) NOT NULL,
  `custom_status` varchar(255) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`aid`, `username`, `emp_id`, `signin_date`, `signin_time`, `signin_late_note`, `signout_time`, `signout_late_note`, `working_hours`, `status`, `pre_experience`, `punchin_type`, `punchout_type`, `custom_status`) VALUES
(1, 'admin', '101', '25-Aug-2015', '10:56', 'hi', '11:54', '', '00:58', 0, '0', '', '', ''),
(2, 'admin2', '102', '25-Aug-2015', '11:42', 'hi', '20:45', 'erfvev ', '09:03', 0, '0', '', 'Custom Markout', '1'),
(3, 'employee1', '103', '25-Aug-2015', '19:00', 'retert', '11:51', '', '16:51', 0, '0', 'Custom Markin', '', '1'),
(4, 'employee2', '104', '25-Aug-2015', '11:58', 'fdghdfh', '17:00', 'ewrt', '05:02', 0, '0', '', 'Custom Markout', '1'),
(5, 'manager', '105', '25-Aug-2015', '20:00', 'xcvxcv', '20:00', 'xcvxcv', '00:00', 0, '0', 'Custom Markin', 'Custom Markout', '1');

-- --------------------------------------------------------

--
-- Table structure for table `bank_slip_info`
--

CREATE TABLE IF NOT EXISTS `bank_slip_info` (
  `bsi` int(11) NOT NULL AUTO_INCREMENT,
  `month_year` varchar(250) NOT NULL,
  `total_amt` varchar(250) NOT NULL,
  `pdf_path` text NOT NULL,
  `csv_path` text NOT NULL,
  `created_date` datetime NOT NULL,
  `created_person` varchar(250) NOT NULL,
  PRIMARY KEY (`bsi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `carry_info`
--

CREATE TABLE IF NOT EXISTS `carry_info` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `carry_left` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `edited_by` varchar(250) NOT NULL,
  `edited_date` datetime NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `carry_info`
--

INSERT INTO `carry_info` (`c_id`, `user_id`, `carry_left`, `status`, `edited_by`, `edited_date`) VALUES
(1, 1, 0, 1, 'admin', '2015-08-25 10:37:10'),
(2, 2, 0, 1, 'admin', '2015-08-25 10:40:09'),
(3, 3, 0, 1, 'admin', '2015-08-25 10:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `date_of_add` varchar(255) NOT NULL,
  UNIQUE KEY `d_id` (`d_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`d_id`, `department_name`, `designation`, `date_of_add`) VALUES
(2, 'Software', 'Web Developer', '25-Aug-2015');

-- --------------------------------------------------------

--
-- Table structure for table `emergency_attendance`
--

CREATE TABLE IF NOT EXISTS `emergency_attendance` (
  `e_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `emp_id` varchar(25) NOT NULL,
  `signin_date` varchar(255) NOT NULL,
  `signin_time` varchar(250) NOT NULL,
  `signin_reason` varchar(255) NOT NULL,
  `signout_time` varchar(250) NOT NULL,
  `signout_reason` varchar(250) NOT NULL,
  `working_hours` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `custom_status` int(11) NOT NULL,
  UNIQUE KEY `e_id` (`e_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `emergency_report`
--

CREATE TABLE IF NOT EXISTS `emergency_report` (
  `ew_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `emp_id` varchar(255) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `type_of_work` varchar(255) NOT NULL,
  `time_of_work` varchar(255) NOT NULL,
  `total_time` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `report_date` varchar(255) NOT NULL,
  `total_records` varchar(255) NOT NULL,
  PRIMARY KEY (`ew_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(1000) NOT NULL,
  `event_description` text NOT NULL,
  `event_date` varchar(250) NOT NULL,
  `created_date` varchar(250) NOT NULL,
  `modify_date` varchar(250) NOT NULL,
  PRIMARY KEY (`event_id`),
  UNIQUE KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_description`, `event_date`, `created_date`, `modify_date`) VALUES
(1, 'Onam celebration', '<p>Date: 27th August 2015</p>\r\n<p>Time: 9.00 AM to 3.00 PM</p>\r\n<p>from:utyfduysdiuyfyusdf</p>', '27-Aug-2015', '25-Aug-2015', '');

-- --------------------------------------------------------

--
-- Table structure for table `events_photos`
--

CREATE TABLE IF NOT EXISTS `events_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `photos_url` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE IF NOT EXISTS `holiday` (
  `h_id` int(11) NOT NULL AUTO_INCREMENT,
  `h_name` varchar(200) NOT NULL,
  `h_date` varchar(55) NOT NULL,
  `create_date` varchar(25) NOT NULL,
  PRIMARY KEY (`h_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_list`
--

CREATE TABLE IF NOT EXISTS `holiday_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `url` varchar(255) NOT NULL,
  `allday` tinyint(1) NOT NULL,
  `h_date` date NOT NULL,
  `className` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE IF NOT EXISTS `issues` (
  `i_id` int(11) NOT NULL AUTO_INCREMENT,
  `primary_responsibility` varchar(1000) NOT NULL,
  `subject` varchar(1000) NOT NULL,
  `o_subject` varchar(1000) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `department` varchar(250) NOT NULL,
  `details` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `posted_date` datetime NOT NULL,
  `post_by` varchar(250) NOT NULL,
  `create_date` datetime NOT NULL,
  `ticket_no` varchar(40) NOT NULL,
  `estimated_date` datetime NOT NULL,
  PRIMARY KEY (`i_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `leave_management`
--

CREATE TABLE IF NOT EXISTS `leave_management` (
  `l_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `leave_from` varchar(50) NOT NULL,
  `leave_to` varchar(50) NOT NULL,
  `half_full` varchar(255) NOT NULL,
  `leave_reason` varchar(255) NOT NULL,
  `apply_date` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `approve_date` varchar(1000) NOT NULL,
  `cancel_date` varchar(100) NOT NULL,
  `change_status_person` varchar(255) NOT NULL,
  PRIMARY KEY (`l_id`),
  UNIQUE KEY `l_id` (`l_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `pagename` varchar(1000) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`p_id`, `pagename`, `created_date`) VALUES
(1, 'my-profile.php', '2015-02-20 00:00:00'),
(2, 'change-password.php', '2015-02-20 00:00:00'),
(3, 'edit-profile.php', '2015-02-20 00:00:00'),
(4, 'logout.php', '2015-02-20 00:00:00'),
(5, 'welcome.php', '2015-02-20 00:00:00'),
(6, 'attendance.php', '2015-02-20 00:00:00'),
(7, 'custom-attendance.php', '2015-02-20 00:00:00'),
(8, 'my-work-status.php', '2015-02-20 00:00:00'),
(9, 'tempwork-report.php', '2015-02-20 00:00:00'),
(10, 'apply-leave.php', '2015-02-20 00:00:00'),
(11, 'leave-status.php', '2015-02-20 00:00:00'),
(12, 'leave-summary.php', '2015-02-20 00:00:00'),
(13, 'thought-of-the-day.php', '2015-02-20 00:00:00'),
(14, 'appreciation.php', '2015-02-20 00:00:00'),
(15, 'birthdays.php', '2015-02-20 00:00:00'),
(16, 'announcement.php', '2015-02-20 00:00:00'),
(17, 'view-issues.php', '2015-02-20 00:00:00'),
(18, 'agendalist.php', '2015-02-20 00:00:00'),
(19, 'attendance-report.php', '2015-02-20 00:00:00'),
(20, 'work-report.php', '2015-02-20 00:00:00'),
(21, 'my-project.php', '2015-02-20 00:00:00'),
(22, 'leave-request-info.php', '2015-02-20 00:00:00'),
(23, 'view-leave-status.php', '2015-02-20 00:00:00'),
(24, 'all-attendance-report.php', '2015-02-20 00:00:00'),
(25, 'all-work-report.php', '2015-02-20 00:00:00'),
(26, 'overall-work-report.php', '2015-02-20 00:00:00'),
(27, 'add-project.php', '2015-02-20 00:00:00'),
(28, 'add-project-task.php', '2015-02-20 00:00:00'),
(29, 'project-assignment.php', '2015-02-20 00:00:00'),
(30, 'productivity-target.php', '2015-02-20 00:00:00'),
(31, 'users-list.php', '2015-02-20 00:00:00'),
(32, 'add-users.php', '2015-02-20 00:00:00'),
(33, 'search-users.php', '2015-02-20 00:00:00'),
(34, 'add-department.php', '2015-02-20 00:00:00'),
(35, 'holiday.php', '2015-02-20 00:00:00'),
(36, 'ip-white-list.php', '2015-02-20 00:00:00'),
(37, 'add-thought-of-the-day.php', '2015-02-20 00:00:00'),
(38, 'view-thought-of-the-day.php', '2015-02-20 00:00:00'),
(39, 'edit-thought-of-the-day.php', '2015-02-20 00:00:00'),
(40, 'add-appreciation.php', '2015-02-20 00:00:00'),
(41, 'view-appreciation.php', '2015-02-20 00:00:00'),
(42, 'edit-appreciation.php', '2015-02-20 00:00:00'),
(43, 'add-announcement.php', '2015-02-20 00:00:00'),
(44, 'view-announcement.php', '2015-02-20 00:00:00'),
(45, 'edit-announcement.php', '2015-02-20 00:00:00'),
(46, 'add-events.php', '2015-02-20 00:00:00'),
(47, 'view-events.php', '2015-02-20 00:00:00'),
(48, 'edit-events.php', '2015-02-20 00:00:00'),
(49, 'edit-users.php', '2015-02-20 00:00:00'),
(50, 'role-management.php', '2015-02-23 15:00:00'),
(51, 'add-productivity-target.php', '2015-02-23 00:00:00'),
(52, 'edit-productivity-target.php', '2015-02-23 00:00:00'),
(53, 'user-login-issue.php', '2015-03-04 00:00:00'),
(54, 'bank-slip.php', '2015-03-10 00:00:00'),
(55, 'bank-slip-genetate.php', '2015-03-10 00:00:00'),
(56, 'hr-apply-leave.php', '2015-03-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `productivity_target`
--

CREATE TABLE IF NOT EXISTS `productivity_target` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `type_of_work` int(250) NOT NULL,
  `target_month` varchar(250) NOT NULL,
  `target_year` varchar(255) NOT NULL,
  `rph` varchar(250) NOT NULL,
  `assign` varchar(250) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`t_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_assignment`
--

CREATE TABLE IF NOT EXISTS `project_assignment` (
  `p_aid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `project_name_id` varchar(255) NOT NULL,
  `assigned_date` varchar(255) NOT NULL,
  UNIQUE KEY `p_aid` (`p_aid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `project_assignment`
--

INSERT INTO `project_assignment` (`p_aid`, `username`, `project_name_id`, `assigned_date`) VALUES
(1, 'admin2', '1', '25-Aug-2015'),
(2, 'employee1', '2', '25-Aug-2015'),
(3, 'employee2', '3', '25-Aug-2015'),
(4, 'manager', '2', '25-Aug-2015'),
(5, 'employee1', '1', '25-Aug-2015');

-- --------------------------------------------------------

--
-- Table structure for table `project_list`
--

CREATE TABLE IF NOT EXISTS `project_list` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(255) NOT NULL,
  `project_add_person` varchar(250) NOT NULL,
  `date_of_add` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `dat_of_mod` varchar(255) NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `project_list`
--

INSERT INTO `project_list` (`p_id`, `project_name`, `project_add_person`, `date_of_add`, `status`, `dat_of_mod`) VALUES
(1, 'project 1', 'admin', '25-Aug-2015', 1, ''),
(2, 'project 2', 'admin', '25-Aug-2015', 1, ''),
(3, 'project 3', 'admin', '25-Aug-2015', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `project_task_list`
--

CREATE TABLE IF NOT EXISTS `project_task_list` (
  `pt_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name_id` varchar(250) NOT NULL,
  `task_name` varchar(255) NOT NULL,
  `create_date` varchar(250) NOT NULL,
  PRIMARY KEY (`pt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `project_task_list`
--

INSERT INTO `project_task_list` (`pt_id`, `project_name_id`, `task_name`, `create_date`) VALUES
(1, '1', 'Task 1', '25-Aug-2015'),
(2, '2', 'Task 2', '25-Aug-2015'),
(3, '3', 'Task 3', '25-Aug-2015');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`r_id`, `rolename`, `created_date`) VALUES
(1, 'Admin', '2015-08-24 00:00:00'),
(3, 'User', '2015-08-25 11:01:09'),
(4, 'manager', '2015-08-25 11:01:18');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE IF NOT EXISTS `role_permission` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` varchar(250) NOT NULL,
  `page_id` varchar(250) NOT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`r_id`),
  UNIQUE KEY `r_id` (`r_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`r_id`, `role_id`, `page_id`, `created_date`) VALUES
(1, '4', '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,56,22,23,24,25,26,27,28,29,30,51,52,31,33,', '2015-08-25 11:01:57');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `logo` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `logo`) VALUES
(1, 'Eoffice', '');

-- --------------------------------------------------------

--
-- Table structure for table `shift_time`
--

CREATE TABLE IF NOT EXISTS `shift_time` (
  `shift_no` int(11) NOT NULL AUTO_INCREMENT,
  `shift_start_time` varchar(55) NOT NULL,
  `shift_end_time` varchar(55) NOT NULL,
  PRIMARY KEY (`shift_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `shift_time`
--

INSERT INTO `shift_time` (`shift_no`, `shift_start_time`, `shift_end_time`) VALUES
(1, '09:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `temporary_report`
--

CREATE TABLE IF NOT EXISTS `temporary_report` (
  `temp_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `emp_id` varchar(255) NOT NULL,
  `project_name` text NOT NULL,
  `type_of_work` varchar(255) NOT NULL,
  `time_of_work` varchar(255) NOT NULL,
  `total_time` varchar(50) NOT NULL,
  `comments` text NOT NULL,
  `report_date` varchar(50) NOT NULL,
  `total_records` varchar(255) NOT NULL,
  PRIMARY KEY (`temp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `thoughts`
--

CREATE TABLE IF NOT EXISTS `thoughts` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `t_title` varchar(200) NOT NULL,
  `t_details` text NOT NULL,
  `t_img` varchar(255) NOT NULL,
  `display_date` date NOT NULL,
  `created_date` date NOT NULL,
  `modify_date` date NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `thoughts`
--

INSERT INTO `thoughts` (`tid`, `t_title`, `t_details`, `t_img`, `display_date`, `created_date`, `modify_date`) VALUES
(1, 'Motivational', 'Motivational', 'uploads/thoughts/225x225_1440481838-1864501797.jpg', '2015-08-25', '2015-08-25', '2015-08-25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `idu` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `sex` varchar(22) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `phone_num` varchar(250) NOT NULL,
  `blood_group` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `salted` text NOT NULL,
  `department` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `join_date` datetime NOT NULL,
  `address` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `shift_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `resigned_date` datetime NOT NULL,
  `leave_carry` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `beneficiary_name` varchar(255) NOT NULL,
  `acc_num` varchar(255) NOT NULL,
  `ifsc_code` varchar(255) NOT NULL,
  `experience` date NOT NULL,
  PRIMARY KEY (`idu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idu`, `username`, `password`, `email_id`, `fname`, `sex`, `employee_id`, `phone_num`, `blood_group`, `dob`, `salted`, `department`, `designation`, `qualification`, `join_date`, `address`, `image`, `emp_id`, `shift_id`, `role`, `status`, `resigned_date`, `leave_carry`, `bank_name`, `branch`, `beneficiary_name`, `acc_num`, `ifsc_code`, `experience`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin1@gmail.com', 'Admin1', 'Male', 'TW-101', '+91 4564564552', 'AB negative', '1989-06-05', '', 'Software', 'Web Developer', 'MBA', '2012-12-04 00:00:00', 'asassasssss', 'uploads/250x250_1440479230-1929999310.png', 101, 1, 'admin', 'active', '0000-00-00 00:00:00', 1, 'moneyindia', 'India', 'admin', '12345678998746', '123456RVI', '2012-11-28'),
(2, 'admin2', 'c84258e9c39059a89ab77d846ddab909', 'Admin2@gmail.com', 'Admin2', 'Male', 'TW-102', '+91 800070000', 'AB negative', '2015-08-31', '', 'Software', 'Web Developer', 'Information Technology', '2015-08-04 00:00:00', 'fujgyuigyut', 'uploads/250x250_1440479566-2053633788.png', 102, 1, 'User', 'active', '0000-00-00 00:00:00', 1, '', '', '', '', '', '2015-07-22'),
(3, 'employee1', '03a395eaf1edb673e0f99c7ca8eb156a', 'Employee1@gmail.com', 'Employee1', 'Male', 'TW-103', '+91 6777767777', 'AB positive', '2015-02-09', '', 'Software', 'Web Developer', 'Computer Science', '2015-03-25 00:00:00', 'weqwqw', 'uploads/250x250_1440479550-648967374.png', 103, 1, 'User', 'active', '0000-00-00 00:00:00', 1, '', '', '', '', '', '2015-01-22'),
(4, 'employee2', 'af74a83ae0d5777401f86af4df941e98', 'employee2@gmail.com', 'employee2', 'Male', 'TW-104', '+91 2000030000', 'A negative', '2014-06-19', '', 'Software', 'Web Developer', 'B.Tech IT', '2015-03-11 00:00:00', 'wxwxwxw', 'uploads/250x250_1440479739-90491132.png', 104, 1, 'User', 'active', '0000-00-00 00:00:00', 0, '', '', '', '', '', '2015-04-14'),
(5, 'manager', '1d0258c2440a8d19e716292b231e3190', 'manager@gmail.com', 'manager', 'Male', 'TW-105', '+91 2030405065', 'A negative', '2015-02-18', '', 'Software', 'Web Developer', 'erer', '2015-08-31 00:00:00', '43547yu5476u54w5tewykj', 'uploads/250x250_1440479819-206485292.png', 105, 1, 'manager', 'active', '0000-00-00 00:00:00', 0, '', '', '', '', '', '2015-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `users_history`
--

CREATE TABLE IF NOT EXISTS `users_history` (
  `h_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status_from` varchar(250) NOT NULL,
  `status_to` varchar(250) NOT NULL,
  `created_info` varchar(250) NOT NULL,
  PRIMARY KEY (`h_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users_history`
--

INSERT INTO `users_history` (`h_id`, `user_id`, `status_from`, `status_to`, `created_info`) VALUES
(1, 2, '', 'active', '25-Aug-2015'),
(2, 3, '', 'active', '25-Aug-2015'),
(3, 4, '', 'active', '25-Aug-2015'),
(4, 5, '', 'active', '25-Aug-2015');

-- --------------------------------------------------------

--
-- Table structure for table `user_leave_info`
--

CREATE TABLE IF NOT EXISTS `user_leave_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `carry_left` int(11) NOT NULL,
  `leave_taken` int(11) NOT NULL,
  `extra_leave` int(11) NOT NULL,
  `leave_month` varchar(250) NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `whitelist`
--

CREATE TABLE IF NOT EXISTS `whitelist` (
  `wid` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(200) NOT NULL,
  `added_date` varchar(255) NOT NULL,
  PRIMARY KEY (`wid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `work_report`
--

CREATE TABLE IF NOT EXISTS `work_report` (
  `w_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `emp_id` varchar(255) NOT NULL,
  `project_name` text NOT NULL,
  `type_of_work` varchar(255) NOT NULL,
  `time_of_work` varchar(255) NOT NULL,
  `total_time` varchar(50) NOT NULL,
  `comments` text NOT NULL,
  `report_date` varchar(50) NOT NULL,
  `total_records` varchar(255) NOT NULL,
  PRIMARY KEY (`w_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `work_report`
--

INSERT INTO `work_report` (`w_id`, `username`, `emp_id`, `project_name`, `type_of_work`, `time_of_work`, `total_time`, `comments`, `report_date`, `total_records`) VALUES
(1, 'admin2', '102', '1', '1', '08:00', '09:03', 'test', '25-Aug-2015', ''),
(2, 'admin2', '102', 'Break', '', '01:03', '09:03', '', '25-Aug-2015', ''),
(3, 'employee1', '103', 'Lunch', '', '00:59', '16:51', '', '25-Aug-2015', ''),
(4, 'employee1', '103', '2', '2', '09:00', '16:51', 'updates', '25-Aug-2015', ''),
(5, 'employee1', '103', 'Break', '', '06:52', '16:51', '', '25-Aug-2015', ''),
(6, 'employee2', '104', '3', '3', '05:02', '05:02', 'updates', '25-Aug-2015', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
