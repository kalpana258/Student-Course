<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../public/assets/main.css">
<div id="header"></div>     
<!------ Include the above in your HEAD tag ---------->


 <nav class="navbar navbar-default">
  <div class="container-fluid">
  
    <ul class="nav navbar-nav">
      <li ><a href="/">Students</a></li>
      <li class="active"><a href="/courseList">Courses</a></li>
         <li><a href="/studentCourseMap">Mapping</a></li>
      <li ><a href="/report">Report</a></li>
    </ul>
  </div>
</nav>



<form class="form-horizontal" action="/createCourse" method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">Course Details</legend>
    </div>
      <?php if(isset($error)){ ?>
      <div class="alert alert-danger" role="alert">
 <?php echo $errors; ?>
</div>
      <?php } ?>
      <div class="box">
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="courseName">Course Name</label>
      <div class="controls">
        <input type="text" id="courseName" name="courseName" placeholder=""  autocomplete="off" class="input-xlarge" required>
      
      </div>
    </div>
 
    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="courseDetails">Course Details</label>
      <div class="controls">
          <textarea id="courseDetails" name="courseDetails" rows="4" cols="50" class="input-xlarge" >
</textarea>
      </div>
    </div>
   <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button class="btn btn-success">submit</button>
      </div>
    </div>
      </div>
  </fieldset>
</form>

<script> 
$(function(){
//  $("#header").load("includes/header.html"); 
//  $("#footer").load("footer.html"); 
});
</script>
