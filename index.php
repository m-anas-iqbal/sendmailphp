<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send mail</title>
</head>
<body>
    PHP core mail send and .php remover
    <?php
    if (isset($_SESSION['message']) && isset($_SESSION['success']) ) {
        if ($_SESSION['success']) {
           echo "<h1>".$_SESSION['message']."</h1>";
        } else {
           
           echo "<h1>".$_SESSION['message']."</h1>";
        }
        session_destroy();
       }
    
    ?>
      <div class="col-md-6 offset-md-3 mt-5">
    <h1>Simple Job Application Form with File Upload with mail</h1>
    <form accept-charset="UTF-8" action="app/controller.php" method="POST" enctype="multipart/form-data" target="_blank">
      <div class="form-group">
        <label for="exampleInputName">Full Name*</label>
        <input type="text" name="fullname" class="form-control" id="exampleInputName" placeholder="Your Name*" required="required">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1" required="required">Email address*</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Your Email*">
      </div>
       <div class="form-group mt-3">
        <label class="mr-4">Upload your CV:</label>
        <input type="file" name="file">
      </div>
      <button type="submit" class="btn btn-submit">Submit</button>
    </form>
  </div>
</body>
</html>