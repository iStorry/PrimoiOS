# PrimoiOS

-------------
# Requirements

### PHP 5 + cURL
```sh 
  apt-get install php5 php5-curl php5-cli
  
```
-------------

# Usage 

```sh
  <?php
  
       require_once __DIR__ . "/Primo.php";
       $app = new Primo();
       echo $app->signup();
```
