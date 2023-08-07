# Apovoice Backend

## Project setup

Just nothing!

### Docker

The development environment is dockerized using `docker-compose` or use the `apovoice.sh` commands.

```sh
./apovoice up             # start the container and attach logging
./apovoice down           # stop the container
./apovoice logs           # attach a logging session to the container
```

### Database

This project comes with a phpMyAdmin installation out of the box. You can access the web interface at [http://localhost:3010](http://localhost:3010).

Login using the following credentials:

```
Username: root
Password: root
```

#### Automatic SQL Schema Import

Create a directory `../sql-dump` and place any `*.sql` file in here. When starting the container using `docker-compose up` all SQL files will be executed to seed the database data.

### Wordpress

Access the wordpress installation at [http://localhost/wp-admin](http://localhost/wp-admin).

Login using the following credentials:

```
Username: admin
Password: admin
```

# Apovoice Azure infrastructure

Subscription used for apovoice

```
subscription name : PG-External-Consumer-EU-01
location : West Europe
```

# Apovoice Azure production infrastructure

All the resources used for produciton is grouped under resources group name **AZ-RG-CS-Apovoice-PaaS-EU-01**
Following are the resource

- 8a4c08b2-6772-4e7a-81ae-3cfea92c3e48-dashboard (apovoice-backend-prod Dashboard)

- apovoice-backend-prod (Application Insights West Europe)
- apovoice-backend-prod (App Service West Europe)
- apovoice-frontend-prod (Application Insights West Europe)
- apovoice-frontend-prod (App Service West Europe)
- apovoiceprodstorage (Storage account West Europe)
- az-cs-eu-apovoice-mysql-prod (Azure Database for MySQL single server West Europe)
- AZAPOVOICEPROD (Container registry West Europe)
- Linux-Apovoice-Asp01-WestEurope (App Service plan West Europe)
- webappapovoicebackendprod (AZAPOVOICEPROD/webappapovoicebackendprod) Container registry webhook West Europe
- webappapovoicefrontendprod (AZAPOVOICEPROD/webappapovoicefrontendprod) Container registry webhook West Europe

Two release pipelines used for deploying frontend and backend app

- Prod Backend (running this pipeline deployes latest code to production backend server )
- Prod Frontend (running this pipeline deployes latest code to prduction frontend server )

**Prod backend is accessible at following link**

- [Admin page ](https://backend.apovoice.es/wp-admin).

**Prod frontend is accessible at following link**

- [front end ] (https://apovoice.es).

# Apovoice Azure Non production infrastructure

All the resources used for produciton is grouped under resources group name **AZ-RG-CS-Apovoice-PaaS-EU-NonProd-01**
Following are the resource

- apovoice-es-backend-stage (App Service West Europe)
- apovoice-es-frontend-stage (App Service West Europe)
- apovoicenonprodstorage (Storage account West Europe)
- az-cs-eu-apovoice-mysql-nonprod (Azure Database for MySQL single server West Europe)
- AZAPOVOICENP (Container registry West Europe)
- Linux-Apovoice-Nonprod-Asp01-WestEurope (App Service plan West Europe)
- webappapovoiceesbackendstage (AZAPOVOICENP/webappapovoiceesbackendstage)
- webappapovoiceesfrontendstage (AZAPOVOICENP/webappapovoiceesfrontendstage)

Two realease pipelines used for deploying frontend and backend app

- NonProd Backend (running this pipeline deployes latest code to stage backend server )
- NonProd Frontend (running this pipeline deployes latest code to stage frontend server )

**stage backend is accessible at following link**

- [Admin page ](https://backend-stage.apovoice.es/wp-admin).

**stage frontend is accessible at following link**

- [front end ] (https://stage.apovoice.at).

# Build Pipelines

Two build pipelines used to build image and push to ACR

- apovoice-backend CI (pushing code to develop branch build iamge from devlop branch code and pushes to non prod acr iamge repo ,similarly master branch push builds from master branch code and pushed to prod acr )
- apovoice-frontend CI (pushing code to develop branch build iamge from devlop branch code and pushes to non prod acr iamge repo ,similarly master branch push builds from master branch code and pushed to prod acr )

# Issues occured on stage enviornment setup

- pipeline setup was configured with outdated branch.
- gateway health prob was not set correctly it should be a url which return http code 200 for our case it should be /wp-admin .
- very strict ip restrictions made it hard to debug the app , hence app was crashing and azure gateway continously returned 503, 502 codes making it very defficult to setup the application .

# Action taken to resolve the issue on azure stage enviornment

- IP restrictions beign removed by PG IT
- heath prob url set to /wp-admin
- code pile line sorice set to coorrect version
- database has been updated with correct domain in our case it (backend-stage.apovoice.es)

# To setup a new enviornment

Following queries needs to be executed on database otherwise following [Application error](https://ibb.co/Nm0N05r) may occure because of incorrect domain

**backend-stage.apovoice.es** can be replaced with necessary domain as needed

```
update apovoice.wp_site set domain = 'backend-stage.apovoice.es' where id=1;
update apovoice.wp_blogs set domain = 'backend-stage.apovoice.es';
update apovoice.wp_options set option_value = 'https://backend-stage.apovoice.es' where option_id in(1,2);
update apovoice.wp_2_options set option_value = 'https://backend-stage.apovoice.es/de' where option_id in(1,2);
update apovoice.wp_3_options set option_value = 'https://backend-stage.apovoice.es/at' where option_id in(1,2);
update apovoice.wp_4_options set option_value = 'https://backend-stage.apovoice.es/com' where option_id in(1,2);
```
