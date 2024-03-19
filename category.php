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
      $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
      // manage system..............................................
      if ($do == 'Manage') {


      ?>
        <div class="col-md-12">
          <table class="table text-center mytable">
            <thead>
              <tr>
                <th scope="col">SI</th>
                <th scope="col">Category Name</th>
                <th scope="col">Category Type</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT * FROM category_table";
              $student_data = mysqli_query($db, $sql);
              $i = 0;
              while ($row = mysqli_fetch_assoc($student_data)) {
                $category_id = $row['category_id'];
                $cat_name = $row['cat_name'];
                $is_parent = $row['is_parent'];
                $status = $row['status'];

                $i++;

              ?>
                <tr>
                  <th scope="row"><?php echo $i ?></th>
                  <td><?php echo $cat_name ?></td>

                  <td><?php
                      if ($is_parent == 0) { ?>
                      <div class="badge badge-primary">Primary Category </div>
                    <?php

                      } else {
                        $sql = "SELECT * FROM category_table WHERE category_id='$is_parent'";
                        $all_info = mysqli_query($db, $sql);
                        while ($row = mysqli_fetch_assoc($all_info)) {
                          $category_id = $row['category_id'];
                          $cat_name = $row['cat_name'];
                        }
                    ?>
                      <div class="badge badge-danger">
                        <?php echo "$cat_name"; ?>
                      </div <?php } ?> </td>


                  <td><?php
                      if ($status == 1) { ?>
                      <span class="badge badge-success">Published</span><?php
                                                                      } else { ?>
                      <span class="badge badge-danger">Draft</span><?php
                                                                      }
                                                                      echo '' ?>
                  </td>
                  <td>
                    <div class="icon">
                      <a href="category.php?do=Edit&update=<?php echo $category_id ?>"><i class="fa-sharp fa-solid fa-pen-to-square fa-sm" style="color:blue;"></i></a>
                      <a href="category.php?do=Delete&delete=<?php echo $category_id ?>"><i class="fa-solid fa-trash  fa-sm" style="color:red;"></i></a>
                    </div>
                  </td>
                </tr>
              <?php }
              ?>
            </tbody>
          </table>
        <?php } elseif ($do == 'Add') {
        ?>
          <div class="container">
            <div class="row">
              <div class="col-md-6 offset-md-3">
                <form method="POST" action="category.php?do=Insert" enctype="multipart/form-data">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Category Name</label>
                    <input type="text" name="cat_name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <!-- subcategory table -->
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Category Type</label>
                    <select name="is_parent" class="form-control">
                      <option selected>Please Select User Account Status</option>
                      <?php
                      $sql = "SELECT * FROM category_table WHERE is_parent='0'";
                      $all_info = mysqli_query($db, $sql);
                      while ($row = mysqli_fetch_assoc($all_info)) {
                        $category_id = $row['category_id'];

                        $cat_name = $row['cat_name'];

                      ?>
                        <option value="<?php echo $category_id ?>"><?php echo $cat_name ?></option>

                      <?php } ?>
                    </select>

                  </div>

                  <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                      <option selected>Please Select User Account Status</option>
                      <option value="0">Draft</option>
                      <option value="1">Published</option>

                    </select>
                  </div>

                  <button type="submit" name="submit" class="btn  btn-primary">Submit</button>
                </form>
                <?php
              }
              //  insert data...............................................
              elseif ($do == 'Insert') {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                  $cat_name = $_POST['cat_name'];
                  $is_parent = $_POST['is_parent'];
                  $status = $_POST['status'];
                  //image validation...................................................................?

                  $sql2 = "INSERT INTO `category_table` (`cat_name`,`is_parent`,`status`) VALUES ('$cat_name','$is_parent','$status')";

                  $std_data = mysqli_query($db, $sql2);
                  if ($std_data) {
                    header("location:category.php?do=Manage");
                  } else {
                    echo die("Database Connected Error" . mysqli_error($db));
                  }
                }
              } elseif ($do == 'Edit') {



                if (isset($_GET['update'])) {
                  $updateID = $_GET['update'];
                  $sql = "SELECT * FROM category_table WHERE category_id='$updateID' ";
                  $allstd = mysqli_query($db, $sql);
                  while ($row = mysqli_fetch_assoc($allstd)) {

                    $category_id = $row['category_id'];
                    $cat_name = $row['cat_name'];
                    $is_parent = $row['is_parent'];
                    $status = $row['status'];

                ?>
                    <div class="container mt-5">
                      <div class="row">
                        <div class="col-md-6 offset-md-3">
                          <form class="from" method="POST" action="" enctype="multipart/form-data">
                            <div class="mb-3">
                              <label for="input1" class="form-label">Name</label>
                              <input type="text" name="cat_name" class="form-control" value="<?php echo $cat_name; ?>" id="input1">
                            </div>
                            <!-- subcategory table -->
                            <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Category Type</label>
                              <select name="is_parent" class="form-control">
                                <option selected>Please Select User Account Status</option>
                                <?php
                                $sql = "SELECT * FROM category_table WHERE is_parent='0'";
                                $all_info = mysqli_query($db, $sql);
                                while ($row = mysqli_fetch_assoc($all_info)) {
                                  $category_id = $row['category_id'];

                                  $cat_name = $row['cat_name'];

                                ?>
                                  <option value="<?php echo $category_id ?>"><?php echo $cat_name ?></option>

                                <?php } ?>
                              </select>

                            </div>

                            <div class="mb-3">
                              <label>Status</label>
                              <select name="status" class="form-control" value="<?php echo $status; ?>">
                                <option selected>Please Select User Account Status</option>
                                <option value="0">Draft</option>
                                <option value="1">Published</option>

                              </select>
                            </div>

                            <button type="submit" name="updated" class="btn btn-dark mybtn">Update</button>
                          </form>
                    <?php }
                }

                if (isset($_POST['updated'])) {

                  $cat_name = $_POST['cat_name'];
                  $is_parent = $_POST['is_parent'];
                  $status = $_POST['status'];
                  //image validation...................................................................?


                  $sql = "UPDATE category_table SET cat_name='$cat_name',is_parent='$is_parent',status='$status' WHERE category_id='$updateID'";
                  $AddUser = mysqli_query($db, $sql);
                  if ($AddUser) {
                    header("Location:category.php?do=Manage");
                    exit();
                  } else {
                    echo die("mysqli_query Error" . mysqli_error($db));
                  }
                }
              } elseif ($do == 'Delete') {
                if (isset($_GET['delete'])) {
                  $deleteID = $_GET['delete'];
                  //delete image sql
                  $DeleteImage = "SELECT * FROM category_table WHERE category_id='$deleteID'";
                  $sqlimg = mysqli_query($db, $DeleteImage);
                  while ($row = mysqli_fetch_assoc($sqlimg)) {
                    $DeleteDepartment = "DELETE FROM category_table WHERE category_id='$deleteID'";
                    $sql = mysqli_query($db, $DeleteDepartment);
                    if ($sql) {
                      header("location:category.php?do=Manage");
                    } else {
                      echo die("Database Connected Error" . mysqli_error($db));
                    }
                  }
                }
              } ?>

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