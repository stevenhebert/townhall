export class PostProfile {
	constructor(public postId: number,
					public postProfileUserName: string,
					public postContent: string,
					public postTitle: string,
					public postDate: Date,
					public postDistrictId: number,
					public postParentId: number,
	){
	}
}