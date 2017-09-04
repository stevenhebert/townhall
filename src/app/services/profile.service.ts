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

	deleteProfile(id: number): Observable<Status> {
		return (this.http.delete(this.profileUrl + id)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	createProfile(profile: Profile): Observable<Status> {
		return (this.http.post(this.profileUrl, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editProfile(profile: Profile): Observable<Status> {
		return (this.http.put(this.profileUrl + profile.id, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getAllProfiles(profile: Profile): Observable<Profile[]> {
		return (this.http.get(this.profileUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByProfileId(id: number): Observable<Profile> {
		return (this.http.get(this.profileUrl + id)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByDistrictId(profileDistrictId: number): Observable<Profile[]> {
		return (this.http.get(this.profileUrl + profileDistrictId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByEmail(profileEmail: string): Observable<Profile> {
		return (this.http.get(this.profileUrl + profileEmail)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getProfileByUserName(profileUserName: string): Observable<Profile> {
		return (this.http.get(this.profileUrl + profileUserName)
			.map(this.extractData)
			.catch(this.handleError));
	}

}