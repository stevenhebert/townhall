import{Component} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {SignInService} from "../services/signin.service";
import {SignIn} from "../classes/signin";
import {SessionService} from "../services/session.service";
import {CookieService} from "ng2-cookies";


@Component({
	templateUrl: "./templates/signin.html",
	selector: "sign-in"
})

export class SignInComponent {

	signin: SignIn = new SignIn(null, null);
	status: Status = null;
	cookieJar : any = {};
	districtId : number = null;

	constructor(private signInService: SignInService, private router: Router, private sessionService: SessionService, private cookieService: CookieService){
	}

	signIn(): void {
		this.signInService.postSignIn(this.signin).subscribe(status=>{
			this.status = status;
			if(status.status === 200){
				this.sessionService.setSession();
				this.cookieJar = this.cookieService.getAll();
				this.districtId = this.cookieJar['profileDistrictId'];
				this.router.navigate(["post/" + this.districtId]);
			} else {
				console.log("failed login");
				alert(status.message);
			}
		});
	}
}