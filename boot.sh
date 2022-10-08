docker kill $(docker ps -q)
cd sql-a
docker-compose up -d
cd ..
cd sql-b
docker-compose up -d
cd ..
cd sql-c
docker-compose up -d
cd ..