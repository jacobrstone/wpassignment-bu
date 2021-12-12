SELECT * FROM Users WHERE user_id > 100;

SELECT * FROM Users WHERE first_name = "Jacob";

SELECT * FROM parcels WHERE tracking_number = "XB096040853ZQ";

SELECT * FROM parcels;

SELECT parcels.tracking_number FROM parcels 
INNER JOIN parcels ON parcels.parcel_id = Users.user_id; 


INSERT INTO parcels(tracking_number, parcel_status, order_date, city, street_address, postcode, country) 
VALUES("XB096040853ZQ","Delivered","2021-12-10","Bournemouth","46 Southcote Road","BH1 3SR","United Kingdom"); 


SELECT parcels.parcel_id, parcels.tracking_number, parcels.order_date, parcels.parcel_status, parcels.country, 
    parcels.city, parcels.street_address, parcels.postcode, Users.first_name, Users.last_name, Users.user_id, Users.email, Users.adminStatus
    FROM parcels
    INNER JOIN user_parcel_link ON parcels.parcel_id = user_parcel_link.parcel_id
    INNER JOIN Users ON user_parcel_link.user_id = Users.user_id
    ORDER BY parcels.order_date DESC, parcels.tracking_number; 




