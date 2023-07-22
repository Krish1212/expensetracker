<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/':
        require __DIR__ . '/pages/dashboard.php';
        break;
    case '/budget':
    case '/budget?type=income':
    case '/budget?type=expenses':
        require __DIR__ . '/pages/budget.php';
        break;
    case '/transactions' :
        require __DIR__ . '/pages/transactions.php';
        break;
    case '/reports' :
        require __DIR__ . '/pages/reports.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/pages/404.php';
        break;
}
?>