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
                    <th scope="col">Image</th>
                    <th scope="col">Price</th>
                    <th scope="col">Title</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Condition</th> 
                    <th scope="col">Brand</th> 
                    <th scope="col">Category</th> 
                    <th scope="col">Cat Type</th> 
                    <th scope="col">Status</th> 
                    <th scope="col">Tags</th> 
                    <th scope="col">Date</th> 
                    <th scope="col">Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sql= "SELECT * FROM all_book";
                        $all_book= mysqli_query($db,$sql);
                        $i=0;
                        while($row = mysqli_fetch_assoc($all_book)){
                            $book_id=$row['book_id'];
                            $image=$row['image'];
                            $book_price=$row['book_price'];
                            $book_title=$row['book_title'];
                            $rating_book=$row['rating_book'];
                            $stock_in_out=$row['stock_in_out'];
                            $condition=$row['condition'];
                            $brand=$row['brand'];
                            $category_id=$row['category_id'];
                            $is_parent=$row['is_parent'];
                            $status=$row['status'];
                            $tag=$row['tag'];
                            $date=$row['date'];
                            
                            $i++;
                        
                    ?>
                    <tr>
                    <th scope="row"><?php echo $i ?></th>
                    <td><img class="rounded-circle myimg" src="image/bookpost/<?php echo $image ?>"></td>
                    <td><?php echo $book_price ?></td>
                    <td><?php echo $book_title ?></td>
                    <td><?php echo $rating_book ?></td>
                    <td><?php echo $stock_in_out ?></td>
                    <td><?php echo $condition ?></td>
                    <td><?php echo $brand ?></td>
                    <!-- Regerantial intrigation category table and user table goes to post table -->
              <!-- category table -->
              <td><?php 
                if($category_id==0){
                  echo 'No Category';
                }
                else{
                  $sql="SELECT * FROM category_table WHERE category_id='$category_id'";
                  $all_product= mysqli_query($db,$sql);
                  while($row = mysqli_fetch_assoc($all_product)){
                        $category_id =$row['category_id'];
                        $cat_name=$row['cat_name'];

                  }
                  echo $cat_name;
                }
              ?></td>
                    <td><?php echo $is_parent ?></td>
                    <td><?php
                    if($status==1){?>
                        <span class="badge badge-success">Published</span><?php
                    }
                    else{?>
                    <span class="badge badge-danger">Draft</span><?php
                    }
                    echo '' ?></td>
                    <td><?php echo $tag ?></td>
                    <td><?php echo $date ?></td>
                    <td>
                    <div class="icon">
                        <a href="allbook.php?do=Edit&update=<?php echo $book_id?>"><i class="fa-sharp fa-solid fa-pen-to-square"></i></a>
                        <a href="allbook.php?do=Delete&delete=<?php echo $book_id ?>"><i class="fa-solid fa-trash"></i></a>
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
      <form class="from" method="POST" Action="allbook.php?do=Insert" enctype="multipart/form-data">
          <div class="mb-3">
                    <label for="formFile" class="form-label">Image</label>
                    <input class="form-control" name="image"  type="file" id="formFile">
                </div>

          <div class="mb-3">
              <label for="input1" class="form-label">Price</label>
              <input type="text" name="book_price"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Title</label>
              <input type="text" name="book_title"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Rating</label>
              <input type="text" name="rating_book"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Stock</label>
              <input type="text" name="stock_in_out"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Condition</label>
              <input type="text" name="condition"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Brand</label>
              <input type="text" name="brand"  class="form-control" id="input1">
          </div>
        </div>
        <div class="col-md-5">

           <!-- refarential intrigation category table and user table  -->
           <div class="mb-3">
                <label >Category</label>
                <select name="category_id" class="form-control">
                    <option>Please Select Your Category</option>
                    <?php 
                        $sql="SELECT * FROM category_table";
                        $all_product= mysqli_query($db,$sql);
                        while($row = mysqli_fetch_assoc($all_product)){
                              $category_id =$row['category_id'];
                              $cat_name=$row['cat_name'];
      
                        
                    ?>
                    <option value="<?php echo $category_id?>"><?php echo $cat_name?></option>
                    <?php } ?>
                </select>
            </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Category Type</label>
              <input type="text" name="is_parent"  class="form-control" id="input1">
          </div>
            <!-- allbook status -->
            <div class="mb-3">
                  <label >Status</label>
                  <select name="status" class="form-control">
                      <option selected>Please Select User Account Status</option>
                      <option value="0">Draft</option>
                      <option value="1">Published</option>
                  
                  </select>
            </div>
            <!-- allbook status end -->
          <div class="mb-3">
              <label for="input1" class="form-label">Tags</label>
              <input type="text" name="tag"  class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Date</label>
              <input type="text" name="date"  class="form-control" id="input1">
          </div>
          <button type="submit" name="submit" class="btn btn-dark mybtn">Publish</button>
            
          </div>
        </form>
  </div>

    <?php }
    // insert data...............................................
    elseif($do=='Insert'){
        if(isset($_POST['submit'])){
            $book_price=$_POST['book_price'];
            $book_title=$_POST['book_title'];
            $rating_book=$_POST['rating_book'];
            $stock_in_out=$_POST['stock_in_out'];
            $condition=$_POST['condition'];
            $brand=$_POST['brand'];
            $category_id=$_POST['category_id'];
            $is_parent=$_POST['is_parent'];
            $status=$_POST['status'];
            $tag=$_POST['tag'];
            $date=$_POST['date'];
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
                  move_uploaded_file($ImageTmp,"image\\bookpost\\".$image);
              $sql="INSERT INTO `all_book` (`image`,`book_price`,`book_title`,`rating_book`,`stock_in_out`,`condition`,`brand`,`category_id`,`is_parent`,`status`,`tag`,`date`) VALUES ('$image','$book_price','$book_title','$rating_book','$stock_in_out','$condition','$brand','$category_id','$is_parent','$status','$tag',now() )";
           
            $book_sql=mysqli_query($db,$sql);
            if($book_sql){
              header("Location:allbook.php?do=Manage");
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
          $sql="SELECT * FROM all_book WHERE book_id='$updateID' ";
          $allstd=mysqli_query($db,$sql);
          while($row=mysqli_fetch_assoc($allstd)){
    
            $book_id=$row['book_id'];
            $image=$row['image'];
            $book_price=$row['book_price'];
            $book_title=$row['book_title'];
            $rating_book=$row['rating_book'];
            $stock_in_out=$row['stock_in_out'];
            $condition=$row['condition'];
            $brand=$row['brand'];
            $category_id=$row['category_id'];
            $is_parent=$row['is_parent'];
            $status=$row['status'];
            $tag=$row['tag'];
            $date=$row['date'];
          ?>
          <div class="row">
    <div class="col-md-5 offset-md-1">
      <form class="from" method="POST" Action="" enctype="multipart/form-data">
          
      <div class="mb-3">
            <?php 
                if(!empty($image)){
                    ?>
                    <img class="mb-3" height="auto" width="100px" style="border-radius: 10px;" src="image/bookpost/<?php echo $image?>">
                    <?php }
                    else{
                        ?><span><?php echo "No Image Uploaded";?></span>
                        <?php
                    }
                ?>
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" name="image" type="file" id="formFile">
            </div>

          <div class="mb-3">
              <label for="input1" class="form-label">Price</label>
              <input type="text" name="book_price" value="<?php echo $book_price ?>"  class="form-control"id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Title</label>
              <input type="text" name="book_title" value="<?php echo $book_title ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Rating</label>
              <input type="text" name="rating_book" value="<?php echo $rating_book ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Stock</label>
              <input type="text" name="stock_in_out" value="<?php echo $stock_in_out ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Condition</label>
              <input type="text" name="condition" value="<?php echo $condition ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Brand</label>
              <input type="text" name="brand" value="<?php echo $brand ?>" class="form-control" id="input1">
          </div>
        </div>
        <div class="col-md-5">

          <!-- refarential intrigation category table and user table  -->
          <div class="mb-3">
                        <label >Category</label>
                    <select name="category_id" class="form-control" value="<?php echo $category_id; ?>">
                        <option>Please Select Your Category</option>
                        <?php 
                            $sql="SELECT * FROM category_table";
                            $all_product= mysqli_query($db,$sql);
                            while($row = mysqli_fetch_assoc($all_product)){
                                    $category_id =$row['category_id'];
                                    $cat_name=$row['cat_name'];
                                              
                            ?>
                            <option value="<?php echo $category_id?>"><?php echo $cat_name?></option>
                            <?php } ?>
                        </select>
                    </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Category Type</label>
              <input type="text" name="is_parent" value="<?php echo $is_parent ?>" class="form-control" id="input1">
          </div>
            <!-- allbook status -->
            <div class="mb-3">
                  <label >Status</label>
                  <select name="status" class="form-control" value="<?php echo $status ?>">
                      <option selected>Please Select User Account Status</option>
                      <option value="0">Draft</option>
                      <option value="1">Published</option>
                  
                  </select>
            </div>
            <!-- allbook status end -->
          <div class="mb-3">
              <label for="input1" class="form-label">Tags</label>
              <input type="text" name="tag" value="<?php echo $tag ?>" class="form-control" id="input1">
          </div>
          <div class="mb-3">
              <label for="input1" class="form-label">Date</label>
              <input type="text" name="date" value="<?php echo $date ?>" class="form-control" id="input1">
          </div>
          <button type="submit" name="updated" class="btn btn-dark mybtn">Update</button>
            
          </div>
        </form>
  </div>
  <?php } 
          if(isset($_POST['updated'])){
            $book_price=$_POST['book_price'];
            $book_title=$_POST['book_title'];
            $rating_book=$_POST['rating_book'];
            $stock_in_out=$_POST['stock_in_out'];
            $condition=$_POST['condition'];
            $brand=$_POST['brand'];
            $category_id=$_POST['category_id'];
            $is_parent=$_POST['is_parent'];
            $status=$_POST['status'];
            $tag=$_POST['tag'];
            $date=$_POST['date'];
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
                  header("Location:allbook.php?do=Edit&update=$updateID");
                  exit();
              }
      //         if(empty($formerrors)){
      //             $image=rand(0,999).'_'.$ImageName;
      //             //upload image to is own folder
      //             move_uploaded_file($ImageTmp,"image\\".$image);
      // }
      
          if(!empty($ImageName)){
              //Delete the existing image while update the new image
              $DeleteImageSql= "SELECT * FROM all_book WHERE book_id='$updateID'";
              $data=mysqli_query($db,$DeleteImageSql);
              while($row=mysqli_fetch_assoc($data)){
                  $ExistingImage=$row['image'];
                  unlink('image/bookpost/'.$ExistingImage);
                  //change the image  name random number
                  $image=rand(0,999).'_'.$ImageName;
                  //upload image to is own folder
                  move_uploaded_file($ImageTmp,"image\\bookpost\\".$image);
                  //update sql..................................................
                  $sql="UPDATE all_book SET image='$image',book_price='$book_price',book_title='$book_title',rating_book='$rating_book',stock_in_out='$stock_in_out',`condition`='$condition',brand='$brand',category_id='$category_id',is_parent='$is_parent',status='$status',tag='$tag',date='$date' WHERE book_id='$updateID'";
                  $AddUser=mysqli_query($db,$sql);
                  if($AddUser){
                      header("Location:allbook.php?do=Manage");
                      exit();
                  }
                  else{
                      echo die("mysqli_query Error".mysqli_error($db));
                  }
          }
      }
      elseif(empty($ImageName)){
        $sql2="UPDATE all_book SET image='$image',book_price='$book_price',book_title='$book_title',rating_book='$rating_book',stock_in_out='$stock_in_out',`condition`='$condition',brand='$brand',category_id='$category_id',is_parent='$is_parent',status='$status',tag='$tag',date='$date' WHERE book_id='$updateID'";
           $another=mysqli_query($db,$sql2);
                  if($another){
                      header("Location:allbook.php?do=Manage");
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
          $DeleteImage= "SELECT * FROM all_book WHERE book_id='$deleteID'";
          $sqlimg=mysqli_query($db,$DeleteImage);
          while($row=mysqli_fetch_assoc($sqlimg)){
              $ExistingImage=$row['image'];
              unlink('image/bookpost/'.$ExistingImage);
          $DeleteDepartment="DELETE FROM all_book WHERE book_id='$deleteID'";
          $sql=mysqli_query($db,$DeleteDepartment);
          if($sql){
              header("location:allbook.php?do=Manage");
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
