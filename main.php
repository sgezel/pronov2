<?php
require_once("header.php");
include_once("UserCrud.php");

$crud = new UserCrud();
?>



<div class="blog_section layout_padding">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 class="blog_taital">Pronostiek invullen</h1>
      </div>

      <div class="alert alert-dark" role="alert">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="flexSwitchQuickPick" name="quickpick">
          <label class="form-check-label" for="flexSwitchQuickPick">QuickPick inschakelen.</label><strong> <a href="quickpick.php">Lees hier meer over de nieuwe QuickPick &trade; feature!</a> </strong>
        </div>
      </div>

    </div>
    <div class="blog_section_2">
      <div class="row">
        <div class="col-md-12">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td colspan="2">Larry the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

<script>
  var checkbox = document.getElementById('flexSwitchQuickPick');
  checkbox.addEventListener("change", functionname, false);

  function functionname() {
    var isChecked = checkbox.checked;

    var http = new XMLHttpRequest();
    var url = 'action_user_quickpick.php';
    var params = 'quickpick=' + isChecked;
    http.open('POST', url, true);

    //Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    http.onreadystatechange = function() { //Call a function when the state changes.
      if (http.readyState == 4 && http.status == 200) {
       
      }
    }
    http.send(params);
  }
</script>

<?php
require_once("footer.php");
?>