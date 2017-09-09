export class Post {
	constructor(public postId: number,
					public postProfileId: number,
					public postContent: string,
					public postDate: Date,
					public postDistrictId: number,
					public postParentId: number,
					public allPosts:string,
){
	}
}