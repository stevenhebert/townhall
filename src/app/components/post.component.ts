import {Component, OnInit} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {Status} from "../classes/status";
import 'rxjs/add/operator/switchMap';

import {PostService} from "../services/post.service";
import {Post} from "../classes/post";
import {PostVote} from "../classes/postvote";


@Component({
	templateUrl: "./templates/post.html",
})

export class PostComponent implements OnInit {

	newPost: Post = new Post(null, null, null, null, null, null, null);
	posts: Post[] = [];
	status: Status = null;

	constructor(protected postService: PostService, protected router: Router, protected activatedRoute: ActivatedRoute) {
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
				//console.log(posts);
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
				} else {

				}
			});
	}

}


