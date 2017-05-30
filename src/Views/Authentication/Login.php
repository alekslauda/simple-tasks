<form style="width:600px; margin:30px auto;" action="" method="POST">
    <?php if($this->view->errorMessage): ?>
        <p class="alert alert-danger"><?= $this->view->errorMessage ?></p>
    <?php endif; ?>
    <div class="form-group">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
    </div>
    <div class="form-group">
        <label for="inputPassword">Password</label>
        <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
    </div>
    <button type="submit" name="login" class="btn btn-primary">Login</button>
</form>