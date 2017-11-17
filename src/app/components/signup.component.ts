import {Component} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SignUpService} from "../services/signup.service";
import {SignUp} from "../classes/signup";

//declare $ for good old jquery
declare let $: any;

@Component({
	selector: "sign-up",
	templateUrl: "./templates/signup.html"
})

export class SignUpComponent {

	signUp: SignUp = new SignUp(null, null, null, null, null, null, null, null, null, null, null);
	status: Status = null;

	constructor(private signUpService: SignUpService, private router: Router) {
	}

	createSignUp(): void {
		this.signUpService.createSignUp(this.signUp)
			.subscribe(status => {
				this.status = status;
			});
	}
}