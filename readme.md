## Personal expenses

### Installation ### 
* type `git clone https://github.com/splinbl4/personal-expenses.git` to clone the repository 
* type `cd projectname`
* type `composer install`
* type `composer update`
* copy *.env.example* to *.env*
* type `php artisan key:generate`to regenerate secure key
* if you use MySQL in *.env* file :
   * set DB_CONNECTION
   * set DB_DATABASE
   * set DB_USERNAME
   * set DB_PASSWORD
* if you use sqlite :
   * type `touch database/database.sqlite` to create the file
   * DB_CONNECTION=sqlite
     DB_DATABASE=/absolute/path/to/database/database.sqlite
* type `php artisan migrate --seed` to create and populate tables
* edit *.env* for emails configuration
* edit *.env* for limit configuration:
    * set EXPENSE_LIMIT
* edit *.env* for scenario configuration:
    * set APP_SCENARIO:
        * adaptive_limit
        * increase_limit    
* optionaly type `npm install` to manage assets