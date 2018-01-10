import {Component} from "@angular/core";
import {Status} from "../classes/status";
import {SignUpService} from "../services/signup.service";
import {SignUp} from "../classes/signup";


declare let $: any;

@Component({
	selector: "sign-up",
	templateUrl: "./templates/signup.html"
})

export class SignUpComponent {

	signUp: SignUp = new SignUp(null, null, null, null, null, null, null, null, null, null, null);
	status: Status = null;
	public captchaResponse: string = '';

	constructor(private signUpService: SignUpService) {
	}

	// public resolved(captchaResponse: string) {
	// 	const newResponse = captchaResponse
	// 		? `${captchaResponse.substr(0, 7)}...${captchaResponse.substr(-7)}`
	// 		: captchaResponse;
	// 	this.captchaResponse += `${JSON.stringify(newResponse)}\n`;
	// }

	createSignUp(): void {
		this.signUpService.createSignUp(this.signUp, this.captchaResponse)
			.subscribe(status => {
				this.status = status;
			});
	}
}