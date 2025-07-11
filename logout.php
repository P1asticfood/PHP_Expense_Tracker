<?php

require_once  'config.php';
require_once 'db.php';

session_destroy();

header("location: login.php");