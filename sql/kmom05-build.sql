# Create user and grant privileges

create user 'pebe22'@'localhost' identified by 'geZkZcwDKRB2';
create user 'pebe22' identified by 'geZkZcwDKRB2';
grant all privileges on pebe22.* to 'pebe22'@'%';
grant all privileges on pebe22.* to 'pebe22'@'localhost';
