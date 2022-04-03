<!DOCTYPE html>
<html>
<head>
    <title>Error</title>

    <!-- bootstrap Lib -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  
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

        <!-- Site Page Wrapper  //START -->
        <div class="page-content">

            <div class="error-404-main-wrapper">
                <div class="error-404-container col-md-4 col-sm-6 col-center">
                    <h3><?php echo   $errorMessage ?></h3>
                </div>
            </div>

        </div>
        <!-- Site Page Wrapper  //ENDS -->
