# Make Profile Image From Name

With this package you can easily generate profile photos in different formats (for now just png)

## installation
```php
composer require luckyboy1001/avatarate
```

## config the package
just create the directory and give the path on config file of package (avatarate)

**Notice: PHP 7.4 is needed**

### publish config 

```php
php artisan vendor:publish --provider=Avatarate\AvatarateServiceProvider
```
avatarate.php will be published to your config directory

##### - more options will be added


## notice

after config the avatarate config file
you must give it a save_directory that should be 
- created before
- writeable

---
### example

```php

    $name = "Mohammad Mohammadi";
    
    $background_color = 'random'; 
    
    $text_color = [220, 120, 12, 1]; // rgb or rgba or random
    
    $shape = "circle"; // rectangle, circle
    
    $size = 240;


    $image = new \Avatarate\Services\AvatarBuilder(
        $name,
        $background_color,
        $text_color,
        $shape,
        $size
    );

    $result = $image->generate();
    

```
---
result :
```php
{
    status: "success",
    file_name: "avatarate-1634383742",
    path: "path-to-laravel-project/public/avatarate/avatarate-1634383742.png"
}
```

and then image is saved in the directory you have given to config file
of the package

---



#### Notice
this package developed based on an open source laravel project I decided to
improve it and add new features


### - to do
- unit tests
- new features

please give me a star if you like it
