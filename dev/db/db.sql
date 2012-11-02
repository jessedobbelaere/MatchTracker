SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `MatchTracker` ;
CREATE SCHEMA IF NOT EXISTS `MatchTracker` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `MatchTracker` ;

-- -----------------------------------------------------
-- Table `MatchTracker`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`users` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(25) NULL ,
  `salt` VARCHAR(255) NULL ,
  `password` VARCHAR(255) NULL ,
  `email` VARCHAR(60) NULL ,
  `surname` VARCHAR(45) NULL ,
  `name` VARCHAR(45) NULL ,
  `isActive` TINYINT(1) NULL DEFAULT true ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MatchTracker`.`leagues`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MatchTracker`.`leagues` ;

CREATE  TABLE IF NOT EXISTS `MatchTracker`.`leagues` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `place` VARCHAR(45) NULL ,
  `user_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_leagues_users1` (`user_id` ASC) ,
  CONSTRAINT `fk_leagues_users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `MatchTracker`.`users` (`id` )
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
  `teamusers_idteamusers` INT NOT NULL ,
  `users_id` INT NOT NULL ,
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
  PRIMARY KEY (`id`) ,
  INDEX `fk_matches_teams1` (`home_team` ASC) ,
  INDEX `fk_matches_teams2` (`away_team` ASC) ,
  CONSTRAINT `fk_matches_teams1`
    FOREIGN KEY (`home_team` )
    REFERENCES `MatchTracker`.`teams` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matches_teams2`
    FOREIGN KEY (`away_team` )
    REFERENCES `MatchTracker`.`teams` (`id` )
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
-- Data for table `MatchTracker`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `MatchTracker`;
INSERT INTO `MatchTracker`.`users` (`id`, `username`, `salt`, `password`, `email`, `surname`, `name`, `isActive`) VALUES (1, 'jesse', 'a7a4c70a965765ccebc6f4d30776db50', 'lqQPTMzaywQs02J+EIvLMExX9jXfaRy6kLlsvgqtFs/GW44SkmdyXsLXFriIlh1L0w6YiF/l7QMZHrHt4t/rQA==', 'jesse@dobbelaere-ae.be', 'Jesse', 'Dobbelaere', 1);

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
