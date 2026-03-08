<?php
if (isset($_POST['course']) && isset($_POST['credits']) && isset($_POST['grade'])) {
    
    $courses = $_POST['course'];
    $credits = $_POST['credits'];
    $grades = $_POST['grade'];
    
    $totalPoints = 0;
    $totalCredits = 0;
    
    // Start building the table
    echo "<h2>Course Summary</h2>";
    echo "<table>";
    echo "<tr>
            <th>Course</th>
            <th>Credits</th>
            <th>Grade</th>
            <th>Grade Points</th>
          </tr>";
    
    // Process each course
    for ($i = 0; $i < count($courses); $i++) {
        $course = htmlspecialchars($courses[$i]);
        $cr = floatval($credits[$i]);
        $gp = floatval($grades[$i]);
        
        // Skip invalid credits
        if ($cr <= 0) continue;
        
        $points = $cr * $gp;
        $totalPoints += $points;
        $totalCredits += $cr;
        
        echo "<tr>";
        echo "<td>" . $course . "</td>";
        echo "<td>" . $cr . "</td>";
        echo "<td>" . $gp . "</td>";
        echo "<td>" . number_format($points, 2) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Calculate and display GPA
    if ($totalCredits > 0) {
        $gpa = $totalPoints / $totalCredits;
        
        // Determine interpretation
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
        
        echo "<div class='result-box'>";
        echo "<h2>Your GPA Result</h2>";
        echo "<p><strong>Total Credits:</strong> " . $totalCredits . "</p>";
        echo "<p><strong>Total Grade Points:</strong> " . number_format($totalPoints, 2) . "</p>";
        echo "<p class='interpretation " . $class . "'>";
        echo "GPA: <strong>" . number_format($gpa, 2) . "</strong> (" . $interpretation . ")";
        echo "</p>";
        echo "</div>";
    } else {
        echo "<p class='result-box'>No valid courses entered. Please check credit hours.</p>";
    }
    
} else {
    echo "<p class='result-box'>Error: Form data not received properly.</p>";
}
?>
