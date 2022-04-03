<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../public/assets/main.css">
<div id="header"></div>     
<!------ Include the above in your HEAD tag ---------->
<?php 
// include nav bar
require realpath(__DIR__ . '/..')."/includes/header.php";

?>



<form class="form-horizontal" action="/createCourse" method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">Course Details</legend>
    </div>
      <?php
     
      if(isset($errors)){ 
          // var_dump($errors);
          ?>
      <div class="alert alert-danger" role="alert">
 <?php 
       foreach($errors as $error){
           echo $error."<br/>"; 
       }
 
 ?>
</div>
      <?php } ?>
        <?php
     
      if(isset($success)){ 
        
          ?>
      <div class="alert alert-success" role="alert">
  <?php echo $success; ?>
</div>
        <?php }
        ?>
      <div class="box">
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="courseName">Course Name</label>
      <div class="controls">
        <input type="text" id="courseName" name="courseName" placeholder=""  autocomplete="off" class="input-xlarge"
               value="<?php echo  isset($postData['courseName']) && !empty($postData['courseName'])? $postData['courseName']:"" ?>"
               required>
      
      </div>
    </div>

    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="courseDetails">Course Details</label>
      <div class="controls">
          <textarea id="courseDetails" name="courseDetails" rows="4" cols="50" class="input-xlarge" 
               >
              <?php echo  isset($postData['courseDetails']) && !empty($postData['courseDetails'])? $postData['courseDetails']:"" ?>
</textarea>
      </div>
    </div>
   <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button class="btn btn-success" name="submit">submit</button>
          <a href="/">   <button type="button" class="btn btn-success">cancel</button></a>
      </div>
    </div>
      </div>
  </fieldset>
</form>


