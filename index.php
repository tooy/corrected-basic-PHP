<?php

$page = $_GET['page'];

if($page=='page1'){
    include('pages/page1.php');
}elseif ($page == 'page2'){
    include('pages/page2.php');
}