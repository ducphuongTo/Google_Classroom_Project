<?php
    session_start();
    require_once('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script src='main.js'></script>

    <title>STREAM</title>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>
  <?php 
    $result = getClassTeacherById($_GET['id']);
    $error = null;
    $file = "";
    if (isset($_POST['content']))
    {
      $content = $_POST['content'];
      if (isset($_POST['content'])){
        $file = $_POST['file'];
      }
      
      if (!empty($content))
      {
        $result = addFeed($content, $_GET['id'], $file);
        if ($result['code'] != 0)
        {
          $error = $result['error'];
        }
        else {
          $classID = $_GET['id'];
          $teacherEmail = $_GET['teacherEmail'];
          header("Location: classteacher.php?id=$classID&teacherEmail=$teacherEmail");
        }
      }
      else
      {
        $error = "Content must not be empty";
      }
    }
  ?>


  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


    <nav class="navbar fixed-top navbar-expand-sm navbar-light">

        <a class="navbar-brand mb-0 navname" href="#"><?=$result['classname']?></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        
        
        
    </nav>
    <div class="container">
        <div class="row">
          <div class="col-sm-12 pt-5 ">
            <div class="card bg-primary">
              <h1><?=$result['lastname'] . ' ' . $result['firstname']?></h1>
              <h4><?=$result['subject'] . '_' . $result['room']?></h4>
            </div>
          </div>
        </div> 

        <div class="row">
          <div class="col-lg-3">
              
          </div>
            
          <div class="col-lg-6">
              <div class="add">
                  <h1>Th??m th??ng b??o</h1>
              </div>
              <?php
                if (!empty($error))
                {
                ?>
                <div class="row">
                  <div style='color:red' class='alert alert-danger'><?=$error?></div>
                </div>
                <?php
                  }
              ?>


            <form action="" class="addFeed" method="post">
                <div class="row">
                    <div class="col-25">
                      <label for="subject">N???i dung</label>
                    </div>
                    <div class="col-75 ml-2">
                      <textarea id="subject" name="content" placeholder="Write something.." ></textarea>
                    </div>
                  </div>
                
                <div class="row">
                  <label class="inputFile">File</label>
                    
                  <div class="col-sm-9 input-group ml-5">
                      <input name="file" type="file" id="image">
                  </div>
                
                </div>

                <div class="row">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-10">
                    <input type="submit" value="Add" class="col-lg-3 mt-2 pl-3 pr-3">
                  </div>
                  
                  
                </div>
              </form>
              <div class="row">
                <a class="col-lg-3 ml-4" href="classteacher.php?id=<?=$_GET['id']?>&teacherEmail=<?=$_GET['teacherEmail']?>">Back</a>
              </div>
            
          </div>
          <div class="col-lg-3">
          
          </div>
        </div>     
    </div>

      <div class="tab-content">
          <div id="homesrc" class="container tab-pane active"><br>
          </div>
          <div id="classworksrc" class="container tab-pane fade"><br>
          </div>
          <div id="peoplesrc" class="container tab-pane fade"><br>
          </div>
      </div>
  
</body>
</html>