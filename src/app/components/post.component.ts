import {Component, OnInit} from "@angular/core";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {Status} from "../classes/status";
import 'rxjs/add/operator/switchMap';

import {PostService} from "../services/post.service";
import {Post} from "../classes/post";
import {PostVote} from "../classes/postvote";
import {Vote} from "../classes/vote";
import {VoteService} from "../services/vote.service";


@Component({
	templateUrl: "./templates/post.html"
})

export class PostComponent implements OnInit {

	newPost: Post = new Post(null, null, null, null, null, null, null);
	posts: Post[] = [];
	status: Status = null;
	newVote: Vote = new Vote(null, null, null, null);

	constructor(protected postService: PostService, protected router: Router, protected activatedRoute: ActivatedRoute, protected voteService: VoteService) {
	}

	ngOnInit(): void {
		this.loadDistrictById();
	}

	loadDistrictById(): void {
		this.activatedRoute.params
			.switchMap((params: Params) => this.postService.getPostByPostDistrictId(+params["postDistrictId"]))
			.subscribe(posts => {
				posts.map(post => {
					if(Object.keys(post.info).length === 0 && post.info.constructor === Object) {
						post.info = new PostVote(post.postId, 0, 0);
					}
				});
				this.posts = posts;
			});
	}

	switchPost(post: Post): void {
		this.router.navigate(["/reply/", post.postId]);
	}

	createPost(): void {
		this.activatedRoute.params.subscribe(params => {
			this.newPost.postDistrictId = +params['postDistrictId']
		});
		this.postService.createPost(this.newPost)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.loadDistrictById();
				}
			});
	}

	createVote(postId: number, voteValue: number): void {
		this.newVote.votePostId = postId;
		this.newVote.voteValue = voteValue;

		this.voteService.createVote(this.newVote)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.loadDistrictById();
				}
			});
	}

	sortPost(by: string): void {
		if(by === 'vote') {
			this.posts.sort((a: any, b: any) => {
				return a.voteValue - b.voteValue;
			});
		} else if(by === 'date') {
			this.posts.sort((a: any, b: any) => {
				return b.postDateTime - a.postDateTime;
			});
		}
	}
}