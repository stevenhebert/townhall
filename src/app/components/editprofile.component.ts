import {Component, ViewChild, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {EditProfileService} from "../services/editprofile.service";
import {Profile} from "../classes/profile";
import {CookieService} from "ng2-cookies";


@Component({
	selector: "edit-profile",
	templateUrl: "./templates/editprofile.html"
})

export class EditProfileComponent implements OnInit {

	@ViewChild("editProfileForm") editProfileForm: any;
	profile: Profile = new Profile(null, null, null, null, null, null, null, null, null, null, null);
	status: Status = null;
	cookieJar: any = {};
	districtId : number = null;

	constructor(private editProfileService: EditProfileService, private router: Router, private cookieService: CookieService) {
	}

	ngOnInit() : void {
		this.cookieJar = this.cookieService.getAll();
		let profileId = this.cookieJar["profileId"];
		this.editProfileService.getProfile(profileId)
					.subscribe(profile => this.profile = profile);
	}

	createProfileEdit(): void {
		this.editProfileService.editProfile(this.profile)
			.subscribe(status => {
				this.status = status;
				console.log(this.status);
				if(status.status === 200) {
					this.cookieJar = this.cookieService.getAll();
					let districtId = this.cookieJar['profileDistrictId'];
					this.router.navigate(["post/" + districtId]);
				}
				else {
					alert(this.status.message);
				}
			});
	}
}