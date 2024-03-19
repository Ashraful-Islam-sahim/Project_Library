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
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql= "SELECT * FROM book_banner";
                        $book_banner= mysqli_query($db,$sql);
                        $i=0;
                        while($row = mysqli_fetch_assoc($book_banner)){
                            $ban_id=$row['ban_id'];
                            $title=$row['title'];
                            $des=$row['des'];
                            $image=$row['image'];
                            $status=$row['status'];

                            $i++;
                        
                    ?>
                    <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><?php echo $title ?></td>
                    <td><?php echo $des ?></td>
                    <td><img class="rounded-circle myimg" src="image/banner/<?php echo $image ?>"></td>
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
                        <a href="banner.php?do=Edit&update=<?php echo $ban_id?>"><i class="fa-sharp fa-solid fa-pen-to-square"></i></a>
                        <a href="banner.php?do=Delete&delete=<?php echo $ban_id ?>"><i class="fa-solid fa-trash"></i></a>
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
      <form class="from" method="POST" Action="banner.php?do=Insert" enctype="multipart/form-data">
          
          <div class="mb-3">
              <label for="input1" class="form-label">Title</label>
              <input type="text" name="title"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Description</label>
              <input type="text" name="des"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input class="form-control" name="image"  type="file" id="formFile">
                </div>
            <!-- banner status -->
            <div class="mb-3">
                  <label >Status</label>
                  <select name="status" class="form-control">
                      <option selected>Please Select User Account Status</option>
                      <option value="0">Draft</option>
                      <option value="1">Published</option>
                  
                  </select>
            </div>
            <!-- banner status end -->
          <button type="submit" name="submit" class="btn btn-dark mybtn">Publish</button>
            
          </div>
        </form>
  </div>

    <?php }
    // insert data...............................................
    elseif($do=='Insert'){
        if(isset($_POST['submit'])){
            $title=$_POST['title'];
            $des=$_POST['des'];
            $image=$_POST['image'];
            $status=$_POST['status'];
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
                  move_uploaded_file($ImageTmp,"image\\banner\\".$image);
              $sql="INSERT INTO `book_banner` (`title`,`des`,`image`,`status`) VALUES ('$title','$des','$image','$status')";
            $book_sql=mysqli_query($db,$sql);
            if($book_sql){
              header("Location:banner.php?do=Manage");
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
            $sql="SELECT * FROM book_banner WHERE ban_id='$updateID' ";
            $allstd=mysqli_query($db,$sql);
            while($row=mysqli_fetch_assoc($allstd)){
      
              $ban_id=$row['ban_id'];
              $title=$row['title'];
              $des=$row['des'];
              $image=$row['image'];
              $status=$row['status'];
            ?>
    <div class="row">
      <div class="col-md-5 offset-md-1">
        <form class="from" method="POST" Action="" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label for="input1" class="form-label">Title</label>
                <input type="text" name="title" value="<?php echo $title ?>" class="form-control" id="input1">
            </div>
            <div class="mb-3">
                <label for="input1" class="form-label">Description</label>
                <input type="text" name="des" value="<?php echo $des ?>" class="form-control" id="input1">
            </div>
            <div class="mb-3">
              <?php 
                  if(!empty($image)){
                      ?>
                      <img class="mb-3" height="auto" width="100px" style="border-radius: 10px;" src="image/banner/<?php echo $image?>">
                      <?php }
                      else{
                          ?><span><?php echo "No Image Uploaded";?></span>
                          <?php
                      }
                  ?>
                  <label for="formFile" class="form-label"></label>
                  <input class="form-control" name="image" type="file" id="formFile">
              </div>
              <!-- blog status -->
              <div class="mb-3">
                    <label >Status</label>
                    <select name="status"value="<?php echo $status ?>" class="form-control">
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
              $ban_id=$_POST['ban_id'];
              $title=$_POST['title'];
              $des=$_POST['des'];
              $image=$_POST['image'];
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
                    header("Location:banner.php?do=Edit&update=$updateID");
                    exit();
                }
        //         if(empty($formerrors)){
        //             $image=rand(0,999).'_'.$ImageName;
        //             //upload image to is own folder
        //             move_uploaded_file($ImageTmp,"image\\".$image);
        // }
        
            if(!empty($ImageName)){
                //Delete the existing image while update the new image
                $DeleteImageSql= "SELECT * FROM book_banner WHERE ban_id='$updateID'";
                $data=mysqli_query($db,$DeleteImageSql);
                while($row=mysqli_fetch_assoc($data)){
                    $ExistingImage=$row['image'];
                    unlink('image/banner/'.$ExistingImage);
                    //change the image  name random number
                    $image=rand(0,999).'_'.$ImageName;
                    //upload image to is own folder
                    move_uploaded_file($ImageTmp,"image\\banner\\".$image);
                    //update sql..................................................
                    $sql="UPDATE book_banner SET title='$title',des='$des',image='$image',status='$status' WHERE ban_id='$updateID'";
                    $AddUser=mysqli_query($db,$sql);
                    if($AddUser){
                        header("Location:banner.php?do=Manage");
                        exit();
                    }
                    else{
                        echo die("mysqli_query Error".mysqli_error($db));
                    }
            }
        }
        elseif(empty($ImageName)){
            $sql2="UPDATE book_banner SET title='$title',des='$des',image='$image',status='$status' WHERE ban_id='$updateID'";
             $another=mysqli_query($db,$sql2);
                    if($another){
                        header("Location:banner.php?do=Manage");
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
          $DeleteImage= "SELECT * FROM book_banner WHERE ban_id='$deleteID'";
          $sqlimg=mysqli_query($db,$DeleteImage);
          while($row=mysqli_fetch_assoc($sqlimg)){
              $ExistingImage=$row['image'];
              unlink('image/banner/'.$ExistingImage);
          $DeleteDepartment="DELETE FROM book_banner WHERE ban_id='$deleteID'";
          $sql=mysqli_query($db,$DeleteDepartment);
          if($sql){
              header("location:banner.php?do=Manage");
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
