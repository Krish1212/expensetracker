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

    // budget plan radio group selector
    $("#typeSelector :input").on("change",function () {
        var selectedType = $(this).val();
        window.location.href = `/budget/${selectedType}`;
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
        var type = $('#budgetPlanFormType option').filter(':selected').val();
        var description = $('#budgetPlanFormDesc').val();
        var amount = $('#budgetPlanFormAmt').val();
        /* alert('date: ' + date);
        alert(' month: ' + month);
        alert('year: ' + year);
        alert('category: ' + category);
        alert('description: ' + description);
        alert('amount: ' + amount); */

        // call the ajax method
        if (category === 'Choose...') {
            alert('Select any valid category!');
            return;
        }
        request = $.ajax({
            url: '/controller/savebudgetentry.php',
            type: 'post',
            data: {
                entryValues: {
                    date: date,
                    month: month,
                    year: year,
                    type: type,
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

    // all expense transactions form submit
    // all expense transactions form validation
    $('#transEntryForm').submit(function(ev) {
        ev.preventDefault();
        ev.stopPropagation();
        $(this).addClass('was-validated');
        // stop propagating if any request is already in progress
        if (request) request.abort();
        // get the input data values
        var date = $('#transFormSubmit').attr('data-bs-date');
        var month = $('#transFormSubmit').attr('data-bs-month');
        var year = $('#transFormSubmit').attr('data-bs-year');
        var category = $('#transFormCategory option').filter(':selected').val();
        var details = $('#transFormDesc').val();
        var amount = $('#transFormAmt').val();
        if (category === 'Choose...') {
            alert('Select any valid category!');
            return;
        }
        request = $.ajax({
            url: '/controller/savetransentry.php',
            type: 'post',
            data: {
                entryValues: {
                    date: date,
                    month: month,
                    year: year,
                    category: category,
                    details: details,
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