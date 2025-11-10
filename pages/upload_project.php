<?php
session_start();


if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit();
}


if ($_SERVER['CONTENT_LENGTH'] > 15 * 1024 * 1024) {
    header("Location: upload_error.php?msg=❌ Uploaded data exceeds the allowed size limit.");
    exit();

}

require_once '../backend/db.php';


if (
    !isset($_POST['title'], $_POST['description'], $_POST['departmentID']) ||
    !isset($_FILES['project_file'], $_FILES['poster_image'])
) {
   header("Location: upload_error.php?msg=❌ Missing required fields or files.");
   exit();
}


$user_id   = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];


$title        = trim($_POST['title']);
$description  = trim($_POST['description']);
$departmentID = intval($_POST['departmentID']);
$category     = match ($departmentID) {
    101 => 'Information System',
    102 => 'Computer Science',
    103 => 'Network and Communications',
    default => 'Unknown',
};

// define file
$project_file = $_FILES['project_file'];
$poster_image = $_FILES['poster_image'];

// chech file location 
if ($project_file['error'] !== UPLOAD_ERR_OK || $poster_image['error'] !== UPLOAD_ERR_OK) {
    header("Location: upload_error.php?msg=❌ File upload error. Please check your file and try again.");
    exit();
}

// check file type
$allowed_exts = ['pdf', 'docx', 'pptx', 'jpg', 'jpeg', 'png'];
$project_ext  = strtolower(pathinfo($project_file['name'], PATHINFO_EXTENSION));
$poster_ext   = strtolower(pathinfo($poster_image['name'], PATHINFO_EXTENSION));

if (!in_array($project_ext, $allowed_exts) || !in_array($poster_ext, $allowed_exts)) {
    header("Location: upload_error.php?msg=❌ Unsupported file type. Allowed types: PDF, DOCX, PPTX, JPG, PNG.");
     exit();
}

// clean file name 
$clean_project_name = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $project_file['name']);
$clean_poster_name  = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $poster_image['name']);

$project_filename = uniqid('proj_') . '_' . $clean_project_name;
$poster_filename  = uniqid('poster_') . '_' . $clean_poster_name;


if (!is_dir('../files')) mkdir('../files', 0777, true);
if (!is_dir('../images')) mkdir('../images', 0777, true);


$project_path = 'files/' . $project_filename;
$poster_path  = 'images/' . $poster_filename;

// upload project
move_uploaded_file($project_file['tmp_name'], '../' . $project_path);

// If project file is PDF, add watermark using Python script
if ($project_ext === 'pdf') {
    $pythonCmd   = 'arch -x86_64 /usr/bin/python3';
    $pdfFullPath = '/Users/luoranasser/Downloads/E-library/' . $project_path;
    $scriptPath  = '/Users/luoranasser/Downloads/E-library/js/add_watermark.py';

    $command = $pythonCmd . ' ' . escapeshellarg($scriptPath) . ' ' . escapeshellarg($pdfFullPath) . ' 2>&1';
    shell_exec($command);
}

// رفع ملف البوستر
move_uploaded_file($poster_image['tmp_name'], '../' . $poster_path);



// التحقق من الاتصال بقاعدة البيانات
if (!$conn) {
    http_response_code(500);
    header("Location: upload_error.php?msg=❌ Database connection failed.");
    exit();

}

// تحضير الإدخال في قاعدة البيانات
$stmt = $conn->prepare("
    INSERT INTO PendingProject (
        uploadDate, title, description, category, projectPath, posterPath,
        facultyID, studentID, departmentID, submittedBy, status
    )
    VALUES (
        CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )
");

$facultyID   = ($user_type === 'faculty') ? $user_id : null;
$studentID   = ($user_type === 'student') ? $user_id : null;
$submittedBy = $user_id;
$status      = 'pending';

// ربط القيم
$stmt->bind_param("ssssssiiss",
    $title,
    $description,
    $category,
    $project_path,
    $poster_path,
    $facultyID,
    $studentID,
    $departmentID,
    $submittedBy,
    $status
);

// تنفيذ الإدخال
if ($stmt->execute()) {
    header("Location: track_projects.php?status_changed=success");
    exit();
} else {
    header("Location: track_projects.php?status_changed=fail");
    exit();
}


// تنظيف الاتصال
$stmt->close();
$conn->close();
?>
