import {Component, OnInit} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Router, ActivatedRoute, Params} from "@angular/router";
import {Status} from "../classes/status";
import 'rxjs/add/operator/switchMap';

import {PostService} from "../services/post.service";
import {Post} from "../classes/post";


@Component({
	templateUrl: "./templates/post.html",
})

export class PostComponent implements OnInit {

	newPost : Post = new Post(null, null, null, null, null, null, null);
	posts : Post[] = [];
	status : Status = null;

	constructor(protected postService: PostService, protected router: Router, protected activatedRoute: ActivatedRoute) {}

	ngOnInit() : void {
		this.loadDistrictById();
	}

	loadDistrictById() : void {
		this.activatedRoute.params
			.switchMap((params : Params)=>this.postService.getPostByPostDistrictId(+params["postDistrictId"]))
			.subscribe(posts=>this.posts = posts);
	}

	getAllPosts() : void {
		this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
	}

	createPost() : void {
		this.activatedRoute.params.subscribe(params=>{this.newPost.postDistrictId = +params['postDistrictId'] });
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