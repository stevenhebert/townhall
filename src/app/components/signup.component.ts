/*
 this component is for signing up to use abq town hall.
 */

//import needed modules for the sign-up component
import{Component, ViewChild, OnInit, EventEmitter, Output} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {SignUp} from "../classes/signup";
import {Status} from "../classes/status";
import {SignUpService} from "../services/signup.service";

//declare $ for good old jquery
declare let $: any;

// set the template url and the selector for the ng powered html tag

@Component({
	templateUrl: "./templates/signup.html",
	selector: "sign-up"
})
export class SignUpComponent implements OnInit {

	@ViewChild("signupForm") signupForm: any;
	signUp: SignUp = new SignUp("", "", "", "", "", "", "", "", "", "");
	status: Status = null;


	constructor(private signUpService: SignUpService, private router: Router) {
	}

	ngOnInit(): void {
	}

	createSignUp(): void {
		this.signUpService.postProfile(this.signUp)

			.subscribe(status => {
				console.log(this.signUp);

				console.log(this.status);
				if(status.status === 200) {
					alert(status.message);
					setTimeout(function() {
						$("#signUp-modal").modal('hide');
					}, 500);
					this.router.navigate([""]);
				}
			});
	}
}