# HetwanPHP
Dofus 1.29.1 emulator written with PHP 7

# Installation
Uncompress on both ```Game``` and ```Login``` folders: ```vendor/cboden.rar``` and ```vendor/react.rar```

$> php composer.phar install

$> php composer.phar dump-autoload

# Generate database
At the root of the game project:

$> vendor/bin/doctrine orm:schema-tool:update --dump-sql --force

Edit ```cli-config.php```, uncomment the commented line and comment the previous uncommented, then re-execute the previous command.

# Configuration
Edit ```Login\app\config\config.yml``` and ```Game\app\config\config.yml``` files.

# Launch
From two separted terminals:

$> php Login/Hetwan.php

$> php Game/Hetwan.php