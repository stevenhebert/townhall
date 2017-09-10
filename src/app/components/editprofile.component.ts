/*
 this component is for signing up to use abq town hall.
 */

//import needed modules for the sign-up component
import{Component, ViewChild, OnInit, EventEmitter, Output} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {EditProfile} from "../classes/editprofile";
import {Status} from "../classes/status";
import {EditProfileService} from "../services/editprofile.service";

//declare $ for good old jquery
declare let $: any;

// set the template url and the selector for the ng powered html tag

@Component({
	templateUrl: "./templates/editprofile.html",
	selector: "editprofile"
})
export class EditProfileComponent implements OnInit {

	@ViewChild("editprofileForm") editprofileForm: any;
	editProfile: EditProfile = new EditProfile("", "", "", "", "", "", "", "", "", "");
	status: Status = null;


	constructor(private editProfileService: EditProfileService, private router: Router) {
	}

	ngOnInit(): void {
	}

	putEditProfile(): void {
		this.editProfileService.putProfile(this.editProfile)

			.subscribe(status => {
				console.log(this.editProfile);

				console.log(this.status);
				if(status.status === 200) {
					alert(status.message);
					setTimeout(function() {
						$("#editProfile-modal").modal('hide');
					}, 500);
					this.router.navigate([""]);
				}
			});
	}
}