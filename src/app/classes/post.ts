export class Post {
	constructor(public postId: number,
					public postDistrictId: number,
					public postParentId: number,
					public postProfileId: number,
					public postContent: string,
					public postDateTime: Date
){
	}
}