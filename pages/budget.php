<!DOCTYPE html>
<html lang="en">

<?php
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
require_once(ROOT_PATH . '/pages/includes/header.html');

include ROOT_PATH . '/handlers/dbHandler.php';
$dbHandler = new DatabaseHandler();
// get the list of categories first
$category_items = $dbHandler->readData('category_table');
$dbHandler->closeDB();
?>

<body>
    <section>
        <div class="container py-4">
            <header class="pb-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
                    <img src="./static/images/expense_tracker.png" alt="brand logo" width="32px" height="32px" style="margin-right: 6px !important" />
                    <span class="fs-4">Expense Tracker - Budget Planner</span>
                </a>
            </header>
            <!-- BUDGET PLANNER FORM COMES HERE -->
            <div class="budget-form bg-warning mb-4" style="--bs-bg-opacity:0.75;">
                <div class="row align-item-start mb-3">
                    <h4 class="col-lg-8">Plan for the month: <?php echo date('F') ?> <?php echo date('Y') ?></h4>
                    <h5 class="col-lg-4 align-text-right">Date: <?php echo date('d-m-Y') ?></h5>
                </div>
                <form class="row d-flex g-3 xalign-items-center xjustify-content-center needs-validation" id="budgetPlanForm" action="" method="post" novalidate>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <div class="input-group-text" for="budgetPlanFormCategory">Category</div>
                            <select class="form-select form-control" name="budgetPlanFormCategory" id="budgetPlanFormCategory" required>
                                <option selected>Choose...</option>
                                <?php for ($c = 0; $c < count($category_items); $c++) { ?>
                                    <?php echo '<option value="' . $category_items[$c]['id'] . '">' . $category_items[$c]['name'] . '</option>' ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <div class="input-group-text">Description</div>
                            <input type="text" class="form-control" id="budgetPlanFormDesc" required autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="input-group">
                            <div class="input-group-text">Amount</div>
                            <input type="number" class="form-control" id="budgetPlanFormAmt" required autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-outline-secondary" id="budgetPlanFormSubmit" data-bs-date="<?php echo date('d-m-Y') ?>" data-bs-month="<?php echo date('F') ?>" data-bs-year="<?php echo date('Y') ?>">Submit</button>
                    </div>
                </form>
            </div>
            <!-- BUDGET PLANNER FORM ENDS HERE -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Month</th>
                            <th scope="col">Category</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Description</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr>
                            <th>1</th>
                            <td>2023/07/10</td>
                            <td>July</td>
                            <td>Recharge</td>
                            <td>181</td>
                            <td>jio mobile</td>
                        </tr>
                        <tr>
                            <th>2</th>
                            <td>2023/07/11</td>
                            <td>July</td>
                            <td>Groceries</td>
                            <td>450</td>
                            <td>to GSM</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
<?php
require_once(ROOT_PATH . '/pages/includes/footer.html');
?>