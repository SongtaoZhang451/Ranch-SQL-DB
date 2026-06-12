USE cbase;

INSERT INTO Employee (EmpID, Name, Role, Phone, HireDate) VALUES
(1001, 'John', 'manager', '555-1234', '2020-01-15'),
(1002, 'Sheperd', 'veterinary', '555-2345', '2021-03-22'),
(1003, 'Holliday', 'ranchhand', '555-3456', '2019-11-10'),
(1004, 'Wyatt', 'accountant', '555-4567', '2022-05-01'),
(1005, 'Bill', 'other', '555-5678', '2023-08-12');

INSERT INTO Pasture (PastureID, Name, Area, SoilType) VALUES
(1, 'North Field', 45, 'mollisols'),
(2, 'South Field', 35, 'aridisols'),
(3, 'East Field', 28, 'alfisols'),
(4, 'West Field', 50, 'vertisols');

INSERT INTO Equipment (EquipID, Type, PurchaseDate, Cnd, PastureID) VALUES
(101, 'tractors & implements', '2022-06-10', 'good', 1),
(102, 'feeding & watering equipment', '2021-02-25', 'service needed', 2),
(103, 'livestock handling equipment', '2023-01-17', 'good', 1),
(104, 'transport & utility vehicles', '2020-09-03', 'retired', 3);

INSERT INTO Cattle (TagNo, Breed, Sex, BirthDate, Weight, Status, PastureID) VALUES
(200001, 'angus', 'male', '2022-01-01', 350.5, 'active', 1),
(200002, 'hereford', 'female', '2021-08-12', 420.0, 'sold', 2),
(200003, 'charolais', 'male', '2023-03-15', 300.7, 'active', 1),
(200004, 'limousin', 'female', '2020-11-20', 510.2, 'deceased', 3);

INSERT INTO HealthRecord (RecordID, VisitDate, Temp, Weight, Diagnosis, Treatment, TagNo) VALUES
(301, '2023-05-10', 38.5, 350.5, 'Checkup', 'None', 200001),
(302, '2022-12-01', 39.0, 420.0, 'Fever', 'Antibiotics', 200002),
(303, '2023-06-18', 38.6, 300.7, 'Injury', 'Bandage', 200003);

INSERT INTO Transaction (TransID, TransDate, Type, Amount) VALUES
(401, '2023-01-10', 'Sale', 1500),
(402, '2022-09-25', 'Purchase', 1200);

INSERT INTO Treats (EmpID, TagNo) VALUES
(1002, 200001),
(1002, 200002),
(1003, 200003);

INSERT INTO Manages (EmpID, PastureID) VALUES
(1001, 1),
(1001, 2),
(1003, 3);
