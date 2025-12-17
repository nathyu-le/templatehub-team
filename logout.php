<?php
require_once __DIR__ . '/core/bootstrap.php';
auth_logout();
redirect('/login.php');
