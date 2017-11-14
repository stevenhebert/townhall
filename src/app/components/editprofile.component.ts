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
	selector: "edit-profile",
	templateUrl: "./templates/editprofile.html"
})

export class EditProfileComponent implements OnInit {

	@ViewChild("editProfileForm") editProfileForm: any;
	profile: Profile = new Profile(null, null, null, null, null, null, null, null, null, null);
	status: Status = null;
	cookieJar: any = {};

	constructor(private editProfileService: EditProfileService, private router: Router, private cookieService: CookieService, private route: ActivatedRoute) {
	}

	ngOnInit() : void {
		this.route.params
			.forEach((params:Params) => {
				this.cookieJar = this.cookieService.getAll();
				let profileId = this.cookieJar["profileId"];
				this.editProfileService.getProfile(profileId)
					.subscribe(profile => this.profile = profile);
			})
	}

	createProfileEdit(): void {
		this.editProfileService.editProfile(this.profile)
			.subscribe(status => {
				this.status = status;
				console.log(this.status);
				if(status.status === 200) {
					$('#editprofile-modal').modal('hide')
				}
				else {
					alert(this.status.message);
				}
			});
	}
}