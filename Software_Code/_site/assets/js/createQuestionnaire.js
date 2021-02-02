let questionnaireJson = {}; // Will store question, tpye and options.

// Sets the dropdown value to text as default.
document.getElementById("question_type").value = "Text";
dropdownTypeChanged();

// Shows or hides specified element. Takes in the element id and boolean value. True to show the element and false to hide it.
function toggleElement(id, bool) {
  if (bool) {
    document.getElementById(id).style.display = "block";
  } else {
    document.getElementById(id).style.display = "none";
  }
}

// Shows/hides options based on dropdown selection.
function dropdownTypeChanged() {

  if (document.getElementById("question_type").value == "Tick all that apply") {
    toggleElement('type_options', true);
  }
  else if (document.getElementById("question_type").value == "Pick one option") {
    toggleElement('type_options', true);
  }
  else {
    toggleElement('type_options', false);
  }
}

function createQuestion() {
 
  let questionName = document.getElementById('question_input').value; // Gets the question input.
  
  // If question is empty, alert and don't do anything.
  if (questionName == '') {
    alert('Please enter a question.')
    return;
  }

  let responseJson= {};// Creates object for response attributes.
  const dropdownValue = document.getElementById("question_type").value; // Gets dropdown value.
  
  let response = document.createElement('div'); // Allows to display input.

  if (dropdownValue == "Text") {

    // Creates attributes relevant to text input and displays in preview.
    responseJson.type = "1";
    responseJson.options = null;
    response.innerHTML = '<textarea class="form-control"></textarea>';

  }
  else if (dropdownValue == "Whole Number") {

    responseJson.type = "2";
    responseJson.options = null;
    response.innerHTML = '<input type="number" class="form-control" value="0">';

  }
  else if (dropdownValue == "Tick all that apply") {

    responseJson.type = "3";
    let optionsArray = []; // To store user options.
    var lines = document.getElementById('options_input').value.split('\n'); 
    for(var i = 0;i < lines.length;i++){
      if (lines[i] != '') {

        optionsArray.push(lines[i]);
        response.innerHTML += '<div class="form-check"><input class="form-check-input" type="checkbox" disabled><label class="form-check-label">' + lines[i] + '</label></div>';
      }
    }
    responseJson.options = optionsArray; // Stores options.
  }
  // Creates attributes relevant to text input and displays in preview.
  else if (dropdownValue == "Pick one option") {
    responseJson.type = "4";
    let optionsArray = []; // To store user options.
    
    var lines = document.getElementById('options_input').value.split('\n');
    for(var i = 0;i < lines.length;i++){
      
      // If line isn't empty.
      if (lines[i] != '') {

        optionsArray.push(lines[i]);
        response.innerHTML += '<div class="form-check"><input class="form-check-input" type="radio" disabled><label class="form-check-label">' + lines[i] + '</label></div>';
      }
    }

    responseJson.options = optionsArray; // Stores options.
  }
  else {
    alert('Invalid question input type.');
    return;
  }
  // Saves question and response atributes.
  questionnaireJson[questionName] = responseJson;
  // Previews question and response by creating html elements.
  let previewQuestion = document.createElement('div');
  previewQuestion.className = "my-4";
  let question = document.createElement('h4');
  question.innerText = questionName;

  previewQuestion.appendChild(question);
  previewQuestion.appendChild(response);
  document.getElementById('question_stack').appendChild(previewQuestion);
  document.getElementById('question_input').value = '';
  document.getElementById('options_input').value = '';
}

dropdownTypeChanged();function submitQuestionnaire() {
function submitQuestionnaire() {

  // Cancel submit if quesitonnaire title is missing.
  if (document.getElementById('questionnaire_title').value == '') {
    alert('Questionnaire title cannot be empty.')
    return;
  }

  // Cancel submit if there are no questions.
  if (Object.keys(questionnaireJson).length <= 0) {
    alert('You cannot submit an empty questionnaire.')
    return;
  }
  
  questionnaireJson.Title = document.getElementById('questionnaire_title').value; // Saves title

  // Creates a hidden text box input to store value of 'questionnareJson' so that php receives it.
  let submitElement = document.createElement('input');
  submitElement.value = JSON.stringify(questionnaireJson);
  submitElement.type = "text";
  submitElement.setAttribute("name", "question_json");
  submitElement.style = "display: none";
  document.getElementById('createQuiz').appendChild(submitElement);

  console.log(questionnaireJson);
