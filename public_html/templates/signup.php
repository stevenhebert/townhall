<div id="signup-modal" class="modal fade" tabindex="-1" role="dialog">

	<div class="modal-dialog modal-lg" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Create a New ABQ Town Hall Account</h4>
			</div>

			<div class="modal-body">

				<!-- actual form -->
				<form class="form-horizontal" #signupForm="ngForm" name="signupForm" (ngSubmit)="postSignUp();">

					<!-- abq town hall first name -->
					<div class="form-group">
						<label for="profileFirstName" class="col-sm-2 control-label">First Name</label>
						<div class="col-sm-10">
							<input type="text" id="profileFirstName" name="profileFirstName" class="form-control" required
									 [(ngModel)]=signUp.profileFirstName" #signUpFirstName="ngModel">
						</div>
					</div>

					<!-- abq town hall last name-->
					<div class="form-group">
						<label for="profileLastName" class="col-sm-2 control-label">Last Name </label>
						<div class="col-sm-10">
							<input type="text" id="profileLastName" name="profileLastName" class="form-control input-sm" required
									 [(ngModel)]="signUp.profileLastName" #signUpLastName="ngModel">
						</div>
					</div>

					<!-- abq town hall address 1 -->
					<div class="form-group">
						<label for="profileAddress1" class="col-sm-2 control-label">Address 1</label>
						<div class="col-sm-10">
							<input type="text" id="profileAddress1" name="profileAdress1" class="form-control input-sm" required
									 [(ngModel)]="signUp.profileAddress1" #signUpAddress1="ngModel">
						</div>
					</div>

					<!-- abq town hall address 2 -->
					<div class="form-group">
						<label for="profileAddress2" class="col-sm-2 control-label">Address 2</label>
						<div class="col-sm-10">
							<input type="text" id="profileAddress2" name="profileAddress2" class="form-control input-sm" required
									 [(ngModel)]="signUp.profileAddress2" #signUpAddress2="ngModel">
						</div>
					</div>

					<!--abq town hall city -->
					<div class="form-group">
						<label for="profileCity" class="col-sm-2 control-label">City</label>
						<div class="col-sm-10">
							<input type="text" id="profileCity" name="profileCity" class="form-control input-sm"
									 required [(ngModel)]="signUp.profileCity" #signUpCity="ngModel">
						</div>
					</div>

					<!--abq town hall state -->
					<div class="form-group">
						<label for="profileState" class="col-sm-2 control-label">State</label>
						<div class="col-sm-10">
							<input type="text" id="profileState" name="profileState" class="form-control input-sm"
									 required [(ngModel)]="signUp.profileState" #signUpState="ngModel">
						</div>
					</div>

					<!--abq town hall zip -->
					<div class="form-group">
						<label for="profileZip" class="col-sm-2 control-label">Zip Code</label>
						<div class="col-sm-10">
							<input type="text" id="profileZip" name="profileZip" class="form-control input-sm"
									 required [(ngModel)]="signUp.profileZip" #signUpZip="ngModel">
						</div>
					</div>

					<!--abq town hall email -->
					<div class="form-group">
						<label for="profileEmail" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="text" id="profileEmail" name="profileEmail" class="form-control input-sm"
									 required [(ngModel)]="signUp.profileEmail" #signUpEmail="ngModel">
						</div>
					</div>

					<!--abq town hall username -->
					<div class="form-group">
						<label for="profileUserName" class="col-sm-2 control-label">Requested Username</label>
						<div class="col-sm-10">
							<input type="text" id="profileUserName" name="profileUserName" class="form-control input-sm"
									 required [(ngModel)]="signUp.profileUserName" #signUpUserName="ngModel">
						</div>
					</div>

					<!--abq town hall password -->
					<div class="form-group">
						<label for="profilePassword" class="col-sm-2 control-label">Requested Password</label>
						<div class="col-sm-10">
							<input type="password" id="profilePassword" name="profilePassword" class="form-control input-sm"
									 required [(ngModel)]="signUp.profilePassword" #signUpPassword="ngModel">
						</div>
					</div>

					<!--abq town hall password confirm -->
					<div class="form-group">
						<label for="profilePasswordConfirm" class="col-sm-2 control-label">Confirm Password</label>
						<div class="col-sm-10">
							<input type="password" id="profilePasswordConfirm" name="profilePasswordConfirm" class="form-control input-sm"
									 required [(ngModel)]="signUp.profilePassword" #signUpPassword="ngModel">
						</div>
					</div>

					<!-- Submit button -->
					<button type="submit" id="submit" name="signUp" class="btn btn-info">Submit</button>
				</form>
			</div>

			<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
				<button type="button" class="close" aria-label="Close" (click)="status = null;"><span
						aria-hidden="true">&times;</span></button>
				{{ status.message }}

			</div>
		</div>
	</div>