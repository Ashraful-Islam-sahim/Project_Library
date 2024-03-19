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
                    <th scope="col">Country</th>
                    <th scope="col">State</th>
                    <th scope="col">Zip-Code</th>
                    <th scope="col">Sub Total</th>
                    <th scope="col">Tax</th>
                    <th scope="col">Total</th> 
                    <th scope="col">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql= "SELECT * FROM cart_table";
                        $cart_table= mysqli_query($db,$sql);
                        $i=0;
                        while($row = mysqli_fetch_assoc($cart_table)){
                            $cart_id=$row['cart_id'];
                            $cart_country=$row['cart_country'];
                            $cart_state=$row['cart_state'];
                            $cart_zip_code=$row['cart_zip_code'];
                            $cart_sub_total=$row['cart_sub_total'];
                            $tax=$row['tax'];
                            $total=$row['total'];
                            
                            $i++;
                        
                    ?>
                    <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><?php echo $cart_country ?></td>
                    <td><?php echo $cart_state ?></td>
                    <td><?php echo $cart_zip_code ?></td>
                    <td><?php echo $cart_sub_total ?></td>
                    <td><?php echo $tax ?></td>
                    <td><?php echo $total ?></td>
                   <td> <div class="icon">
                        <a href="cart.php?do=Edit&update=<?php echo $cart_id?>"><i class="fa-sharp fa-solid fa-pen-to-square"></i></a>
                        <a href="cart.php?do=Delete&delete=<?php echo $cart_id ?>"><i class="fa-solid fa-trash"></i></a>
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
      <form class="from" method="POST" Action="cart.php?do=Insert" enctype="multipart/form-data">
          
          <div class="mb-3">
              <label for="input1" class="form-label">Country</label>
              <input type="text" name="cart_country"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">State</label>
              <input type="text" name="cart_state"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Zip-Code</label>
              <input type="text" name="cart_zip_code"  class="form-control" id="input1">
          </div>
     </div>
     <div class="col-md-5">
          <div class="mb-3">
              <label for="input1" class="form-label">Sub Total</label>
              <input type="text" name="cart_sub_total"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Tax</label>
              <input type="text" name="tax"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Total</label>
              <input type="text" name="total"  class="form-control" id="input1">
          </div>
          <button type="submit" name="submit" class="btn btn-dark mybtn">Publish</button>
            
          </div>
        </form>
  </div>

    <?php }
    // insert data...............................................
    elseif($do=='Insert'){
        if(isset($_POST['submit'])){
            $cart_country=$_POST['cart_country'];
            $cart_state=$_POST['cart_state'];
            $cart_zip_code=$_POST['cart_zip_code'];
            $cart_sub_total=$_POST['cart_sub_total'];
            $tax=$_POST['tax'];
            $total=$_POST['total'];
           //insert sql.................................
              $sql="INSERT INTO `cart_table` (`cart_country`,`cart_state`,`cart_zip_code`,`cart_sub_total`,`tax`,`total`) VALUES ('$cart_country','$cart_state' ,'$cart_zip_code','$cart_sub_total','$tax','$total')";
           
            $book_sql=mysqli_query($db,$sql);
            if($book_sql){
              header("Location:cart.php?do=Manage");
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
          $sql="SELECT * FROM cart_table WHERE cart_id='$updateID' ";
          $allstd=mysqli_query($db,$sql);
          while($row=mysqli_fetch_assoc($allstd)){
    
            $cart_id=$row['cart_id'];
            $cart_country=$row['cart_country'];
            $cart_state=$row['cart_state'];
            $cart_zip_code=$row['cart_zip_code'];
            $cart_sub_total=$row['cart_sub_total'];
            $tax=$row['tax'];
            $total=$row['total'];
          ?>
  <div class="row">
    <div class="col-md-5 offset-md-1">
      <form class="from" method="POST" Action="" enctype="multipart/form-data">
          
          <div class="mb-3">
              <label for="input1" class="form-label">Country</label>
              <input type="text" name="cart_country" value="<?php echo $cart_country ?>"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">State</label>
              <input type="text" name="cart_state" value="<?php echo $cart_country ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Zip-Code</label>
              <input type="text" name="cart_zip_code" value="<?php echo $cart_zip_code ?>" class="form-control" id="input1">
          </div>
     </div>
     <div class="col-md-5">
          <div class="mb-3">
              <label for="input1" class="form-label">Sub Total</label>
              <input type="text" name="cart_sub_total" value="<?php echo $cart_sub_total ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Tax</label>
              <input type="text" name="tax" value="<?php echo $tax ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Total</label>
              <input type="text" name="total" value="<?php echo $total ?>" class="form-control" id="input1">
          </div>
          <button type="submit" name="updated" class="btn btn-dark mybtn">Update</button>
            
          </div>
        </form>
  </div>
  <?php } 
          if(isset($_POST['updated'])){
            $cart_country=$_POST['cart_country'];
            $cart_state=$_POST['cart_state'];
            $cart_zip_code=$_POST['cart_zip_code'];
            $cart_sub_total=$_POST['cart_sub_total'];
            $tax=$_POST['tax'];
            $total=$_POST['total'];

                  //update sql..................................................
                  $sql="UPDATE cart_table SET cart_country='$cart_country',cart_state='$cart_state',cart_zip_code='$cart_zip_code',cart_sub_total='$cart_sub_total',tax='$tax',total='$total' WHERE cart_id='$updateID'";
                  $AddUser=mysqli_query($db,$sql);
                  if($AddUser){
                      header("Location:cart.php?do=Manage");
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
          $DeleteDepartment="DELETE FROM cart_table WHERE cart_id='$deleteID'";
          $sql=mysqli_query($db,$DeleteDepartment);
          if($sql){
              header("location:cart.php?do=Manage");
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
