<?php 
	defined('BASEPATH') or exit('No direct script access allowed');
	$this->load->view('templates/header');
?>

<div class="container-fluid vh100">
   <div class="row vh100">
      <div class="col-md-6 vh100 d-none d-md-flex justify-content-center align-items-center" style="background-color: beige;">
         <img src="<?= base_url('assets/bot.png') ?>" class="bot-image">
      </div>
      <div class="col-md-6 vh100 d-flex justify-content-center align-items-center">
         <form action="#" class="signin-form w-100">
            <div class="form-group mb-3">
               <label class="label" for="name">Username</label>
               <input type="text" class="form-control" placeholder="Username" required="">
            </div>
            <div class="form-group mb-3">
               <label class="label" for="password">Password</label>
               <input type="password" class="form-control" placeholder="Password" required="">
            </div>
            <div class="form-group">
               <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
            </div>
         </form>
      </div>
   </div>
</div>

<?php 
	$this->load->view('templates/footer');
?>