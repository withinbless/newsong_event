<?php
$servername = "localhost";
$username = "newsong";
$password = "~!korea9800";
$dbname = "newsong";



//get Param from query string
$team_id = $_GET["team_id"];
$event_id = $_GET["event_id"];
$rank = $_GET["rank"];
$is_win = $_GET["is_win"];    

$is_ranking_event = false;
$event_type = 0;

// SQL Logic
// Table List
//  1. newsong_team
//      team_id
//      team_name
//  2. newsong_event
//      event_id
//      event_type
//  3. newsong_event_result
//      team_id
//      event_id
//      rank
//      score

echo("team_id :: $team_id / event_id :: $event_id / rank :: $rank / is_win :: $is_win <br>");

/*** Check Event Type by EventId ***/
$event_type = check_event_type($event_id);

/*** Insert Event Result When EventType is valided ***/
if($event_type > 0){
    insert_event_result($event_type);
}else{
    echo "ERROR <br>";
}

/*** Insert Event Result With TeamId, EventId, Rank, Score_At_Event ***/
function insert_event_result($event_type) {
    $score = 0;
    $rank = $GLOBALS[rank];
    $is_win = $GLOBALS[is_win];

    $conn = try_db_conn();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo("connection failed");
        return 0;
    }else{

        if($event_type == 1){
            //승패전 점수 계산
            //승자팀 +15
            //패자팀 +5
            $rank = 0;

            if($is_win){
                $score = 15;
            }else{
                $score = 5;
            }     

        }else if($event_type == 2){
            //순위전 점수 계산
            //순위별 점수 차등

            if($rank == 1){
                $score = 20;
            }else{
                $score = 20 - (($rank -1) * 2);
            }

            if($is_win){
                $score += 5;
            }
        }

        $insert_event_result_query = 
            "INSERT INTO newsong_event_result ( event_id, team_id, rank, is_win, score ) VALUES ('$GLOBALS[event_id]', '$GLOBALS[team_id]', $rank, '$GLOBALS[is_win]', $score)";
     
        $conn->query($insert_event_result_query);
    }
}

function check_event_type($event_id){

    $conn = try_db_conn();

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo("connection failed");
        return 0;
    }else{
        echo "***** CHECK EVENT TYPE FUNCTION *****<br>";
        /**CHECK EVENT TYPE**/
        $check_event_type_query = 
            "SELECT event_type FROM newsong_event WHERE event_id=$event_id";

        // 쿼리 실행 후 결과값 저장
        $result = $conn->query($check_event_type_query);

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $event_type = $row["event_type"];
            echo $event_type . "<br>";
        }
        } else {
            echo "0 results<br>";
        }

        $conn->close();
        return $event_type;
    }
}

function try_db_conn(){
        // Create connection
    $mconn = new mysqli($GLOBALS[servername], $GLOBALS[username], $GLOBALS[password], $GLOBALS[dbname]);
    return $mconn;
}

?>