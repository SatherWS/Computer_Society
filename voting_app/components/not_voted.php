<h3>Your IP: <?php echo $_SERVER['REMOTE_ADDR'];?></h3>
<input type='hidden' value='<?php echo $_SERVER['REMOTE_ADDR'];?>' name='usr' class='form-control' placeholder='Enter Your Name'>
<div class="row">
    <div class="col-md-6">
        <h3>Select Your Vote:</h3>
    </div>
    <div class="col-md-6 text-right">
        <button type="submit" name="vote" value="yes" class="btn btn-success">Yes</button>
        <button type="submit" name="vote" value="no" class="btn btn-success">No</button>
        <button type="submit" name="vote" value="maybe" class="btn btn-success">Maybe</button>
    </div>
</div>