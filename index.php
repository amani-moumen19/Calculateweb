<?php
// Initialize variables
$result = "";
$tableHtml = "";
$gpaResult = "";

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $courses = $_POST['course'] ?? [];
    $credits = $_POST['credits'] ?? [];
    $grades = $_POST['grade'] ?? [];
    
    $totalPoints = 0;
    $totalCredits = 0;
    
    // Build table HTML
    $tableHtml = "<h2>Course Summary</h2>";
    $tableHtml .= "<table>";
    $tableHtml .= "<tr>
                    <th>Course</th>
                    <th>Credits</th>
                    <th>Grade</th>
                    <th>Grade Points</th>
                  </tr>";
    
    for ($i = 0; $i < count($courses); $i++) {
        $course = htmlspecialchars($courses[$i]);
        $cr = floatval($credits[$i]);
        $gp = floatval($grades[$i]);
        
        if ($cr <= 0) continue;
        
        $points = $cr * $gp;
        $totalPoints += $points;
        $totalCredits += $cr;
        
        $tableHtml .= "<tr>";
        $tableHtml .= "<td>" . $course . "</td>";
        $tableHtml .= "<td>" . $cr . "</td>";
        $tableHtml .= "<td>" . $gp . "</td>";
        $tableHtml .= "<td>" . number_format($points, 2) . "</td>";
        $tableHtml .= "</tr>";
    }
    
    $tableHtml .= "</table>";
    
    // Calculate GPA
    if ($totalCredits > 0) {
        $gpa = $totalPoints / $totalCredits;
        
        if ($gpa >= 3.7) {
            $interpretation = "Distinction";
            $class = "distinction";
        } elseif ($gpa >= 3.0) {
            $interpretation = "Merit";
            $class = "merit";
        } elseif ($gpa >= 2.0) {
            $interpretation = "Pass";
            $class = "pass";
        } else {
            $interpretation = "Fail";
            $class = "fail";
        }
        
        $gpaResult = "<div class='result-box'>";
        $gpaResult .= "<h2>Your GPA Result</h2>";
        $gpaResult .= "<p><strong>Total Credits:</strong> " . $totalCredits . "</p>";
        $gpaResult .= "<p><strong>Total Grade Points:</strong> " . number_format($totalPoints, 2) . "</p>";
        $gpaResult .= "<p class='interpretation " . $class . "'>";
        $gpaResult .= "GPA: <strong>" . number_format($gpa, 2) . "</strong> (" . $interpretation . ")";
        $gpaResult .= "</p>";
        $gpaResult .= "</div>";
    } else {
        $gpaResult = "<p class='result-box'>No valid courses entered. Please check credit hours.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GPA Calculator - Step 2</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <h1>GPA Calculator</h1>
    
    <!-- Display results if available -->
    <?php if (!empty($tableHtml)): ?>
        <?php echo $tableHtml; ?>
        <?php echo $gpaResult; ?>
        <hr>
    <?php endif; ?>
    
    <!-- Form always appears -->
    <form action="index.php" method="post" onsubmit="return validateForm()">
        <div id="courses">
            <div class="course-row">
                <label>Course:</label>
                <input type="text" name="course[]" placeholder="e.g. Mathematics" required>
                
                <label>Credits:</label>
                <input type="number" name="credits[]" placeholder="e.g. 3" min="1" step="0.5" required>
                
                <label>Grade:</label>
                <select name="grade[]">
                    <option value="4.0">A (4.0)</option>
                    <option value="3.0">B (3.0)</option>
                    <option value="2.0">C (2.0)</option>
                    <option value="1.0">D (1.0)</option>
                    <option value="0.0">F (0.0)</option>
                </select>
            </div>
        </div>
        
        <button type="button" class="add-btn" onclick="addCourse()">+ Add Course</button>
        <br><br>
        <input type="submit" value="Calculate GPA">
    </form>
</body>
</html>
