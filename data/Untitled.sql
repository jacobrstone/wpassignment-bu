SELECT * FROM Users WHERE user_id > 100;

SELECT * FROM Users WHERE first_name = "Admin";

SELECT * FROM parcels WHERE tracking_number = "WG507201122YP";

SELECT * FROM parcels;

SELECT parcels.tracking_number FROM parcels 
INNER JOIN parcels ON parcels.parcel_id = Users.user_id; 

INSERT INTO parcels(tracking_number, parcel_status, order_date, city, street_address, postcode, country) 
VALUES("XB096040853ZQ","Delivered","2021-12-10","Bournemouth","46 Southcote Road","BH1 3SR","United Kingdom"); 

UPDATE Users SET adminStatus = 1 WHERE email = kat@gmail.com;