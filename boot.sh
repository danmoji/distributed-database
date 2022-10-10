docker network create backend-network
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
docker network connect backend-network sql-a-web-1
docker network connect backend-network sql-b-web-1
docker network connect backend-network sql-c-web-1