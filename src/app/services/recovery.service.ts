import {Injectable, Input} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Recovery} from "../classes/recovery";

@Injectable()
export class RecoveryService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private recoveryUrl = "api/recovery/";

	postRecovery(recovery: string): Observable<Status> {
		return (this.http.post(this.recoveryUrl + profileEmail + recovery)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}