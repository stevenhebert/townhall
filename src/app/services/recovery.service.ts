import {Injectable, Input} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";

@Injectable()
export class RecoveryService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private recoveryUrl = "api/recovery/";

	postRecovery(profile: Profile): Observable<Status> {
		return (this.http.post(this.recoveryUrl + profile.profileEmail + recovery, profile)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}