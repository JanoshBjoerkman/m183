<?php
  require_once(VIEW_PATH . "/header.php");
?>

<div class="row">
  <div class="col-xs-12">
    <h1>Register</h1>
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    <form action="index.php?" method="POST">
      <div class="form-group has-success has-feedback">
        <label for="username">Username (Email):</label>
        <input type="email" class="form-control" id="username" placeholder="Enter email" name="username" required> 
      </div>     
      <div class="form-group">
        <label for="pwd">Password:</label>
        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
      </div>
      <div class="form-group">
        <label for="firstname">First Name:</label>
        <input type="text" class="form-control" id=firstname placeholder="Enter first name" name="firstname" required>
      </div>
      <div class="form-group">
        <label for="lastname">Last Name:</label>
        <input type="text" class="form-control" id="lastname" placeholder="Enter last name" name="lastname" required>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-default" name="op" value="signup-action">Submit</button>
      </div>
    </form>
  </div>   
</div>

<?php
  require_once(VIEW_PATH . "/footer.php");
?>  
