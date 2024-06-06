<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

function ensureUploadsDirectory() {
    $targetDirectory = "uploads/";
    if (!is_dir($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }
}

function handleFileUpload($fileKey) {
    ensureUploadsDirectory(); 
    $targetDirectory = "uploads/";
    $fileExtension = pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION);
    $baseName = pathinfo($_FILES[$fileKey]['name'], PATHINFO_FILENAME);
    $newFileName = $baseName . "_" . uniqid() . '.' . $fileExtension;
    $targetFile = $targetDirectory . $newFileName;

    if ($_FILES[$fileKey]['size'] > 5000000) {
        return ['error' => "File is too large.", 'path' => null];
    }
    if (strtolower($fileExtension) != "pdf") {
        return ['error' => "Only PDF files are allowed.", 'path' => null];
    }
    if (!move_uploaded_file($_FILES[$fileKey]['tmp_name'], $targetFile)) {
        return ['error' => "Error uploading file. Check directory permissions and file path.", 'path' => null];
    }
    return ['error' => null, 'path' => $targetFile];
}

$host = '127.0.0.1';
$port = 3306;
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projectName = $_POST['projectName'] ?? '';
    $projectRequirements = $_POST['projectRequirements'] ?? '';
    $projectLocation = $_POST['projectLocation'] ?? '';
    $locationDetails = $_POST['locationDetails'] ?? '';
    $planFile = handleFileUpload('planFile');
    $designFile = handleFileUpload('designFile');

    if ($planFile['error'] || $designFile['error']) {
        echo $planFile['error'] ?? $designFile['error'];
        exit();
    }

    $sql = "INSERT INTO customerprojects (ProjectName, ProjectRequirements, ProjectLocation, LocationDetails, PlanFilePath, DesignFilePath) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $pdo->beginTransaction();
    try {
        $stmt->execute([$projectName, $projectRequirements, $projectLocation, $locationDetails, $planFile['path'], $designFile['path']]);
        $pdo->commit();
        header('Location: http://localhost/project_Bonyan/code/CODE_HTML/Homepagecustomr.html');
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>
