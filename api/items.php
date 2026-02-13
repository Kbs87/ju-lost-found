<?php
header('Content-Type: application/json');
require_once '../includes/db.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Fetch items with optional search/filter
    $type = $_GET['type'] ?? 'all';
    $query = "SELECT * FROM items WHERE status = 'active'";
    $params = [];

    if ($type !== 'all') {
        $query .= " AND type = :type";
        $params[':type'] = $type;
    }

    $query .= " ORDER BY created_at DESC";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $items = $stmt->fetchAll();
        echo json_encode($items);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} elseif ($method === 'POST') {
    // Handle new item submission
    try {
        // Basic validation for required fields
        $required = ['type','item_name','description','location','event_date','contact_name','contact_phone'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => "Missing field: $field"]);
                exit;
            }
        }
        // Simple file upload logic
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
            
            $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                $imagePath = 'uploads/' . $fileName;
            }
        }

        $sql = "INSERT INTO items (type, item_name, description, location, event_date, contact_name, contact_phone, contact_email, image_path) 
                VALUES (:type, :item_name, :description, :location, :event_date, :contact_name, :contact_phone, :contact_email, :image_path)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':type' => $_POST['type'],
            ':item_name' => $_POST['item_name'],
            ':description' => $_POST['description'],
            ':location' => $_POST['location'],
            ':event_date' => $_POST['event_date'],
            ':contact_name' => $_POST['contact_name'],
            ':contact_phone' => $_POST['contact_phone'],
            ':contact_email' => $_POST['contact_email'] ?? '',
            ':image_path' => $imagePath
        ]);

        echo json_encode(['success' => true, 'message' => 'Item reported successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
