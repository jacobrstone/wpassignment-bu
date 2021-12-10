SELECT * FROM Users WHERE user_id > 100;

SELECT * FROM Users WHERE first_name = "Jacob";

SELECT * FROM parcels WHERE tracking_number = "AB012345678CD";

SELECT * FROM parcels;

SELECT parcels.tracking_number FROM parcels 
INNER JOIN parcels ON parcels.parcel_id = Users.user_id; 