import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {EditProfile} from "../classes/editprofile";

@Injectable()
export class EditProfileService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private editProfileUrl = "api/editprofile/";

	putProfile(editProfile: EditProfile) : Observable<Status> {
		return(this.http.post(this.editProfileUrl, editProfile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}