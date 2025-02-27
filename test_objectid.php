<?php
require 'vendor/autoload.php';

use MongoDB\BSON\ObjectId;

$id = new ObjectId("64a8c99f10b7c5f8e06d1b2d");
echo "ObjectId created successfully: " . $id;
