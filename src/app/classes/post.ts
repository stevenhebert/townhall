import {PostVote} from "./postvote";

export class Post {
	constructor(public postId: number,
					public postDistrictId: number,
					public postParentId: number,
					public postProfileUserName: string,
					public postContent: string,
					public postDateTime: Date,
					public info: PostVote
){
	}
}