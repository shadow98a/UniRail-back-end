<?php

    error_reporting(E_ALL);
    ini_set('display_errors',1);

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $object=$_POST['object'];
        $time=$_POST['time'];
        $problem=$_POST['problem'];

        if(empty($object)){
            $errMSG = "학번을 입력해 주시기를 바랍니다.";
        }
        else if(empty($time)){
            $errMSG = "비밀번호를 입력해 주시기를 바랍니다.";
        }
        else if(empty($problem)){
            $errMSG = "이름을 입력해 주시기를 바랍니다.";
        }

        if(!isset($errMSG))

        {
            try{

                $stmt = $con->prepare('INSERT INTO problem(object, time, problem) VALUES(:object, :time, :problem)');
                $stmt->bindParam(':object', $object);
                $stmt->bindParam(':time', $time);
                $stmt->bindParam(':problem', $problem);

                if($stmt->execute())
                {
                    $successMSG = "새로운 사용자를 추가했습니다.";
                }
                else
                {
                    $errMSG = "사용자 추가 에러";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage());
            }
        }

    }

?>


<?php
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;


    if (!$android)
    {
?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST">
                object: <input type = "text" name = "object" />
                time: <input type = "text" name = "time" />
                problem: <input type = "text" name = "problem" />
                <input type = "submit" name = "submit" />
            </form>

       </body>
    </html>

<?php
    }
?>
