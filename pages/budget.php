<?php
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
require_once(ROOT_PATH . '/pages/includes/header.html');

include ROOT_PATH . '/handlers/dbHandler.php';
$dbHandler = new DatabaseHandler();

//get the value of the selected year
$budgetPlanYear = (isset($params['year'])) ? $params['year'] : date("Y");
// get the value of the selected month
$budgetPlanMonth = (isset($params['month'])) ? $params['month'] : date("F");
// get the value of the selected type
$budgetPlanType = (isset($params['type'])) ? $params['type'] : 'income';

$monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
$yearsList = ["2021", "2022", "2023"];
// get the list of categories first
$category_income = array();
$category_expenses = array();
$category_items = array();
$expenseAmounts = array();
$dataSetRows = $dbHandler->readData('category_table');

foreach ($dataSetRows as $item) {
    $category_type = $item['type'];
    if ($category_type == 'income') {
        $incomeItem = array();
        $incomeItem['id'] = $item['id'];
        $incomeItem['name'] = $item['name'];
        $category_income[] = $incomeItem;
    } else {
        $expenseItem = array();
        $expenseItem['id'] = $item['id'];
        $expenseItem['name'] = $item['name'];
        $category_expenses[] = $expenseItem;
    }
}
if (isset($budgetPlanType) && $budgetPlanType == 'income')
{
    $category_items = $category_income;
}
else
{
    $category_items = $category_expenses;
}

// get the list of budget records for the current month
// column constraints are month = current month
// expected columns are all columns
$matchColumns = array('month' => date("F"));
$currentYear = (isset($budgetPlanYear)) ? $budgetPlanYear : date("Y");
$currentMonth = (isset($budgetPlanMonth)) ? $budgetPlanMonth : date("F");

$combinedQuery = "SELECT category_table.name, category_table.type, description, amount FROM budget_planner INNER JOIN category_table ON budget_planner.category=category_table.id WHERE budget_planner.month=\"" . $currentMonth . "\" AND budget_planner.year=\"" . $currentYear . "\";";
$resultDataSet = $dbHandler->query($combinedQuery);
$budget_income_items = array();
$budget_expense_items = array();
while ($row = mysqli_fetch_assoc($resultDataSet)) {
    if ($row['type'] == 'income') {
        $budget_income_items[] = $row;
    } else {
        $budget_expense_items[] = $row;
        $expenseAmounts[] = $row['amount'];
    }
}

if (count($budget_expense_items) == 0) {
    $budget_records = 'There are no items to display, start adding records now.';
}
function addNumberColumn($inputArray)
{
    if (!is_array($inputArray)) {
        return;
    }
    $totalValue = 0;
    for ($i = 0; $i < count($inputArray); $i++) {
        $totalValue += $inputArray[$i]['amount'];
    }
    return $totalValue;
}
$incomeTotal = addNumberColumn($budget_income_items);
$expensesTotal = addNumberColumn($budget_expense_items);

$dbHandler->closeDB();

?>
<!DOCTYPE html>
<html lang="en">

<body>
    <section>
        <div class="container py-4">
            <header class="pb-3 mb-4 border-bottom">
                <a href="/" class="d-flex align-items-center text-body-emphasis text-decoration-none">
                    <img src="/static/images/expense_tracker.png" alt="brand logo" width="32px" height="32px" style="margin-right: 6px !important" />
                    <span class="fs-4">Expense Tracker - Budget Planner</span>
                </a>
            </header>
            <!-- BUDGET PLANNER FORM COMES HERE -->
            <div class="budget-form bg-warning mb-4" style="--bs-bg-opacity:0.75;">
                <div class="row">
                    <div class="col-lg-3">
                        <h5>Date: <?php echo date('d-m-Y') ?></h5>
                    </div>
                    <form class="needs-validation" id="budgetPlanForm" action="" method="post" novalidate>
                        <div class="btn-group mb-3 col-lg-4" role="group" id="typeSelector">
                            <input type="radio" class="btn-check" name="budgetPlanFormType" id="budgetPlanFormType1" autocomplete="off" value="income" <?php if ($budgetPlanType == 'income') echo "checked"?>>
                            <label class="btn btn-outline-secondary" for="budgetPlanFormType1">Income</label>
                            <input type="radio" class="btn-check" name="budgetPlanFormType" id="budgetPlanFormType2" autocomplete="off" value="expenses" <?php if ($budgetPlanType == 'expenses') echo "checked"?>>
                            <label class="btn btn-outline-secondary" for="budgetPlanFormType2">Expenses</label>
                        </div>
                        <div class="table-responsive budgetFormTable">
                            <table class="table table-bordered table-condensed" cellpadding=0 cellspacing=0>
                                <thead>
                                    <tr align="center">
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr align="center">
                                        <td>
                                            <select class="form-select form-control" name="budgetPlanFormCategory" id="budgetPlanFormCategory" required>
                                                <option selected>Choose...</option>
                                                <?php for ($c = 0; $c < count($category_items); $c++) { ?>
                                                    <?php echo '<option value="' . $category_items[$c]['id'] . '">' . $category_items[$c]['name'] . '</option>' ?>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="budgetPlanFormDesc" name="budgetItemDesc" autocomplete="off">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="budgetPlanFormAmt" name="budgetItemAmt" required autocomplete="off">
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <td colspan="4">
                                        <div class="mt-3">
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-outline-secondary" id="budgetPlanFormSubmit" data-bs-date="<?php echo date('Y-m-d'); ?>" data-bs-month="<?php echo $currentMonth; ?>" data-bs-year="<?php echo $currentYear; ?>">Submit</button>
                                            </div>
                                        </div>
                                    </td>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                    <!-- <form class="needs-validation" id="budgetPlanForm" action="" method="post" novalidate>
                        <div class="row align-items-center justify-content-center mt-3">
                            <div class="col-lg-2">
                                <div class="input-group">
                                    <div class="input-group-text" for="budgetPlanFormType">Type</div>
                                    <select class="form-select form-control" name="budgetPlanFormType" id="budgetPlanFormType" required id="budgetPlanFormType" onchange="location.href = '/budget/' + this.options[this.selectedIndex].value">
                                        <option <?php if (isset($budgetPlanType) && $budgetPlanType == 'expenses') {
                                                    echo 'selected';
                                                } ?> value="expenses">Expenses</option>
                                        <option <?php if (isset($budgetPlanType) && $budgetPlanType == 'income') {
                                                    echo 'selected';
                                                } ?> value="income">Income</option>
                                    </select>
                                </div>
                            </div>
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
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <div class="input-group-text">Description</div>
                                    <input type="text" class="form-control" id="budgetPlanFormDesc" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <div class="input-group-text">Amount</div>
                                    <input type="number" class="form-control" id="budgetPlanFormAmt" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <div class="d-grid col-lg-6">
                                <button type="submit" class="btn btn-outline-secondary" id="budgetPlanFormSubmit" data-bs-date="<?php echo date('Y-m-d'); ?>" data-bs-month="<?php echo $currentMonth; ?>" data-bs-year="<?php echo $currentYear; ?>">Submit</button>
                            </div>
                        </div>
                    </form> -->
                </div>
            </div>
            <!-- BUDGET PLANNER FORM ENDS HERE -->
            <!-- BUDGET INCOME TABULAR STARTS HERE -->
            <?php if (is_array($budget_income_items)) : ?>
                <div class="container p-3 mb-3 opacity-75">
                    <div class="row">
                        <div class="col-lg-2 align-text-left">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="selectYear">Year</label>
                                <select class="form-select form-select-sm" id="selectYear" onchange="location.href = '/budget/' + this.options[this.selectedIndex].text + '/<?php echo $currentMonth; ?>'">
                                    <?php for ($i = 1; $i <= count($yearsList); $i++) { ?>
                                        <option <?php if ($currentYear == $yearsList[$i - 1]) echo 'selected' ?> value="<?php echo $i ?>"><?php echo $yearsList[$i - 1] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="selectMonth">Month</label>
                                <select class="form-select form-select-sm" id="selectMonth" onchange="location.href = '/budget/<?php echo $currentYear; ?>/' + this.options[this.selectedIndex].text">
                                    <?php for ($i = 1; $i <= count($monthsList); $i++) { ?>
                                        <option <?php if ($currentMonth == $monthsList[$i - 1]) echo 'selected' ?> value="<?php echo $i ?>"><?php echo $monthsList[$i - 1] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 shadow rounded p-2 table-responsive">
                            <table class="table table-bordered table-sm caption-top">
                                <caption><strong>Income Details</strong></caption>
                                <tbody>
                                    <?php foreach ($budget_income_items as $item) { ?>
                                        <tr>
                                            <th><?php echo $item['name'] ?></th>
                                            <td>₹<?php echo $item['amount'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot class="table-group-divider">
                                    <tr>
                                        <th>Total</th>
                                        <td>₹<?php echo $incomeTotal ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-lg-6 shadow rounded">
                            <div class="p-3 h-100">
                                <!-- <div class="mh-100"> -->
                                <canvas id="chartContainer"></canvas>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-lg-12">
                            <div class="p-1" style="height: 100%">
                                <div class="mh-100 text-bg-warning opacity-75 d-flex justify-content-between">
                                    <h4 class="p-3">Total Income: <span>₹<?php echo $incomeTotal ?></span></h4>
                                    <h4 class="p-3">Total Expenses: <span>₹<?php echo $expensesTotal ?></span></h4>
                                    <h4 class="p-3">Balance: <span>₹<?php echo ($incomeTotal - $expensesTotal) ?></span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <!-- BUDGET INCOME TABULAR ENDS HERE -->
            <!-- BUDGET EXPENSES TABULAR STARTS HERE -->
            <?php if (is_array($budget_expense_items)) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover caption-top">
                        <caption><strong>Expense Details</strong></caption>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category</th>
                                <th scope="col">Description</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php for ($i = 0; $i < count($budget_expense_items); $i++) { ?>
                                <tr>
                                    <th><?php echo ($i + 1); ?></th>
                                    <td><?php echo $budget_expense_items[$i]['name']; ?></td>
                                    <td><?php echo $budget_expense_items[$i]['description']; ?></td>
                                    <td>₹<?php echo $budget_expense_items[$i]['amount']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot class="table-group-divider">
                            <tr>
                                <th colspan="3">Total</th>
                                <th>₹<?php echo $expensesTotal ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    <!-- BUDGET EXPENSES TABULAR STARTS HERE -->
                </div>
            <?php else : ?>
                <div class="fs-5 text-capitalize text-nowrap border text-md-center"><?php echo $budget_expense_items; ?></div>
            <?php endif; ?>
        </div>
    </section>
</body>
<?php
require_once(ROOT_PATH . '/pages/includes/footer.html');
?>
<script>
    $(document).ready(function() {
        var expensesList = [];
        var barColors = [];
        var category_object = <?php echo json_encode($budget_expense_items); ?>;
        $.map(category_object, function(item) {
            const randomColor = Math.floor(Math.random() * 16777215).toString(16);
            expensesList.push(item['name']);
            barColors.push('#' + randomColor);
        });
        // console.log(expensesList);
        var expenseAmount = <?php echo json_encode($expenseAmounts); ?>;
        var xValues = expensesList;
        var yValues = expenseAmount;

        new Chart("chartContainer", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    data: yValues,
                    backgroundColor: barColors,
                }],
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: "Expenses Chart",
                    }
                }
            }
        });
    });
</script>