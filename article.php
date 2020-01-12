<?php
    include("_users.php");
    include("_articles.php");

    session_start();

    $latestArticle = getLatestArticle();

    if (isset($_GET["id"]))
    {
        $selectedArticle = getArticleById($_GET["id"]);
        if (!empty($selectedArticle))
        {
            $category = $selectedArticle["category"];
            $author = getUserById($selectedArticle["authorId"], $users);
        }
        else
        {
            header("Location: novinky.php");
        }
    }
    else
    {
        header("Location: novinky.php");
    }

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
    <link rel="stylesheet" href="CSS/head.css" media="all"/>
    <link rel="stylesheet" href="CSS/navigation_menu.css" media="all"/>
    <link rel="stylesheet" href="CSS/side_panel.css" media="all"/>
    <link rel="stylesheet" href="CSS/main_page.css" media="all"/>
    <link rel="stylesheet" href="CSS/article.css" media="all"/>
    <link rel="stylesheet" href="CSS/print.css" media="print"/>
    <title>ZWA News</title>
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
    <!-- ARTICLE -->
    <div class="mainPage">
        <!-- TITLE -->
        <h1><?php echo htmlspecialchars($selectedArticle["title"]); ?></h1>
        <!-- TIME & AUTHOR -->
        <?php 
            echo "<p>".date("d.m.Y, H:i e", $selectedArticle["timestamp_created"]);
            echo " - ".$author["firstname"]." ".$author["lastname"]."</p>";
        ?>
        <!-- SUMMARY -->
        <?php 
            if (strlen($selectedArticle["summary"]) > 0)
            {
                echo "<p>".replacePlaceholders(htmlspecialchars($selectedArticle["summary"]))."</p>";
            }
        ?>
        <!-- IMAGE -->
        <?php
            if (strlen($selectedArticle["image"]) > 0)
            {
                echo "<img src=\"".htmlspecialchars($selectedArticle["image"])."\" alt=\"".htmlspecialchars($selectedArticle["image_description"])."\">";
            }
        ?>
        <!-- ARTICLE -->
        <?php echo "<article>".replacePlaceholders(htmlspecialchars($selectedArticle["article"]))."</article>"; ?>
    </div>
</body>
</html>