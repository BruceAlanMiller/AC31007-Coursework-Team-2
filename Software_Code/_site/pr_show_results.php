<!DOCTYPE html>
<html lang="en-US">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
  <title>Results - Questionnaire Extraordinare</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/consentStyleSheet.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container px-4">
    <a class="navbar-brand" href="index.html">Questionnaire Extraordinare</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.html">Home</a>
        </li>
		<li class="nav-item">
          <a class="nav-link" aria-current="page" href="createquestionnaire.php">Quiz Creator</a>
        </li>
      </ul>
      <div class="d-flex">
        <a class="btn btn-outline-light" href="assets/php/destroy_session.php">Log Out</a>
      </div>
    </div>
  </div>
</nav>
  <div class="container bg-white px-4">
  <div class="row">
    <div class="col">
      
      <!-- Link takes user back to dashboard -->
      <a href="dashboard.php" class="btn btn-primary my-2">Back to Dashboard</a>

      <?php
      include "assets/php/GLOBAL_CONFIG.php";
      // If not logged in (as Principal Researcher)
      if(!isset($_SESSION['researcherType']) || $_SESSION['researcherType'] != 'PR' && $_SESSION['researcherType'] != 'Lab Manager') {
        header("Location: login.php");
        exit;
      }
      // Logged in as a Researcher
      else {
        $_SESSION['currQnaire'] = $_POST['questionnaire']; // Used in individual_results.php for return button
        echo "<form action='individual_results.php' method='POST'>
          <label for='participants'>Filter by participant:</label>
          <select name='participant' id='participant'>";
          $FETCH_QUESTIONNAIRE_PARTICIPANTS = "CALL `20agileteam2db`.`get_questionnaire_response`(".$_POST['questionnaire'].");`";
          $STMT = $MYSQL_CONNECTION->prepare($FETCH_QUESTIONNAIRE_PARTICIPANTS);
          $STMT->execute();
          $RESEARCHER_PARTICIPANTS = $STMT->fetchall(); }
          foreach ($RESEARCHER_PARTICIPANTS as $ROW) {
            echo "<option name='". $ROW['Participant_ID'] . "' value='" . $ROW['Participant_ID'] . "'>" . $ROW['Participant_ID'] . "</option>";
          }
          echo "</select>
          <br><br>
          <input id='submit' name='submit' class='btn btn-lg btn-primary mt-0 mb-4' type='submit' value='Filter'>
        </form>";

        $CURR_QUESTION = NULL; // Used for printing question names
        foreach ($_POST as $key => $value) {
          if ($key != "submit")
          {
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
          else {
            echo "";
          }
        }

      ?>
    </div>
  </div>
</div>

  <script src="https://unpkg.com/@popperjs/core@2.4.0/dist/umd/popper.min.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/hideOverlay.js"></script>
</body>

</html>