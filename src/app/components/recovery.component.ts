import {Component, Input} from "@angular/core";
import {ActivatedRoute, Router} from "@angular/router";
import {HttpParams, HttpClient} from '@angular/common/http';
import {Status} from "../classes/status";
import {RecoveryService} from "../services/recovery.service";
import {Recovery} from "../classes/recovery";

@Component({
	templateUrl: "./templates/recovery.html",
})

export class RecoveryComponent {

	@Input("recoverPasswordForm") recoverPasswordForm: any;
	recovery: Recovery = new Recovery(null, null, null);
	status: Status = null;

	constructor(private http: HttpClient, private recoveryService: RecoveryService, private router: Router, private route: ActivatedRoute) {

		this.route.params.subscribe(params => console.log(params));
		//if navigate to /recovery/123456789, 123456789 should get emitted on the observable and this would get printed to the console as: {recovery: 123456789}
	}

	createRecovery(): void {
		this.route.params.subscribe( );

		this.recoveryService.postRecovery(this.recovery)
			.subscribe(status => {
				this.status = status;
				console.log(this.status);
				if(status.status === 200) {
					alert("account recovered, you may now login.")
				}
				else {
					alert(status.message);
				}
			});
	}

	// 	let params = new HttpParams();
	// 	params = params.set(profileRecoveryToken, 'recovery');
	// 	params = params.set(profileEmail, 'profileEmail');
	// }


}