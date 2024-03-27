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

<?php
require_once("footer.php");
?>