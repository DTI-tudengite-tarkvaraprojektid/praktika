    <?php
  require("functions.php");
  //kui pole sisselogitud
  if(!isset($_SESSION["userId"])){
	  header("Location: login.php");
	  exit();
  }
  //väljalogimine
  if(isset($_GET["logout"])) {
	  session_destroy();
	  header("Location:login.php");
	  exit();
  }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">

      <link rel="stylesheet"
        href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
      <link rel="stylesheet" href="tlu.css" />

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
      <script src="ruumihaldus.js"></script>
      <title>DTI Ruumihaldus</title>
    </head>

    <body>




      <!-- HOME PAGE -->
      <div data-role="page" id="home">
        <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header"
          role="banner">
          <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
        </div>
        <div data-role="navbar">
          <ul>
            <li><a href="#home" data-transition="none" data-icon="home">Avaleht</a></li>
            <li><a href="#add" data-transition="none" data-icon="plus">Lisa</a></li>
            <!--<li><a href="#help" data-transition="flip" data-icon="comment">Abileht</a></li>
          <li><a href="#settings" data-transition="turn" data-icon="gear">Sätete leht</a></li>-->
          </ul>
        </div>
        <div data-role="content">
          <ul id="properties" data-role="listview" data-filter="true" data-filter-placeholder="Otsi ruumi..."
            data-inset="true"></ul>

          <button id="downloadButton" data-theme="A">Lae alla</button>
          <button id="deleteButton" data-theme="A" onclick="deleteAll()">Kustuta kõik andmed</button>
          <div>
            <label for="uploadButton" class="buttonLabel">Lae fail üles, et sealt andmed lehele lugeda:</label>
            <input type="file" data-theme="A" id="uploadButton">
          </div>
        </div>
        <div class="ui-footer ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="footer"
          role="banner">
          <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
        </div>
      </div>



      <!-- ADD PAGE -->
      <div data-role="page" id="add">
        <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header"
          role="banner">
          <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
        </div>
        <div data-role="navbar">
          <ul>
            <li><a href="#home" data-transition="none" data-icon="home">Avaleht</a></li>
            <li><a href="#add" data-transition="none" data-icon="plus">Lisa</a></li>
          </ul>
        </div>
        <div data-role="content">
          <form id="addForm">
            <!--<label for="addTask">Sisesta ülesande nimi: </label>
          <input type="text" id="addTask">
          <label for="addDate">Sisesta kuupäev:</label>
          <input type="text" data-role="date" class="date" id="addDate" data-inline="true">-->

            <label for="addClassCoordinates">Sisesta ruumi koordinaadid: </label>
            <textarea type="text" id="addClassCoordinates" rows="4" cols="50"></textarea>

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

            <button id="submitAdd" class="ui-btn ui-corner-all">LISA</button>
          </form>
        </div>
        <div class="ui-footer ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="footer"
          role="banner">
          <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
        </div>
      </div>

      <!-- EDIT PAGE -->
      <div data-role="page" id="edit">
        <div class="ui-header ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="header"
          role="banner">
          <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
        </div>
        <div data-role="navbar">
          <ul>
            <li><a href="#home" data-transition="none" data-icon="home">Avaleht</a></li>
            <li><a href="#add" data-transition="none" data-icon="plus">Lisa</a></li>
          </ul>
        </div>
        <div data-role="content">
          <form id="editForm">
            <label for="editCoordinates">Sisesta ruumi koordinaadid: </label>
            <input type="text" id="editCoordinates">
            <label for="editRoom">Sisesta ruumi nimi: </label>
            <input type="text" id="editRoom">
            <label for="editPeople">Sisesta ruumi eesmärk:</label>
            <input type="text" id="editPeople">
            <label for="editPurpose">Sisesta ruumiga seotud inimesed:</label>
            <input type="text" id="editPurpose">
            <label for="editSeats">Sisesta ruumi kohtade arv: </label>
            <input type="number" id="editSeats" min="1" max="500">
            <label for="editComments">Lisa kommentaare: </label>
            <input type="text" id="editComments">

            <button id="submitEdit" class="ui-btn ui-corner-all">LISA</button>
          </form>
        </div>
        <div class="ui-footer ui-bar-a" data-swatch="a" data-theme="A" data-form="ui-bar-a" data-role="footer"
          role="banner">
          <h1 class="ui-title" tabindex="0" role="heading" aria-level="1">DTI Ruumihaldus</h1>
        </div>
      </div>
    </body>

    </html>