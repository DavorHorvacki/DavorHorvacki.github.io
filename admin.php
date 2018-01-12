<?php session_start(); ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
      <link type="text/css" rel="stylesheet" href="cssdeo.css" />
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Permanent+Marker|Cuprum" rel="stylesheet">
      <title></title>

      <style>
          table th{
              border-bottom: solid 3pt darkblue;
              font-size: 20px;

          }

          table td{
              border-bottom: solid 1pt darkblue;
              font-size: 15px;
          }

      </style>
  </head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <body>

  <div style="background-color: #ebebeb;border-bottom: 1px solid #9d9d9d;">
      <a href="admin.php"><img src="pitalice_logo.png" height="140px" style="margin-right: 12%;margin-top: -1%"></a>
    <button class="button" type="button" name="button" id="lista_pitanja" style="margin-right: 2%">Lista pitanja</button>
    <button class="button" type="button" name="button" id="lista_odgovora">Lista odgovora</button>
      <a href="logout.php"><button class="button" type="button" name="button" id="lista_odgovora">Odjava</button></a>

  </div>
  <br/><br/>
    <table id="table" hidden="hidden" style="margin: auto;font-family: 'Cuprum', sans-serif;" >
         <tr>
             <th>&nbsp;Username&nbsp;</th>
             <th>&nbsp;User ID&nbsp;</th>
         </tr>
         <tbody id="tbody">

         </tbody>
     </table>
     <div id="statistics-content">
     <table id="korisnicki_odgovori" hidden="hidden" style="margin: auto;font-family: 'Cuprum', sans-serif;">
          <tr>
              <th class="tableth">&nbsp;Odgovor ID&nbsp;</th>
              <th class="tableth">&nbsp;User ID&nbsp;</th>
              <th class="tableth">&nbsp;Pitanje ID&nbsp;</th>
              <th class="tableth">&nbsp;Odgovor&nbsp;</th>
              <th class="tableth">&nbsp;Ocena&nbsp;</th>
          </tr>
          <tbody id="tbody">

          </tbody>
      </table>

  <br/><br/>
     <table id="pitanja_table" hidden="hidden" style="margin: auto;font-family: 'Cuprum', sans-serif;">
          <tr>
              <th class="tableth">&nbsp;Pitanje ID&nbsp;</th>
              <th class="tableth">&nbsp;Pitanje&nbsp;</th>
              <th class="tableth">A</th>
              <th class="tableth">B</th>
              <th class="tableth">C</th>
              <th class="tableth">D</th>
              <th class="tableth">Izmene/Statistika</th>
          </tr>
          <tbody id="tbody">

          </tbody>
      </table>
      <br><br>
      <div id="changeQuestion" hidden="hidden" class="col-sm-offset-4">
        <div class="changeInfo"></div>
        <label for="pitanje"><h3>Pitanje: </h3> </label><input type="text" name="username" placeholder="Pitanje" class="logininputs" id="pitanje">
        <br/><br/>
        <label for="pitanje"><h3>Odgovor A): </h3> </label><input type="text" name="username" placeholder="Odgovor A" class="logininputs" id="odgovor_a">
        <br/><br/>
        <label for="pitanje"><h3>Odgovor B): </h3> </label><input type="text" name="username" placeholder="Odgovor B" class="logininputs" id="odgovor_b">
        <br/><br/>
        <label for="pitanje"><h3>Odgovor C): </h3> </label><input type="text" name="username" placeholder="Odgovor C" class="logininputs" id="odgovor_c">
        <br/><br/>
        <label for="pitanje"><h3>Odgovor D): </h3> </label><input type="text" name="username" placeholder="Odgovor D" class="logininputs" id="odgovor_d">
        <br/><br/>
        <button name="update" id="updatebutton" class="btn btn-success">Azuriraj</button>
      </div>

        <br/><br/>
      <table id="odgovori_table" hidden="hidden" style="margin: auto;font-family: 'Cuprum', sans-serif;">
           <tr>
               <th class="tableth">&nbsp;Odgovor ID&nbsp;</th>
               <th class="tableth">&nbsp;User ID&nbsp;</th>
               <th class="tableth">&nbsp;Pitanje ID&nbsp;</th>
               <th class="tableth">&nbsp;Odgovor&nbsp;</th>
               <th class="tableth">&nbsp;Ocena&nbsp;</th>
           </tr>
           <tbody id="tbody">

           </tbody>
       </table>

       <table id="CIquestions" hidden="hidden" style="margin: auto;font-family: 'Cuprum', sans-serif;">
            <tr>
                <th class="tableth">&nbsp;Pitanje ID&nbsp;</th>
                <th class="tableth">&nbsp;Tacnih&nbsp;</th>
                <th class="tableth">&nbsp;Pogresnih&nbsp;</th>
            </tr>
            <tbody id="tbody">

            </tbody>
        </table>

        <table id="questionDiffs" hidden="hidden" style="margin: auto;font-family: 'Cuprum', sans-serif;">
             <tr>
                 <th class="tableth">&nbsp;Pitanje ID&nbsp;</th>
                 <th class="tableth">&nbsp;Easy&nbsp;</th>
                 <th class="tableth">&nbsp;Medium&nbsp;</th>
                 <th class="tableth">&nbsp;Hard&nbsp;</th>
             </tr>
             <tbody id="tbody">

             </tbody>
         </table>

    </div>


  </body>

  <script>
  var userList=[];
  var questionsList=[];
  var answersList=[];
  var userAnswers=[];
  getData("user list"); //defaultni poziv- lista korisnika

  function getUserAnswers(user_id) {
      $.ajax({
          data: { data: "answers list for user",user_id: user_id },
          type: "POST",
          url: "administration.php",

          success: function(data){
            userAnswers = [];
                tempUserAnswers= JSON.parse(data);
                for (var i = 0; i < tempUserAnswers.length; i++) {
                  userAnswers.push({
                  odgovor_id: tempUserAnswers[i].odgovor_id,
                  user_id: tempUserAnswers[i].user_id,
                  pitanje_id: tempUserAnswers[i].pitanje_id,
                  odgovor: tempUserAnswers[i].odgovor,
                  ocena: tempUserAnswers[i].ocena
                  });
                }
                  if (tempUserAnswers != "No answers") {
                    userAnswersAppend();
                  } else {
                    document.getElementById("pitanja_table").hidden = "hidden";
                    document.getElementById("CIquestions").hidden = "hidden";
                    document.getElementById("changeQuestion").hidden = "hidden";
                    document.getElementById("odgovori_table").hidden = "hidden";
                    document.getElementById("questionDiffs").hidden = "hidden";
                    document.getElementById("korisnicki_odgovori").hidden = "";
                    $("#korisnicki_odgovori .dynamicWrite").empty();
                    tr = $('<tr class="dynamicWrite"/>');
                    tr.append("<td class='tabledata' colspan='5'>" + tempUserAnswers + "</td>");
                    $('#korisnicki_odgovori').append(tr);
                  }

              }
            });

  }

  function getData(data) {
    var dataTxt = data;
      $.ajax({
          data: { data: data },
          type: "POST",
          url: "administration.php",

          success: function(data){
            switch (dataTxt) {
              case "user list":
                userList = [];
                tempUser= JSON.parse(data);
                for (var i = 0; i < tempUser.length; i++) {
                  userList.push({
                  username: tempUser[i].username,
                  user_id: tempUser[i].user_id
                  });
                }
                getUsers();
                break;
              case "questions list":
                questionsList=[];
                tempQuestions= JSON.parse(data);
                for (var i = 0; i < tempQuestions.length; i++) {
                  questionsList.push({
                  pitanje_id: tempQuestions[i].pitanje_id,
                  pitanje: tempQuestions[i].pitanje,
                  a: tempQuestions[i].a,
                  b: tempQuestions[i].b,
                  c: tempQuestions[i].c,
                  d: tempQuestions[i].d
                  });
                }
                questionsAppend();
                break;

                case "answers list":
                  answersList = [];
                  tempAnswers= JSON.parse(data);
                  for (var i = 0; i < tempAnswers.length; i++) {
                    answersList.push({
                    odgovor_id: tempAnswers[i].odgovor_id,
                    user_id: tempAnswers[i].user_id,
                    pitanje_id: tempAnswers[i].pitanje_id,
                    odgovor: tempAnswers[i].odgovor,
                    ocena: tempAnswers[i].ocena
                    });
                  }
                  answersAppend();
                  break;
            }
              // tempUser= JSON.parse(data);
              // for (var i = 0; i < tempUser.length; i++) {
              //   userList.push({
              //   username: tempUser[i].username,
              //   user_id: tempUser[i].user_id
              //   });
              // }
          }
      });//ajax
  };

$('#lista_pitanja').on("click", function() {
    getData("questions list");//poziv liste pitanja
});

$('#lista_odgovora').on("click", function() {
    getData("answers list")//poziv liste odgovora
});

function questionsAppend() {
  document.getElementById("odgovori_table").hidden = "hidden";
  document.getElementById("korisnicki_odgovori").hidden = "hidden";
  document.getElementById("CIquestions").hidden = "hidden";
  document.getElementById("questionDiffs").hidden = "hidden";
  document.getElementById("changeQuestion").hidden = "hidden";
  document.getElementById("pitanja_table").hidden = "";
  $("#pitanja_table .dynamicWrite").empty();
  let tr;
  for (var i = 0; i < questionsList.length; i++) {
      tr = $('<tr class="dynamicWrite"/>');
      tr.append("<td class='tabledata pitanje_id'>" + questionsList[i].pitanje_id + "</td>");
      tr.append("<td class='tabledata'>" + questionsList[i].pitanje + "</td>");
      tr.append("<td class='tabledata'>" + questionsList[i].a + "</td>");
      tr.append("<td class='tabledata'>" + questionsList[i].b + "</td>");
      tr.append("<td class='tabledata'>" + questionsList[i].c + "</td>");
      tr.append("<td class='tabledata'>" + questionsList[i].d + "</td>");
      tr.append("<td class='tabledata'> <span style='float:left;margin-left:20px; cursor:pointer;' class='glyphicon glyphicon-edit' onClick='changeQuestion("+questionsList[i].pitanje_id+",\""+questionsList[i].pitanje+"\",\""+questionsList[i].a+"\",\""+questionsList[i].b+"\",\""+questionsList[i].c+"\",\""+questionsList[i].d+"\")'></span><span style='float:left; margin-left:20px; cursor:pointer;' class='glyphicon glyphicon-stats' onClick='CIquestions("+questionsList[i].pitanje_id+")'></span></span><span style='float:left; margin-left:20px; cursor:pointer;' class='glyphicon glyphicon-tasks' onClick='questionDiff("+questionsList[i].pitanje_id+")'></span> </td>");


      $('#pitanja_table').append(tr);
  }
}

function answersAppend() {
  document.getElementById("odgovori_table").hidden = "";
  document.getElementById("pitanja_table").hidden = "hidden";
  document.getElementById("korisnicki_odgovori").hidden = "hidden";
  document.getElementById("changeQuestion").hidden = "hidden";
  document.getElementById("CIquestions").hidden = "hidden";
  document.getElementById("questionDiffs").hidden = "hidden";
  $("#odgovori_table .dynamicWrite").empty();
  let tr;
  for (var i = 0; i < answersList.length; i++) {
      tr = $('<tr class="dynamicWrite"/>');
      tr.append("<td class='tabledata'>" + answersList[i].odgovor_id + "</td>");
      tr.append("<td class='tabledata'>" + answersList[i].user_id + "</td>");
      tr.append("<td class='tabledata'>" + answersList[i].pitanje_id + "</td>");
      tr.append("<td class='tabledata'>" + answersList[i].odgovor + "</td>");
      tr.append("<td class='tabledata'>" + answersList[i].ocena + "</td>");
      $('#odgovori_table').append(tr);
  }
}

function getUsers() {
  document.getElementById("table").hidden = "";
  let tr;
  for (var i = 0; i < userList.length; i++) {
      tr = $('<tr/>');
      tr.append("<td><a onClick='getUserAnswers("+userList[i].user_id+")'>" + userList[i].username + "</a></td>");
      tr.append("<td>" + userList[i].user_id + "</td>");
      $('#table').append(tr);
  }
}

function userAnswersAppend() {
  document.getElementById("korisnicki_odgovori").hidden = "";
  document.getElementById("odgovori_table").hidden = "hidden";
  document.getElementById("pitanja_table").hidden = "hidden";
  $("#korisnicki_odgovori .dynamicWrite").empty();
  let tr;
  for (var i = 0; i < userAnswers.length; i++) {
      tr = $('<tr class="dynamicWrite"/>');
      tr.append("<td class='tabledata'>" + userAnswers[i].odgovor_id + "</td>");
      tr.append("<td class='tabledata'>" + userAnswers[i].user_id + "</td>");
      tr.append("<td class='tabledata'>" + userAnswers[i].pitanje_id + "</td>");
      tr.append("<td class='tabledata'>" + userAnswers[i].odgovor + "</td>");
      tr.append("<td class='tabledata'>" + userAnswers[i].ocena + "</td>");
      $('#korisnicki_odgovori').append(tr);
  }
}

function changeQuestion(pitanje_id,pitanje,odgovor_a,odgovor_b,odgovor_c,odgovor_d) {
  document.getElementById("pitanja_table").hidden = "hidden";
  document.getElementById("changeQuestion").hidden = "";
  $("#pitanje_id").val(pitanje_id);
  $("#pitanje").val(pitanje);
  $("#odgovor_a").val(odgovor_a);
  $("#odgovor_b").val(odgovor_b);
  $("#odgovor_c").val(odgovor_c);
  $("#odgovor_d").val(odgovor_d);

  $('#updatebutton').on("click", function(){
    var question_id = pitanje_id;
    var question = $("#pitanje").val();
    var a = $("#odgovor_a").val();
    var b = $("#odgovor_b").val();
    var c = $("#odgovor_c").val();
    var d = $("#odgovor_d").val();

    $.ajax({
        data: { data: "change question",question_id: question_id, question: question, a: a, b: b, c: c, d: d },
        type: "POST",
        url: "administration.php",

        success: function(data){
          tempAnswer= JSON.parse(data);
          $(".changeInfo").addClass("alert alert-warning");
          $(".changeInfo").html(tempAnswer.message);
            setTimeout(function() { $("#changeQuestion").hide(); }, 2000);
        }
          });

  })

}

function CIquestions(question_id) {
  var question_id = question_id;

  $.ajax({
      data: { data: "correct incorrect for question",question_id: question_id },
      type: "POST",
      url: "administration.php",

      success: function(data){
        tempCIquestions= JSON.parse(data);
        document.getElementById("CIquestions").hidden = "";
          document.getElementById("pitanja_table").hidden = "hidden";
        document.getElementById("changeQuestion").hidden = "hidden";
        document.getElementById("odgovori_table").hidden = "hidden";
        document.getElementById("questionDiffs").hidden = "hidden";

        $("#CIquestions .dynamicWrite").empty();
        let tr;
        tr = $('<tr class="dynamicWrite"/>');
        tr.append("<td class='tabledata'>" + question_id + "</td>");
        tr.append("<td class='tabledata'>" + tempCIquestions.correct + "</td>");
        tr.append("<td class='tabledata'>" + tempCIquestions.incorrect + "</td>");
        $('#CIquestions').append(tr);
      }
        });
}

function questionDiff(question_id) {
  var question_id = question_id;

  $.ajax({
      data: { data: "difficulty stats for question",question_id: question_id },
      type: "POST",
      url: "administration.php",

      success: function(data){
        tempQuestionDiff= JSON.parse(data);
        document.getElementById("CIquestions").hidden = "hidden";
          document.getElementById("pitanja_table").hidden = "hidden";
        document.getElementById("changeQuestion").hidden = "hidden";
        document.getElementById("odgovori_table").hidden = "hidden";
        document.getElementById("questionDiffs").hidden = "";

        $("#questionDiffs .dynamicWrite").empty();
        let tr;
        tr = $('<tr class="dynamicWrite"/>');
        tr.append("<td class='tabledata'>" + question_id + "</td>");
        tr.append("<td class='tabledata'>" + tempQuestionDiff.Easy + "</td>");
        tr.append("<td class='tabledata'>" + tempQuestionDiff.Medium + "</td>");
        tr.append("<td class='tabledata'>" + tempQuestionDiff.Hard + "</td>");
        $('#questionDiffs').append(tr);
      }
        });
}

$(document).ready(function(){
  getUsers();
})



  </script>
</html>
