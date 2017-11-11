import {Component, ViewChild,} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {ForgotService} from "../services/forgot.service";
import {Forgot} from "../classes/forgot";

//declare $ for good old jquery
declare let $: any;

@Component({
	templateUrl: "./templates/forgot.html",
	selector: "forgot"
})

export class ForgotComponent {

	@ViewChild("forgotForm") forgotForm: any;
	forgot: Forgot = new Forgot("");
	status: Status = null;

	constructor(private forgotService: ForgotService, private router: Router) {
	}

	createForgot(): void {
		this.forgotService.createForgot(this.forgot)
			.subscribe(status => {
				this.status = status;
				console.log(this.status);
				if(status.status === 200) {
					$('#forgot-modal').modal('hide')
					alert("If registered, a recovery link has been sent to the provided email. Requests are valid for 15 minutes from the time sent.")
				}
				else {
					alert(status.message);
				}
			});
	}
}