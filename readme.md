# Where is that IP from?

You can easily look for an IP and it will shows where is that IP from. It shows the range, region and city.

If I have more time, I would have done it in **[this way](otherSolutions.md)**.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

You need to have following tools in order to run the project in the server or local environment.

* Webserver e.g. Apache or Nginx
* PHP v7
* Composer
* You should download the free IP lookup database from here: https://db-ip.com/db/download/city. This will
  be the data that forms the basis of your application.
    * Put the file in the `db` directory. Depends on your OS directory name is case sensitive or not.
    * Unzip the `dpip-city-YYYY-MM.gz` to the same directory. Rename the `csv` file to`db.csv`.

### Installing

With composer pull all the required packages.

```
composer install
composer dump-autoload -o
```

## Running the tests

Once you pull all the required packages with **composer**, then you can use **phpunit** to run all the tests. Run **phpunit** from command line when you are in the project directory. Make sure the **phpunit** is in the **PATH**
```
cd to-the-project-root
phpunit
```

### Extra

I have used
* [PSR-2](http://www.php-fig.org/psr/psr-2/) for coding style
* [PSR-4](http://www.php-fig.org/psr/psr-4/) for autoloading
* [Laravel](https://laravel.com/) directory structure


## Versioning

I use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/mohokh67/IP-Parser/tags). 

## Authors

* **[MoHo Khaleqi](https://github.com/mohokh67)**

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
