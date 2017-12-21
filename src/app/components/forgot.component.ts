import {Component, ViewChild,} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {ForgotService} from "../services/forgot.service";
import {Forgot} from "../classes/forgot";

declare let $: any;

@Component({
	selector: "forgot",
	templateUrl: "./templates/forgot.html"
})

export class ForgotComponent {

	@ViewChild("forgotForm") forgotForm: any;
	forgot: Forgot = new Forgot(null);
	status: Status = null;

	constructor(private forgotService: ForgotService, private router: Router) {
	}

	createForgot(): void {
		this.forgotService.createForgot(this.forgot)
			.subscribe(status => {
				this.status = status;
				console.log(this.status);
				if(this.status.status === 200) {
					$('#forgot-modal').modal('hide');
					setTimeout((router: Router) => {
						alert(this.status.message);
					}, 1000);
				}
				else {
					alert(this.status.message);
				}
			});
	}
}