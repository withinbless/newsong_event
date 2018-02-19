<?php 

$servername = "localhost";
$username = "newsong";
$password = "~!korea9800";
$dbname = "newsong";

$get_total_result_query = 
    "SELECT team_id, SUM(score) as score, COUNT(team_id) as game_count, SUM(is_win) as win_count FROM newsong_event_result group by team_id order by score desc";

$conn = try_db_conn();


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo("connection failed");
    return 0;
}else{

    $result = $conn -> query($get_total_result_query);
    $data = array();
    if ($result->num_rows > 0) {
        // output data of each row
        $idx = 0;
        while($row = $result->fetch_assoc()) {            
            $array_data = 
                array(                
                    "team_id" => '"'.$row["team_id"].'"', 
                    "score" => '"'.$row["score"].'"', 
                    "game_count" => '"'.$row["game_count"].'"', 
                    "win_count" => '"'.$row["win_count"].'"'
                ); 
            
            echo $array_data."<br>";
            array_push($data, $array_data);
            $idx++;

        }
        echo json_encode($data)."<br>";
    } else {
        echo "0 results<br>";
    }

    $conn->close();
}


function try_db_conn(){
    // Create connection
    $mconn = new mysqli($GLOBALS[servername], $GLOBALS[username], $GLOBALS[password], $GLOBALS[dbname]);
    return $mconn;
}

?>