<?php
/*require_once("db_config.php");

$templateParams["title"] = "Profile";
$templateParams["homepage"] = "";
$templateParams["notifications"] = "";
//$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "../js/settings.js");

require("../template/base.php");*/
?>

<?php
require_once 'db_config.php';
define("IMG_PATH", "../img/");

$templateParams["title"] = "Profile";
$templateParams["user_exists"] = false;
$templateParams["errormsg"] = "Missing username";
//$templateParams["paginaprofilouser"]=$_SESSION["username"];
$templateParams["name"]=null;
$templateParams["homepage"] = "";
$templateParams["notifications"] = "";

if (isset($_GET["username"])) {
    /*$templateParams["user_exists"] = $dbh->checkValueInDb("user", "username", $_GET["username"]);*/
    $templateParams["user_exists"]=true;
    if ($templateParams["user_exists"]) {
        $templateParams["name"] = "show-profile.php";
        $user = $dbh->getUserInfo($_GET["username"]);
        $templateParams["username"] = $_GET["username"];
        $templateParams["bio"] = $user["bio"];
        $templateParams["user_image"] = IMG_PATH . $user["urlProfilePicture"];
        $templateParams["birthDate"] = $user["birthDate"];
        $templateParams["email"] = $user["email"];
        $templateParams["name"] = $user["name"];
        $templateParams["surname"] = $user["surname"];
        /*$templateParams["post_count"] = $dbh->getPostCountFromUser($templateParams["username"]);
        $templateParams["follower_count"] = $dbh->getFollowerCount($templateParams["username"]);
        $templateParams["followed_count"] = $dbh->getFollowedCount($templateParams["username"]);*/
        $templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "../js/profile.js");
        //$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "../js/user-profile-list.js");
        //$templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "../js/reactions.js", "../js/utils.js", "../js/user-profile-list.js", "../js/follow.js");
    } else {
        $templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "../js/utils.js");
        $templateParams["errormsg"] = "Utente non trovato.";
        $templateParams["name"] = "show-error.php";
    }
}

require '../template/base.php'
?>