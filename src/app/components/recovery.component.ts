import {Component} from "@angular/core";
import {ActivatedRoute, Router, Params} from "@angular/router";
import {Status} from "../classes/status";
import {RecoveryService} from "../services/recovery.service";
import {Recovery} from "../classes/recovery";

@Component({
	templateUrl: "./templates/recovery.html"
})

export class RecoveryComponent {

	recovery: Recovery = new Recovery(null, null, null);
	status: Status = null;

	constructor(private recoveryService: RecoveryService, private router: Router, private route: ActivatedRoute) {
	}

	createRecovery(): void {
		this.route.params
			.subscribe((params: Params) => {
				this.recovery.profileRecoveryToken = (params['recovery'])
			});
		this.recoveryService.createRecovery(this.recovery)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					setTimeout((router: Router) => {
						this.router.navigate([""]);
					}, 10000);
				}
				else if(status.status === 418) {
					setTimeout((router: Router) => {
						this.router.navigate(["forgot"]);
					}, 10000);
				}
			});
	}
}