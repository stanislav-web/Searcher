# Phalcon Database Searcher

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/stanislav-web/Searcher/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/Searcher/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/stanislav-web/Searcher/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/stanislav-web/Searcher/?branch=master) [![Build Status](https://travis-ci.org/stanislav-web/Searcher.svg?branch=master)](https://travis-ci.org/stanislav-web/Searcher) [![Total Downloads](https://poser.pugx.org/stanislav-web/phalcon-searcher/downloads.svg)](https://packagist.org/packages/stanislav-web/phalcon-searcher) [![Codacy Badge](https://www.codacy.com/project/badge/d616577e94f64a1a9678e18676845dda)](https://www.codacy.com/public/stanisov/Searcher) [![Latest Unstable Version](https://poser.pugx.org/stanislav-web/phalcon-searcher/v/unstable.svg)](https://packagist.org/packages/stanislav-web/phalcon-searcher)

Extension is used to group search for project models Currently under TTD

## Description
This is the search service is designed to search multiple SQL tables. Convenient to use autocomplete, search documents, search the whole site.

## Change Log 

#### [v 1.0-beta] 2014-12-16
    - support MySQL
    - support column type such as INT, VARCHAR, CHAR, TEXT, DATE, DATETIME
    - fulltext search
    - support all main expressions (where, order, group, limit, offset)
    - multi table search
    - compatible with \Phalcon\Paginator
    - view results as json, serialized, array or \Phalcon\Mvc\Model\Resultset\Simple
    - support callbacks to pretty modifying result

## Compatible
- PSR-0, PSR-1, PSR-2, PSR-4 Standards

## System requirements
- PHP 5.5.x >
- MySQL

## Install
First update your dependencies through composer. Add to your composer.json:
```php
"require": {
    "stanislav-web/phalcon-searcher": "dev-master",
}
```
Then run to update dependency and autoloader 
```python
php composer.phar update
php composer.phar install
```
_(Do not forget to include the composer autoloader)_

Or manual require in your loader service
```php
    $loader->registerNamespaces([
        'Searcher\Searcher' => 'path to src'
    ]);
```
You can create an injectable service
```php
    $this->di['searcher'] = function() {
        return new \Searcher\Searcher();
    };
```
## Usage

#### Simple usage

```php
<?php 
    use \Searcher\Searcher;
     
    // create object instance
    $searcher = new Searcher();
    
    // Prepare models and fields to participate in search
    $searcher->setFields([
        'Model/Auto'    =>    [
            'mark',
            'model'
        ],
        'Model/Distributor'    =>    [
            'name',
            'description'
        ]
    ])
    ->setQuery('FerRari');
    
    $result = $searcher->run();
```

#### Filters

```php
<?php 
    use \Searcher\Searcher;
     
    // create object instance
    $searcher = new Searcher();
    
    // Prepare models and fields to participate in search
    $searcher->setFields([
        '\Models\Auto'    =>    [
            'mark',
            'model'
        ],
        '\Models\Distributor'    =>    [
            'name',
            'description'
        ]
    ])
    ->setMin(3)                                     //  minimum char to query
    ->setMax(15)                                    //  maximum char to query
    ->setExact(true)                                //  strict mode search 
    ->setOrder([\Models\Auto' => ['id' => 'DESC']])  //  ORDER BY Model/Auto.id DESC
    ->setGroup(['\Models\Distributor' => ['id']])            //  GROUP BY Model/Auto.id
    ->setThreshold(100)                             //  LIMIT 100
    ->setQuery('FerRari');
    
    $result = $searcher->run();
    
```

```php
<?php 
    use \Searcher\Searcher;
     
    // create object instance
    $searcher = new Searcher();
    
    // Prepare models and fields to participate in search
    $searcher->setFields([
        '\Models\Auto'    =>    [
            'mark',
            'model'
        ],
        '\Models\Distributor'    =>    [
            'name',
            'description'
        ]
    ])
    ->setExact(true) // strict mode search 
    ->setOrder([
                    '\Models\/Auto' => ['id' => 'DESC']
                    '\Models\Distributor' => ['description' =>  'ASC']
              ])                                                //  ORDER BY Model/Auto.id DESC, Model/Distributor.description ASC
    ->setGroup([
                '\Models\/Auto' => ['id', 'mark']
                '\Models\Distributor' => ['id', 'description']
              ])                                                //  GROUP BY Model/Auto.id, Model/Auto.mark, Model/Distributor.id, Model/Distributor.description 
    
    ->setThreshold([0,100])                                     //    OFFSET 0, LIMIT 100
    ->setQuery('FerRari');
    
    $result = $searcher->run();
    
```

#### Result modifiers and callbacks
```php
<?php 
    use \Searcher\Searcher;
     
    // create object instance
    $searcher = new Searcher();
    
    // Prepare models and fields to participate in search
    $searcher->setFields([
        '\Models\Auto'    =>    [
            'mark',
            'model'
        ],
        '\Models\Distributor'    =>    [
            'name',
            'description'
        ]
    ])
    ->setQuery('FerRari');
    
    $result = $searcher->run('json'); // available array, serialize, json, Resultset as default
    
    // OR
    
    /**
     * @param $result 
     */
    $result = $searcher->run('array', function($result) {
        
        //... any modifiers 
        return $result;
             
    }); // available, array, serialize, json, Resultset as default

```

## Unit Test
Also available in /phpunit directory. Run command to start
```php
php build/phpunit.phar --configuration phpunit.xml.dist --coverage-text
```

Read logs from phpunit/log

##[Change Log](https://github.com/stanislav-web/Searcher/blob/master/CHANGELOG.md "Change Log")

##[Issues](https://github.com/stanislav-web/Searcher/issues "Issues")

## Screen
```
Unavailable
```
[![Project Status](http://stillmaintained.com/stanislav-web/Searcher.svg)](http://stillmaintained.com/stanislav-web/Searcher) [![Latest Stable Version](https://poser.pugx.org/stanislav-web/phalcon-searcher/v/stable.svg)](https://packagist.org/packages/stanislav-web/phalcon-searcher) [![MIT License](https://poser.pugx.org/stanislav-web/phalcon-searcher/license.svg)](https://packagist.org/packages/stanislav-web/phalcon-searcher) [![Gitter](https://badges.gitter.im/Join Chat.svg)](https://gitter.im/stanislav-web/Searcher?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=body_badge)

