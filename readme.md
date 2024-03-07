# Blog Module for Bagisto v. 2

## Installation approach 1
soon

## Instalation approach 2
- Create ``Mziel`` and ``Blog`` dir in packages directory 
``cd packages
mkdir Mziel/Blog ``
- Copy the files to Blog directory
- Add to composer.json file find autoload psr-4 and add
`` "Mziel\\Blog\\": "packages/Mziel/Blog/src" ``
- Add to config/app.php in section providers 
``Mziel\Blog\Providers\BlogServiceProvider::class, ``
- Run commands
``composer dump-autoload
php artisan optimize ``

## Generate demo content
use command ``php artisan blog:demo``
