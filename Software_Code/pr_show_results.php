---
layout: default
title: Results
---
<div class="container bg-white px-4">
  <div class="row">
    <div class="col">
      <?php
      include "assets/php/GLOBAL_CONFIG.php";
      // If not logged in (as Principal Researcher)
      if(!isset($_SESSION['researcherType']) || $_SESSION['researcherType'] != 'PR') {
        header("Location: login.php");
        exit;
      }
      // Logged in as PR
      else {
        $CURR_QUESTION = NULL; // Used for printing question names
        foreach ($_POST as $key => $value) {
          $FETCH_QUESTIONNAIRE_RESPONSES = "CALL `20agileteam2db`.`get_questions`(". $value .")";
          $STMT = $MYSQL_CONNECTION->prepare($FETCH_QUESTIONNAIRE_RESPONSES);
          $STMT->execute();
          $RESEARCHER_QUESTIONNAIRES = $STMT->fetchall();
          // For each answer in questionnaire
          foreach ($RESEARCHER_QUESTIONNAIRES as $row) {
            if ($row['Response'] != NULL) { // Open ended question
              if ($row["Question ID"] != $CURR_QUESTION){
                $CURR_QUESTION = $row["Question ID"];
                // echo $row['Description'] . "<br>";
                echo "<h3 class='text-primary mt-3 mb-1'>" . $row['Description'] . "</h3>";
              }
              echo $row['Response']. "<br>";
            }
            else { // Select one of the following or tick all of the following
              if ($row["Question ID"] != $CURR_QUESTION) {
                $CURR_QUESTION = $row["Question ID"];
                // echo $row['Description'] . "<br>";
                echo "<h3 class='text-primary mt-3 mb-1'>" . $row['Description'] . "</h3>";
              }
              $FETCH_QUESTION_OPTIONS = "CALL `20agileteam2db`.`options_for_question`(". $row['Question ID'] .")";
              $STMT = $MYSQL_CONNECTION->prepare($FETCH_QUESTION_OPTIONS);
              $STMT->execute();
              $QUESTION_OPTIONS = $STMT->fetchall();
              // Check the option corresponding to Option_ID
              foreach ($QUESTION_OPTIONS as $result) {
                if ($result['Option_ID'] == $row['Option ID']) {
                  echo $result['Options'];
                }
              }
              echo "<br>";
            }
          }
        }
      }
      ?>
    </div>
  </div>
</div>