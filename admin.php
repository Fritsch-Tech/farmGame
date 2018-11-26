<?php
    require_once "util/DBConnection.php";
    session_start();

    if($_SESSION['login'] !== True) {
        header('LOCATION:login.php');
        die();
    }

?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title>Admin</title>
</head>
    <body>
        <table class="table table-striped table-dark table-bordered">
        <tr>
            <th>id</th>
            <th>Vorname</th>
            <th>Nachname</th>
            <th>username</th>
            <th>eMail</th>
            <th>Hash</th>
        </tr>
        <?php
        $db = DBConnection::getConnection();
        $stmt = $db->prepare("SELECT * FROM user");
        $stmt->bindParam(':username',	$_SESSION['username']);
        $stmt->execute();

        $data = $stmt->fetchALL(PDO::FETCH_OBJ);
        foreach($data as $user){
            echo('
                <tr>
                    <td>'.$user->id.'</td>
                    <td>'.$user->name.'</td>
                    <td>'.$user->surname.'</td>
                    <td>'.$user->username.'</td>
                    <td>'.$user->eMail.'</td>
                    <td>'.$user->passwort.'</td>
                </tr>
            ');
        }
        ?>
        </table>
        <br/><button onclick='window.location.reload(true);'>RELOAD</button></a><br/>
        <a href="login.php"><button>LOGOUT</button></a><br/>
    </body>
</html>
