export class Post {
	constructor(public postId: number,
					public postProfileId: number,
					public postContent: string,
					public postTitle: string,
					public postDate: Date,
					public postDistrictId: number,
					public postParentId: number,
){
	}
}