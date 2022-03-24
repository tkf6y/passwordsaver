<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Password Manager</title>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">

        <br><br>

        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" minLength="5" required>
            </div><br>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
            </div>
            <br>
            <input type="submit" name="submit" class="btn btn-primary"></input>
        </form> 

        <?php

        //Including dbconfig file.
        include 'dbconfig.php';
        $conn = getDbConnection();

        if(isset($_POST["submit"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $EncryptPassword = md5($password);

            $stmt = $conn->prepare("INSERT INTO login (username, password, hashed_password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $password, $EncryptPassword);
            $stmt->execute();
        }

        $logins = [];

        $sql = "SELECT * FROM login";
        $stmt = mysqli_prepare($conn, $sql);


        if (false === $stmt) {
        echo mysqli_error($conn);
        } else {
            if (mysqli_stmt_execute($stmt)) {
                $results = mysqli_stmt_get_result($stmt);
                $logins = mysqli_fetch_all($results, MYSQLI_ASSOC);
            }
        }
        ?>

        <br>

        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th scope="col">Hashed Password</th>
            </tr>
        </thead>
        <tbody>
            <?php if(sizeof($logins) < 1) : ?>
                <strong style="color: red;">No records found!</strong><br><br>
            <?php elseif (sizeof($logins) == 1) : ?>
                <strong style="color: green;">1 record found!</strong><br><br>
            <?php else : ?>
                <strong style="color: green;"><?= sizeof($logins) ?> records found!</strong><br><br>
            <?php endif; foreach($logins as $login) : ?>
                <tr>
                <th scope="row"><?= $login["id"] ?></th>
                <td><?= $login["username"] ?></td>
                <td><?= $login["password"] ?></td>
                <td><?= $login["hashed_password"] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
</body>
</html>
