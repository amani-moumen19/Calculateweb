$(document).ready(function() {
    // Add course row
    $('#addCourse').click(function() {
        var newRow = $('.course-row:first').clone();
        newRow.find('input').val('');
        newRow.find('select').prop('selectedIndex', 0);
        newRow.find('.remove-row').show();
        $('#courses').append(newRow);
    });

    // Remove course row
    $(document).on('click', '.remove-row', function() {
        $(this).closest('.course-row').remove();
    });

    // Handle form submission with AJAX
    $('#gpaForm').submit(function(e) {
        e.preventDefault(); // Prevent normal form submission

        // Show loading message
        $('#resultContainer').html('<div class="alert alert-info">Calculating GPA...</div>');

        // Get form data
        var formData = $(this).serialize(); // This serializes the form data

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: 'calculate_gpa.php', // Make sure this path is correct
            data: formData,
            success: function(response) {
                $('#resultContainer').html(response);
            },
            error: function(xhr, status, error) {
                $('#resultContainer').html('<div class="alert alert-danger">Error: ' + error + '</div>');
            }
        });
    });
});
