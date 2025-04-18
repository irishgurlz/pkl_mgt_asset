<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mgt_asset";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];

    // Prepare and execute query
    $sql = "SELECT nama, organisasi.kode_org FROM employee 
            INNER JOIN organisasi ON employee.kode_org = organisasi.kode_org WHERE nik = ?";
    
    $stmt = $conn->prepare($sql);
    
    // Check if the query is prepared successfully
    if ($stmt) {
        $stmt->bind_param("s", $nik);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();
        if ($row = $result->fetch_assoc()) {
            $data = array(
                'nama' => $row['nama'],
                'kode_org' => $row['kode_org']
            );
        }

        // Output as JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Query preparation failed']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'NIK parameter is missing']);
}

$conn->close();
?>
