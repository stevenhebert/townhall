import {Component, OnInit, Input} from "@angular/core";
import {ActivatedRoute, Params, Router} from "@angular/router";
import {Status} from "../classes/status";
import {RecoveryService} from "../services/recovery.service";
import {Profile} from "../classes/profile";

@Component({
	templateUrl: "./templates/recovery.html",
})

export class RecoveryComponent implements OnInit {

	profile: Profile = new Profile(null, null, null, null, null, null, null, null, null, null);
	status: Status = null;
	@Input('profile') profileEmail: string;

	constructor(private recoveryService: RecoveryService, private router: Router, private route: ActivatedRoute) {
	}

	ngOnInit(): void {
		this.route.params
			.switchMap((params: Params) => this.recoveryService.postRecovery(params['recovery']))
	}

	createRecovery(): void {
		this.recoveryService.postRecovery(this.profile)
			.subscribe(status => {
				this.status = status;
				console.log(this.status);
				if(status.status === 200) {
					alert("You may now login.")
				}
				else {
					alert(status.message);
				}
			});
	}
}