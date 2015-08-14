
<div class="row">
	<div class="columns">
		<form novalidate method="post" action="index.php?page=login">
			<h2>Log into your Account</h2>
			
			
			<div class="row">
				<div class="medium-10 columns">
					<div class="medium-6 columns">
						<label>Username:</label>
						<input type="text" name="username" placeholder="username" >
						<?php	
						$this->foundationAlert($this->loginUsernameError, 'error');
					?>
					</div>
					<div class="medium-6 columns">
						<label>Password:</label>
						<input type="password" name="password">
						<?php	
						$this->foundationAlert($this->loginPasswordError, 'error');
					?>
					</div>
			
				</div>	
				<div class="medium-2  columns">
					<input type="submit" value="login" name="login" class="button small dink-button" >
					<?php	
						$this->foundationAlert($this->loginError, 'error');
					?>
				</div>
				</div>
				
					
					
				
			</div>
			
			
		</form>
	</div>
</div>