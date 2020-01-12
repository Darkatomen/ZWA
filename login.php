<?php
    include("_users.php");
    include("_articles.php");

    session_start();

    $latestArticle = getLatestArticle();
    
    // Validate login
    if (isset($_POST['login']))
    {
        $username = isset($_POST['username']) ? $_POST['username'] : false;
        $password = isset($_POST['password']) ? $_POST['password'] : false;
        
        if ($username && $password)
        {
            $user = getUserByUsername($username, $users);
            
            if ($user)
            {
                if (password_verify($password, $user['passwordhash']))
                {
                    $_SESSION['userId'] = $user['id'];
                }
                else
                {
                    $error = "Wrong username or password!";
                }
            }
            else
            {
                $error = "Wrong username or password!";
            }
        }
        else
        {
            $error = "Wrong username or password!";
        }
    }

    if (isset($_SESSION["userId"]))
    {
        header("Location: novinky.php");
    }
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <!-- TITLE AND ICON -->
    <title>Login</title>
    <link rel="shortcut icon" href="logo.png" type="image/png">
    <!-- CSS -->
    <link rel="stylesheet" href="CSS/head.css" media="all"/>
    <link rel="stylesheet" href="CSS/navigation_menu.css" media="all"/>
    <link rel="stylesheet" href="CSS/side_panel.css" media="all"/>
    <link rel="stylesheet" href="CSS/main_page.css" media="all"/>
    <link rel="stylesheet" href="CSS/login.css" media="all"/>
    <link rel="stylesheet" href="CSS/print.css" media="print"/>
    <!-- JAVASCRIPT -->
    <script src="JS/login.js"></script>
</head>
<body>
    <!-- HEAD PANEL -->
    <div id="head">
        <h1><a href="novinky.php">ZWA News</a></h1>
        <h2><?php echo date("l - d.m.Y").", ".(date("W") % 2 == 0 ? "even" : "odd")." week";?></h2>
    </div>
    <!-- NAVIGATION MENU -->
    <nav id="navigation">
        <a href="novinky.php">ZWA News</a>
        <a href="novinky.php?category=home">Home</a>
        <a href="novinky.php?category=abroad">Abroad</a>
        <!-- login / logout -->
        <div id="user">
            <a href="login.php" class="active">Login</a>
        </div>
    </nav>
    <!-- PANEL WITH LATEST NEWS-->
    <div id="side">
        <div id="latest" class="panel">
        <h2>Latest</h2>
        <?php
            $author = getUserById($latestArticle["authorId"], $users);
            echo "<h3><a href=\"".$latestArticle["url"]."\">".htmlspecialchars($latestArticle["title"])."</a></h3>";
            echo "<p class=\"author\">".date("d.m.Y, H:i e", $latestArticle["timestamp_created"]);
            echo " - ".$author["firstname"]." ".$author["lastname"]."</p>";
            echo "<p>".replacePlaceholders(htmlspecialchars(getArticleSummary($latestArticle)))."</p>";
        ?>
        </div>
    </div>
    <!-- LOGIN -->
    <div class="mainPage">
        <form action="" method="post">
            <h2>Login</h2>
            <?php echo isset($error) ? "<p class=\"error\">".$error."</p>" : ""; ?>
            <label class="textbox">
                <h3>Username:</h3>
                <input type="text" required name="username" id="username" placeholder="Username" value=<?php echo isset($_POST["username"]) ? $_POST["username"] : "\"\""; ?>>
            </label>
            <label class="textbox">
                <h3>Password:</h3>
                <input type="password" required name="password" id="password" placeholder="Password">
            </label>
            <input type="submit" name="login" value="Login" id="submit">
        </form>
    </div>
    <script>init();</script>
</body>
</html>