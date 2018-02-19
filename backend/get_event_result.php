
<?php

/***
 * 
 * 굳이 php 를 서버 사이드로 사용할 필요가 없다. 
 * 클라이언트에서 동작하는 서버 코드기 때문에 php 파일을 로드하여 그 안에서 html 을 표기하면 된다.
 * 
 * 그럼... 지금 작성한 각 html 페이지와 php 코드를 통합하자.
 * 
 */



$servername = "localhost";
$username = "newsong";
$password = "~!korea9800";
$dbname = "newsong";


//get Param from query string
$method = $_GET["m"];
$team_id = $_GET["tid"];
$event_id = $_GET["eid"];

if($method == "team"){
    // team result
    getEventResultWithTeamId($team_id);

}else if($method == "event"){
    // event result
    getEventResultWithEventId($event_id);

}else if($method == "all"){
    // total result
    getTotalResult();
}else{
    return;
}


function getEventResultWithEventId($eid){
    
    $conn = try_db_conn();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo("connection failed");
        return 0;
    }else{
        //Check event type 
        //점수 표기법 기본점수(+승패점수)
        $getEventResultQuery = 
            "SELECT a.team_name as team_name, b.rank, b.base_score, b.extra_score, b.is_win
            FROM newsong_event_result AS b
            INNER JOIN newsong_team AS a ON a.team_id = b.team_id
            WHERE b.event_id='$eid'
            ORDER BY rank";
        
        $result = $conn->query($getEventResultQuery);
        $result_table = "";
        $data = array();

        if ($result->num_rows > 0) {
            // output data of each row
            $idx = 0;
            while($row = $result->fetch_assoc()) {     
                echoWithUTF8Encoding("<tr class='odd'>");
                echoWithUTF8Encoding("<td>".$row["rank"]."</td>");
                echoWithUTF8Encoding("<td>".$row["team_name"]."</td>");
                echoWithUTF8Encoding("<td>".$row["base_score"]."( ".$row["extra_score"]." )</td>");
                echoWithUTF8Encoding("<td>".$row["is_win"]."</td>");
                echoWithUTF8Encoding("</tr>");
            }
            
        } else {
            return "error";

        }
    }
}

function getEventResultWithTeamId($tid){
    
    $conn = try_db_conn();
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo("connection failed");
        return 0;
    }else{
        $getTeamResultQuery = 
            "SELECT event_id, score, is_win FROM newsong_event_result WHERE team_id='$tid'";
        
        $result = $conn->query($getTeamResultQuery);
        
        $data = array();

        if ($result->num_rows > 0) {
            // output data of each row
            $idx = 0;
            while($row = $result->fetch_assoc()) {            
                $array_data = 
                    array(                
                        "event_id" => '"'.$row["event_id"].'"', 
                        "score" => '"'.$row["score"].'"',                         
                        "is_win" => '"'.$row["is_win"].'"'
                    ); 
                
                echo $array_data."<br>";
                array_push($data, $array_data);
                $idx++;

            }
            echo json_encode($data)."<br>";
        } else {
            echo "getEventResultWithTeamId()<br/>";
            echo "0 results<br>";
        }
    }
}

function getTotalResult(){

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
            echo "getTotalResult();<br/>";
            echo "0 results<br>";
        }

        $conn->close();
    }
}


function try_db_conn(){
    // Create connection
    $mconn = new mysqli($GLOBALS[servername], $GLOBALS[username], $GLOBALS[password], $GLOBALS[dbname]);
    return $mconn;
}


function echoWithUTF8Encoding($text){
    
    echo iconv("euc-kr", "utf-8", $text);
}
?>

