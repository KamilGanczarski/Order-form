# Order-form
configuration

## Database file sql to build
```
/vendor/Database/sql/db.sql
```

## Set app location
App location to fetch from api in resources/js/app-vue.js in property app_url, for example:<br />
```
app_url: 'http://localhost/all/order-form.pl/Order-form/app/api/',<br />
```

## File configuration to connect mysql
File directory
```
/config/database.php
```

Parameters to configure mysql connection
```
'database' => env('DB_DATABASE', 'your-database-name'),
'username' => env('DB_USERNAME', 'your-database-username'),
'password' => env('DB_PASSWORD', 'your-database-password'),
```

## Correct coupon codes:
```
5PLFAST active 50%
Q95FAST inactive 25%
```
