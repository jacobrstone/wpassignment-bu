<?php 
include_once 'nav.php'; 

$query = "SELECT * FROM parcels WHERE parcel_id IN (SELECT user_id FROM user_parcel_link WHERE user_id = ?"); 




?> 




<?php include_once 'footer.php'; ?>