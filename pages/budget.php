<!DOCTYPE html>
<html lang="en">

<?php
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
require_once(ROOT_PATH . '/pages/includes/header.html');

include ROOT_PATH . '/handlers/dbHandler.php';
$dbHandler = new DatabaseHandler();
// get the list of categories first
$category_items = $dbHandler->readData('category_table');
// get the list of budget records for the current month
// column constraints are month = current month
// expected columns are all columns
$matchColumns = array('month' => date("F"));
$currentMonth = date("F");
$combinedQuery = "SELECT category_table.name, description, amount FROM budget_planner INNER JOIN category_table ON budget_planner.category=category_table.id WHERE budget_planner.month=\"" . $currentMonth . "\";";
$resultDataSet = $dbHandler->query($combinedQuery);
$budget_records = array();
while ($row = mysqli_fetch_assoc($resultDataSet)) {
    $budget_records[] = $row;
}

if (count($budget_records) == 0) {
    $budget_records = 'There are no items to display, start adding records now.';
}

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
                        <button type="submit" class="btn btn-outline-secondary" id="budgetPlanFormSubmit" data-bs-date="<?php echo date('Y-m-d') ?>" data-bs-month="<?php echo date('F') ?>" data-bs-year="<?php echo date('Y') ?>">Submit</button>
                    </div>
                </form>
            </div>
            <!-- BUDGET PLANNER FORM ENDS HERE -->
            <?php if (is_array($budget_records)): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category</th>
                                <th scope="col">Description</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php for($i = 0; $i < count($budget_records); $i++) { ?>
                                <tr>
                                    <th><?php echo ($i + 1);?></th>
                                    <td><?php echo $budget_records[$i]['name']; ?></td>
                                    <td><?php echo $budget_records[$i]['description']; ?></td>
                                    <td><?php echo $budget_records[$i]['amount']; ?></td>
                                </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="fs-5 text-capitalize text-nowrap border text-md-center"><?php echo $budget_records; ?></div>
            <?php endif;?>
        </div>
    </section>
</body>
<?php
require_once(ROOT_PATH . '/pages/includes/footer.html');
?>