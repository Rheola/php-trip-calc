GRANT ALL PRIVILEGES ON DATABASE main TO main;

CREATE ROLE testsym WITH PASSWORD 'testsym';

create DATABASE testsym owner=testsym;

ALTER ROLE testsym WITH LOGIN;
ALTER USER testsym WITH SUPERUSER;

GRANT ALL PRIVILEGES ON DATABASE main TO testsym;

GRANT ALL PRIVILEGES ON DATABASE testsym TO testsym;
