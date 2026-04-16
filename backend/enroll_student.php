<?php
// 1. Set headers to return JSON format
header("Content-Type: application/json; charset=UTF-8");
ini_set('display_errors', 1);
error_reporting(E_ALL);


// 2. Enforce POST request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["status" => "error", "message" => "Method not allowed. Please use POST."]);
    exit;
}

// 3. Retrieve the two required parameters
$student_id = $_POST['student_id'] ?? '';
$subject_code = $_POST['subject_code'] ?? '';

// 4. Validate inputs
if (empty($student_id) || empty($subject_code)) {
    http_response_code(400); // Bad Request
    echo json_encode(["status" => "error", "message" => "Missing parameters. Both student_id and subject_code are required."]);
    exit;
}

// 5. Database Connection
$conn = new mysqli("localhost", "root", "", "school_app_db");
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit;
}

// 6. Logic Part 1: Check if the student exists in the system
$stmt = $conn->prepare("SELECT full_name FROM students WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Student not found - Multi-status response handling
    http_response_code(404); // Not Found
    echo json_encode(["status" => "error", "message" => "Student ID not found in the system."]);
    $stmt->close();
    $conn->close();
    exit;
}

// Fetch student name to include in the success payload
$student = $result->fetch_assoc();
$stmt->close();

// 7. Logic Part 2: Insert the enrollment record
$insert_stmt = $conn->prepare("INSERT INTO enrollments (student_id, subject_code) VALUES (?, ?)");
$insert_stmt->bind_param("ss", $student_id, $subject_code);

if ($insert_stmt->execute()) {
    // Success scenario
    http_response_code(201); // Created
    echo json_encode([
        "status" => "success",
        "message" => "Student successfully enrolled.",
        "data" => [
            "student_id" => $student_id,
            "student_name" => $student['full_name'],
            "subject_code" => $subject_code
        ]
    ]);
} else {
    // Database insertion failure
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Failed to enroll student due to a server error."]);
}

// Clean up connections
$insert_stmt->close();
$conn->close();
?>