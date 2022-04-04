<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">

      
<!------ Include the above in your HEAD tag ---------->
<?php 
// include nav bar
require realpath(__DIR__ . '/..')."/includes/header.php";

?>
<form class="form-horizontal" action="/saveStudentSuscription"  method="POST">
  <fieldset>
  
      <?php if(isset($error)){ ?>
      <div class="alert alert-danger" role="alert">
 <?php echo $errors; ?>
</div>
      <?php } ?>
    <?php 
 
    if(count($response)== 0){ ?>
      <h1> No Records </h1>
    <?php }else{ ?>
      <table class="table">
        
          <thead>
                <tr>
          <th>Student Name</th>
          <th>Course Name</th>
                </tr>

              </thead>
      <?php foreach($response as $data){ ?>
      <tr>
              <td>
   <?php echo $data['fname']; ?>
              </td>
              <td>
       <?php echo $data['name']; ?>
              </td>
          </tr>
      <?php } ?>
      </table>
    <?php } ?>
      <br>
 
     
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