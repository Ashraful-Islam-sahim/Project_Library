<?php 
      ob_start(); 
  ?>
<?php include "inc/header.php" ?>
<?php include "inc/navbar.php" ?>
<?php include "inc/menu.php" ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <span class="m-0 text-dark">Dashboard</span>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php 
            $do=isset($_GET['do']) ? $_GET['do']:'Manage';
// manage system..............................................
      if($do=='Manage'){

           
        ?>
        <div class="col-md-12">
            <table class="table text-center mytable">
                <thead>
                    <tr>
                    <th scope="col">SI</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">User Image</th>
                    <th scope="col">Role</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql= "SELECT * FROM user_table";
                        $student_data= mysqli_query($db,$sql);
                        $i=0;
                        while($row = mysqli_fetch_assoc($student_data)){
                            $user_id=$row['user_id'];
                            $user_name=$row['user_name'];
                            $email=$row['email'];
                            $image=$row['image'];
                            $role=$row['role'];
                            $status=$row['status'];
                            
                            $i++;
                        
                    ?>
                    <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><?php echo $user_name ?></td>
                    <td><?php echo $email ?></td>
                    <td><img class="rounded-circle myimg" src="image/users/<?php echo $image ?>"></td>
                    <?php 
                        
                    ?>
                    <td><?php
                    if($role==1){?>
                        <span class="badge badge-success">Administrator</span><?php
                    }
                    if($role==2){?>
                        <span class="badge badge-info">Editor</span><?php
                    }
                    if($role==3){?>
                        <span class="badge badge-warning">Author</span><?php
                    }
                    echo '' ?></td>

                    <td><?php
                    if($status==1){?>
                        <span class="badge badge-success">Published</span><?php
                    }
                    else{?>
                    <span class="badge badge-danger">Draft</span><?php
                    }
                    echo '' ?></td>
                    <td>
                        <div class="icon">  
                            <a href="users.php?do=Edit&update=<?php echo $user_id?>"><i class="fa-sharp fa-solid fa-pen-to-square fa-sm" style="color:blue;"></i></a>
                          
                            <a href="users.php?do=Delete&delete=<?php echo $user_id ?>"><i class="fa-solid fa-trash  fa-sm" style="color:red;"></i></a>
                        </div>
                    </td>
                    </tr>
                    <?php } 
                    ?>
                </tbody>
            </table>
            <?php } 
elseif($do =='Add'){ ?>
          <div class="row">
            <div class="col-md-6 offset-md-3">
            <form class="from" method="POST" Action="users.php?do=Insert" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="input1" class="form-label">User Name</label>
                    <input type="text" name="user_name" required class="form-control" id="input1">
                </div>

                <div class="mb-3">
                    <label for="input1" class="form-label">Email</label>
                    <input type="email" name="email" required class="form-control" id="input1">
                </div>

                <div class="mb-3">
                    <label for="input1" class="form-label">Password</label>
                    <input type="password" name="password" required class="form-control" id="input1">
                </div>

                <div class="mb-3">
                    <label for="input1" class="form-label">Re-type-Password</label>
                    <input type="password" name="re_type_pass" required class="form-control" id="input1">
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label"></label>
                    <input class="form-control" name="image" required type="file" id="formFile">
                </div>

                <div class="mb-3">
                <label >Role</label>
                <select name="role" class="form-control">
                    <option selected>Please Select User Role</option>
                    <option value="1">Administrator</option>
                    <option value="2">Editor</option>
                    <option value="3">Author</option>
                
                </select>
            </div>

                <div class="mb-3">
                <label >Status</label>
                <select name="status" class="form-control">
                    <option selected>Please Select User Account Status</option>
                    <option value="0">Draft</option>
                    <option value="1">Published</option>
                
                </select>
            </div>
            
            <button type="submit" name="submit" class="btn  btn-primary">Submit</button>

            </form>
            <?php }
            //  insert data...............................................
elseif($do == 'Insert'){
              if($_SERVER['REQUEST_METHOD'] == 'POST'){
              $user_name=$_POST['user_name'];
              $email=$_POST['email'];
              $password=sha1($_POST['password']);
              $re_type_pass=sha1($_POST['re_type_pass']);
              $image=$_POST['image'];
              $role=$_POST['role'];
              $status=$_POST['status'];
                 //image validation...................................................................?

              $ImageName=$_FILES['image']['name'];
              $ImageSize=$_FILES['image']['size'];
              $ImageTmp=$_FILES['image']['tmp_name'];


              $Expolded=explode('.',$_FILES['image']['name']);
              $last_dot_element=end($Expolded);
              $Image_Extention=strtolower($last_dot_element);
              $Image_Allowed_Extention=array("jpg","jpeg","png");

              $formerrors=array();

              if(!empty($ImageName)){
                  if(!empty($ImageName) && !in_array($Image_Extention, $Image_Allowed_Extention)){
                      $formerrors='Invalid Image Format';
                  }
                  if(!empty($ImageSize) && $ImageSize>2097152){
                      $formerrors='Invalid is Too large! Allowed Image size is 2MB';
                      ?>
                      <i class="fa-regular fa-face-sad-cry fa-fade micon" style="color: #ffffff;"></i>
                 <h1>OOPS!!</h1>
                 <h5><?php echo $formerrors;?></h5>
                  <button type="submit" class="btn btn-dark mybtn1"><a href="index.php?do=Add">TryAgain</a></button>
                 <?php
                  }
              }
              // if(!empty($formerrors)){
              //     header("Location:index.php?do=Add");
              //     exit();
              // }
              if(empty($formerrors)){
                  $image=rand(0,999).'_'.$ImageName;
                  //upload image to is own folder
                  move_uploaded_file($ImageTmp,"image\\users\\".$image);
              $sql="INSERT INTO `user_table` (`user_name`,`email`,`password`,`re_type_pass`,`image`,`role`,`status`) VALUES ('$user_name','$email','$password','$re_type_pass','$image','$role','$status')";
           
              $std_data=mysqli_query($db,$sql);
              if($std_data){
                  header("location:users.php?do=Manage");
              }
      
              else{
                  echo die("Database Connected Error".mysqli_error($db));
              }
              
          }
                                  
      }
                  }
elseif($do == 'Edit'){
        if(isset($_GET['update'])){
            $updateID=$_GET['update'];
            $sql="SELECT * FROM user_table WHERE user_id='$updateID' ";
            $allstd=mysqli_query($db,$sql);
            while($row=mysqli_fetch_assoc($allstd)){

                $user_id=$row['user_id'];
                $user_name=$row['user_name'];
                $email=$row['email'];
                $password=$row['password'];
                $re_type_pass=$row['re_type_pass'];
                $image=$row['image'];
                $role=$row['role'];
                $status=$row['status'];

    ?>
 <div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form class="from" method="POST" action="" enctype="multipart/form-data">

            <div class="mb-3">
                    <label for="input1" class="form-label">User Name</label>
                    <input type="text" name="user_name" required class="form-control" value="<?php echo $user_name; ?>" id="input1">
                </div>

            <div class="mb-3">
                    <label for="input1" class="form-label">Email</label>
                    <input type="email" name="email" required class="form-control" value="<?php echo $email; ?>" id="input1">
                </div>

            <div class="mb-3">
                    <label for="input1" class="form-label">Password</label>
                    <input type="password" name="password" required class="form-control" value="<?php echo $password; ?>" id="input1">
                </div>

            <div class="mb-3">
                    <label for="input1" class="form-label">Re-type Password</label>
                    <input type="password" name="re_type_pass" required class="form-control" value="<?php echo $re_type_pass; ?>" id="input1">
                </div>

                <div class="mb-3">
                        <?php 
                            if(!empty($image)){
                                ?>
                                <img class="mb-3" height="auto" width="100px" style="border-radius: 10px;" src="image/users/<?php echo $image?>">
                                <?php }
                                else{
                                    ?><span><?php echo "No Image Uploaded";?></span>
                                    <?php
                                }
                        ?>
                    <label for="formFile" class="form-label"></label>
                    <input class="form-control" name="image" type="file" id="formFile">
                </div>

            <div class="mb-3">
                <label >Role</label>
                <select name="role" class="form-control" value="<?php echo $role; ?>">
                    <option selected>Please Select User Role</option>
                    <option value="1">Administrator</option>
                    <option value="2">Editor</option>
                    <option value="3">Author</option>
                
                </select>
            </div>

                <div class="mb-3">
                <label >Status</label>
                <select name="status" class="form-control" value="<?php echo $status; ?>">
                    <option selected>Please Select User Account Status</option>
                    <option value="0">Draft</option>
                    <option value="1">Published</option>
                
                </select>
            </div>

                <button type="submit" name="updated" class="btn btn-dark mybtn">Update</button>
            </form>
            <?php }} 

                        if(isset($_POST['updated'])){
                          $user_name=$_POST['user_name'];
                          $email=$_POST['email'];
                          $password=$_POST['password'];
                          $re_type_pass=$_POST['re_type_pass'];
                          $image=$_POST['image'];
                          $role=$_POST['role'];
                          $status=$_POST['status'];
        //image validation...................................................................?
        
                            $ImageName=$_FILES['image']['name'];
                            $ImageSize=$_FILES['image']['size'];
                            $ImageTmp=$_FILES['image']['tmp_name'];
        
        
                            $Expolded=explode('.',$_FILES['image']['name']);
                            $last_dot_element=end($Expolded);
                            $Image_Extention=strtolower($last_dot_element);
                            $Image_Allowed_Extention=array("jpg","jpeg","png");
        
                            $formerrors=array();
                        if(!empty($ImageName)){
                                if(!empty($ImageName) && !in_array($Image_Extention, $Image_Allowed_Extention)){
                                    $formerrors='Invalid Image Format';
                                }
                                if(!empty($ImageSize) && $ImageSize>2097152){
                                    $formerrors='Invalid is Too large! Allowed Image size is 2MB';
                                }
                            }
                        if(!empty($formerrors)){
                                header("Location:users.php?do=Edit&update=$updateID");
                                exit();
                            }
                    //         if(empty($formerrors)){
                    //             $image=rand(0,999).'_'.$ImageName;
                    //             //upload image to is own folder
                    //             move_uploaded_file($ImageTmp,"image\\users\\".$image);
                    // }
                    
                        if(!empty($ImageName)){
                            //Delete the existing image while update the new image
                            $DeleteImageSql= "SELECT * FROM user_table WHERE user_id='$updateID'";
                            $data=mysqli_query($db,$DeleteImageSql);
                            while($row=mysqli_fetch_assoc($data)){
                                $ExistingImage=$row['image'];
                                unlink('image/users/'.$ExistingImage);
                                //change the image  name random number
                                $image=rand(0,999).'_'.$ImageName;
                                //upload image to is own folder
                                move_uploaded_file($ImageTmp,"image\\users\\".$image);
                                $sql="UPDATE user_table SET user_name='$user_name',email='$email',password='$password',re_type_pass='$re_type_pass',image='$image',role='$role',status='$status' WHERE user_id='$updateID'";
                                $AddUser=mysqli_query($db,$sql);
                                if($AddUser){
                                    header("Location:users.php?do=Manage");
                                    exit();
                                    
                                }
                                else{
                                    echo die("mysqli_query Error".mysqli_error($db));
                                }
                        }
                    }
                    elseif(empty($ImageName)){
                        $sql="UPDATE user_table SET user_name='$user_name',email='$email',password='$password',re_type_pass='$re_type_pass',image='$image',role='$role',status='$status' WHERE user_id='$updateID'";
                          $AddUser=mysqli_query($db,$sql);
                                if($AddUser){
                                    header("Location:users.php?do=Manage");
                                    exit();
                                }
                                else{
                                    echo die("mysqli_query Error".mysqli_error($db));
                                }
                    }
                }
              }
elseif($do == 'Delete'){
                if(isset($_GET['delete'])){
                    $deleteID=$_GET['delete'];
                    //delete image sql
                    $DeleteImage= "SELECT * FROM user_table WHERE user_id='$deleteID'";
                    $sqlimg=mysqli_query($db,$DeleteImage);
                    while($row=mysqli_fetch_assoc($sqlimg)){
                        $ExistingImage=$row['image'];
                        unlink('image/users/'.$ExistingImage);
                    $DeleteDepartment="DELETE FROM user_table WHERE user_id='$deleteID'";
                    $sql=mysqli_query($db,$DeleteDepartment);
                    if($sql){
                        header("location:users.php?do=Manage");
                    }
                    else{
                        echo die("Database Connected Error".mysqli_error($db));
                    }
                }}}
             ?>

    <!-- <?php  ?> -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-pre
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<?php include "inc/script.php" ?>
<?php 
  ob_end_flush()
?>
</body>
</html>
