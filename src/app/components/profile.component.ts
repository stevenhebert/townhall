import{Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";
import "rxjs/add/operator/switchMap";


@Component({
	templateUrl: "./templates/profile-template.php",
	selector: "profile-view"
})

export class ProfileComponent implements OnInit {
	status: Status = null;
	profile: Profile = new Profile(null, null, "", "", "", "", "", "", "", "", "", "", "", "");

	constructor(private profileService: ProfileService, private route: ActivatedRoute) {
	}


	ngOnInit(): void {
		this.getProfile();
	}

	getProfile(): void {
		this.route.params
			.switchMap((params: Params) => this.profileService.getProfileByProfileId(+params["id"]))
			.subscribe(reply => this.profile = reply);
	}




}