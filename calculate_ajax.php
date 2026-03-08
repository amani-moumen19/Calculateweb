<?php
header('Content-Type: application/json');

// Check if data received
if (!isset($_POST['course']) || !isset($_POST['credits']) || !isset($_POST['grade'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Form data not received properly.'
    ]);
    exit;
}

$courses = $_POST['course'];
$credits = $_POST['credits'];
$grades = $_POST['grade'];

$totalPoints = 0;
$totalCredits = 0;
$courseDetails = [];

// Process each course
for ($i = 0; $i < count($courses); $i++) {
    $courseName = htmlspecialchars($courses[$i]);
    $cr = floatval($credits[$i]);
    $gp = floatval($grades[$i]);
    
    // Skip invalid entries
    if (empty($courseName) || $cr <= 0) {
        continue;
    }
    
    $points = $cr * $gp;
    $totalPoints += $points;
    $totalCredits += $cr;
    
    $courseDetails[] = [
        'name' => $courseName,
        'credits' => $cr,
        'grade' => $gp,
        'points' => $points
    ];
}

// Calculate GPA
if ($totalCredits > 0) {
    $gpa = $totalPoints / $totalCredits;
    
    // Determine interpretation
    if ($gpa >= 3.7) {
        $interpretation = "Distinction";
    } elseif ($gpa >= 3.0) {
        $interpretation = "Merit";
    } elseif ($gpa >= 2.0) {
        $interpretation = "Pass";
    } else {
        $interpretation = "Fail";
    }
    
    echo json_encode([
        'success' => true,
        'courses' => $courseDetails,
        'total_credits' => $totalCredits,
        'total_points' => $totalPoints,
        'gpa' => $gpa,
        'interpretation' => $interpretation
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No valid courses entered. Please check credit hours.'
    ]);
}
?>
