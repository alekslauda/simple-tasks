<div class="row">
    <div class="span12">
    <h2>Registered Users Table</h2>    
          <table class="table">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($this->view->registeredUsers as $user) : ?>
              <tr <?= ($user->getId() == $this->view->loggedUserId) ? "class='alert alert-info'" : false?>>
                <td><?php echo $user->getId()?></td>
                <td><?php echo $user->getName()?></td>
                <td><?php echo $user->getEmail()?></td>
                <td><?php echo $user->getPassword(true)?></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
    </div>
</div>
