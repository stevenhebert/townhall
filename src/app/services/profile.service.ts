import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";

@Injectable ()
export class ProfileService extends BaseService {

	constructor(protected http: Http) {
		super(http)	;
	}

	private profileUrl = "api/profile/";

	getProfileByProfileId(id: number): Observable<Profile> {
		return (this.http.get(this.profileUrl + id)
			.map(this.extractData)
			.catch(this.handleError));
	}
}