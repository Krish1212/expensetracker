<!DOCTYPE html>
<html lang="en">

<?php 
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
require_once(ROOT_PATH . '/pages/includes/header.html');
?>

<body>
    <section>
        <div class="container py-4">
            <header class="pb-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
                    <img src="./static/images/expense_tracker.png" alt="brand logo" width="32px" height="32px" style="margin-right: 6px !important" />
                    <span class="fs-4">Expense Tracker - Transactions</span>
                </a>
            </header>
        </div>
    </section>
</body>
<?php
require_once(ROOT_PATH . '/pages/includes/footer.html');
?>