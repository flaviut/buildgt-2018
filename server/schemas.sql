-- auto-generated definition
CREATE TABLE log
(
  logID     INT AUTO_INCREMENT
    PRIMARY KEY,
  custID    INT                                NOT NULL,
  time      DATETIME DEFAULT CURRENT_TIMESTAMP NULL,
  happiness DOUBLE                             NULL,
  gender    INT                                NULL,
  age       DOUBLE                             NULL,
  faceID    VARCHAR(255)                       NULL,
  glasses   VARCHAR(255)                       NULL,
  CONSTRAINT log_ibfk_1
  FOREIGN KEY (custID) REFERENCES customers (custID)
)
  ENGINE = InnoDB;

CREATE INDEX custID
  ON log (custID);


-- auto-generated definition
CREATE TABLE customers
(
  custID    INT AUTO_INCREMENT
    PRIMARY KEY,
  faceID    VARCHAR(255) NULL,
  age       DOUBLE       NULL,
  gender    INT          NULL,
  happiness DOUBLE       NULL,
  thief     INT          NULL,
  glasses   VARCHAR(255) NULL
)
  ENGINE = InnoDB;

CREATE VIEW customers_calc AS
  SELECT
    `curedb`.`customers`.`custID`       AS `custID`,
    `curedb`.`customers`.`thief`        AS `thief`,
    avg(`curedb`.`log`.`age`)           AS `age`,
    max(`curedb`.`log`.`gender`)        AS `gender`,
    any_value(`curedb`.`log`.`glasses`) AS `glasses`,
    avg(`curedb`.`log`.`happiness`)     AS `happiness`
  FROM `curedb`.`customers`
    JOIN `curedb`.`log`
  WHERE (`curedb`.`log`.`custID` = `curedb`.`customers`.`custID`)
  GROUP BY `curedb`.`log`.`custID`;

