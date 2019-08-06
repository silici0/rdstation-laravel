# Laravel integration for RDStation version 2.0

This library provides an objected-oriented wrapper of the PHP classes to access RDStation API v2

## Installation

```
composer require silici0/rdstation-laravel:dev-master
```

## Configuration

need create
```
{
  
}
```

## Usage example

```
$rdstation = resolve('rdstation');

$d = array();
$d['name'] = 'Fulano de tal';
$d['email']= 'rafael@teste.com.br';
$d['personal_phone']='(11) 4022-1234';

$rdstation->createOrUpdate($d);
```