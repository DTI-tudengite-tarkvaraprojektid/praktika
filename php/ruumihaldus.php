<?php
require("functions.php");
// Check if session exists and matches DB by ID
if (!isset($_SESSION["userId"]) || checkIfIdInDb($_SESSION["userId"]) == 0) {
  session_destroy();
  header("Location: login.php");
  exit();
}

// Signing out
if (isset($_GET["logout"])) {
  session_destroy();
  header("Location: login.php");
  exit();
}
$notice = "";
$username = "";

$usernameError = "";
$passwordError = "";
$passwordError2 = "";

if (isset($_POST["submitUserData"])) { // Don't check before sending the form
  if (isset($_POST["username"]) and !empty($_POST["username"])) {
    $username = test_input($_POST["username"]);
  } else {
    $notice += "Palun sisesta oma kasutajanimi!";
  }

  if (isset($_POST["password"]) and !empty($_POST["password"])) {
    $password = test_input($_POST["password"]);
    if (strlen($password) < 8) {
      $notice += "Palun sisesta piisavalt pikk parool!";
    }
  } else {
    $notice += "Palun sisesta oma parool!";
  }

  if (isset($_POST["passwordconfirm"]) and !empty($_POST["passwordconfirm"])) {
    $password = test_input($_POST["password"]);
    if ($_POST["passwordconfirm"] != $_POST["password"]) {
      $notice += "Palun sisesta samad paroolid!";
    }
  } else {
    $notice += "Palun kinnita ka oma parooli!";
  }

  // Check if errors are empty
  if (empty($usernameError) and empty($passwordError) and empty($passwordError2)) {
    $notice += signup($username, $_POST["password"]);
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
  <link rel="stylesheet" href="../css/ruumihaldus.css">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous"></script>
  <script type="text/javascript">
    function reload() {
      setTimeout(function() {
        location.reload();
      }, 10);
    }
  </script>

  <script src="../js/force-https.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js" defer></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" defer></script>
  <script src="../js/ruumihaldus.js" defer></script>
  <title>DTI Ruumihaldus</title>
</head>

<body>
  <!-- RUUMID -->

  <div data-role="page" id="rooms">
    <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header" role="banner">
      <h1></h1>
    </div>
    <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header" role="banner">
      <h1 class="ui-title" tabindex="0" role="heading" aria-level="1"></h1>
      <a href="ruumihaldus.php#addUsers" data-icon="user">Lisa uus kasutaja</a>
      <a href="?logout=1" onclick="return reload();" data-icon="power">Logi välja</a>
    </div>
    <div data-role="navbar">
      <ul>
        <li><a href="#rooms" data-transition="none" data-icon="bars">Ruumid</a></li>
        <li><a href="#addRoom" data-transition="none" data-icon="plus">Lisa ruum</a></li>
        <li><a href="#corridors" data-transition="none" data-icon="bars">Koridorid</a></li>
      </ul>
    </div>
    <div data-role="content">
      <ul id="roomProperties" data-role="listview" data-filter="true" data-filter-placeholder="Otsi ruumi..." data-inset="true"></ul>
      <button id="downloadRoomsButton" data-theme="A">Lae ruumid alla</button>
      <button id="deleteRoomsButton" data-theme="A">Kustuta kõik ruumide andmed</button>
      <div>
        <label for="uploadRoomsButton" class="buttonLabel">Lae fail üles, et sealt andmed lehele lugeda:</label>
        <input type="file" data-theme="A" id="uploadRoomsButton">
      </div>
    </div>
    <div class="ui-footer ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="footer" role="banner">
      <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
    </div>
  </div>
  <!-- CORRIDORS -->

  <div data-role="page" id="corridors">
    <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header" role="banner">
      <h1></h1>
    </div>
    <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header" role="banner">
      <h1 class="ui-title" tabindex="0" role="heading" aria-level="1"></h1>
      <a href="ruumihaldus.php#addUsers" data-icon="user">Lisa uus kasutaja</a>
      <a href="?logout=1" onclick="return reload();" data-icon="power">Logi välja</a>
    </div>
    <div data-role="navbar">
      <ul>
        <li><a href="#rooms" data-transition="none" data-icon="bars">Ruumid</a></li>
        <li><a href="#addRoom" data-transition="none" data-icon="plus">Lisa ruum</a></li>
        <li><a href="#corridors" data-transition="none" data-icon="bars">Koridorid</a></li>
      </ul>
    </div>
    <div class="corridorEditor">
      <iframe src="editor.html" width="25%" height="700"></iframe>
    </div>
    <div class="ui-footer ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="footer" role="banner">
      <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
    </div>
  </div>

  <!-- ADD ROOM PAGE -->
  <div data-role="page" id="addRoom">
    <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header" role="banner">
      <h1></h1>
    </div>
    <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header" role="banner">
      <h1 class="ui-title" tabindex="0" role="heading" aria-level="1"></h1>
      <a href="ruumihaldus.php#addUsers" data-icon="user">Lisa uus kasutaja</a>
      <a href="?logout=1" onclick="return reload();" data-icon="power">Logi välja</a>
    </div>
    <div data-role="navbar">
      <ul>
        <li><a href="#rooms" data-transition="none" data-icon="bars">Ruumid</a></li>
        <li><a href="#addRoom" data-transition="none" data-icon="plus">Lisa ruum</a></li>
        <li><a href="#corridors" data-transition="none" data-icon="bars">Koridorid</a></li>
      </ul>
    </div>
    <div data-role="content">
      <form id="addForm">
        <label for="addClassCoordinates">Sisesta ruumi koordinaadid: </label>
        <input type="text" id="addClassCoordinates">

        <label for="addClassRoom">Sisesta ruumi nimi: </label>
        <input type="text" id="addClassRoom">

        <label for="addClassPeople">Sisesta ruumiga seotud isikud: </label>
        <input type="text" id="addClassPeople">

        <label for="addClassPurpose">Sisesta ruumi eesmärk: </label>
        <input type="text" id="addClassPurpose">

        <label for="addClassSeats">Sisesta ruumi kohtade arv: </label>
        <input type="number" id="addClassSeats" min="1" max="500">

        <label for="addClassComments">Lisa kommentaare: </label>
        <input type="text" id="addClassComments">

        <button id="submitAddRooms" class="ui-btn ui-corner-all">LISA</button>
      </form>
    </div>
    <div class="ui-footer ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="footer" role="banner">
      <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
    </div>
  </div>
  <!-- EDIT ROOM PAGE -->
  <div data-role="page" id="editRoomPage">
    <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header" role="banner">
      <h1></h1>
    </div>
    <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header" role="banner">
      <h1 class="ui-title" tabindex="0" role="heading" aria-level="1"></h1>
      <a href="ruumihaldus.php#addUsers" data-icon="user">Lisa uus kasutaja</a>
      <a href="?logout=1" onclick="return reload();" data-icon="power">Logi välja</a>
    </div>
    <div data-role="navbar">
      <ul>
        <li><a href="#rooms" data-transition="none" data-icon="bars">Ruumid</a></li>
        <li><a href="#corridors" data-transition="none" data-icon="bars">Koridorid</a></li>
        <li><a href="#addRoom" data-transition="none" data-icon="plus">Lisa ruum</a></li>
      </ul>
    </div>
    <div data-role="content">
      <form id="editRoomForm">
        <label for="editRoomCoordinates">Sisesta ruumi koordinaadid: </label>
        <input type="text" id="editRoomCoordinates">
        <label for="editRoom">Sisesta ruumi nimi: </label>
        <input type="text" id="editRoom">
        <label for="editPeople">Sisesta ruumiga seotud inimesed:</label>
        <input type="text" id="editPeople">
        <label for="editPurpose">Sisesta ruumiga eesmärk:</label>
        <input type="text" id="editPurpose">
        <label for="editSeats">Sisesta ruumi kohtade arv: </label>
        <input type="number" id="editSeats" min="1" max="500">
        <label for="editComments">Lisa kommentaare: </label>
        <input type="text" id="editComments">
        <button id="submitRoomEdit" class="ui-btn ui-corner-all">MUUDA</button>
      </form>
    </div>
    <div class="ui-footer ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="footer" role="banner">
      <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
    </div>
  </div>
  <!-- UUS KASUTAJA -->
  <div data-role="page" id="addUsers">
    <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header" role="banner">
      <h1></h1>
    </div>
    <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header" role="banner">
      <h1 class="ui-title" tabindex="0" role="heading" aria-level="1"></h1>
      <a href="ruumihaldus.php#addUsers" data-icon="user">Lisa uus kasutaja</a>
      <a href="?logout=1" onclick="return reload();" data-icon="power">Logi välja</a>
    </div>
    <div data-role="navbar">
      <ul>
        <li><a href="#rooms" data-transition="none" data-icon="bars">Ruumid</a></li>
        <li><a href="#addRoom" data-transition="none" data-icon="plus">Lisa ruum</a></li>
        <li><a href="#corridors" data-transition="none" data-icon="bars">Koridorid</a></li>
      </ul>
    </div>
    <div data-role="content">
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Kasutajanimi: </label>
        <input type="text" name="username" value="<?php echo $username; ?>"><span><?php echo $usernameError; ?></span>
        <label>Salasõna: </label>
        <input type="password" name="password" value=""><span><?php echo $passwordError; ?></span>
        <label>Salasõna uuesti: </label>
        <input type="password" name="passwordconfirm" value=""><span><?php echo $passwordError2; ?></span>
        <input type="submit" name="submitUserData" value="Loo kasutaja" target="_blank">
        <p><?php echo $notice; ?></p>
      </form>



    </div>
  </div>
  <div class="ui-footer ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="footer" role="banner">
    <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
  </div>
</body>

</html>
