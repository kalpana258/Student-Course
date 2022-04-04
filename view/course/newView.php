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
      <label class="control-label"  for="contact_no">Show</label>
    <select name="num_rows" id="show_entries">
        <option value="2"> <?php echo 2 ?></option>
        <option value="5"> <?php echo 5 ?></option>
        <option value="10"> <?php echo 10 ?></option>
        <option value="20"> <?php echo 20 ?></option>
          </select>
               <table width="100%" id="course_table" class="table table-striped">
                    <thead >
                        <tr class="tr_header">
                           <th scope="col" >Course Code</th>
                           <th scope="col" >Course</th>
                           <th scope="col" >Course Details</th>
                           <th scope="col" >Action</th>
                        </tr>
                    </thead>
                    
                </table><br/>
                <div id="div_pagination">
                    <input type="text" name="row" id="row" >
                    <input type="hidden" name="allcount" id="allcount" >
                    <input type="button" class="btn btn-info" id="prev" name="but_prev" value="Previous">
                    <input type="button" class="btn btn-info" id="next" name="but_next" value="Next">
                    
                    
                </div>
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
           var show = $("#show_entries").val();
      $.ajax({
       
                url:"/getCourseList",
                data: { num_rows: show,row:0} ,
                method:'POST',
                success:function(data)
                {                    
                    data = $.parseJSON(data);
                    responseData = data.data
                    
                   var row = '<tbody>';   
                    for (var i=0; i<responseData.length; i++) {
                        
                            row += '<tr>';   
                        
                            row += '<td>' + responseData[i]['course_code'] + '</td>';
                            row += '<td>' + responseData[i]['name'] + '</td>';
                            row += '<td>' + responseData[i]['details'] + '</td>';
                            row += '<td><a href="/createCourse?id='+responseData[i]['id']+'" class="btn btn-primary">EDIT</a> &nbsp;&nbsp;<a href="#" class="btn btn-danger"onclick="del('+responseData[i]['id']+')">Delete</a></td>';
                        
                    
                        row += '</tr>';
                        
                    }
                    row += '</tbody>';
    
                    $('#course_table').append(row);
                      $('#row').val(data["row"]);
                    $('#allcount').val(data["recordsFiltered"]);
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                                
                
            });

    $("#show_entries").change(function(){

        $.ajax({
                url:"/getCourseList",
                data: { num_rows: this.value} ,
                method:'POST',
                success:function(data)
                {                    
                    data = $.parseJSON(data);
                    responseData = data.data
                    $("#course_table > tbody").remove();
                   var row = '<tbody>';   
                    for (var i=0; i<responseData.length; i++) {
                        
                            row += '<tr>';   
                        
                            row += '<td>' + responseData[i]['course_code'] + '</td>';
                            row += '<td>' + responseData[i]['name'] + '</td>';
                            row += '<td>' + responseData[i]['details'] + '</td>';
                            row += '<td><a href="#" class="btn btn-primary" onclick="edit('+responseData[i]['id']+')">EDIT</a> &nbsp;&nbsp;<a href="#" class="btn btn-danger"onclick="del('+responseData[i]['id']+')">Delete</a></td>';
                        
                    
                        row += '</tr>';
                        
                    }
                    row += '</tbody>';
    
                    $('#course_table').append(row);
                     $('#row').val(data["row"]);
                    $('#allcount').append(data["recordsFiltered"]);
                    
                    $('#prev').removeAttr('disabled');
                    $('#next').removeAttr('disabled');
                
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                                
                
            });
    })

    $("#prev").click(function(){
        var show = $("#show_entries").val()
        var row = $("#row").val()
        var totalcount = $("#allcount").val()
        $.ajax({
                url:"/getCourseList",
                data: { num_rows: show, but_prev:1,row:row,allcount:totalcount} ,
                method:'POST',
                success:function(data)
                {                    
                    data = $.parseJSON(data);
                    responseData = data.data
                    $("#course_table > tbody").remove();
                   var row = '<tbody>';   
                    for (var i=0; i<responseData.length; i++) {
                        
                            row += '<tr>';   
                        
                            row += '<td>' + responseData[i]['course_code'] + '</td>';
                            row += '<td>' + responseData[i]['name'] + '</td>';
                            row += '<td>' + responseData[i]['details'] + '</td>';
                            row += '<td><a href="#" class="btn btn-primary" onclick="edit('+responseData[i]['id']+')">EDIT</a> &nbsp;&nbsp;<a href="#" class="btn btn-danger"onclick="del('+responseData[i]['id']+')">Delete</a></td>';
                        
                    
                        row += '</tr>';
                        
                    }
                    row += '</tbody>';
    
                    $('#course_table').append(row);
                     $('#row').val(data["row"]);
                    $('#allcount').append(data["recordsFiltered"]);
                    
                     if(data["row"] <=0 ){
                        
                    $('#prev').attr('disabled','disabled');
                }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                                
                
            });
    })

    $("#next").click(function(){
          var show = $("#show_entries").val()
        var row = $("#row").val()
        var totalcount = $("#allcount").val()
        $.ajax({
                url:"/getCourseList",
                data: { num_rows: show, but_next:1, row:row,allcount:totalcount} ,
                method:'POST',
                success:function(data)
                {                    
                    data = $.parseJSON(data);
                    responseData = data.data
                    $("#course_table > tbody").remove();
                   var row = '<tbody>';   
                    for (var i=0; i<responseData.length; i++) {
                        
                            row += '<tr>';   
                        
                            row += '<td>' + responseData[i]['course_code'] + '</td>';
                            row += '<td>' + responseData[i]['name'] + '</td>';
                            row += '<td>' + responseData[i]['details'] + '</td>';
                            row += '<td><a href="#" class="btn btn-primary" onclick="edit('+responseData[i]['id']+')">EDIT</a> &nbsp;&nbsp;<a href="#" class="btn btn-danger"onclick="del('+responseData[i]['id']+')">Delete</a></td>';
                        
                    
                        row += '</tr>';
                        
                    }
                    row += '</tbody>';
    
                    $('#course_table').append(row);
                    if(data["row"] >= data["recordsFiltered"] ){
                        
                    $('#next').attr('disabled','disabled');
                }
                    $('#row').val(data["row"]);
                    $('#allcount').append(data["recordsFiltered"]);
                    
                    
                    
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                                
                
            });
    })

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
     
       $(document).on('click','.delete', function(){

        var id = $(this).attr("id");
        if(confirm("Are you sure want to delete this user?"))
        {
            $.ajax({
                url:"/delete",
                method:"POST",
                data:{student_id:id},
                success:function(data)
                {
                    location.reload();
                  //  dataTable.ajax.reload();
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
      