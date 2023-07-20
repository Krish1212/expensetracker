$(document).ready(function() {
    var request;
    // navigator function
    $('#navtransactions').click(function() {
        window.location.assign('./transactions');
    });
    // navigator function
    $('#navbudgetPlanner').click(function() {
        window.location.assign('./budget');
    });
    // navigator function
    $('#navreports').click(function() {
        window.location.assign('./reports');
    });

    // budget plan form validation
    // budget plan form submit
    $('#budgetPlanForm').submit(function(ev) {
        ev.preventDefault();
        ev.stopPropagation();
        $(this).addClass('was-validated');
        // stop propagating if any request is already in progress
        if (request) request.abort();
        // get the input data values
        var date = $('#budgetPlanFormSubmit').attr('data-bs-date');
        var month = $('#budgetPlanFormSubmit').attr('data-bs-month');
        var year = $('#budgetPlanFormSubmit').attr('data-bs-year');
        var category = $('#budgetPlanFormCategory option').filter(':selected').val();
        var description = $('#budgetPlanFormDesc').val();
        var amount = $('#budgetPlanFormAmt').val();
        // console.log(date, month, year, category, description, amount);
        // call the ajax method
        if (category === 'Choose...') {
            alert('Select any valid category!');
            return;
        }
        request = $.ajax({
            url: 'controller/savebudgetentry.php',
            type: 'post',
            data: {
                entryValues: {
                    date: date,
                    month: month,
                    year: year,
                    category: category,
                    description: description,
                    amount: amount,
                }
            }
        });

        request.done(function(response, textStatus, jqXHR) {
            console.log(response, textStatus);
            // alert(response);
            window.location.reload();
        });
        request.fail(function(jqXHR, textStatus, error) {
            console.error("Error: ", textStatus, error);
            // alert('Error: ', textStatus, error);
        });
    });
});