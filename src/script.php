<?php

require_once("./Api.class.php");

$response = Api::get("http://sql-b_web_1/hello.php");

echo "hello";