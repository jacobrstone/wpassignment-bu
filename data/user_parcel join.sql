SELECT parcels.tracking_number, parcels.order_date, parcels.parcel_status, parcels.country, parcels.city, parcels.street_address, parcels.postcode, Users.first_name, Users.last_name, Users.email 
FROM parcels 
INNER JOIN user_parcel_link ON parcels.parcel_id = user_parcel_link.parcel_id
INNER JOIN Users ON user_parcel_link.user_id = Users.user_id
ORDER BY parcels.order_date DESC, parcels.tracking_number;