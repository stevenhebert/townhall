import {Component, OnInit} from "@angular/core";
import {VoteService} from "../services/vote.service";
import {Vote} from "../classes/vote";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/post-list.html"
})

export class VoteComponent implements OnInit {

	newVote : Vote = new Vote(null, null, null, null);
	votes : Vote[] = [];
	status : Status = null;

	constructor(protected voteService: VoteService) {}

	ngOnInit(): void {
		this.getAllVotes();
	}

	getAllVotes(): void {
		this.voteService.getAllVotes()
			.subscribe(votes => this.votes = votes);
	}




}