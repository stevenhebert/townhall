//this is the modal that pops up when "sign-in" is clicked

import{Component, } from "@angular/core";

import {Router} from "@angular/router";

import {Status} from "../classes/status";
import {SignIn} from "../classes/signin";
import {SignInService} from "../services/signin.service";
declare var $: any;

@Component({
	templateUrl: "./templates/signin.html",
	selector: "signin"
})

export class SignInComponent {

	signin: SignIn = new SignIn(null, null);
	status: Status = null;

	constructor(private signInService: SignInService, private router: Router){
	}

	signIn(): void {
		this.signInService.postSignIn(this.signin).subscribe(status=>{
			this.status=status;
			if(status.status === 200){

				this.router.navigate(["profile"]);
			} else {
				console.log("failed login");
			}
		});
	}

}
