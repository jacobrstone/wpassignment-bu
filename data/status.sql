create table  status (
	status_id INT,
	status_name VARCHAR(18),
    primary key(status_id)
);
insert into  status (status_id, status_name) values (1, 'Out for delivery');
insert into  status (status_id, status_name) values (2, 'Delivered');
insert into  status (status_id, status_name) values (3, 'Dispatched');
insert into  status (status_id, status_name) values (4, 'Payment received');
insert into  status (status_id, status_name) values (5, 'Lost in transit');
insert into  status (status_id, status_name) values (6, 'Parcel diverted');
insert into  status (status_id, status_name) values (7, 'Held at PO');
insert into  status (status_id, status_name) values (8, 'Returned to sender');