DROP DATABASE IF EXISTS `cbase`;
CREATE DATABASE `cbase`; 
USE `cbase`;

CREATE TABLE Employee (
  EmpID INT PRIMARY KEY CHECK (EmpID <= 9999),
  Name VARCHAR(20),
  Role VARCHAR(20) CHECK (
    Role IN ('manager', 'veterinary', 'ranchhand', 'accountant', 'other')
    ),
  Phone VARCHAR(15),
  HireDate DATE
);

CREATE TABLE Pasture (
  PastureID INT PRIMARY KEY CHECK (PastureID <= 99),
  Name VARCHAR(20),
  Area INT CHECK (Area <= 99),
  SoilType VARCHAR(20)  CHECK (
    SoilType IN (
    'mollisols',
    'aridisols',
    'alfisols',
    'entisols',
    'inceptisols',
    'vertisols',
    'andisols',
    'histosols',
    'saline-alkali',
    'other'
    )
  )
);

CREATE TABLE Equipment (
  EquipID INT PRIMARY KEY CHECK (EquipID <= 999),
  Type VARCHAR(40) CHECK (
    Type IN (
    'livestock handling equipment',
    'tractors & implements',
    'feeding & watering equipment',
    'maintenance & workshop equipment',
    'transport & utility vehicles',
    'fencing & infrastructure',
    'irrigation & water management',
    'Other'
    )
  ),
  PurchaseDate DATE,
  Cnd VARCHAR(20)  CHECK (
    Cnd IN ('good', 'service needed', 'retired')
  ),
  PastureID INT,
  FOREIGN KEY (PastureID) REFERENCES Pasture(PastureID)
);

CREATE TABLE Cattle (
  TagNo INT PRIMARY KEY CHECK (TagNo <= 9999999) ,
  Breed VARCHAR(20) CHECK (
    Breed IN (
      'angus',
      'hereford',
      'charolais',
      'limousin',
      'simmental',
      'shorthorn',
      'brangus',
      'braford',
      'beefmaster',
      'gelbvieh',
      'other'
    )
  ),
  Sex VARCHAR(10) CHECK (Sex IN ('male', 'female')) ,
  BirthDate DATE,
  Weight DECIMAL(10,1) CHECK (Weight >= 0),
  Status VARCHAR(20) CHECK (
    Status IN ('active', 'sold', 'deceased')
  ),
  PastureID INT,
  FOREIGN KEY (PastureID) REFERENCES Pasture(PastureID)
);

CREATE TABLE HealthRecord (
  RecordID INT PRIMARY KEY CHECK (RecordID <= 9999999999) ,
  VisitDate DATE,
  Temp DECIMAL(10,1) CHECK (Weight >= 0),
  Weight DECIMAL(10,1) CHECK (Weight >= 0),
  Diagnosis VARCHAR(50),
  Treatment VARCHAR(50),
  TagNo INT,
  FOREIGN KEY (TagNo) REFERENCES Cattle(TagNo)
);

CREATE TABLE Transaction (
  TransID INT PRIMARY KEY CHECK(TransID <= 9999999999), 
  TransDate DATE,
  Type VARCHAR(10) CHECK (
    Type IN ('Sale', 'Purchase')
  ),
  Amount INT CHECK(Amount <= 9999999)
);

CREATE TABLE Treats (
  EmpID INT,
  TagNo INT,
  PRIMARY KEY (EmpID, TagNo),
  FOREIGN KEY (EmpID) REFERENCES Employee(EmpID),
  FOREIGN KEY (TagNo) REFERENCES Cattle(TagNo)
);

CREATE TABLE Manages (
  EmpID INT,
  PastureID INT,
  PRIMARY KEY (EmpID, PastureID),
  FOREIGN KEY (EmpID) REFERENCES Employee(EmpID),
  FOREIGN KEY (PastureID) REFERENCES Pasture(PastureID)
);

CREATE TABLE Financial (
  TagNo INT,
  TransID INT,
  PRIMARY KEY (TagNo, TransID),
  FOREIGN KEY (TagNo) REFERENCES Cattle(TagNo),
  FOREIGN KEY (TransID) REFERENCES Transaction(TransID)
);