START TRANSACTION;

CREATE TABLE Package (
  name VARCHAR(30) NOT NULL,
  version VARCHAR(10) NOT NULL,
  path VARCHAR(255) NOT NULL,
  status VARCHAR(255) NOT NULL,
  
  PRIMARY KEY (name, version)
);

COMMIT;
