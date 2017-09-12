import{Component, ViewChild, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";
import {EditProfileService} from "../services/editprofile.service";

declare let $: any;

@Component({
	templateUrl: "./templates/editprofile.html",
})

export class EditProfileComponent implements OnInit {
	@ViewChild("editProfileForm") editProfileForm: any;
	status: Status = null;
	profile: Profile = new Profile(0, "", "", "", "", "", "", "", "", "");

	constructor(private editProfileService: EditProfileService, private route: ActivatedRoute) {
	}

	ngOnInit(): void {
		this.editProfile();
	}

	editProfile(): void {
		this.route.params
			.switchMap((params: Params) => this.editProfileService.getProfileByProfileId(params['id']))
			.subscribe(reply => this.profile = reply);
	}
}