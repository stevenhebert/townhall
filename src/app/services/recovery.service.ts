import {Injectable} from "@angular/core";
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

	createRecovery(recovery: Recovery): Observable<Status> {
		return (this.http.post(this.recoveryUrl, recovery)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}