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


	signIn: SignIn = new SignIn(null, null);
	status: Status = null;

	constructor(private SignInService: SignInService, private router: Router){
	}

	signin(): void {
		this.SignInService.postSignIn(this.signIn).subscribe(status=>{
			this.status = status;
			if(status.status === 200){

				this.router.navigate(["profile"]);
			} else {
				console.log("failed login");
			}
		});
	}
}