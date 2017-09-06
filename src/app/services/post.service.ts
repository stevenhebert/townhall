import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Post} from "../classes/post";
import {Status} from "../classes/status";

@Injectable()
export class PostService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private postUrl = "api/post/";

	getAllPosts() : Observable<Post[]> {
		return(this.http.get(this.postUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByPostId(postId : number) : Observable<Post> {
		return(this.http.get(this.postUrl + postId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByDistrictId(districtId : number) : Observable<Post> {
		return(this.http.get(this.postUrl + districtId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByProfileId(profileId : number) : Observable<Post> {
		return(this.http.get(this.postUrl + profileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByPostContent(postContent : string) : Observable<Post> {
		return(this.http.get(this.postUrl + postContent)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByDate(postDate : string) : Observable<Post> {
		return(this.http.get(this.postUrl + postDate)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getPostByPostParentId(postParentId : number) : Observable<Post> {
		return(this.http.get(this.postUrl + postParentId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	createPost(post : Post) : Observable<Status> {
		return(this.http.post(this.postUrl, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
}