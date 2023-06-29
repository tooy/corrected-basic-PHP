<?php

$page = $_GET['page'] ?? '404';

if ($page == 'page1') {
    include('pages/page1.phtml');
} elseif ($page == 'page2') {
    include('pages/page2.phtml');
} else if ($page == '404') {
    include "page/404.phtml";
}

