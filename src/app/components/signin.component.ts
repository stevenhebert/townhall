//this is the modal that pops up when "sign-in" is clicked

import{Component, } from "@angular/core";

import {Router} from "@angular/router";

import {Status} from "../classes/status";
import {SignOutService} from "../services/signout.service";
import {SignInService} from "../services/signin.service";
declare var $: any;

@Component({
	templateUrl: "./templates/signout-template.html",
	selector: "signOut"
})

export class SignOutComponent {

	status: Status = null;

	constructor(private SignOutService: SignOutService, private SignInService: SignInService, private  router: Router){}

	isSignedIn = false;

	ngOnChanges (): void{
		this.isSignedIn = this.SignInService.isSignedIn;

	}

	signIn() : void {
		this.SignOutService.getSignOut()
			.subscribe(status => {
				this.status = status;

				if(status.status === 200) {
					this.router.navigate([""]);
					this.SignInService.isSignedIn = false;
				}
			});
	}
}