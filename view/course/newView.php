<!DOCTYPE html>
<html>
<head>
    <title>List</title>

    <!-- bootstrap Lib -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
 
    <style type="text/css">
        .content{
            max-width: 800px;
            margin: auto;
        }

        h1{
            text-align: center;
            padding-bottom: 60px;
        }
    </style>

</head>
<body>
      <nav class="navbar navbar-default">
  <div class="container-fluid">
   
    <ul class="nav navbar-nav">
       <li><a href="/">Students</a></li>
      <li  class="active"><a href="/courseList">Courses</a></li>
        <li><a href="/studentCourseMap">Mapping</a></li>
      <li ><a href="/report">Report</a></li>
    </ul>
  </div>
</nav>    
<div class="content">
    <h1></h1>
               <table id="course_table" class="table table-striped">
                    <thead bgcolor="#6cd8dc">
                        <tr class="table-primary">
                           <th scope="col" width="5%">Edit</th>
                           <th width="30%">Course</th>
                           <th scope="col" width="5%">Delete</th>
                        </tr>
                    </thead>
                    
                </table>
                <br>
             <div align="right">
                <a href="/createCourse" id="add_button"  class="btn btn-success">Add Course</a>
       </div>     
</div>
</body>
</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="course_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Edit</h4>
                </div>
                <div class="modal-body">
                    <label>Course Name</label>
                    <input type="text" name="course_name" id="course_name" class="form-control" autocomplete="off" required /><br>
                    <label> Course Details </label>
                    <input type="text" name="course_details" id="course_details" class="form-control"/><br>
                    
                    
                </div>
            <div class="modal-footer">
                    <input type="hidden" name="course_id" id="course_id"/>
                    <input type="submit" name="action" id="action" class="btn btn-primary" value="Add" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
      $.ajax({
                url:"/getCourseList",
                data: new FormData( {start: 0, length : 10}) ,
                method:'POST',
                contentType:false,
                processData:false,
                success:function(data)
                {
                      
                  
                }
            });

     $(document).on('submit', '#course_form', function(event){
        event.preventDefault();
        var id = $('#id').val();
        var courseName = $('#course_name').val();
        var courseDetails = $('#course_details').val();
        

        if(courseName != '' && courseDetails != '')
        {
            $.ajax({
                url:"editCourse",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                      
                     var json = $.parseJSON(data);
                  
                    $('#course_form')[0].reset();
                    $('#userModal').modal('hide');
                    dataTable.ajax.reload();
                  
                    if(json['success']==false){
                        alert("Error on saving.");
                    }else{
                         alert("SuccessFully saved");
                    }
                }
            });
        }
        else
        {
            alert("Required fields are missing");
        }
    });

    $(document).on('click', '.update', function(){
        var course_id = $(this).attr("id");
        $.ajax({
            url:"/getCourse",
            method:"POST",
            data:{id:course_id},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#id').val(data.id);
                $('#course_name').val(data.name);
                $('#course_details').val(data.details);
//                $('#datepicker').val(data.dob);
//                $('#phone').val(data.phone);
                $('.modal-title').text("Edit");
                $('#course_id').val(course_id);
                $('#action').val("Save");
              
            }
        });
     });

    $(document).on('click','.delete', function(){

        var id = $(this).attr("id");
        if(confirm("Are you sure want to delete this user?"))
        {
            $.ajax({
                url:"/deleteCourse",
                method:"POST",
                data:{course_id:id},
                success:function(data)
                {
                    dataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
     });
$( function() {
    $( "#datepicker" ).datepicker();
  } );
    });
</script>
      