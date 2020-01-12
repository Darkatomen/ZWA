<?php
    include("_users.php");
    include("_articles.php");

    session_start();
    
    // Get the selected category
    $category = isset($_GET["category"]) ? strtolower($_GET["category"]) : "all";
    switch ($category)
    {
        case "all":
            $articles = getArticles();
            break;
        case "test":
            $articles = getArticlesByCategory("test");
            break;
        case "home":
            $articles = getArticlesByCategory("home");
            break;
        case "abroad":
            $articles = getArticlesByCategory("abroad");
            break;
        default:
            header("Location: novinky.php");
            break;
    }
    $latestArticle = getLatestArticle();

    $userId = isset($_SESSION["userId"]) ? $_SESSION["userId"] : false;
    if ($userId)
    {
        $user = getUserById($userId, $users);
    }
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <!-- TITLE AND ICON -->
    <title>ZWA News</title>
    <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
    <!-- CSS -->
    <link rel="stylesheet" href="CSS/head.css" media="all"/>
    <link rel="stylesheet" href="CSS/navigation_menu.css" media="all"/>
    <link rel="stylesheet" href="CSS/side_panel.css" media="all"/>
    <link rel="stylesheet" href="CSS/main_page.css" media="all"/>
    <link rel="stylesheet" href="CSS/novinky.css" media="all"/>
    <link rel="stylesheet" href="CSS/print.css" media="print"/>
    <!-- JAVASCRIPT -->
    <script src="JS/latest.js"></script>
</head>
<body>
    <!-- HEAD PANEL -->
    <div id="head">
        <h1><a href="novinky.php">ZWA News</a></h1>
        <h2><?php echo date("l - d.m.Y").", ".(date("W") % 2 == 0 ? "even" : "odd")." week";?></h2>
    </div>
    <!-- NAVIGATION MENU -->
    <nav id="navigation">
        <a href="novinky.php" <?php echo $category == "all" ? "class=\"active\"" : ""; ?>>ZWA News</a>
        <a href="novinky.php?category=home" <?php echo $category == "home" ? "class=\"active\"" : ""; ?>>Home</a>
        <a href="novinky.php?category=abroad" <?php echo $category == "abroad" ? "class=\"active\"" : ""; ?>>Abroad</a>
        <!-- login / logout -->
        <div id="user">
            <?php if ($userId) { ?>
                <?php if ($user["userRole"] == "admin") { ?> 
                    <a href="new_article.php">New article</a>
                <?php } ?>
                <a href="logout.php"><?php echo htmlspecialchars($user["firstname"]) ?> - Logout</a>
            <?php } else { ?>
                <a href="login.php">Login</a>
            <?php } ?>
        </div>
    </nav>
    <!-- PANEL WITH LATEST NEWS-->
    <div id="side">
        <div id="latest">
            <h2>Latest</h2>
            <?php
                $author = getUserById($latestArticle["authorId"], $users);
                echo "<h3><a href=\"".$latestArticle["url"]."\">".htmlspecialchars($latestArticle["title"])."</a></h3>";
                echo "<p class=\"author\">".date("d.m.Y, H:i e", $latestArticle["timestamp_created"]);
                echo " - ".htmlspecialchars($author["firstname"])." ".htmlspecialchars($author["lastname"])."</p>";
                echo "<p>".replacePlaceholders(htmlspecialchars(getArticleSummary($latestArticle)))."</p>";
            ?>
        </div>
    </div>
    <!-- ARTICLES -->
    <div class="mainPage">
        <?php
            foreach ($articles as $article)
            {
                $author = getUserById($article["authorId"], $users);
                echo "<div><h1><a href=\"".$article["url"]."\">".htmlspecialchars($article["title"])."</a></h1>";
                echo "<p class=\"author\">".date("d.m.Y, H:i e", $article["timestamp_created"]);
                echo " - ".htmlspecialchars($author["firstname"])." ".htmlspecialchars($author["lastname"])."</p>";
                echo "<p>".replacePlaceholders(htmlspecialchars(getArticleSummary($article)))."</p></div>";
            }
        ?>
    </div>
</body>
</html>