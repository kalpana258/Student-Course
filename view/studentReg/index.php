<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
 <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../public/assets/main.css">
      
<?php 
// include nav bar
require realpath(__DIR__ . '/..')."/includes/header.php";

?>
<form class="form-horizontal" action="/createStudent" method="POST">
  <fieldset>
    <div id="legend">
      <legend class="">Student Details</legend>
    </div>
      <?php
     
      if(isset($errors)){ 
     
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
      <label class="control-label"  for="fname">First Name</label>
      <div class="controls">
        <input type="text" id="fname" name="fname" placeholder=""  maxlength="50" autocomplete="off" class="input-xlarge" required
               value="<?php echo  isset($postData['fname']) && !empty($postData['fname'])? $postData['fname']:"" ?>"
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
                value="<?php echo  isset($postData['lname']) && !empty($postData['lname'])? $postData['lname']:"" ?>"
                oninvalid="this.setCustomValidity('Last Name is required')"
                oninput="this.setCustomValidity('')"/>
      
      </div>
    </div>
 
    <div class="control-group">
      <!-- Password-->
      <label class="control-label" for="dob">DOB</label>
      <div class="controls">
     <input type="text" id="datepicker"  name="dob" class="input-xlarge"  autocomplete="off" required
           value="<?php echo  isset($postData['dob']) && !empty($postData['dob'])? $postData['dob']:"" ?>"  >
      
      </div>
      
      
    </div>
  <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="contact_no">Email</label>
      <div class="controls">
        <input type="email" id="email" name="email" placeholder="" autocomplete="off"  class="input-xlarge"
               required 
                 value="<?php echo  isset($postData['email']) && !empty($postData['email'])? $postData['email']:"" ?>">
      
      </div>
    </div>
    <div class="control-group">
      <!-- Password -->
      <label class="control-label"  for="contact_no">Mobile No</label>

      <div class="controls">
          <!-- country codes (ISO 3166) and Dial codes. -->
          <select name="countryCode" id="">
              <?php foreach($countryCodes as $countryCode){?>
                <option value="<?php echo $countryCode['value'] ?>"
                <?php echo  isset($postData['countryCode']) && $countryCode['value']==$postData['countryCode']?'Selected':"" ?>        
                        ><?php echo $countryCode['name']."(".$countryCode['value'].")" ?></option>
              <?php } ?>
          </select>
        <input type="tel" id="contact_no" name="contact_no" placeholder="" autocomplete="off"  max-length="10" pattern="^[0-9]{10,11}$" class="input-xlarge"
                value="<?php echo  isset($postData['contact_no']) && !empty($postData['contact_no'])? $postData['contact_no']:"" ?>"
               required >
      
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
 <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
   <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({dateFormat: 'dd/mm/yy'} );
  } );
  </script>