import{Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {ProfileService} from "../service/profile-service";
import {Profile} from "../class/profile";
import {Status} from "../class/status";
import "rxjs/add/operator/switchMap";


@Component({
	templateUrl: "./templates/profile-template.php",
	selector: "profile-view"
})

export class ProfileComponent implements OnInit {
	status: Status = null;
	profile: Profile = new Profile(0, 0, "", "", 0, "", "", "", "");

	constructor(private profileService: ProfileService, private route: ActivatedRoute) {
	}


	ngOnInit(): void {
		this.getProfile();
	}

	getProfile(): void {
		this.route.params
			.switchMap((params: Params) => this.profileService.getProfile(+params["id"]))
			.subscribe(reply => this.profile = reply);
	}




}