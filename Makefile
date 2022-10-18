build:
	docker-compose build --no-cache

up:
	docker-compose up

run: build up

load-schema:
	docker cp db/transforma.sql  transforma_minas_db_1:/tmp
	docker exec transforma_minas_db_1 /bin/bash -c 'mysql transforma < /tmp/transforma.sql --password=root'

create-users:
	docker cp db/popula-usuarios.sql  transforma_minas_db_1:/tmp
	docker exec transforma_minas_db_1 /bin/bash -c 'mysql transforma < /tmp/popula-usuarios.sql --password=root'

sampledevdata:
	docker cp db/transforma-devdata.sql  transforma_minas_db_1:/tmp
	docker exec transforma_minas_db_1 /bin/bash -c 'mysql transforma < /tmp/transforma-devdata.sql --password=root'
