export class Vote {
	constructor(public votePostId: number,
					public voteProfileId: number,
					public voteDateTime: Date,
					public voteValue: number) {

	}
}