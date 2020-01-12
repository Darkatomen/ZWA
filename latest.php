<?php
include("_users.php");
include("_articles.php");
$article = getLatestArticle();
echo "<h2>Latest</h2>";
$author = getUserById($article["authorId"], $users);
echo "<h3><a href=\"".$article["url"]."\">".htmlspecialchars($article["title"])."</a></h3>";
echo "<p class=\"author\">".date("d.m.Y, H:i e", $article["timestamp_created"]);
echo " - ".htmlspecialchars($author["firstname"])." ".htmlspecialchars($author["lastname"])."</p>";
echo "<p>".replacePlaceholders(htmlspecialchars(getArticleSummary($article)))."</p>";
?>