<?php include("includes/init.php"); ?>

<?php
  $owners = Owner::find_all();
 ?>


        <div id="page-wrapper">
          <div class="container-fluid">
              <!-- Page Heading -->
              <div class="row">
                  <div class="col-lg-12">

                      <h1 class="page-header">
                          OWNERS
                      </h1>
                      <a href="add_user.php" class="btn btn-primary"> Add User</a>

                    <div class="col-md-12">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Business name</th>
                          <th>First Name</th>
                          <th>Surname</th>
                          <th>Email</th>
                          <th>Telephone</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($owners as $owner) : ?>
                        <tr>
                          <td><?php echo $owner->id; ?></td>
                            <td><?php echo $owner->businessname; ?>
                              <div class="action_links">
                                <a href="delete_owners.php?id=<?php echo $owner->id;?>">Delete</a>
                                <a href="edit_owners.php?id=<?php echo $owner->id; ?>">Edit</a>
                               </div>
                            </td>
                            <td><?php echo $owner->firstname; ?></td>
                            <td><?php echo $owner->surname; ?></td>
                            <td><?php echo $owner->email; ?></td>
                            <td><?php echo $owner->telephone; ?></td>
                        </tr>
                      <?php endforeach;  ?>
                      </tbody>
                    </table>
                    </div>
                  </div>
              </div>
              <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
