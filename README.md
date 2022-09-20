# Trans IP Coding

 A PHP CLI tool that executes hashing on a remote file (http for example) and fetches the result, with error handling and with RabbitMQ retry mechanism. It is completely dockerized and you can easily setup in your local environment. Application based on Symfony 5.4 with 7.3.33 and all the modern practices follow in this project. 

## clone project

Use the below link for cloning.

```bash
git clone https://github.com/MuhammadAteebHussain/trans_ip_symfony.git
```

## Installation
Note: make sure you have install docker and docker-compse latest
  Copy .env.example (currently you will get sample .env) to .env and update credentials

## 
- stop any previous development environment

```bash
docker-compose -f docker-compose.yml down --remove-orphans
docker-compose -f docker-compose.yml rm -f -s
```
## 
- starting development environment please make sure check the ports in docker-compose.yml
```bash
docker-compose up -d --build
```
##
- give write access to public var and cache directory
##
-  Then RUN Command
```bash
composer install
composer dumpautload -o
```

##
-  for checking containers 
```bash
docker-compose ps -a
```

##
-  Now enter in your php container by using the following command
```bash
sudo docker exec -it trans_ip_coding_backend_php  bash
```
## Running Project
-  After setting all please up your listeners inside your container run the following commands
```bash
php bin/console  app:create-file
app:create-hash-listen
```

##
- RUN Unit tests
```bash
php bin/phpunit
```
##
- For Generating Hash separately
```bash
php bin/console app:generate-hash
Please enter the URL if you want multiple please add with comma seperated 
?  http://speed.transip.nl/10mb.bin
Please enter the Valid File Path?   
public
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
