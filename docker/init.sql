GRANT ALL PRIVILEGES ON DATABASE main TO main;

CREATE ROLE trip_test_role WITH PASSWORD 'trip_test_password';

create DATABASE trip_test owner=trip_test_role;

ALTER ROLE trip_test_role WITH LOGIN;
ALTER USER trip_test_role WITH SUPERUSER;

GRANT ALL PRIVILEGES ON DATABASE main TO trip_test_role;

GRANT ALL PRIVILEGES ON DATABASE trip_test TO trip_test_role;
