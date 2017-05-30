<form style="width:600px; margin:30px auto;" action="" method="POST">
    
    <div class="form-group">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
        <?php
            if(isset($this->view->errors['email'])) {
                ?>
            <p class="alert alert-danger"><?= $this->view->errors['email'] ?></p>
        <?php
            }
        ?>
    </div>
        <div class="form-group">
        <label for="inputEmail">Full Name</label>
        <input type="name" class="form-control" id="inputEmail" name="name" placeholder="Enter your full name">
        <?php
            if(isset($this->view->errors['name'])) {
                ?>
            <p class="alert alert-danger"><?= $this->view->errors['name'] ?></p>
        <?php
            }
        ?>
    </div>
    <div class="form-group">
        <label for="inputPassword">Password</label>
        <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
        <?php
            if(isset($this->view->errors['password'])) {
                ?>
            <p class="alert alert-danger"><?= $this->view->errors['password'] ?></p>
        <?php
            }
        ?>
    </div>
    <button type="submit" name="register" class="btn btn-primary">Register</button>
</form>