<?php 

$connect = mysqli_connect('localhost', 'root', '','php_cms');

if (mysqli_connect_errno()){
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}