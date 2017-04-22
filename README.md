# Turiknox Area Shipping

## Overview

A Magento 2 module that will allow you to add a custom shipping method to be shown either in the storefront or the admin area.

## Requirements

Magento 2.1.x

## Installation

Copy the contents of the module into your Magento root directory.

Enable the module via the command line:

/path/to/php bin/magento module:enable Turiknox_AreaShipping

Run the database upgrade via the command line:

/path/to/php bin/magento setup:upgrade

Run the compile command and refresh the Magento cache:

/path/to/php bin/magento setup:di:compile 

/path/to/php bin/magento cache:clean


## Usage

Stores -> Configuration -> Sales -> Shipping Methods
