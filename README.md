# COVID

## About COVID

COVID is a web application to test Laravel framework features.

### Common tasks

* Create database and an assign user with its correct privileges.
```sql
CREATE DATABASE IF NOT EXISTS covid;
CREATE USER 'covid'@'%' IDENTIFIED BY 'covid';
GRANT ALL PRIVILEGES ON * . * TO 'covid'@'%';
FLUSH PRIVILEGES;
```

* Basic commands to execute locally
```bash
mkdir -p storage/logs/
echo "" > storage/logs/laravel.log

php artisan cache:clear
php artisan route:clear
php artisan config:clear

composer install
npm install

php artisan clear-compiled

npm run dev
php artisan migrate

php artisan db:seed
```

* Run on production
```bash
composer install --optimize-autoloader --no-dev
```

### Tasks executed before

* Install login / registration
```bash
composer require laravel/ui
php artisan ui react --auth
```

* Homestead and .env settings for local use
- if using homestead then set mysql ip host with value stored in Homestead.yaml
- Ensure ssh key exists else generated it in ~/.ssh/id_rsa_homestead

```bash
ssh-keygen -t rsa -C "local@homestead"
```

```yaml
ip: "192.168.10.10"
memory: 2048
cpus: 2
provider: virtualbox

authorize: ~/.ssh/id_rsa_homestead.pub

keys:
    - ~/.ssh/id_rsa_homestead

folders:
    - map: ~/Projects/code
      to: /home/vagrant/code

sites:
    - map: covid.local
      to: /home/vagrant/code/covid/public

databases:
    - covid
```   

```dotenv
APP_ENV=local
APP_DEBUG=true
APP_URL=http://covid.local:8000

LOG_CHANNEL=single

DB_CONNECTION=mysql
DB_HOST=192.168.10.10
DB_PORT=3306
DB_DATABASE=covid
DB_USERNAME=covid
DB_PASSWORD=covid

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_DRIVER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=

DAILY_REPORT_TIMEOUT = 0
DAILY_REPORT_BASE_URL = "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_daily_reports/"
```