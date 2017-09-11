import{Component} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SignInService} from "../services/signin.service";
import {SignIn} from "../classes/signin";

declare var $: any;

@Component({
	templateUrl: "./templates/signin.html",
	selector: "sign-in"
})

export class SignInComponent {

	signin: SignIn = new SignIn("fuck off", "dammit");
	status: Status = null;

	constructor(private signInService: SignInService, private router: Router){
	}

	signIn(): void {
		this.signInService.postSignIn(this.signin).subscribe(status=>{
			this.status = status;
			if(status.status === 200){

				this.router.navigate([""]);
			} else {
				console.log("failed login");
			}
		});
	}
}