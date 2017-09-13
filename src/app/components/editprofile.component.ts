import {Component, ViewChild, OnInit} from "@angular/core";
import {Observable} from "rxjs/Observable"
import {ActivatedRoute, Params, Router} from "@angular/router";
import {Status} from "../classes/status";
import {EditProfileService} from "../services/editprofile.service";
import {Profile} from "../classes/profile";
import {CookieService} from "ng2-cookies";

//declare $ for good old jquery
declare let $: any;

@Component({
	templateUrl: "./templates/editprofile.html",
	selector: "edit-profile"
})

export class EditProfileComponent implements OnInit {
	@ViewChild("editProfileForm") signUpForm: any;
	profile: Profile = new Profile(null, null, null, null, null, null, null, null, null, null);
	status: Status = null;
	cookieJar: any = {};

	constructor(private editProfileService: EditProfileService, private router: Router, private cookieService: CookieService,private route: ActivatedRoute) {
	}

	ngOnInit() : void {
		this.route.params.forEach((params: Params) => {
			let profileId = +params["profileId"];
			this.cookieJar = this.cookieService.getAll();
			this.editProfileService.getProfile(profileId)
				.subscribe(profile => this.profile = profile);

		})
	}

	createProfileEdit(): void {
		this.editProfileService.editProfile(this.profile)
			.subscribe(status => this.status = status);

	}
}