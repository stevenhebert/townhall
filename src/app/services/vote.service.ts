import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Vote} from "../classes/vote";
import {Status} from "../classes/status";
import {PostVote} from "../classes/postvote";


@Injectable()
export class VoteService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private voteUrl = "api/vote/";

	getAllVotes(): Observable<Vote[]> {
		return(this.http.get(this.voteUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// not used
	// getVoteByPostIdAndProfileId(votePostId: number, voteProfileId : number) : Observable<Vote> {
	// 	return(this.http.get(this.voteUrl + votePostId + voteProfileId)
	// 		.map(this.extractData)
	// 		.catch(this.handleError));
	// }

	createVote(vote: Vote): Observable<Status> {
		return(this.http.post(this.voteUrl, vote)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editVote(vote: Vote): Observable<Status> {
		return(this.http.put(this.voteUrl + vote.votePostId + vote.voteProfileId, vote)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	// not used
	// getSumOfVoteValuesByPostId(votePostId : number) : Observable<PostVote> {
	// 	return(this.http.get(this.voteUrl + '?votePostId=' + votePostId)
	// 		.map(this.extractData)
	// 		.catch(this.handleError));
	// }
}