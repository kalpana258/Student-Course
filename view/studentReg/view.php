<!DOCTYPE html>
<html>
<head>
    <title>List</title>

    <!-- bootstrap Lib -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- datatable lib -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
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
       <li class="active"><a href="/">Students</a></li>
      <li><a href="/courseList">Courses</a></li>
         <li><a href="/studentCourseMap">Mapping</a></li>
      <li ><a href="/report">Report</a></li>
    </ul>
  </div>
</nav>    
<div class="content">
    <h1></h1>
               <table id="student_table" class="table table-striped">
                    <thead bgcolor="#6cd8dc">
                        <tr class="table-primary">
                           <th scope="col" width="5%">Edit</th>
                           <th width="30%">First Name</th>
                           <th width="30%">Last Name</th>
                           <th scope="col" width="5%">Delete</th>
                        </tr>
                    </thead>
                </table>
                <br>
          <div align="right">
                <a href="/createStudent" id="add_button"  class="btn btn-success">Add Student</a>
       </div>    
</div>
</body>
</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="student_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Edit</h4>
                </div>
                <div class="modal-body">
                    <label>First Name</label>
                    <input type="text" name="fname" id="fname" class="form-control"
                           required
               oninvalid="this.setCustomValidity('First Name is required')"
               oninput="this.setCustomValidity('')"/><br>
                    <label> Last Name </label>
                    <input type="text" name="lname" id="lname" class="form-control"
                           required
                oninvalid="this.setCustomValidity('Last Name is required')"
                oninput="this.setCustomValidity('')"/><br>
                    
                      <label>DOB </label>
                         <input type="text" id="datepicker"  name="dob" class="form-control"
                                required>
                
                    
                      <label>Contact No</label>
                    <input type="text" name="phone" id="phone" class="form-control"
                           
                           autocomplete="off"  max="10" pattern="^[6-9]\d{9}$" /><br>
                </div>
            <div class="modal-footer">
                    <input type="hidden" name="student_id" id="student_id"/>
                    <input type="submit" name="action" id="action" class="btn btn-primary" value="Add" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
     var dataTable = $('#student_table').DataTable({
        "paging":true,
        "processing":true,
        "serverSide":true,
        "dom":'lrtip',
        "order": [],
        "info":true,
        "ajax":{
            url:"/getlist",
            type:"post"
        },
        "columnDefs":[
           {
            "target":[0,3,4],
            "orderable":false,
           },
        ],
     });

     $(document).on('submit', '#student_form', function(event){
        event.preventDefault();
        var id = $('#id').val();
        var fname = $('#fname').val();
        var lname = $('#lname').val();
         var dob = $('#dob').val();
          var phone = $('#phone').val();

        if(fname != '' && lname != '')
        {
            $.ajax({
                url:"edit",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                    var json = $.parseJSON(data);
                  
                    $('#student_form')[0].reset();
                    $('#userModal').modal('hide');
                      dataTable.ajax.reload();
                    if(json['success']==false){
                        alert(json['message']);
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
        var student_id = $(this).attr("id");
        $.ajax({
            url:"/getstudent",
            method:"POST",
            data:{id:student_id},
            dataType:"json",
            success:function(data)
            {
                $('#userModal').modal('show');
                $('#id').val(data.id);
                $('#fname').val(data.fname);
                $('#lname').val(data.lname);
                $('#datepicker').val(data.dob);
                $('#phone').val(data.phone);
                $('.modal-title').text("Edit");
                $('#student_id').val(student_id);
                $('#action').val("Save");
              
            }
        });
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
      