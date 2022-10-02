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
docker network connect backend-network sql-a_web_1
docker network connect backend-network sql-b_web_1
docker network connect backend-network sql-c_web_1