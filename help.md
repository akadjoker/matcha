docker-compose up -d

docker-compose ps

docker-compose logs web

docker-compose exec web bash

docker-compose down

phpadmin
      http://localhost:8888 
 

Email:   PGADMIN_DEFAULT_EMAIL
Password:  PGADMIN_DEFAULT_PASSWORD


 docker run -u $(id -u):$(id -g)    -it   -v /home/djoker/Carla/Bin:/tf/scripts   tensorflow/tensorflow:2.10.0-gpu   bash

Separador "General":

Name: "matcha"  


Separador "Connection":

Host name/address: "db"  
Port: "5432"
Maintenance database: "postgres" 
Username:   POSTGRES_USER
Password:  POSTGRES_PASSWORD
Save password: Marcar esta opção se quiseres guardar a password

MailHog em: http://localhost:8025


limpar as tbales e criar novas

Parar os containers: docker-compose down
Remover o volume: docker volume rm matcha_db_data
Iniciar novamente: docker-compose up -d

https://www.stickpng.com/img/download/580b585b2edbce24c47b2408


Os próximos passos lógicos para o desenvolvimento seriam:

1 Implementar a estrutura da base de dados PostgreSQL com as tabelas que planeamos
2 Desenvolver o sistema de autenticação (registo e login)
3 Criar as funcionalidades do perfil de utilizador
3 Implementar as funções de pesquisa e listagem de perfis