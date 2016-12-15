-- MySQL dump 10.11
--
-- Host: localhost    Database: phprojekt-mvc
-- ------------------------------------------------------
-- Server version    5.0.38-Ubuntu_0ubuntu1-log

BEGIN;

-- Drop table if exists
DROP TABLE IF EXISTS `timecard`;
DROP TABLE IF EXISTS `item_rights`;
DROP TABLE IF EXISTS `configuration`;
DROP TABLE IF EXISTS `note`;
DROP TABLE IF EXISTS `tags_modules`;
DROP TABLE IF EXISTS `tags_users`;
DROP TABLE IF EXISTS `tags`;
DROP TABLE IF EXISTS `tab_module_relation`;
DROP TABLE IF EXISTS `module_tab_relation`;
DROP TABLE IF EXISTS `tab`;
DROP TABLE IF EXISTS `search_words`;
DROP TABLE IF EXISTS `search_word_module`;
DROP TABLE IF EXISTS `search_display`;
DROP TABLE IF EXISTS `todo`;
DROP TABLE IF EXISTS `role_module_permissions`;
DROP TABLE IF EXISTS `project_user_role_relation`;
DROP TABLE IF EXISTS `project_role_user_permissions`;
DROP TABLE IF EXISTS `module_project_relation`;
DROP TABLE IF EXISTS `project_module_permissions`;
DROP TABLE IF EXISTS `project`;
DROP TABLE IF EXISTS `history`;
DROP TABLE IF EXISTS `groups_user_relation`;
DROP TABLE IF EXISTS `role`;
DROP TABLE IF EXISTS `groups`;
DROP TABLE IF EXISTS `user_setting`;
DROP TABLE IF EXISTS `setting`;
DROP TABLE IF EXISTS `module`;
DROP TABLE IF EXISTS `module_instance`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `database_manager`;
DROP TABLE IF EXISTS `calendar`;
DROP TABLE IF EXISTS `filemanager`;
DROP TABLE IF EXISTS `contact`;
DROP TABLE IF EXISTS `helpdesk`;
DROP TABLE IF EXISTS `minutes`;
DROP TABLE IF EXISTS `minutes_item`;
DROP TABLE IF EXISTS `test`;
DROP TABLE IF EXISTS `frontend_message`;

--
-- Table structure for table `database_manager`
--
CREATE TABLE `database_manager` (
  `id` int NOT NULL AUTO_INCREMENT,
  `table_name` varchar(50) default NULL,
  `table_field` varchar(60) default NULL,
  `form_tab` int(11) default NULL,
  `form_label` varchar(255) default NULL,
  `form_type` varchar(50) default NULL,
  `form_position` int(11) default NULL,
  `form_columns` int(11) default NULL,
  `form_regexp` varchar(255) default NULL,
  `form_range` text default NULL,
  `default_value` varchar(255) default NULL,
  `list_position` int(11) default NULL,
  `list_align` varchar(20) default NULL,
  `list_use_filter` int(4) default NULL,
  `alt_position` int(11) default NULL,
  `status` varchar(20) default NULL,
  `is_integer` int(4) default NULL,
  `is_required` int(4) default NULL,
  `is_unique` int(11) default NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `user`
--
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) default NULL,
  `lastname` varchar(255) default NULL,
  `status` varchar(1) default 'A',
  `admin` int(1) NOT NULL default 0,
  PRIMARY KEY(`id`),
  UNIQUE(`username`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `module`
--
-- save_type can be 0 for projects, 1 for global, 2 for both
--
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `save_type` int(1) NOT NULL default 0,
  `version` varchar(20) default NULL,
  `active` int(1) NOT NULL default 1,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `groups`
--
CREATE TABLE `groups` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255),
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `groups_user_relation`
--
CREATE TABLE `groups_user_relation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `groups_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `history`
--
CREATE TABLE `history` (
  `id` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `field` varchar(255) NOT NULL,
  `old_value` text default NULL,
  `new_value` text default NULL,
  `action` varchar(50) NOT NULL,
  `datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `project`
--
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) default NULL,
  `path` varchar(50) NOT NULL default '/',
  `title` varchar(255) NOT NULL,
  `notes` text default NULL,
  `owner_id` int(11) default NULL,
  `start_date` date default NULL,
  `end_date` date default NULL,
  `priority` int(11) default NULL,
  `current_status` int(2) NOT NULL default 2,
  `complete_percent` varchar(4) default NULL,
  `hourly_wage_rate` varchar(10) default NULL,
  `budget` varchar(10) default NULL,
  `contact_id` int(11) default NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `project_module_permissions`
--
CREATE TABLE `project_module_permissions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `module_id` int(11) NOT NULL,
    `project_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `role`
--
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent` int(11) default NULL,
  PRIMARY KEY(`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `project_role_user_permissions`
--
CREATE TABLE `project_role_user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `role_module_permissions`
--
CREATE TABLE `role_module_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `access` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `todo`
--
CREATE TABLE `todo` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `notes` text default NULL,
  `owner_id` int(11) default NULL,
  `project_id` int(11) NOT NULL,
  `start_date` date default NULL,
  `end_date` date default NULL,
  `priority` int(11) default NULL,
  `current_status` int(2) NOT NULL default 1,
  `user_id` int(11) default NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `setting`
--
CREATE TABLE `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `key_value` varchar(255) NOT NULL,
  `value` text default NULL,
  `identifier`  varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `search_words`
--
CREATE TABLE `search_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `search_word_module`
--
CREATE TABLE `search_word_module` (
  `module_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`,`module_id`,`word_id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `search_display`
--
CREATE TABLE `search_display` (
  `module_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `first_display` text,
  `second_display` text,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`item_id`,`module_id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `tags`
--
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `word` varchar(255) NOT NULL,
  `crc32` bigint NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `tags_users`
--
CREATE TABLE `tags_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `tags_modules`
--
CREATE TABLE `tags_modules` (
  `module_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `tag_user_id` int(11) NOT NULL,
  PRIMARY KEY (`module_id`, `item_id`, `tag_user_id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `tab`
--
CREATE TABLE `tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `module_tab_relation`
--
CREATE TABLE `module_tab_relation` (
  `tab_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`tab_id`, `module_id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `note`
--
CREATE TABLE `note` (
  `id` int(11) NOT NULL auto_increment,
  `project_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `comments` text default NULL,
  `owner_id` int(11) default NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `configuration`
--
CREATE TABLE `configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `key_value` varchar(255) NOT NULL,
  `value` text default NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `item_rights`
--
CREATE TABLE `item_rights` (
  `module_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `access` int(3) NOT NULL,
  PRIMARY KEY (`module_id`,`item_id`,`user_id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `timecard`
--
CREATE TABLE `timecard` (
  `id` int(11) NOT NULL auto_increment,
  `owner_id` int(11) default NULL,
  `start_datetime` datetime default NULL,
  `end_time` time default NULL,
  `minutes` int(11) default NULL,
  `project_id` int(11) default NULL,
  `notes` text default NULL,
  `module_id` int(11) default 1,
  `item_id` int(11) default NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `calendar`
--
CREATE TABLE `calendar` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) default 0,
  `owner_id` int(11) default NULL,
  `project_id` int(11) NOT NULL,
  `title` varchar(255) default NULL,
  `place` varchar(255) default NULL,
  `notes` text default NULL,
  `start_datetime` datetime default NULL,
  `end_datetime` datetime default NULL,
  `status` int(1) default 0,
  `rrule` text default NULL,
  `visibility` int(1) default 0,
  `participant_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `filemanager`
--
CREATE TABLE `filemanager` (
  `id` int(11) NOT NULL auto_increment,
  `owner_id` int(11) default NULL,
  `title` varchar(100) NOT NULL,
  `comments` text default NULL,
  `project_id` int(11) NOT NULL,
  `files` text NOT NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `contact`
--
CREATE TABLE `contact` (
  `id` int(11) NOT NULL auto_increment,
  `owner_id` int(11) default NULL,
  `project_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `firstphone` varchar(255) NOT NULL,
  `secondphone` varchar(255) NOT NULL,
  `mobilephone` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zipcode` varchar(50) NOT NULL,
  `country` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `private` int(1) default 0,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;


--
-- Table structure for table `helpdesk`
--
CREATE TABLE `helpdesk` (
  `id` int(11) NOT NULL auto_increment,
  `owner_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `assigned` int(11) default NULL,
  `date` date default NULL,
  `project_id` int(11) NOT NULL,
  `priority` int(2) default NULL,
  `attachments` text default NULL,
  `description` text default NULL,
  `status` int(2) default NULL,
  `due_date` date default NULL,
  `author` int(11) default NULL,
  `solved_by` int(11) default NULL,
  `solved_date` date default NULL,
  `contact_id` int(11) default NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Table structure for table `minutes`
--
CREATE TABLE IF NOT EXISTS `minutes` (
  `id` int(11) NOT NULL auto_increment,
  `owner_id` int(11) default NULL,
  `project_id` int(11) default NULL,
  `title` varchar(255) default NULL,
  `description` text,
  `meeting_datetime` datetime default NULL,
  `end_time` time default NULL,
  `place` varchar(255) default NULL,
  `moderator` varchar(255) default NULL,
  `participants_invited` text,
  `participants_attending` text,
  `participants_excused` text,
  `item_status` int(11) default NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Table structure for table `minutes_item`
--
CREATE TABLE `minutes_item` (
  `id` int(11) NOT NULL auto_increment,
  `owner_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `minutes_id` int(11) NOT NULL,
  `topic_type` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `topic_date` date default NULL,
  `user_id` int(11) default NULL,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Table structure for table `module_instance`
--
CREATE TABLE `module_instance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) default NULL,
  `module` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE  `frontend_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `process` varchar(255) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `valid_until` datetime NOT NULL,
  `valid_from` datetime NOT NULL,
  `description` text,
  `delivered` int(3) NOT NULL DEFAULT '0',
  `details` text,
  PRIMARY KEY (`id`)
) CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- INSERT DATA
--

INSERT INTO `module` (`id`, `name`, `label`, `save_type`, `version`, `active`) VALUES
(1, 'Project', 'Project', 0, '6.0.0', 1),
(2, 'Todo', 'Todo', 0, '6.0.0', 1),
(3, 'Note', 'Note', 0, '6.0.0', 1),
(4, 'Timecard', 'Timecard', 1, '6.0.0', 1),
(5, 'Calendar', 'Calendar', 1, '6.0.0', 1),
(6, 'Gantt', 'Gantt', 0, '6.0.0', 1),
(7, 'Filemanager', 'Filemanager', 0, '6.0.0', 1),
(8, 'Statistic', 'Statistic', 0, '6.0.0', 1),
(9, 'Contact', 'Contact', 1, '6.0.0', 1),
(10, 'Helpdesk', 'Helpdesk', 0, '6.0.0', 1),
(11, 'Minutes','Minute', 0, '6.0.0', 1);

INSERT INTO `database_manager` (`id`, `table_name`, `table_field`, `form_tab`, `form_label`, `form_type`, `form_position`, `form_columns`, `form_regexp`, `form_range`, `default_value`, `list_position`, `list_align`, `list_use_filter`, `alt_position`, `status`, `is_integer`, `is_required`, `is_unique`) VALUES
(1, 'Project', 'title', 1, 'Title', 'text', 1, 1, NULL, NULL, NULL, 1, 'left', 1, 2, '1', 0, 1, 0),
(2, 'Project', 'notes', 1, 'Notes', 'textarea', 2, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(3, 'Project', 'project_id', 1, 'Parent', 'selectValues', 3, 1, NULL, 'Project#id#title', NULL, 0, NULL, 1, 0, '1', 1, 1, 0),
(4, 'Project', 'start_date', 1, 'Start date', 'date', 4, 1, NULL, NULL, NULL, 3, 'center', 1, 3, '1', 0, 0, 0),
(5, 'Project', 'end_date', 1, 'End date', 'date', 5, 1, NULL, NULL, NULL, 4, 'center', 1, 4, '1', 0, 0, 0),
(6, 'Project', 'priority', 1, 'Priority', 'rating', 6, 1, NULL, '10', '5', 5, 'center', 1, 5, '1', 1, 0, 0),
(7, 'Project', 'current_status', 1, 'Current status', 'selectValues', 7, 1, NULL, '1#Offered|2#Ordered|3#Working|4#Ended|5#Stopped|6#Re-Opened|7#Waiting', '1', 6, 'center', 1, 6, '1', 1, 0, 0),
(8, 'Project', 'complete_percent', 1, 'Complete percent', 'percentage', 8, 1, NULL, NULL, NULL, 7, 'center', 1, 7, '1', 0, 0, 0),
(9, 'Project', 'budget', 1, 'Budget', 'text', 9, 1, NULL, NULL, NULL, 0, NULL, 1, 8, '1', 0, 0, 0),
(10, 'Project', 'hourly_wage_rate', 1, 'Hourly wage rate', 'text', 10, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '0', 0, 0, 0),
(11, 'Project', 'contact_id', 1, 'Contact', 'selectValues', 11, 1, NULL, 'Contact#id#name', NULL, 0, NULL, 1, 9, '1', 1, 0, 0),

(12, 'Todo', 'title', 1, 'Title', 'text', 1, 1, NULL, NULL, NULL, 1, 'left', 1, 2, '1', 0, 1, 0),
(13, 'Todo', 'notes', 1, 'Notes', 'textarea', 2, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(14, 'Todo', 'start_date', 1, 'Start date', 'date', 4, 1, NULL, NULL, NULL, 3, 'center', 1, 3, '1', 0, 0, 0),
(15, 'Todo', 'end_date', 1, 'End date', 'date', 5, 1, NULL, NULL, NULL   , 4, 'center', 1, 4, '1', 0, 0, 0),
(16, 'Todo', 'priority', 1, 'Priority', 'rating', 6, 1, NULL, '10', '5', 5, 'center', 1, 5, '1', 1, 0, 0),
(17, 'Todo', 'current_status', 1, 'Current status', 'selectValues', 7, 1, NULL, '1#Waiting|2#Accepted|3#Working|4#Stopped|5#Ended', '1', 7, 'center', 1, 6, '1', 1, 0, 0),
(18, 'Todo', 'project_id', 1, 'Project', 'selectValues', 3, 1, NULL, 'Project#id#title', NULL, 0, NULL, 1, 0, '1', 1, 1, 0),
(19, 'Todo', 'user_id', 1, 'User', 'selectValues', 8, 1, NULL, 'User#id#lastname', NULL  , 6, 'left', 1, 7, '1', 1, 0, 0),

(20, 'Note', 'project_id', 1, 'Project', 'selectValues', 3, 1, NULL, 'Project#id#title', NULL, 0, NULL, 1, 0, '1', 1, 1, 0),
(21, 'Note', 'title', 1, 'Title', 'text', 1, 1, NULL, NULL, '', 1, 'left', 1, 2, '1', 0, 1, 0),
(22, 'Note', 'comments', 1, 'Comments', 'textarea', 2, 1, NULL, NULL, '', 0, NULL, 1, 0, '1', 0, 0, 0),

(23, 'Calendar', 'title', 1, 'Title', 'text', 1, 1, NULL, NULL, NULL, 1, 'left', 1, 2, '1', 0, 1, 0),
(24, 'Calendar', 'place', 1, 'Place', 'text', 2, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(25, 'Calendar', 'notes', 1, 'Notes', 'textarea', 3, 2, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(26, 'Calendar', 'start_datetime', 1, 'Start', 'datetime', 4, 1, NULL, NULL, NULL, 2, 'center', 1, 3, '1', 0, 1, 0),
(27, 'Calendar', 'end_datetime', 1, 'End', 'datetime', 5, 1, NULL, NULL, NULL, 4, 'center', 1, 0, '1', 0, 1, 0),
(28, 'Calendar', 'visibility', 1, 'Visibility', 'selectValues', 6, 1, NULL, '0#Public|1#Private', 0, 0, NULL, 1, 0, '1', 1, 0, 0),
(29, 'Calendar', 'status', 1, 'Status', 'selectValues', 7, 1, NULL, '0#Pending|1#Accepted|2#Rejected', 1, 7, 'left', 1, 0, '1', 1, 0, 0),
(30, 'Calendar', 'participant_id', 1, 'Participant', 'hidden', 8, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 1, 1, 0),
(31, 'Calendar', 'rrule', 1, 'Rrule', 'hidden', 9, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),

(32, 'Filemanager', 'title', 1, 'Title', 'text', 1, 1, NULL, NULL, NULL, 1, 'center', 1, 0, '1', 0, 1, 0),
(33, 'Filemanager', 'comments', 1, 'Comments', 'textarea', 2, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(34, 'Filemanager', 'project_id', 1, 'Project', 'selectValues', 3, 1, NULL, 'Project#id#title', NULL, 0, NULL, 1, 0, '1', 1, 1, 0),
(35, 'Filemanager', 'files', 1, 'Upload', 'upload', 5, 1, NULL, NULL, NULL, 3, 'center', 1, 0, '1', 0, 1, 0),

(36, 'Contact', 'name', 1, 'Name', 'text', 1, 1, NULL, NULL, NULL, 1, 'left', 1, 0, '1', 0, 1, 0),
(37, 'Contact', 'email', 1, 'E-Mail', 'text', 2, 1, NULL, NULL, NULL, 2, 'left', 1, 0, '1', 0, 0, 0),
(38, 'Contact', 'company', 1, 'Company', 'text', 3, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(39, 'Contact', 'firstphone', 1, 'First phone', 'text', 4, 1, NULL, NULL, NULL,  3, 'left', 1, 0, '1', 0, 0, 0),
(40, 'Contact', 'secondphone', 1, 'Second phone', 'text', 5, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(41, 'Contact', 'mobilephone', 1, 'Mobile phone', 'text', 6, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(42, 'Contact', 'street', 1, 'Street', 'text', 7, 1, NULL, NULL, NULL, 4, 'left', 1, 0, '1', 0, 0, 0),
(43, 'Contact', 'city', 1, 'City', 'text', 8, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(44, 'Contact', 'zipcode', 1, 'Zip Code', 'text', 9, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(45, 'Contact', 'country', 1, 'Country', 'text', 10, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(46, 'Contact', 'comment', 1, 'Comment', 'textarea', 11, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(47, 'Contact', 'private', 1, 'Private', 'selectValues', 12, 1, NULL, '0#No|1#Yes', '0', 5, 'center', 1, 0, '1', 1, 0, 0),

(48, 'Helpdesk', 'title', 1, 'Title', 'text', 1, 1, NULL, NULL, NULL, 1, 'center', 1, 0, '1', 0, 1, 0),
(49, 'Helpdesk', 'assigned', 1, 'Assigned', 'selectValues', 3, 1, NULL, 'User#id#lastname', NULL, 4, 'center', 1, 0, '1', 1, 0, 0),
(50, 'Helpdesk', 'date', 1, 'Date', 'display', 4, 1, NULL, NULL, NULL, 2, 'center', 1, 0, '1', 0, 1, 0),
(51, 'Helpdesk', 'project_id', 1, 'Project', 'selectValues', 6, 1, NULL, 'Project#id#title', NULL, 0, NULL, 1, 0, '1', 1, 1, 0),
(52, 'Helpdesk', 'priority', 1, 'Priority', 'rating', 7, 1, NULL, '10', '5', 5, 'center', 1, 0, '1', 1, 0, 0),
(53, 'Helpdesk', 'attachments', 1, 'Attachments', 'upload', 8, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(54, 'Helpdesk', 'description', 1, 'Description', 'textarea', 11, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(55, 'Helpdesk', 'status', 1, 'Status', 'selectValues', 12, 1, NULL, '1#Open|2#Assigned|3#Solved|4#Verified|5#Closed', '1', 6, 'center', 1, 0, '1', 1, 1, 0),
(56, 'Helpdesk', 'due_date', 1, 'Due date', 'date', 5, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(57, 'Helpdesk', 'author', 1, 'Author', 'display', 2, 1, NULL, 'User#id#lastname', NULL, 3, 'center', 1, 0, '1', 1, 1, 0),
(58, 'Helpdesk', 'solved_by', 1, 'Solved by', 'display', 9, 1, NULL, 'User#id#lastname', NULL, 0, NULL, 1, 0, '1', 1, 0, 0),
(59, 'Helpdesk', 'solved_date', 1, 'Solved date', 'display', 10, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(60, 'Helpdesk', 'contact_id', 1, 'Contact', 'selectValues', 13, 1, NULL, 'Contact#id#name', NULL, 0, NULL, 1, 0, '1', 1, 0, 0),

(61, 'Minutes', 'title', 1, 'Title', 'text', 1, 1, NULL, NULL, NULL, 3, 'center', 1, 0, '1', 0, 1, 0),
(62, 'Minutes', 'meeting_datetime', 1, 'Start', 'datetime', 2, 1, NULL, NULL, NULL, 1, 'center', 1, 0, '1', 0, 1, 0),
(63, 'Minutes', 'end_time', 1, 'End', 'time', 3, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(64, 'Minutes', 'project_id', 1, 'Project', 'selectValues', 4, 1, NULL, 'Project#id#title', NULL, 0, NULL, 1, 0, '1', 1, 1, 0),
(65, 'Minutes', 'description', 1, 'Description', 'textarea', 5, 1, NULL, NULL, NULL, 4, 'center', 1, 0, '1', 0, 0, 0),
(66, 'Minutes', 'place', 1, 'Place', 'text', 6, 1, NULL, NULL, NULL, 5, 'center', 1, 0, '1', 0, 0, 0),
(67, 'Minutes', 'moderator', 1, 'Moderator', 'text', 7, 1, NULL, NULL, NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(68, 'Minutes', 'participants_invited', 2, 'Invited', 'multipleSelectValues', 8, 1, NULL, 'User#id#username', NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(69, 'Minutes', 'participants_attending', 2, 'Attending', 'multipleSelectValues', 9, 1, NULL, 'User#id#username', NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(70, 'Minutes', 'participants_excused', 2, 'Excused', 'multipleSelectValues', 10, 1, NULL, 'User#id#username', NULL, 0, NULL, 1, 0, '1', 0, 0, 0),
(71, 'Minutes', 'item_status', 1, 'Status', 'selectValues', 11, 1, NULL, '1#Planned|2#Empty|3#Filled|4#Final', '1', 6, 'center', 1, 0, '1', 1, 0, 0);


INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `status`, `admin`) VALUES
(1,'david', 'David', 'Soria Parra', 'A', 1),
(2,'gus', 'Gustavo', 'Solt', 'A', 0),
(3,'inactive', NULL, NULL, 'I', 0);

INSERT INTO `setting` (`id`, `user_id`, `module_id`, `key_value`, `value`, `identifier`) VALUES
(1, 1, 0, 'password','156c3239dbfa5c5222b51514e9d12948', 'Core'),
(2, 1, 0, 'email','david@example.com', 'Core'),
(3, 1, 0, 'language','en', 'Core'),
(4, 1, 0, 'timeZone','2', 'Core'),
(5, 1, 0, 'datarecords','1', 'Notification'),
(6, 1, 0, 'loginlogout','1', 'Notification'),
(7, 2, 0, 'password','156c3239dbfa5c5222b51514e9d12948', 'Core'),
(8, 2, 0, 'email','gus@example.com', 'Core'),
(9, 2, 0, 'language','en', 'Core'),
(10, 2, 0, 'timeZone','2', 'Core'),
(11, 2, 0, 'datarecords','1', 'Notification'),
(12, 2, 0, 'loginlogout','1', 'Notification'),
(13, 3, 0, 'password','156c3239dbfa5c5222b51514e9d12948', 'Core'),
(14, 3, 0, 'email','test@example.com', 'Core'),
(15, 3, 0, 'language','en', 'Core'),
(16, 3, 0, 'timeZone','2', 'Core'),
(17, 3, 0, 'datarecords','1', 'Notification'),
(18, 3, 0, 'loginlogout','1', 'Notification');

INSERT INTO `project` (`id`, `project_id`, `path`, `title`, `notes`, `owner_id`, `start_date`, `end_date`, `priority`, `current_status`, `complete_percent`, `hourly_wage_rate`, `budget`) VALUES
(1,NULL,'/','Invisible Root','',1,NULL,NULL,NULL,1,0,NULL,NULL),
(2,1,'/1/','Project 1','',1,'2009-06-01','2009-10-31',NULL,1,0,NULL,NULL),
(3,1,'/1/','Project 2','',2,NULL,NULL,NULL,1,0,NULL,NULL),
(4,2,'/1/2/','Sub Project','',1,'2009-06-01','2009-07-31',NULL,1,0,NULL,NULL),
(5,2,'/1/2/','Test Project','Test note',1,'2009-08-01','2009-10-31',NULL,2,0,NULL,NULL),
(6,4,'/1/2/4/','Sub Sub Project 1','',1,'2009-06-01','2009-06-30',NULL,1,0,NULL,NULL),
(7,4,'/1/2/4/','Sub Sub Project 2','',1,'2009-07-01','2009-07-31',NULL,1,0,NULL,NULL);

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'default'),
(2, 'ninatest'),
(3, 'ninasgruppe'),
(4, 'testgruppe');

INSERT INTO `role` (`id`, `name`, `parent`) VALUES
(1, 'admin', 0);

INSERT INTO `groups_user_relation` (`id`, `groups_id`, `user_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 1);

INSERT INTO `project_role_user_permissions` (`project_id`, `user_id`, `role_id`) VALUES
(1, 1, 1);

INSERT INTO `role_module_permissions` (`role_id`, `module_id`, `access`) VALUES
(1, 1, 139),
(1, 2, 139),
(1, 3, 139),
(1, 6, 139),
(1, 7, 139),
(1, 10, 139),
(1, 11, 139);

INSERT INTO `item_rights` (`module_id`, `item_id`, `user_id`, `access`) VALUES
(1, 1, 1, 255),
(1, 1, 2, 255),
(1, 1, 3, 255),
(1, 2, 1, 255),
(1, 2, 3, 255),
(1, 4, 1, 255),
(1, 4, 3, 255),
(1, 5, 1, 255),
(1, 5, 3, 255),
(1, 6, 1, 255),
(1, 7, 1, 255),
(1, 8, 1, 255),
(1, 9, 1, 255),
(1, 10, 1, 255),
(1, 11, 1, 255),
(4, 1, 1, 255),
(4, 2, 1, 255),
(4, 3, 1, 255),
(4, 4, 1, 255),
(4, 5, 1, 255),
(4, 6, 1, 255),
(2, 1, 1, 255),
(2, 1, 3, 255);

INSERT INTO `todo` (`id`, `title`, `notes`, `owner_id`, `project_id`, `start_date`, `end_date`, `priority`, `current_status`) VALUES
(1,'Todo of Test Project','',1,1,'2007-12-12','2007-12-31',0,1);

INSERT INTO `timecard` (`id`, `owner_id`, `start_datetime`, `end_time`, `minutes`, `project_id`, `notes`, `module_id`, `item_id`) VALUES
(1, 1, '2008-04-29 08:00:00', '13:00:00', 300, 1, 'TEST', 1, NULL),
(2, 1, '2008-04-29 14:00:00', '18:00:00', 240, 2, 'TEST', 1, NULL),
(3, 1, '2008-04-30 08:00:00', '13:00:00', 300, 1, 'TEST', 1, NULL),
(4, 1, '2008-04-30 14:00:00', '18:00:00', 240, 1, 'TEST', 1, NULL),
(5, 1, '2008-05-02 08:00:00', '13:00:00', 300, 2, 'TEST', 1, NULL),
(6, 1, '2008-05-02 14:00:00', '18:00:00', 240, 1, 'TEST', 1, NULL);

INSERT INTO `tags` (`id`, `word`, `crc32`) VALUES
(1,'this',-17923545),
(2,'todo',1510913696);

INSERT INTO `tags_users` (`id`, `user_id`, `tag_id`) VALUES
(1, 1, 1),
(2, 1, 2);

INSERT INTO `tags_modules` (`module_id`, `item_id`, `tag_user_id`) VALUES
(1, 1, 1);

INSERT INTO `module_instance` VALUES
(1,5,'Task','Developer Tasks'),
(2,5,'Tasks','Project Tasks');

INSERT INTO `project_module_permissions` (`module_id`, `project_id`) VALUES
(1,1),
(2,1),
(3,1),
(4,1),
(5,1),
(7,1),
(10,1),
(1,2),
(2,2),
(3,2),
(4,2),
(5,2),
(7,2),
(1,3),
(2,3),
(3,3),
(4,3),
(5,3),
(1,4),
(2,4),
(3,4),
(4,4),
(5,4),
(1,5),
(2,5),
(3,5),
(4,5),
(5,5),
(1,6),
(2,6),
(3,6),
(4,6),
(5,6),
(1,7),
(2,7),
(3,7),
(4,7),
(5,7),
(11,1);

INSERT INTO `search_words` (`id`, `word`, `count`) VALUES
(1, 'NOTE', 1);

INSERT INTO `search_word_module` (`module_id`, `item_id`, `word_id`) VALUES
(1, 1, 1);

INSERT INTO `search_display` (`module_id`, `item_id`, `first_display`, `project_id`) VALUES
(1, 1, 'test', 1);

INSERT INTO `tab` (`id`, `label` ) VALUES
(1, 'Basic Data');

COMMIT;
