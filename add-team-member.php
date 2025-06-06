<?php
  include './header.php';


  if(!isset($_GET['team-id']) || strlen($_GET['team-id']) < 1 || !ctype_digit($_GET['team-id'])){
    echo '<script> history.back()</script>';
    exit();
  }

  require_once './src/requester.php';
  require_once './src/user.php';
  require_once './src/team-member.php';

  $users = new User();
  $allusers = $users::findAll();



        $err = '';
        $msg = '';
       
    if (isset($_POST['submit'])) {
       
        $user = $_POST['id'];
        $teamid = $_GET['team-id'];
       // print_r($teamid);die();
        if($user == 'none'){

            $err = "please select user";

        }else {
        
        try {

            $team_mem = new TeamMember([
                'id' => $user,
                'team-id' => $teamid
              
            ]); 
      
           

            $saveteam = $team_mem->save();
          //  print_r($saveteam);die();
          $msg = "Member Added successfully";
            
        } catch (Exception $e) {

            $err = "Failed to Add member";
            
        }
 }
}

 
?>
<div id="content-wrapper">

    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Add New Member </li>
        </ol>

        <div class="card mb-3">
            <div class="card-header">
                <h3>Create a new member</h3>
            </div>
            <div class="card-body">
               <?php if(strlen($err) > 1) :?>
                <div class="alert alert-danger text-center my-3" role="alert"> <strong>Failed! </strong> <?php echo $err;?></div>
                <?php endif?>

                <?php if(strlen($msg) > 1) :?>
                <div class="alert alert-success text-center my-3" role="alert"> <strong>Success! </strong> <?php echo $msg;?></div>
                <?php endif?>
               
                <form method="POST" action="">
                   
                  
                    <div class="form-group row col-lg-8 offset-lg-2 col-md-8 offset-md-2 col-sm-12">
                        <label for="name" class="col-sm-12 col-lg-2 col-md-2 col-form-label">User</label>
                        <div class="col-sm-8">
                            <select name="id" class="form-control">
                                <option>--select--</option>
                                <?php foreach($allusers as $user):?>
                                <option value="<?php echo $user->id?>"> <?php echo $user->name?></option>
                                <?php endforeach?>
                            </select>
                        </div>
                    </div>
                    
                    
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-lg btn-primary"> Create</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    <!-- Sticky Footer -->
    <footer class="sticky-footer">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright © Your Website 2019</span>
            </div>
        </div>
    </footer>

</div>
<!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="./index.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin.min.js"></script>

<!-- Demo scripts for this page-->
<script src="js/demo/datatables-demo.js"></script>
<script src="js/demo/chart-area-demo.js"></script>

</body>

</html>