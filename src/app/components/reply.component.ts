import {Component, OnInit} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {Status} from "../classes/status";
import 'rxjs/add/operator/switchMap';

import {PostService} from "../services/post.service";
import {Post} from "../classes/post";
import {PostVote} from "../classes/postvote";

@Component({
	templateUrl: "./templates/reply.html",
})


export class ReplyComponent implements OnInit {

	post : Post = new Post(null, null, null, null, null, null, null);
	childPost: Post = new Post(null, null, null, null, null, null, null);
	newPost: Post = new Post(null, null, null, null, null, null, null);
	posts: Post[] = [];
	status: Status = null;


	constructor(protected postService: PostService, protected router: Router, protected activatedRoute: ActivatedRoute) {
	}


	ngOnInit(): void {
		this.loadPostParentPostId();
		this.loadPostsByParentPostId();
	}


	loadPostsByParentPostId(): void {
		this.activatedRoute.params
			.switchMap((params: Params) => this.postService.getPostsByPostParentId(+params["id"]))
			.subscribe(posts => {
				posts.map(post => {
					if(Object.keys(post.info).length === 0 && post.info.constructor === Object) {
						post.info = new PostVote(post.postId, 0, 0);
					}

				});
				console.log(posts);
				this.posts = posts;


			});

	}

	createPost(): void {

		this.newPost.postDistrictId = this.childPost.postDistrictId;
		this.newPost.postParentId = this.childPost.postId;

		this.postService.createPost(this.newPost)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.loadPostsByParentPostId();
				} else {

				}
			});
	}

	loadPostParentPostId(): void {
		this.activatedRoute.params
			.switchMap((params: Params) => this.postService.getPostByPostId(+params["id"]))
			.subscribe(post => {this.childPost = post});
	}
}
