# Trans IP Coding

The main goal of this project is to genrate and URL hash by CLI. For making commands we are using her the most light framework Symfony 5.4. PHP version 7.3.33 greater. All the environment container based.
We are using here all the modern approaches for achiving our goal.  

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
## Running Project
-  After setting all please up your listeners
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