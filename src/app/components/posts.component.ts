import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs";
import {PostService} from "../services/post-service";
import {Post} from "../classes/post";
// import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/posts.php"
})

export class PostsComponent implements OnInit {

	newPost : Post = new Post(null, null, null, null);
	posts : Post[] = [];
	//status : Status = null;

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