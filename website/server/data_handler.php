<?php
session_start();

$conn = mysqli_connect('localhost','root','','php-project');

$id = $_SESSION['user']['id'];

// Вызов хранимой процедуры
$call = "CALL GetPersonalDataChangesById(".$id.")";
$procedureCall = $call;
$result = $conn->query($procedureCall);


// Проверка результата и формирование списка строк
if ($result->num_rows > 0) {
    $dataList = array();
    while ($row = $result->fetch_assoc()) {
        $dataList[] = $row;
        //die($row['telephone']);
    }
    $_SESSION['user']['dataList'] = $dataList;
    //die($summ);
    session_write_close();
    echo "Data retrieved successfully.";
} else {
    echo "No records found.";
}

header('Location: ../data.php'); 

?>