<?php
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    $executionStartTime = microtime(true);

    include("config.php");

    header('Content-Type: application/json; charset=UTF-8');

    $conn = new mysqli($cd_host, $cd_user, $cd_password, $cd_dbname, $cd_port, $cd_socket);

    if (mysqli_connect_errno()) {
        $output['status']['code'] = "300";
        $output['status']['name'] = "failure";
        $output['status']['description'] = "database unavailable";
        $output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
        $output['data'] = [];
        mysqli_close($conn);
        echo json_encode($output);
        exit;
    }

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $departmentID = $_POST['departmentID'];
    $jobTitle = $_POST['jobTitle'];
    $id = $_POST['id'];
    
    // Prepare query with placeholders
    $query = 'UPDATE personnel SET firstName = ?, lastName = ?, email = ?, departmentID = ?, jobTitle = ? WHERE id = ?';
    $stmt = $conn->prepare($query);
    
    // Bind parameters
    $stmt->bind_param("sssssi", $firstName, $lastName, $email, $departmentID, $jobTitle, $id);
    
    // Execute statement
    $result = $stmt->execute();
    
  
    
    
    if (!$result) {
        $output['status']['code'] = "400";
        $output['status']['name'] = "executed";
        $output['status']['description'] = "query failed";    
        $output['data'] = [];
        mysqli_close($conn);
        echo json_encode($output); 
        exit;
    }

    $data = [];

    $output['status']['code'] = "200";
    $output['status']['name'] = "ok";
    $output['status']['description'] = "success";
    $output['status']['returnedIn'] = (microtime(true) - $executionStartTime) / 1000 . " ms";
    $output['data'] = $data;

    mysqli_close($conn);

    echo json_encode($output);
?>
