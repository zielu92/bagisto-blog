# Blog Module for Bagisto v. 2

## Installation via composer
``composer require mziel/blog``

## Manual installation
- Create ``Mziel`` and ``Blog`` dir in packages directory 
``cd packages
mkdir Mziel/Blog ``
- Copy the files to the Blog directory
- Add to composer.json file find autoload PSR-4 and add
`` "Mziel\\Blog\\": "packages/Mziel/Blog/src" ``
- Add to config/app.php in the section providers 
``Mziel\Blog\Providers\BlogServiceProvider::class, ``
- Run commands
``composer dump-autoload
php artisan optimize ``

## Generate demo content
use the command ``php artisan blog:demo``
