<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../public/assets/main.css">
      
<!------ Include the above in your HEAD tag ---------->
 <nav class="navbar navbar-default">
  <div class="container-fluid">
   
    <ul class="nav navbar-nav">
      <li class="active"><a href="/">Students</a></li>
      <li><a href="/courseList">Courses</a></li>
         <li><a href="/studentCourseMap">Mapping</a></li>
      <li ><a href="/report">Report</a></li>
    </ul>
  </div>
</nav>   
<form class="form-horizontal" action="/createStudent" method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">Student Details</legend>
    </div>
      <?php if(isset($error)){ ?>
      <div class="alert alert-danger" role="alert">
 <?php echo $errors; ?>
</div>
      <?php } ?>
      <div class="box">
    <div class="control-group">
      <!-- Username -->
      <label class="control-label"  for="fname">First Name</label>
      <div class="controls">
        <input type="text" id="fname" name="fname" placeholder=""  maxlength="50" autocomplete="off" class="input-xlarge" required
               oninvalid="this.setCustomValidity('First Name is required')"
               oninput="this.setCustomValidity('')"/>
      
      </div>
    </div>
 
    <div class="control-group">
      <!-- E-mail -->
      <label class="control-label" for="lname">Last Name</label>
      <div class="controls">
        <input type="text" id="lname" name="lname" placeholder=""  maxlength="50" autocomplete="off"
               class="input-xlarge" required
                oninvalid="this.setCustomValidity('Last Name is required')"
                oninput="this.setCustomValidity('')"/>
      
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="dob">DOB</label>
      <div class="controls">
     <input type="text" id="datepicker"  name="dob" class="input-xlarge"  autocomplete="off" required
            >
      
      </div>
      
      
    </div>
 
    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="contact_no">Contact No</label>
      <div class="controls">
        <input type="tel" id="contact_no" name="contact_no" placeholder="" autocomplete="off"  max="10" pattern="^[6-9]\d{9}$" class="input-xlarge"
               required >
      
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
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
   <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy'} );
    
  //$("#header").load("includes/header.html"); 
  
//  $("#footer").load("footer.html"); 

  } );
  </script>