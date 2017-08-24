# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.19)
# Database: lurdes_bot2
# Generation Time: 2017-08-24 18:35:32 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table champions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `champions`;

CREATE TABLE `champions` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `champ_key` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table champions_play_tips
# ------------------------------------------------------------

DROP TABLE IF EXISTS `champions_play_tips`;

CREATE TABLE `champions_play_tips` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `champion` int(11) unsigned DEFAULT NULL,
  `tip` text,
  `for_team` enum('A','E') NOT NULL DEFAULT 'A',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `champion` (`champion`),
  CONSTRAINT `champions_play_tips_ibfk_1` FOREIGN KEY (`champion`) REFERENCES `champions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) DEFAULT '0',
  `discord_command_identifier` char(2) DEFAULT NULL,
  `discord_bot_id` varchar(300) DEFAULT NULL,
  `discord_bot_permissions` int(11) DEFAULT NULL,
  `discord_bot_token` varchar(300) DEFAULT NULL,
  `discord_text_webhook` varchar(300) DEFAULT NULL,
  `riot_api_key` varchar(300) DEFAULT NULL,
  `color_ally_team` int(11) DEFAULT NULL,
  `color_enemy_team` int(11) DEFAULT NULL,
  `lol_version` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table discord_guilds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `discord_guilds`;

CREATE TABLE `discord_guilds` (
  `id` varchar(25) NOT NULL DEFAULT '',
  `name` varchar(40) DEFAULT '',
  `icon` varchar(200) DEFAULT NULL,
  `ownerId` varchar(25) DEFAULT '',
  `member_count` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table discord_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `discord_users`;

CREATE TABLE `discord_users` (
  `id` varchar(25) NOT NULL DEFAULT '',
  `lolSummonerName` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table lol_version
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lol_version`;

CREATE TABLE `lol_version` (
  `current_version` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`current_version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table music_playlist_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `music_playlist_status`;

CREATE TABLE `music_playlist_status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `discordChannel` varchar(40) DEFAULT NULL,
  `music` int(11) unsigned DEFAULT NULL,
  `status` enum('PLAYING','PAUSED','FINISHED') NOT NULL DEFAULT 'PAUSED',
  PRIMARY KEY (`id`),
  UNIQUE KEY `discordChannel` (`discordChannel`,`music`),
  KEY `music` (`music`),
  CONSTRAINT `music_playlist_status_ibfk_1` FOREIGN KEY (`music`) REFERENCES `music_playlists` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table music_playlists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `music_playlists`;

CREATE TABLE `music_playlists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `discordGuild` varchar(40) DEFAULT NULL,
  `discordChannel` varchar(40) DEFAULT NULL,
  `discordUser` varchar(30) DEFAULT NULL,
  `source` enum('Y') NOT NULL DEFAULT 'Y',
  `sourceUrl` varchar(200) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `isTemp` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table musics_djs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `musics_djs`;

CREATE TABLE `musics_djs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `discordGuildId` varchar(30) NOT NULL DEFAULT '',
  `discordUserId` varchar(30) NOT NULL DEFAULT '',
  `discordTextChannelId` varchar(30) NOT NULL DEFAULT '',
  `discordVoiceChannelId` varchar(30) NOT NULL DEFAULT '',
  `bitrate` int(11) NOT NULL,
  `currentTrack` int(10) unsigned DEFAULT NULL,
  `currentPlaylist` int(11) unsigned DEFAULT NULL,
  `djStatus` enum('PLAYING','PAUSED','FINISHED') NOT NULL DEFAULT 'PAUSED',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table runes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `runes`;

CREATE TABLE `runes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `image` varchar(50) DEFAULT NULL,
  `image_sprite` varchar(50) DEFAULT NULL,
  `rune_type` varchar(50) DEFAULT NULL,
  `rune_tier` int(11) DEFAULT NULL,
  `stats_key` varchar(100) DEFAULT NULL,
  `stats_value` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table spells
# ------------------------------------------------------------

DROP TABLE IF EXISTS `spells`;

CREATE TABLE `spells` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `image_sprite` varchar(50) DEFAULT NULL,
  `summoner_level` int(11) DEFAULT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table summoners
# ------------------------------------------------------------

DROP TABLE IF EXISTS `summoners`;

CREATE TABLE `summoners` (
  `id` int(11) NOT NULL,
  `nickname` varchar(80) DEFAULT NULL,
  `account_id` bigint(20) DEFAULT NULL,
  `profile_icon_id` int(11) DEFAULT NULL,
  `revision_date` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
