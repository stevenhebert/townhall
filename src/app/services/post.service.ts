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

	deletePost(id: number): Observable<Status> {
		return (this.http.delete(this.postUrl + id)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	createPost(post: Post): Observable<Status> {
		return (this.http.post(this.postUrl, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getPostByPostId(postId: number): Observable<Post> {
		return (this.http.get(this.postUrl + "?id=" + postId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByPostProfileId(postProfileId: number): Observable<Post> {
		return (this.http.get(this.postUrl + '?postProfileId=' + postProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByPostContent(postContent: string): Observable<Post> {
		return (this.http.get(this.postUrl + '?postContent=' + postContent)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByDate(postDate: Date): Observable<Post> {
		return (this.http.get(this.postUrl + '?postDate=' + +postDate)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostByPostDistrictId(postDistrictId: number): Observable<Post[]> {
		return (this.http.get(this.postUrl + '?postDistrictId=' + postDistrictId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostsByPostParentId(postParentId: number): Observable<Post[]> {
		return (this.http.get(this.postUrl + '?postParentId=' + postParentId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getAllPosts(): Observable<Post[]> {
		return (this.http.get(this.postUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}
}