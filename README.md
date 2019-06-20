# foxtek-assignment

Before we begin, a few caveats:
* I know i could have used Facades, but given the scope of the assignment, i consider that unneccesary goldplating.
* I used a database to make sure that we don't hit the servers too often (barring initial setup), 
    though this was not explicitly in the specification, it seemed permissible.
* consequently, the import commands would have to be executed once daily thereafter to have the data stay up to date. 
    I did not provision anything for this, as the demo environment runs in a place 
    that will not be serving requests long enough for that to be relevant. We'll just take that as read.


## Install
Install steps assume a Debian-like Linux environment (specifically: ubuntu Ubuntu 18.04.1 LTS)

### Mysql 
If you do not already have a mysql (equivalent) server running, install it. 
This demo setup assumes a root user with the password 'root' 
and database named 'foxtek' with 'utf8 - default collation', 
which is highly insecure and should never be done outside of a local dev/demo environment.
<br>
If this is too rich for your blood, you will need to change the `.env` and `.env.testing` files accordingly.

### PHP Modules 
you will need PHP 7.1, installed with at least the following modules
* PHP >= 7.1.3
* BCMath PHP Extension
* Ctype PHP Extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Mysql PHP extension
* curl PHP extension
    
You should be able to install these modules with for example `sudo apt-get install php-mysql`

### Git 
Clone this repository in a directory you have the appropriate rights and permissions to

### Composer
You should have composer installed. If you don't, go see: https://getcomposer.org, 
follow the instructions as appropriate for your OS and run `composer install` from inside the `xkcd` folder

### Artisan
make the `artisan` file executable as is appropriate for your OS (probably `chmod +x artisan`)

### DB Content
Now that artisan is up and running we should be able to populate the database with tables
`php artisan migrate:fresh`

### Import data

Run the following commands: `php artisan import:space` and `php artisan import:xkcd`.
The first one should be done in a second or two, grab a cup of coffee for the second one, 
it should take about 4 minutes if you want all of the data.

### Artisan serve

run the following command: `php artisan serve`, it will start up a small but functional temporary webserver. 
it typically runs on port 8000, if you already have something running there it will prompt you with like so:
```
[Thu Jun 20 17:41:06 2019] Failed to listen on 127.0.0.1:8000 (reason: Address already in use)
Laravel development server started: <http://127.0.0.1:8001>
```
You may have to adjust `xkxd/tests/api.suite.yml` to match accordingly.

You should now be able to browse to `http://localhost:8000/api/space/year/2013/limit/2` and see:

```
{  
   meta:{  
      request:{  
         sourceId:"space",
         year:2013,
         limit:2
      }
   },
   timestamp:"2019-06-20T19:31:27.461706Z",
   data:[  
      {  
         number:10,
         date:"2013-03-01",
         name:"CRS-2",
         link:"https://en.wikipedia.org/wiki/SpaceX_CRS-2",
         details:"Last launch of the original Falcon 9 v1.0 launch vehicle"
      },
      {  
         number:11,
         date:"2013-09-29",
         name:"CASSIOPE",
         link:"http://www.parabolicarc.com/2013/09/29/falcon-9-launch-payloads-orbit-vandenberg/",
         details:"Commercial mission and first Falcon 9 v1.1 flight, with improved 13-tonne to LEO capacity. Following second-stage separation from the first stage, an attempt was made to perform an ocean touchdown test of the discarded booster vehicle. The test provided good test data on the experiment-its primary objective-but as the booster neared the ocean, aerodynamic forces caused an uncontrollable roll. The center engine, depleted of fuel by centrifugal force, shut down resulting in the impact and destruction of the vehicle."
      }
   ]
}
```

## Automated tests
Just to show that i can, i have added a small set of (API) assertions that checks 
the bare minimum for compliance.

From the main (xkcd) directory run `./vendor/bin/codecept run api`, it will execute the test.
You should see something like this on the console:

```
Codeception PHP Testing Framework v3.0.1
Powered by PHPUnit 7.5.13 by Sebastian Bergmann and contributors.
Running with seed: 

Api Tests (1) 
-----------------------------------------------------------------------------------------------------------------------------------------
✔ SpaceCest: First spec test case (0.03s)
-------------------------------------------------------------------------------------------------------------------------------------------------------

Time: 139 ms, Memory: 20.00 MB

OK (1 test, 4 assertions)
```
