<?php
require_once("db_config.php");

$numeropost = 1; //prende un post alla volta
$var = false;
$modifyButton= false;
if (isset($_SESSION["username"]) && isset($_POST["postsView"])) {
    if($_POST["postsView"] == "HomePage") {
        $post = $dbh->getHomePosts($_SESSION["username"], $numeropost); //prende i post degli utenti che segue
    } else if($_POST["postsView"] == "Explore") {
        $post = $dbh->getExplorePosts($_SESSION["username"], $numeropost);
    } else if($_POST["postsView"] == "Profile") {
        $post = $dbh->getAllUserPosts($_POST["username"]); //query post utente
        $modifyButton = true;
    }
    
    for($i = 0; $i < count($post); $i++) {
        $post[$i]["datePost"] = date("F j, Y", strtotime($post[$i]["datePost"]));
        $post[$i]["num_comments"] = $dbh->getPostComments($post[$i]["postID"]);
        
        $reactCount = $dbh->getAllReactionCount($post[$i]["postID"]);
        $post[$i] = array_merge($post[$i] , $reactCount);
        $userReactions = $dbh->hasReactedAll($_SESSION["username"], $post[$i]["postID"]);
        
        $post[$i] = array_merge($post[$i] , $userReactions);
        $post[$i]["modifyButton"] = $modifyButton;
        $var = true;
    }
}

$post1["posts"] = $post;
$post1["success"] = $var;

$templateParams["title"] = "Show Post";
header("Content-Type: application/json");
echo json_encode($post1);

?>