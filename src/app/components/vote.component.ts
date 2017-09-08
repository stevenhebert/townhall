import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs";
import {VoteService} from "../services/vote.service";
import {Vote} from "../classes/vote";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/post-list.php"
})

export class VoteComponent implements OnInit {

	newVote : Vote = new Vote(null, null, null, null);
	votes : Vote[] = [];
	status : Status = null;

	constructor(protected voteService: VoteService) {}

	ngOnInit() : void {
		this.getAllVotes();
	}

	getAllVotes() : void {
		this.voteService.getAllVotes()
			.subscribe(votes => this.votes = votes);
	}

	createVote() : void {
		this.voteService.createVote(this.newVote)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.getAllVotes();
				}
			});
	}
}