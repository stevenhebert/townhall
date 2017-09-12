import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";

@Injectable()
export class EditProfileService extends BaseService {

	constructor(protected http: Http) {
		super(http)	;
	}

	private profileUrl = "api/profile/";


	editProfile(profile: Profile): Observable<Status> {
		return (this.http.put(this.profileUrl + profile.id, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getProfileByProfileId(id: number): Observable<Profile> {
		return (this.http.get(this.profileUrl + id)
			.map(this.extractData)
			.catch(this.handleError));
	}
}