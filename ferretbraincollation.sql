-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2016 at 01:34 PM
-- Server version: 5.5.47-0ubuntu0.12.04.1
-- PHP Version: 5.3.10-1ubuntu3.21

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ferretbraincollation`
--

-- --------------------------------------------------------

--
-- Table structure for table `architecture`
--

CREATE TABLE IF NOT EXISTS `architecture` (
  `architecture_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `literature_id` int(10) unsigned NOT NULL,
  `brain_sites_id` int(10) unsigned NOT NULL,
  `layer_number` int(10) unsigned NOT NULL,
  `architecture_pdc` int(11) NOT NULL DEFAULT '1',
  `parameters_id` int(11) unsigned NOT NULL DEFAULT '1',
  `parameters_value` text,
  PRIMARY KEY (`architecture_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=116 ;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `authors_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `authors_name` varchar(255) DEFAULT NULL,
  `authors_surname` varchar(255) DEFAULT NULL,
  `authors_middleName` varchar(255) DEFAULT NULL COMMENT 'optional',
  PRIMARY KEY (`authors_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=29 AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Table structure for table `brain_maps`
--

CREATE TABLE IF NOT EXISTS `brain_maps` (
  `brain_maps_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `literature_id` varchar(255) DEFAULT NULL,
  `brain_maps_type` varchar(2) DEFAULT 'FF',
  `brain_maps_index` varchar(255) DEFAULT NULL,
  `reference_figures` varchar(250) NOT NULL DEFAULT '''''',
  `reference_text` varchar(250) NOT NULL DEFAULT '''''',
  `citation` text,
  `comments` text,
  PRIMARY KEY (`brain_maps_id`),
  UNIQUE KEY `literature_id` (`literature_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=40 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `brain_sites`
--

CREATE TABLE IF NOT EXISTS `brain_sites` (
  `brain_sites_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `brain_sites_index` varchar(255) DEFAULT NULL,
  `brain_sites_acronyms_id` int(11) NOT NULL,
  `brain_maps_id` int(11) DEFAULT NULL,
  `brain_sites_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`brain_sites_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=35 AUTO_INCREMENT=253 ;

-- --------------------------------------------------------

--
-- Table structure for table `brain_sites_classes`
--

CREATE TABLE IF NOT EXISTS `brain_sites_classes` (
  `brain_sites_classes_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `brain_sites_classes_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`brain_sites_classes_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=23 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `brain_sites_types`
--

CREATE TABLE IF NOT EXISTS `brain_sites_types` (
  `brain_sites_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `brain_sites_type_name` varchar(255) DEFAULT NULL,
  `brain_sites_type_desc` text,
  PRIMARY KEY (`brain_sites_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=170 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `brain_site_acronyms`
--

CREATE TABLE IF NOT EXISTS `brain_site_acronyms` (
  `brain_site_acronyms_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `acronym_name` varchar(255) DEFAULT NULL,
  `acronym_full_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`brain_site_acronyms_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=48 AUTO_INCREMENT=160 ;

-- --------------------------------------------------------

--
-- Table structure for table `coding_rules`
--

CREATE TABLE IF NOT EXISTS `coding_rules` (
  `coding_rules_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `coding_rules_name` varchar(255) DEFAULT NULL,
  `coding_rules_desc` text,
  PRIMARY KEY (`coding_rules_id`),
  UNIQUE KEY `coding_rules_name` (`coding_rules_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=4332 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `connectivity_cache`
--

CREATE TABLE IF NOT EXISTS `connectivity_cache` (
  `record_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `literature_id` int(11) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` int(11) NOT NULL DEFAULT '1',
  `content` longtext NOT NULL,
  PRIMARY KEY (`record_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `extension_codes`
--

CREATE TABLE IF NOT EXISTS `extension_codes` (
  `extension_codes_id` int(11) NOT NULL AUTO_INCREMENT,
  `extension_codes_name` varchar(1) DEFAULT NULL,
  `extension_codes_desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`extension_codes_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=49 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ferretdb_left_menu`
--

CREATE TABLE IF NOT EXISTS `ferretdb_left_menu` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_caption` varchar(255) DEFAULT NULL,
  `item_link` varchar(300) DEFAULT NULL,
  `item_type` int(11) NOT NULL DEFAULT '0',
  `item_mass` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `ferretdb_log`
--

CREATE TABLE IF NOT EXISTS `ferretdb_log` (
  `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `log_table_id` int(11) unsigned DEFAULT NULL,
  `log_action` int(11) DEFAULT NULL,
  `log_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `log_entry_id` int(11) unsigned DEFAULT NULL,
  `log_previous_data` text,
  `log_parameter` int(11) NOT NULL DEFAULT '0',
  `log_comment` text,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=25 AUTO_INCREMENT=971 ;

-- --------------------------------------------------------

--
-- Table structure for table `ferretdb_log_parameter`
--

CREATE TABLE IF NOT EXISTS `ferretdb_log_parameter` (
  `parameter_id` int(11) NOT NULL AUTO_INCREMENT,
  `parameter_name` varchar(255) NOT NULL,
  PRIMARY KEY (`parameter_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `ferretdb_news`
--

CREATE TABLE IF NOT EXISTS `ferretdb_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(255) NOT NULL DEFAULT 'No title',
  `news_text` text,
  `news_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `news_state` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `ferretdb_pages`
--

CREATE TABLE IF NOT EXISTS `ferretdb_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `page_content` text,
  `page_type` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page_name` (`page_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `ferretdb_tables_descriptions`
--

CREATE TABLE IF NOT EXISTS `ferretdb_tables_descriptions` (
  `tables_descriptions_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tables_descriptions_name` varchar(255) DEFAULT NULL,
  `tables_descriptions_desc` varchar(255) DEFAULT NULL,
  `tables_controller` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tables_descriptions_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=64 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `ferretdb_users`
--

CREATE TABLE IF NOT EXISTS `ferretdb_users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_surname` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `user_reg_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_class` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=88 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ferretdb_workflow`
--

CREATE TABLE IF NOT EXISTS `ferretdb_workflow` (
  `job_id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) NOT NULL,
  `literature_id` int(11) NOT NULL DEFAULT '0',
  `job_type` int(11) NOT NULL DEFAULT '0',
  `job_state` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `record_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`job_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `injections`
--

CREATE TABLE IF NOT EXISTS `injections` (
  `injections_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `injections_index` varchar(255) DEFAULT NULL,
  `methods_id` int(10) unsigned NOT NULL,
  `literature_id` varchar(255) DEFAULT NULL,
  `brain_sites_id` int(11) DEFAULT NULL,
  `PDC_site` varchar(255) DEFAULT NULL,
  `site_type` varchar(255) DEFAULT NULL,
  `injections_citation` text,
  `injections_refText` varchar(255) DEFAULT NULL,
  `injections_refFigures` varchar(255) DEFAULT NULL,
  `injections_hemisphere` varchar(255) DEFAULT NULL,
  `EC` int(11) unsigned DEFAULT NULL,
  `PDC_EC` int(11) unsigned DEFAULT NULL,
  `injection_volume` varchar(255) DEFAULT NULL,
  `injections_concentration` varchar(255) DEFAULT NULL,
  `injections_laminae` varchar(6) DEFAULT NULL,
  `PDC_laminae` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`injections_id`),
  UNIQUE KEY `injection_index` (`injections_index`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=964 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `injections_and_outcomes`
--

CREATE TABLE IF NOT EXISTS `injections_and_outcomes` (
  `relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `injections_id` int(11) NOT NULL DEFAULT '0',
  `outcome_id` int(11) NOT NULL DEFAULT '0',
  `literature_id` int(11) NOT NULL,
  PRIMARY KEY (`relation_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- Table structure for table `injections_data`
--

CREATE TABLE IF NOT EXISTS `injections_data` (
  `data_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `injections_id` int(11) NOT NULL,
  `literature_id` int(11) NOT NULL,
  `parameters_id` int(11) NOT NULL DEFAULT '1',
  `parameters_value` text,
  PRIMARY KEY (`data_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `injections_parameters`
--

CREATE TABLE IF NOT EXISTS `injections_parameters` (
  `parameters_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parameters_name` varchar(255) NOT NULL,
  `parameters_description` text NOT NULL,
  `parameters_type` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`parameters_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `labeling_outcome`
--

CREATE TABLE IF NOT EXISTS `labeling_outcome` (
  `outcome_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `literature_id` int(11) NOT NULL,
  `outcome_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`outcome_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `labelled_sites`
--

CREATE TABLE IF NOT EXISTS `labelled_sites` (
  `labelled_sites_id` int(11) NOT NULL AUTO_INCREMENT,
  `outcome_id` int(11) unsigned DEFAULT NULL,
  `brain_sites_id` int(11) unsigned DEFAULT NULL,
  `labelled_sites_type` varchar(255) DEFAULT NULL,
  `PDC_SITE` varchar(255) DEFAULT NULL,
  `EC` int(11) unsigned DEFAULT NULL,
  `PDC_EC` int(11) unsigned DEFAULT NULL,
  `labelled_sites_density` int(11) DEFAULT NULL,
  `PDC_DENSITY` int(11) DEFAULT NULL,
  `total_neurons_number` varchar(255) DEFAULT NULL,
  `percent_neurons_labeled` varchar(255) DEFAULT NULL,
  `labelled_sites_laminae` varchar(6) DEFAULT NULL,
  `PDC_LAMINAE` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`labelled_sites_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=40 AUTO_INCREMENT=203 ;

-- --------------------------------------------------------

--
-- Table structure for table `literature`
--

CREATE TABLE IF NOT EXISTS `literature` (
  `literature_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `literature_index` varchar(255) DEFAULT NULL COMMENT 'Surname(s) of author(s) plus the print year: exapmle ABC2012',
  `literature_title` varchar(255) DEFAULT NULL,
  `literature_year` varchar(4) DEFAULT NULL,
  `literature_source` varchar(255) DEFAULT NULL COMMENT 'Journal/Chapter/Book',
  `number_or_chapter` varchar(250) DEFAULT '',
  `page_number` varchar(250) DEFAULT '',
  `literature_abstract` text,
  `literature_physicalCopy` varchar(255) DEFAULT '0' COMMENT '0 - if none, else filename',
  `doi_id` varchar(250) DEFAULT NULL,
  `pubmed_id` varchar(250) DEFAULT '',
  `literature_comments` text,
  `literature_state` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`literature_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=1422 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Table structure for table `literature_abbreviations`
--

CREATE TABLE IF NOT EXISTS `literature_abbreviations` (
  `abbreviations_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `abbreviations_short` varchar(250) NOT NULL,
  `abbreviations_full` varchar(350) NOT NULL,
  PRIMARY KEY (`abbreviations_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `literature_and_authors`
--

CREATE TABLE IF NOT EXISTS `literature_and_authors` (
  `lna_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `literature_id` int(11) DEFAULT NULL,
  `authors_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`lna_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=13 AUTO_INCREMENT=297 ;

-- --------------------------------------------------------

--
-- Table structure for table `maps_relations`
--

CREATE TABLE IF NOT EXISTS `maps_relations` (
  `maps_relations_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `maps_relations_code` int(11) DEFAULT NULL COMMENT 'should be: I S L O C or E',
  `brain_sites_id_a` int(11) DEFAULT NULL,
  `brain_sites_id_b` int(11) DEFAULT NULL,
  `literature_id` int(11) DEFAULT NULL,
  `reference_text` varchar(255) DEFAULT NULL,
  `reference_figures` varchar(255) DEFAULT NULL,
  `PDC_RELATION` int(11) DEFAULT NULL,
  `citation` text,
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`maps_relations_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=52 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `methods`
--

CREATE TABLE IF NOT EXISTS `methods` (
  `methods_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `literature_id` int(10) unsigned NOT NULL,
  `reference_text` varchar(250) NOT NULL,
  `reference_figures` varchar(250) NOT NULL,
  `tracers_id` int(11) NOT NULL,
  `bilateral_use` varchar(100) NOT NULL,
  `injection_method` varchar(100) NOT NULL,
  `survival_time` varchar(100) NOT NULL,
  `section_thickness` varchar(100) NOT NULL,
  `number_of_sections` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`methods_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE IF NOT EXISTS `parameters` (
  `parameters_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parameters_name` varchar(200) NOT NULL,
  `description` text,
  `parameters_type` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`parameters_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `pdc`
--

CREATE TABLE IF NOT EXISTS `pdc` (
  `PDC_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `PDC_name` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`PDC_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=20 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `relation_codes`
--

CREATE TABLE IF NOT EXISTS `relation_codes` (
  `relation_codes_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `relation_codes_name` varchar(1) DEFAULT NULL,
  `relation_codes_desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`relation_codes_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=38 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `tracers`
--

CREATE TABLE IF NOT EXISTS `tracers` (
  `tracers_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracers_name` varchar(250) NOT NULL,
  `tracers_description` text NOT NULL,
  PRIMARY KEY (`tracers_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
