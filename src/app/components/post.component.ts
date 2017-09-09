/*
this component is for posting and viewing ABQ Town Hall posts.
 */

// import modules associated with post
import {Component, OnInit} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Router} from "@angular/router";
import {Status} from "../classes/status";

import {PostService} from "../services/post.service";
import {Post} from "../classes/post";

@Component({
	templateUrl: "./templates/post.php"
})

export class PostComponent implements OnInit {

	newPost : Post = new Post(null, null, null, null, null, null, null);
	posts : Post[] = [];
	status : Status = null;

	constructor(protected postService: PostService) {}

	ngOnInit() : void {
		this.getAllPosts();
	}

	getAllPosts() : void {
		this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
	}

	createPost() : void {
		this.postService.createPost(this.newPost)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.getAllPosts();
				}
			});
	}
}