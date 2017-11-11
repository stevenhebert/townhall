import {Component, OnInit, Input} from "@angular/core";
import {ActivatedRoute, Params, Router} from "@angular/router";
import {Status} from "../classes/status";
import {RecoveryService} from "../services/recovery.service";
import {Recovery} from "../classes/recovery";

@Component({
	templateUrl: "./templates/recovery.html",
})

export class RecoveryComponent implements OnInit {

	@Input("recoveryForm") recoveryForm: any;
	recovery: Recovery = new Recovery(null, null, );
	status: Status = null;

	constructor(private recoveryService: RecoveryService, private router: Router, private route: ActivatedRoute) {
	}

	ngOnInit(): void {
		this.activatedRoute.params.subscribe((params: Params) => {
			let recovery.profileRecoveryToken = params['recovery'];
			console.log(profileRecoveryToken);
		});
	}

	createRecovery(): void {
		this.route.params.subscribe(params => {
			this.recovery.profileEmail = +params['profileEmail']
		});
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
}