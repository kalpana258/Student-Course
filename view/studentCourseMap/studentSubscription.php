<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">

      
<!------ Include the above in your HEAD tag ---------->
 <nav class="navbar navbar-default">
  <div class="container-fluid">
   
    <ul class="nav navbar-nav">
      <li><a href="/">Students</a></li>
      <li><a href="/courseList">Courses</a></li>
        <li class="active"><a href="/studentCourseMap">Mapping</a></li>
      <li ><a href="/report">Report</a></li>
    </ul>
  </div>
</nav>   
<form class="form-horizontal" action="/saveStudentSuscription"  method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">Student Course Registration</legend>
    </div>
      <?php if(isset($error)){ ?>
      <div class="alert alert-danger" role="alert">
 <?php echo $errors; ?>
</div>
      <?php } ?>
      
      <table><tr>
             
              <td>
 <div class="form-group col-md-4">
      <label for="student">student</label>
      <select id="student" name="student[]" class="form-control">
        <option selected >Select Student</option>
        <?php foreach($studentdropdown as $student){ ?>
         <option value=<?php echo $student['id'] ?>><?php echo $student['fname']?></option>
        <?php } ?>
      </select>
    </div>
              </td>
              <td>
   <div class="form-group col-md-4">
      <label for="course">course</label>
      <select id="course" name="course[]" class="form-control">
        <option selected>Select Course</option>
         <?php foreach($courseDropdown as $course){ ?>
         <option value=<?php echo $course['id'] ?>><?php echo $course['name']?></option>
        <?php } ?>
      </select>
    </div>
              </td><td>
              <button class="btn btn-md btn-primary" 
                      id="addBtn" type="button"> Add new Row</button>
              </td>
          </tr>
      </table>
      <br>
   <div class="control-group">
      <!-- Button -->
      <div class="controls">
        <button class="btn btn-success">submit</button>
      </div>
    </div>
     
  </fieldset>
</form>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
  <script>
  $( function() {
      
       var rowIdx = 0;
  
      // jQuery button click event to add a row
      $('#addBtn').on('click', function () {
        // Adding a row inside the tbody.
        $('table').append(`<tr id="R${++rowIdx}">
             <td> <div class="form-group col-md-4">
     
      <select id="student" name="student[]" class="form-control">
        <option selected>Select Student</option>
        <?php foreach($studentdropdown as $student){ ?>
        <option value=<?php echo $student['id'] ?>><?php echo $student['fname']?></option>
      <?php } ?>
      </select>
    </div>
              </td>
               <td>
   <div class="form-group col-md-4">
   
      <select id="course" name="course[]" class="form-control">
        <option selected>Select Course</option>
   <?php foreach($courseDropdown as $course){ ?>
       <option value=<?php echo $course['id'] ?>><?php echo $course['name']?></option>
     <?php } ?>
      </select>
    </div>
              </td>
            
              </tr>`);
      });
  

  } );
  </script>