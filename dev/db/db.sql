SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `MatchTracker` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `MatchTracker` ;

-- -----------------------------------------------------
-- Table `MatchTracker`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`users` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(255) NOT NULL ,
  `username_canonical` VARCHAR(255) NOT NULL ,
  `firstname` VARCHAR(255) NULL DEFAULT NULL ,
  `lastname` VARCHAR(255) NULL DEFAULT NULL ,
  `facebookId` VARCHAR(255) NULL DEFAULT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `email_canonical` VARCHAR(255) NOT NULL ,
  `enabled` TINYINT(1) NOT NULL ,
  `salt` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `last_login` DATETIME NULL DEFAULT NULL ,
  `locked` TINYINT(1) NOT NULL ,
  `expired` TINYINT(1) NOT NULL ,
  `expires_at` DATETIME NULL DEFAULT NULL ,
  `confirmation_token` VARCHAR(255) NULL DEFAULT NULL ,
  `password_requested_at` DATETIME NULL DEFAULT NULL ,
  `roles` LONGTEXT NOT NULL COMMENT '(DC2Type:array)' ,
  `credentials_expired` TINYINT(1) NOT NULL ,
  `credentials_expire_at` DATETIME NULL DEFAULT NULL ,
  `twitterID` VARCHAR(255) NULL DEFAULT NULL ,
  `twitter_username` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `UNIQ_957A647992FC23A8` (`username_canonical` ASC) ,
  UNIQUE INDEX `UNIQ_957A6479A0D96FBF` (`email_canonical` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`sports`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`sports` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`sports` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`sport_types`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`sport_types` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`sport_types` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `players_on_field` INT NULL ,
  `sports_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sport_types_sports1` (`sports_id` ASC) ,
  CONSTRAINT `fk_sport_types_sports1`
    FOREIGN KEY (`sports_id` )
    REFERENCES `MatchTracker`.`sports` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`leagues`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`leagues` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`leagues` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `user_id` INT NOT NULL ,
  `fields` INT NULL ,
  `description` TEXT NULL ,
  `number_of_teams` INT NULL ,
  `startdate` DATE NULL ,
  `enddate` DATE NULL ,
  `players_on_field` INT NULL ,
  `place` VARCHAR(255) NULL ,
  `sport_types_id` INT NOT NULL ,
  `return` TINYINT(1)  NULL ,
  `groups` INT NULL ,
  `goesOn` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_leagues_users1` (`user_id` ASC) ,
  INDEX `fk_leagues_sport_types1` (`sport_types_id` ASC) ,
  CONSTRAINT `fk_leagues_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `MatchTracker`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_leagues_sport_types1`
    FOREIGN KEY (`sport_types_id` )
    REFERENCES `MatchTracker`.`sport_types` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`teams`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`teams` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`teams` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `users_id` INT NOT NULL ,
  `gameday` VARCHAR(45) NULL ,
  `gamehour` VARCHAR(45) NULL ,
  `gameplace` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_teams_users1` (`users_id` ASC) ,
  CONSTRAINT `fk_teams_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `MatchTracker`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`players`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`players` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`players` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(65) NULL ,
  `age` INT NULL ,
  `teams_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_players_teams` (`teams_id` ASC) ,
  CONSTRAINT `fk_players_teams`
    FOREIGN KEY (`teams_id` )
    REFERENCES `MatchTracker`.`teams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`leagues_has_teams`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`leagues_has_teams` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`leagues_has_teams` (
  `leagues_id` INT NOT NULL ,
  `teams_id` INT NOT NULL ,
  PRIMARY KEY (`leagues_id`, `teams_id`) ,
  INDEX `fk_leagues_has_teams_teams1` (`teams_id` ASC) ,
  INDEX `fk_leagues_has_teams_leagues1` (`leagues_id` ASC) ,
  CONSTRAINT `fk_leagues_has_teams_leagues1`
    FOREIGN KEY (`leagues_id` )
    REFERENCES `MatchTracker`.`leagues` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_leagues_has_teams_teams1`
    FOREIGN KEY (`teams_id` )
    REFERENCES `MatchTracker`.`teams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`matches`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`matches` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`matches` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `home_team` INT NOT NULL ,
  `away_team` INT NOT NULL ,
  `date` DATETIME NULL ,
  `start_time` DATETIME NULL ,
  `leagues_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_matches_teams1` (`home_team` ASC) ,
  INDEX `fk_matches_teams2` (`away_team` ASC) ,
  INDEX `fk_matches_leagues1` (`leagues_id` ASC) ,
  CONSTRAINT `fk_matches_teams1`
    FOREIGN KEY (`home_team` )
    REFERENCES `MatchTracker`.`teams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matches_teams2`
    FOREIGN KEY (`away_team` )
    REFERENCES `MatchTracker`.`teams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matches_leagues1`
    FOREIGN KEY (`leagues_id` )
    REFERENCES `MatchTracker`.`leagues` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`match_events`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`match_events` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`match_events` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `text` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`matches_has_match_events`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`matches_has_match_events` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`matches_has_match_events` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `matches_id` INT NOT NULL ,
  `match_events_id` INT NOT NULL ,
  `players_id` INT NOT NULL ,
  `teams_id` INT NOT NULL ,
  `time` DATETIME NULL ,
  INDEX `fk_matches_has_match_events_match_events1` (`match_events_id` ASC) ,
  INDEX `fk_matches_has_match_events_matches1` (`matches_id` ASC) ,
  INDEX `fk_matches_has_match_events_players1` (`players_id` ASC) ,
  INDEX `fk_matches_has_match_events_teams1` (`teams_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_matches_has_match_events_matches1`
    FOREIGN KEY (`matches_id` )
    REFERENCES `MatchTracker`.`matches` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matches_has_match_events_match_events1`
    FOREIGN KEY (`match_events_id` )
    REFERENCES `MatchTracker`.`match_events` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matches_has_match_events_players1`
    FOREIGN KEY (`players_id` )
    REFERENCES `MatchTracker`.`players` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matches_has_match_events_teams1`
    FOREIGN KEY (`teams_id` )
    REFERENCES `MatchTracker`.`teams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`messages` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`messages` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `text` TEXT NULL ,
  `receiver_id` INT NOT NULL ,
  `sender_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_messages_users1` (`receiver_id` ASC) ,
  INDEX `fk_messages_users2` (`sender_id` ASC) ,
  CONSTRAINT `fk_messages_users1`
    FOREIGN KEY (`receiver_id` )
    REFERENCES `MatchTracker`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users2`
    FOREIGN KEY (`sender_id` )
    REFERENCES `MatchTracker`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `MatchTracker`.`sports`
-- -----------------------------------------------------
START TRANSACTION;
USE `MatchTracker`;
INSERT INTO `MatchTracker`.`sports` (`id`, `name`) VALUES (1, 'Voetbal');
INSERT INTO `MatchTracker`.`sports` (`id`, `name`) VALUES (2, 'Tennis');

COMMIT;

-- -----------------------------------------------------
-- Data for table `MatchTracker`.`sport_types`
-- -----------------------------------------------------
START TRANSACTION;
USE `MatchTracker`;
INSERT INTO `MatchTracker`.`sport_types` (`id`, `name`, `players_on_field`, `sports_id`) VALUES (1, 'Veldvoetbal', 11, 1);
INSERT INTO `MatchTracker`.`sport_types` (`id`, `name`, `players_on_field`, `sports_id`) VALUES (2, 'Zaalvoetbal', 5, 1);
INSERT INTO `MatchTracker`.`sport_types` (`id`, `name`, `players_on_field`, `sports_id`) VALUES (3, 'Aangepast', NULL, 1);
INSERT INTO `MatchTracker`.`sport_types` (`id`, `name`, `players_on_field`, `sports_id`) VALUES (4, 'Enkel', 1, 2);
INSERT INTO `MatchTracker`.`sport_types` (`id`, `name`, `players_on_field`, `sports_id`) VALUES (5, 'Gemengd dubbel', 2, 2);

COMMIT;

-- -----------------------------------------------------
-- Data for table `MatchTracker`.`match_events`
-- -----------------------------------------------------
START TRANSACTION;
USE `MatchTracker`;
INSERT INTO `MatchTracker`.`match_events` (`id`, `name`, `text`) VALUES (1, 'goal', '%player heeft gescoord voor %team .');
INSERT INTO `MatchTracker`.`match_events` (`id`, `name`, `text`) VALUES (2, 'owngoal', '%player scoorde een own goal.');
INSERT INTO `MatchTracker`.`match_events` (`id`, `name`, `text`) VALUES (3, 'red card', '%player kreeg een rode kaart.');
INSERT INTO `MatchTracker`.`match_events` (`id`, `name`, `text`) VALUES (4, 'yellow card', '%player kreeg een gele kaart.');
INSERT INTO `MatchTracker`.`match_events` (`id`, `name`, `text`) VALUES (5, 'penalty', 'Penalty voor team %team .');
INSERT INTO `MatchTracker`.`match_events` (`id`, `name`, `text`) VALUES (6, 'start', 'De wedstrijd tussen %team1 en %team2 is gestart');
INSERT INTO `MatchTracker`.`match_events` (`id`, `name`, `text`) VALUES (7, 'stop', 'Einde van de wedstrijd.');

COMMIT;
