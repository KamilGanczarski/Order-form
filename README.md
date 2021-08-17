# Order-form
configuration

## File configuration to connect mysql
Database file sql to build
```
/vendor/Database/sql/db.sql
```

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

## Set app location
App location to fetch data from api in resources/js/app-vue.js in property app_url,
for example:
```
app_url: 'http://localhost/all/order-form.pl/Order-form/app/api/'
```

## Correct coupon codes:
First coupon
```
Code: 5PLFAST 
Active: active 
Discount: 50%
```
Second coupon
```
Code: Q95FAST 
Active: inactive 
Discount: 25%
```
