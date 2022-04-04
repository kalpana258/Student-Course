<!------ Include the above in your HEAD tag ---------->

<?php 
//echo "request url ". $_SERVER['REQUEST_URI'];
//exit();
?>
 <nav class="navbar navbar-default">
  <div class="container-fluid">
   
    <ul class="nav navbar-nav">
      <li <?php echo $_SERVER['REQUEST_URI']=="/" ||  $_SERVER['REQUEST_URI']=="/createStudent"?'class=active':''; ?>><a href="/">Students</a></li>
      <li <?php echo  $_SERVER['REQUEST_URI']=="/courseList" ||
              $_SERVER['REQUEST_URI']=="/createCourse"?'class=active':''; ?>><a href="/courseList">Courses</a></li>
         <li <?php echo  $_SERVER['REQUEST_URI']=="/studentCourseMap"?'class=active':''; ?>><a href="/studentCourseMap">Mapping</a></li>
      <li <?php echo  $_SERVER['REQUEST_URI']=="/report"?'class=active':''; ?>><a href="/report">Report</a></li>
    </ul>
  </div>
</nav>   