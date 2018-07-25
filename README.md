# About
This is a small framework for create backend for web applications

# Config
All what you need is config MySQL connection - config/mysql.php

# How it words
Each request go to controller and run method. Last part of url after "/" is name of method. All before - way and file of controller
Result of each method should be $this->registry['template']->render('json');
Where json is templates/json.php