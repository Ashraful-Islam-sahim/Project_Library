<?php 
      ob_start(); 
  ?>
<?php include "inc/header.php" ?>
<?php include "inc/navbar.php" ?>
<?php include "inc/menu.php" ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->

  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
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


  <!-- /.content-wrapper -->
  <!-- all book content start -->
  <?php 
     $do=isset($_GET['do']) ? $_GET['do']:'Manage';
     // manage data...............................................
     if($do=='Manage'){      
        ?>
        <div class="col-md-12">
            <table class="table text-center">
                <thead>
                    <tr>
                    <th scope="col">SI</th>
                    <th scope="col">User</th>
                    <th scope="col">Time</th>
                    <th scope="col">Date</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Title</th>
                    <th scope="col">Image</th> 
                    <th scope="col">Description</th> 
                    <th scope="col">Status</th> 
                    <th scope="col">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql= "SELECT * FROM blog_table";
                        $blog_table= mysqli_query($db,$sql);
                        $i=0;
                        while($row = mysqli_fetch_assoc($blog_table)){
                            $blog_id=$row['blog_id'];
                            $blog_user=$row['blog_user'];
                            $blog_time=$row['blog_time'];
                            $blog_date=$row['blog_date'];
                            $rating_book=$row['rating_book'];
                            $blog_title=$row['blog_title'];
                            $image=$row['image'];
                            $blog_des=$row['blog_des'];
                            $blog_status=$row['blog_status'];
                            
                            $i++;
                        
                    ?>
                    <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><?php echo $blog_user ?></td>
                    <td><?php echo $blog_time ?></td>
                    <td><?php echo $blog_date ?></td>
                    <td><?php echo $rating_book ?></td>
                    <td><?php echo $blog_title ?></td>
                    <td><img class="rounded-circle myimg" src="image/blog/<?php echo $image ?>"></td>
                    <td><?php echo $blog_des ?></td>
                    <td><?php
                    if($blog_status==1){?>
                        <span class="badge badge-success">Published</span><?php
                    }
                    else{?>
                    <span class="badge badge-danger">Draft</span><?php
                    }
                    echo '' ?></td>
                    <td>
                    <div class="icon">
                        <a href="blog.php?do=Edit&update=<?php echo $blog_id?>"><i class="fa-sharp fa-solid fa-pen-to-square"></i></a>
                        <a href="blog.php?do=Delete&delete=<?php echo $blog_id ?>"><i class="fa-solid fa-trash"></i></a>
                    </div>
                    </td>
                    </tr>
                    <?php } 
                    ?>
                </tbody>
            </table>
        </div>
            <?php } 
    // add data...............................................
     elseif($do=='Add'){ ?>
  <div class="row">
    <div class="col-md-5 offset-md-1">
      <form class="from" method="POST" Action="blog.php?do=Insert" enctype="multipart/form-data">
          
          <div class="mb-3">
              <label for="input1" class="form-label">User</label>
              <input type="text" name="blog_user"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Time</label>
              <input type="text" name="blog_time"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Date</label>
              <input type="text" name="blog_date"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Rating</label>
              <input type="text" name="rating_book"  class="form-control" id="input1">
          </div>
     </div>
     <div class="col-md-5">
          <div class="mb-3">
              <label for="input1" class="form-label">Title</label>
              <input type="text" name="blog_title"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input class="form-control" name="image"  type="file" id="formFile">
                </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Description</label>
              <input type="text" name="blog_des"  class="form-control" id="input1">
          </div>
            <!-- blog status -->
            <div class="mb-3">
                  <label >Status</label>
                  <select name="blog_status" class="form-control">
                      <option selected>Please Select User Account Status</option>
                      <option value="0">Draft</option>
                      <option value="1">Published</option>
                  
                  </select>
            </div>
            <!-- blog status end -->
          <button type="submit" name="submit" class="btn btn-dark mybtn">Publish</button>
            
          </div>
        </form>
  </div>

    <?php }
    // insert data...............................................
    elseif($do=='Insert'){
        if(isset($_POST['submit'])){
            $blog_id=$_POST['blog_id'];
            $blog_user=$_POST['blog_user'];
            $blog_time=$_POST['blog_time'];
            $blog_date=$_POST['blog_date'];
            $rating_book=$_POST['rating_book'];
            $blog_title=$_POST['blog_title'];
            $image=$_POST['image'];
            $blog_des=$_POST['blog_des'];
            $blog_status=$_POST['blog_status'];
            //image validation......................................................->
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
                 <?php
                  }
              }
              if(empty($formerrors)){
                  $image=rand(0,999).'_'.$ImageName;
                  //upload image to is own folder
                  move_uploaded_file($ImageTmp,"image\\blog\\".$image);
              $sql="INSERT INTO `blog_table` (`blog_user`,`blog_time`,`blog_date`,`rating_book`,`blog_title`,`image`,`blog_des`,`blog_status`) VALUES ('$blog_user','$blog_time',now() ,'$rating_book','$blog_title','$image','$blog_des','$blog_status')";
           
            $book_sql=mysqli_query($db,$sql);
            if($book_sql){
              header("Location:blog.php?do=Manage");
            }
      
              else{
                  echo die("Database Connected Error".mysqli_error($db));
              }
              
          }
                                  
      }
        }
    // edit & update data.......................................
    elseif($do == 'Edit'){
      if(isset($_GET['update'])){
          $updateID=$_GET['update'];
          $sql="SELECT * FROM blog_table WHERE blog_id='$updateID' ";
          $allstd=mysqli_query($db,$sql);
          while($row=mysqli_fetch_assoc($allstd)){
    
            $blog_id=$row['blog_id'];
            $blog_user=$row['blog_user'];
            $blog_time=$row['blog_time'];
            $blog_date=$row['blog_date'];
            $rating_book=$row['rating_book'];
            $blog_title=$row['blog_title'];
            $image=$row['image'];
            $blog_des=$row['blog_des'];
            $blog_status=$row['blog_status'];
          ?>
  <div class="row">
    <div class="col-md-5 offset-md-1">
      <form class="from" method="POST" Action="" enctype="multipart/form-data">
          
          <div class="mb-3">
              <label for="input1" class="form-label">User</label>
              <input type="text" name="blog_user" value="<?php echo $blog_user ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Time</label>
              <input type="text" name="blog_time" value="<?php echo $blog_time ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Date</label>
              <input type="text" name="blog_date" value="<?php echo $blog_date ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Rating</label>
              <input type="text" name="rating_book" value="<?php echo $rating_book ?>" class="form-control" id="input1">
          </div>
     </div>
     <div class="col-md-5">
          <div class="mb-3">
              <label for="input1" class="form-label">Title</label>
              <input type="text" name="blog_title" value="<?php echo $blog_title ?>"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
            <?php 
                if(!empty($image)){
                    ?>
                    <img class="mb-3" height="auto" width="100px" style="border-radius: 10px;" src="image/blog/<?php echo $image?>">
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
              <label for="input1" class="form-label">Description</label>
              <input type="text" name="blog_des" value="<?php echo $blog_des ?>" class="form-control" id="input1">
          </div>
            <!-- blog status -->
            <div class="mb-3">
                  <label >Status</label>
                  <select name="blog_status"value="<?php echo $blog_status ?>" class="form-control">
                      <option selected>Please Select User Account Status</option>
                      <option value="0">Draft</option>
                      <option value="1">Published</option>
                  
                  </select>
            </div>
            <!-- blog status end -->
          <button type="submit" name="updated" class="btn btn-dark mybtn">Update</button>
            
          </div>
        </form>
  </div>
  <?php } 
          if(isset($_POST['updated'])){
            $blog_id=$_POST['blog_id'];
            $blog_user=$_POST['blog_user'];
            $blog_time=$_POST['blog_time'];
            $blog_date=$_POST['blog_date'];
            $rating_book=$_POST['rating_book'];
            $blog_title=$_POST['blog_title'];
            $blog_des=$_POST['blog_des'];
            $blog_status=$_POST['blog_status'];
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
                  header("Location:blog.php?do=Edit&update=$updateID");
                  exit();
              }
      //         if(empty($formerrors)){
      //             $image=rand(0,999).'_'.$ImageName;
      //             //upload image to is own folder
      //             move_uploaded_file($ImageTmp,"image\\".$image);
      // }
      
          if(!empty($ImageName)){
              //Delete the existing image while update the new image
              $DeleteImageSql= "SELECT * FROM blog_table WHERE blog_id='$updateID'";
              $data=mysqli_query($db,$DeleteImageSql);
              while($row=mysqli_fetch_assoc($data)){
                  $ExistingImage=$row['image'];
                  unlink('image/blog/'.$ExistingImage);
                  //change the image  name random number
                  $image=rand(0,999).'_'.$ImageName;
                  //upload image to is own folder
                  move_uploaded_file($ImageTmp,"image\\blog\\".$image);
                  //update sql..................................................
                  $sql="UPDATE blog_table SET blog_user='$blog_user',blog_time='$blog_time',blog_date='$blog_date',rating_book='$rating_book',blog_title='$blog_title',image='$image',blog_des='$blog_des',blog_status='$blog_status' WHERE blog_id='$updateID'";
                  $AddUser=mysqli_query($db,$sql);
                  if($AddUser){
                      header("Location:blog.php?do=Manage");
                      exit();
                  }
                  else{
                      echo die("mysqli_query Error".mysqli_error($db));
                  }
          }
      }
      elseif(empty($ImageName)){
        $sql2="UPDATE blog_table SET blog_user='$blog_user',blog_time='$blog_time',blog_date='$blog_date',rating_book='$rating_book',blog_title='$blog_title',image='$image',blog_des='$blog_des',blog_status='$blog_status' WHERE blog_id='$updateID'";
           $another=mysqli_query($db,$sql2);
                  if($another){
                      header("Location:blog.php?do=Manage");
                      exit();
                  }
                  else{
                      echo die("mysqli_query Error".mysqli_error($db));
                  }
                }
             }
           }
         }
    //delete data..................................................
    elseif($do == 'Delete'){
      if(isset($_GET['delete'])){
          $deleteID=$_GET['delete'];
          //delete image sql
          $DeleteImage= "SELECT * FROM blog_table WHERE blog_id='$deleteID'";
          $sqlimg=mysqli_query($db,$DeleteImage);
          while($row=mysqli_fetch_assoc($sqlimg)){
              $ExistingImage=$row['image'];
              unlink('image/blog/'.$ExistingImage);
          $DeleteDepartment="DELETE FROM blog_table WHERE blog_id='$deleteID'";
          $sql=mysqli_query($db,$DeleteDepartment);
          if($sql){
              header("location:blog.php?do=Manage");
          }
          else{
              echo die("Database Connected Error".mysqli_error($db));
          }
      }}} ?>
  </div>
  <!-- all book content end -->
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

<?php include "inc/script.php" ?>
<?php 
  ob_end_flush()
?>
</body>
</html>
