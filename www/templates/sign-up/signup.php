<div class="row">
	<div class="columns">
		<form novalidate method="post" action="index.php?page=sign-up">
			<h2>Registration Form</h2>

			<div class="row">
				<div class="medium-6 columns">
					<label>Username:</label>
					<input type="text" name="username" placeholder="username" value="<?php echo $this->userName; ?>">
				<?php $this->foundationAlert($this->userNameError, 'error');?>
				</div>
				<div class="medium-6 columns">
					<label>E-mail:</label>
					<input type="email" name="email" placeholder="octopus@designink.com" value="<?php echo $this->email; ?>">
					<?php $this->foundationAlert($this->emailError, 'error');?>
				</div>
				<div class="medium-6 columns">
					<label>Password:</label>
					<input type="password" name="password1">
				</div>
				<div class="medium-6 columns">
					<label>Confirm Password:</label>
					<input type="password" name="password2">
					<?php $this->foundationAlert($this->passwordError, 'error');?>
				</div>	
			</div>
			<div class="row">	
				<div class="medium-6  columns right">
					<input type="submit" value="create account" name="create-account" class="button small dink-button right" id="create-account">
				</div>
			</div>
			
			
			

		</form>
	</div>
</div>