<?php
define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
require_once(ROOT_PATH . '/pages/includes/header.html');

include ROOT_PATH . '/handlers/dbHandler.php';
$dbHandler = new DatabaseHandler();

//get the value of the selected year
$transYear = $params['year'];
// get the value of the selected month
$transMonth = $params['month'];

$monthsList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
$yearsList = ["2021", "2022", "2023"];
// get the list of categories first
$category_expenses = array();
$category_items = array();
$expenseAmounts = array();
$dataSetRows = $dbHandler->readData('category_table');

foreach ($dataSetRows as $item) {
    $category_type = $item['type'];
    if ($category_type != 'income')
    {
        $expenseItem = array();
        $expenseItem['id'] = $item['id'];
        $expenseItem['name'] = $item['name'];
        $category_expenses[] = $expenseItem;
    }
}
echo $incomeTotal;

$category_items = $category_expenses;

// get the list of transaction records for the current month
// column constraints are month = current month
// expected columns are all columns
$matchColumns = array('month' => date("F"));
$currentYear = (isset($transYear)) ? $transYear : date("Y");
$currentMonth = (isset($transMonth)) ? $transMonth : date("F");
$combinedQuery = "SELECT category_table.name, details, amount FROM transactions INNER JOIN category_table ON transactions.category=category_table.id WHERE transactions.month=\"" . $currentMonth . "\" AND transactions.year=\"" . $currentYear . "\";";
$resultDataSet = $dbHandler->query($combinedQuery);
$trans_expense_items = array();
$incomeTotal = 0;
while ($row = mysqli_fetch_assoc($resultDataSet)) {
    $trans_expense_items[] = $row;
    $expenseAmounts[] = $row['amount'];
}

if (count($trans_expense_items) == 0) {
    $trans_records = 'There are no items to display, start adding records now.';
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
$expensesTotal = addNumberColumn($trans_expense_items);

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
                    <span class="fs-4">Expense Tracker - Monthly Transactions</span>
                </a>
            </header>
            <!-- TRANSACTION FORM COMES HERE -->
            <div class="trans-form bg-warning mb-4" style="--bs-bg-opacity:0.75;">
                <div class="row p-3">
                    <div class="col-lg-3 offset-lg-1">
                        <h5>Date: <?php echo date('d-m-Y') ?></h5>
                    </div>
                    <form class="needs-validation" id="transEntryForm" action="" method="post" novalidate>
                        <div class="row align-items-center justify-content-center mt-3">
                            <!-- Budget plan type selection not needed -->
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <div class="input-group-text" for="transFormCategory">Category</div>
                                    <select class="form-select form-control" name="transFormCategory" id="transFormCategory" required>
                                        <option selected>Choose...</option>
                                        <?php for ($c = 0; $c < count($category_items); $c++) { ?>
                                            <?php echo '<option value="' . $category_items[$c]['id'] . '">' . $category_items[$c]['name'] . '</option>' ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <div class="input-group-text" for="transFormDesc">Details</div>
                                    <input type="text" class="form-control" id="transFormDesc" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <div class="input-group-text" for="transFormAmt">Amount</div>
                                    <input type="number" class="form-control" id="transFormAmt" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <div class="d-grid col-lg-6">
                                <button type="submit" class="btn btn-outline-secondary" id="transFormSubmit" data-bs-date="<?php echo date('Y-m-d'); ?>" data-bs-month="<?php echo $currentMonth; ?>" data-bs-year="<?php echo $currentYear; ?>">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- TRANSACTION FORM ENDS HERE -->
            <!-- TRANSACTIONS TABULAR STARTS HERE -->
            <div class="container p-3 mb-3 opacity-75">
                <div class="row">
                    <div class="col-lg-2 align-text-left">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="selectYear">Year</label>
                            <select class="form-select form-select-sm" id="selectYear" onchange="location.href = '/transactions/' + this.options[this.selectedIndex].text + '/<?php echo $currentMonth; ?>'">
                                <?php for ($i = 1; $i <= count($yearsList); $i++) { ?>
                                    <option <?php if ($currentYear == $yearsList[$i - 1]) echo 'selected' ?> value="<?php echo $i ?>"><?php echo $yearsList[$i - 1] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="selectMonth">Month</label>
                            <select class="form-select form-select-sm" id="selectMonth" onchange="location.href = '/transactions/<?php echo $currentYear; ?>/' + this.options[this.selectedIndex].text">
                                <?php for ($i = 1; $i <= count($monthsList); $i++) { ?>
                                    <option <?php if ($currentMonth == $monthsList[$i - 1]) echo 'selected' ?> value="<?php echo $i ?>"><?php echo $monthsList[$i - 1] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-around">
                    <div class="col-lg-5 shadow rounded">
                        <div class="p-3 h-100">
                            <!-- <div class="mh-100"> -->
                            <canvas id="chartContainer"></canvas>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="col-lg-5 shadow rounded p-3">
                        <div class="mh-100 text-bg-warning opacity-75 d-flex justify-content-between">
                            <h4 class="p-3">Total Expenses: <span>₹<?php echo $expensesTotal ?></span></h4>
                            <h4 class="p-3">Balance: <span>₹<?php echo ($incomeTotal - $expensesTotal) ?></span></h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BUDGET INCOME TABULAR ENDS HERE -->
            <!-- BUDGET EXPENSES TABULAR STARTS HERE -->
            <?php if (is_array($trans_expense_items) && count($trans_expense_items) > 0) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover caption-top">
                        <caption><strong>All Expense Transactions</strong></caption>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category</th>
                                <th scope="col">Details</th>
                                <th scope="col">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php for ($i = 0; $i < count($trans_expense_items); $i++) { ?>
                                <tr>
                                    <th><?php echo ($i + 1); ?></th>
                                    <td><?php echo $trans_expense_items[$i]['name']; ?></td>
                                    <td><?php echo $trans_expense_items[$i]['details']; ?></td>
                                    <td>₹<?php echo $trans_expense_items[$i]['amount']; ?></td>
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
                <div class="fs-5 text-capitalize text-nowrap border text-md-center"><?php echo $trans_records; ?></div>
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
        var category_object = <?php echo json_encode($trans_expense_items); ?>;
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