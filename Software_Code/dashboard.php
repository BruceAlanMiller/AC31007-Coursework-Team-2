---
layout: default
title: Dashboard
---
<div class="container bg-white px-4 py-2">
  <div class="row">
    <div class="col">
      // Button that redirects to dashboard.
      <a href="dashboard.php" class="btn btn-primary my-2">Back to Dashboard</a>
      <?php
      include "assets/php/GLOBAL_CONFIG.php";
      //If not logged in
      if(!isset($_SESSION['researcherType'])) {
        header("location: login.php");
        exit;
      }
      // elseif($_SESSION['researcherType'] == ){
      //
      // }
      //
      // elseif($_SESSION['researcherType'] == ){
      //
      // }
      ?>
      <?php
      if($_SESSION['researcherType'] == 'PR'){ // Shown to Principal Researchers
      // Show all of the given PR's questionnaires
      $FETCH_RESEARCHER_QUESTIONNAIRES = "CALL `20agileteam2db`.`researcher_questionnaires`(".$_SESSION['userid'].")";
      $STMT = $MYSQL_CONNECTION->prepare($FETCH_RESEARCHER_QUESTIONNAIRES);
      $STMT->execute();
      $RESEARCHER_QUESTIONNAIRES = $STMT->fetchall(); }

      elseif($_SESSION['researcherType'] == 'Lab Manager'){ // Shown to Lab Managers

      // Links to other lab manager pages such as manage_login and manage_researchers.
      echo '<a href="manage_researchers.php" class="btn btn-primary me-2">Manage Researchers</a><a href="manage_login.php" class="btn btn-primary">Manage Logins</a>';
      
      // Show all questionnaires
      $FETCH_RESEARCHER_QUESTIONNAIRES = "SELECT * FROM `20agileteam2db`.`all_questionnaires`";
      $STMT = $MYSQL_CONNECTION->prepare($FETCH_RESEARCHER_QUESTIONNAIRES);
      $STMT->execute();
      $RESEARCHER_QUESTIONNAIRES = $STMT->fetchall(); }


      ?>

      <h1 class="text-primary">Which questionnaire responses do you want to see?</h1>

      <!-- Dropdown to select questionnaire -->
      <form action="pr_show_results.php" method="POST">
        <label for="questionnaires">Questionnaire:</label>
        <select name="questionnaire" id="questionnaire">
          <?php foreach ($RESEARCHER_QUESTIONNAIRES as $ROW) {
            echo "<option name='". $ROW['Questionnaire ID'] . "' value='" . $ROW['Questionnaire ID'] . "'>" . $ROW['Questionnaire Name'] . "</option>";
          } ?>
        </select>
        <br><br>
        <input id="submit" name="submit" class="btn btn-lg btn-primary mt-0 mb-4" type="submit" value="Submit">
      </form>

      <form action="assets/php/export.php">
        <!-- Export Function -->
        <button class="btn btn-lg btn-primary mt-0 mb-4">Export Data</button>
      </form>
    </div>
  </div>
</div>
