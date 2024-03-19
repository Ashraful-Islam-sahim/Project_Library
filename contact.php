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
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql= "SELECT * FROM contact_table";
                        $contact_table= mysqli_query($db,$sql);
                        $i=0;
                        while($row = mysqli_fetch_assoc($contact_table)){
                            $id =$row['id'];
                            $name=$row['name'];
                            $email=$row['email'];
                            $subject=$row['subject'];
                            $des=$row['des'];

                            $i++;
                        
                    ?>
                    <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><?php echo $name ?></td>
                    <td><?php echo $email ?></td>
                    <td><?php echo $subject ?></td>
                    <td><?php echo $des ?></td>
                    <td>
                    <div class="icon">
                        <a href="contact.php?do=Edit&update=<?php echo $id?>"><i class="fa-sharp fa-solid fa-pen-to-square"></i></a>
                        <a href="contact.php?do=Delete&delete=<?php echo $id ?>"><i class="fa-solid fa-trash"></i></a>
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
      <form class="from" method="POST" Action="contact.php?do=Insert" enctype="multipart/form-data">
          
          <div class="mb-3">
              <label for="input1" class="form-label">Name</label>
              <input type="text" name="name"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Email</label>
              <input type="text" name="email"  class="form-control" id="input1">
          </div>
        
          <div class="mb-3">
              <label for="input1" class="form-label">Subject</label>
              <input type="text" name="subject"  class="form-control" id="input1">
          </div>
        
          <div class="mb-3">
              <label for="input1" class="form-label">Description</label>
              <input type="text" name="des"  class="form-control" id="input1">
          </div>
        
          <button type="submit" name="submit" class="btn btn-dark mybtn">Publish</button>
            
          </div>
        </form>
  </div>

    <?php }
    // insert data...............................................
    elseif($do=='Insert'){
        if(isset($_POST['submit'])){
          $name=$_POST['name'];
          $email=$_POST['email'];
          $subject=$_POST['subject'];
          $des=$_POST['des'];
           //insert sql.....................
              $sql="INSERT INTO `contact_table` (`name`,`email`,`subject`,`des`) VALUES ('$name','$email','$subject','$des')";
            $book_sql=mysqli_query($db,$sql);
            if($book_sql){
              header("Location:contact.php?do=Manage");
            }
      
              else{
                  echo die("Database Connected Error".mysqli_error($db));
              }
              
          }
                                  
      }
        
    // edit & update data.......................................
    elseif($do == 'Edit'){
        if(isset($_GET['update'])){
            $updateID=$_GET['update'];
            $sql="SELECT * FROM contact_table WHERE id='$updateID' ";
            $allstd=mysqli_query($db,$sql);
            while($row=mysqli_fetch_assoc($allstd)){
      
              $id=$row['id'];
              $name=$row['name'];
              $email=$row['email'];
              $subject=$row['subject'];
              $des=$row['des'];
            ?>
     <div class="row">
    <div class="col-md-5 offset-md-1">
      <form class="from" method="POST" Action="" enctype="multipart/form-data">
          
          <div class="mb-3">
              <label for="input1" class="form-label">Name</label>
              <input type="text" name="name" value="<?php echo $name ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Email</label>
              <input type="text" name="email" value="<?php echo $email ?>" class="form-control" id="input1">
          </div>
        
          <div class="mb-3">
              <label for="input1" class="form-label">Subject</label>
              <input type="text" name="subject" value="<?php echo $subject ?>" class="form-control" id="input1">
          </div>
        
          <div class="mb-3">
              <label for="input1" class="form-label">Description</label>
              <input type="text" name="des" value="<?php echo $des ?>" class="form-control" id="input1">
          </div>
        
          <button type="submit" name="updated" class="btn btn-dark mybtn">Update</button>
            
          </div>
        </form>
  </div>
    <?php } 
            if(isset($_POST['updated'])){
              $id=$_POST['id'];
              $name=$_POST['name'];
              $email=$_POST['email'];
              $subject=$_POST['subject'];
              $des=$_POST['des'];
              //update sql..................................................
              $sql="UPDATE contact_table SET name='$name',email='$email',subject='$subject',des='$des' WHERE id='$updateID'";
              $AddUser=mysqli_query($db,$sql);
              if($AddUser){
                  header("Location:contact.php?do=Manage");
                  exit();
              }
              else{
                  echo die("mysqli_query Error".mysqli_error($db));
              }
            }
        }
               }
    //delete data..................................................
    elseif($do == 'Delete'){
      if(isset($_GET['delete'])){
          $deleteID=$_GET['delete'];
          $DeleteDepartment="DELETE FROM contact_table WHERE id='$deleteID'";
          $sql=mysqli_query($db,$DeleteDepartment);
          if($sql){
              header("location:contact.php?do=Manage");
          }
          else{
              echo die("Database Connected Error".mysqli_error($db));
          }
      }}?>
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
