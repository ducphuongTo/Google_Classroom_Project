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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='main.js'></script>
    <title>WELCOMEEEEEE</title>
</head>
<body>
    <?php
        $email = $_GET['username'];
        
        $error='';
        $className = '';
        $subject = '';
        $room = '';
        $image = '';

        if (isset($_POST['classname']) && isset($_POST['subject']) && isset($_POST['room'])
        && isset($_GET['username']) && isset($_POST['image']))
        {
            $className = $_POST['classname'];
            $subject = $_POST['subject'];
            $room = $_POST['room'];
            $image = $_POST['image'];

            if (empty($className)) {
                $error = 'Please enter your class name';
            }
            else if (empty($subject)) {
                $error = 'Please enter your subject';
            }
            else if (empty($room)) {
                $error = 'Please enter your room';
            }
            else if (empty($image)) {
                $error = 'Please add your image';
            }
            else if (empty($email)) {
                $error = 'Your email can not be found';
            }
            else {
                
                $result = addClassRoom($className, $room, $subject, $email, $image);
                if ($result['code'] == 2)
                {
                    $error = 'An error occured. Please try again later';
                }
                else{
                    header("Location:hometeacher.php?username=$email");
                }
                
                
                
            }
        }

        if (isset($_GET['removeClass']))
        {
            $result = deleteClassRoom($_GET['removeClass']);
            if ($result['code'] != 0)
            {
                $error = $result['error'];
            }
            else{
                header("Location:hometeacher.php?username=$email");
            }
        }
        
    ?>


    <main class="home">
        
        <nav class="navbar fixed-top navbar-expand-lg navbar-light">
            <span style="font-size:30px;cursor:pointer" onclick="togMenu()">&#9776;</span>
            <a class="navbar-brand mb-0 h1">DOGE CLASSROOM, Hello <?=$email?></a>
            <span class="fas fa-plus ml-auto p-2" style="font-size:30px" onclick="togCreate()"></span>
            <a href='Login.php' class="fa fa-sign-out p-2"></a>
        </nav>
        
        <div id="leftMenu" class="sidenav">
            <a href="javascript:void(0)" class="closeMenubtn" onclick="closeNav()">&times;</a>
            <input type="text" id="searchbar" onkeyup="searchclass()" placeholder="Search for class...">
            <ul id="classlist">
            <?php
                $result = getClassRoom($email);
                while($row = $result->fetch_assoc())
                {

            ?>
                    <li><a href="classteacher.php?id=<?=$row['id']?>&teacherEmail=<?=$email?>"><?=$row['classname']?></a></li>
            <?php
                }
            ?>
            </ul>
        </div>
        
        <div id="creating" class="createsrc">
            <a href="javascript:void(0)" class="closeCreatebtn" onclick="closeCreate()">&times;</a>
            <form action="" method="post">
            <div class="mb-3">
                <label>Class name (required)</label>
                <div class="input-group">
                    <input name="classname" value="<?=$className?>" type="text" class="form-control" id="classname" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Subject</label>
                <div class="input-group">
                    <input name="subject" value="<?=$subject?>" type="text" class="form-control" id="subject">
                </div>
            </div>

            <div class="mb-3">
                <label>Room</label>
                <div class="input-group">
                    <input name="room" type="text" value="<?=$room?>" class="form-control" id="room">
                </div>
            </div>

            <div class="mb-3">
                <label>Class image</label>
                <div class="input-group">
                    <input name="image" type="file" id="image">
                </div>
            </div>
            
            <hr class="mb-4">
            <button class="btn-lg btn-block" id="createbtn" type="submit">Create</button>
        </form>
        </div>
        

        

        <div class="card-groups">
            <div class="row">
            <?php
                $result = getClassRoom($email);
                while($row = $result->fetch_assoc())
                {

            ?>
                    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6 col-12">
                        <div class="card border-info">
                            <img class="card-img-top" src="/images/<?php echo $row['imageclass']?> "   style="max-height:200px"    alt="Card image">
                            <div class="card-body">
                                <h4 class="card-title"><?=$row['classname']?> - ID: <?=$row['id']?></h4>
                                <p class="card-text"><?=$row['subject'] . ", " . $row['room']?></p>
                                <div class="container">
                                    <a href="classteacher.php?id=<?=$row['id']?>&teacherEmail=<?=$email?>" class="btn btn-dark m-1">GO TO CLASS</a>
                                    <a class="btn btn-dark m-1" href="editClass.php?id=<?=$row['id']?>">EDIT</a>
                                    <a class="btn btn-dark m-1" data-toggle="modal" data-target="#confirm<?=$row['id']?>">DELETE</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="confirm<?=$row['id']?>">
                        <div class="modal-dialog">
                        <div class="modal-content">
                        
                            <div class="modal-header">
                            <h4 class="modal-title">X??a l???p hoc.</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                            B???n c?? ch???c r???ng mu???n x??a l???p h???c kh??ng
                            </div>
                        
                            <div class="modal-footer">
                                <a class="btn btn-primary btn-sm" href="hometeacher.php?username=<?=$email?>&removeClass=<?=$row['id']?>">c??</a>
                                <a class="btn btn-primary btn-sm" href="hometeacher.php?username=<?=$email?>">Kh??ng</a>
                            </div>            
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
                
            </div>
        </div>
        
    </main>
</body>
</html>