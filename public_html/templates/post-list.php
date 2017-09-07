<form #postForm="ngForm" name="postForm" id="postForm" class="form-horizontal well" (ngSubmit)="createPost();" novalidate>
	<h2>Create Post</h2>
	<hr />
	<div class="form-group" [ngClass]="{ 'has-error': post.touched && post.invalid }">
		<label for="post">Post</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-comment" aria-hidden="true"></i>
			</div>
			<input type="text" name="post" id="post" class="form-control" maxlength="8192" required [(ngModel)]="post.post" #postText="ngModel" />
		</div>
		<div [hidden]="postText.valid || postText.pristine" class="alert alert-danger" role="alert">
			<p *ngIf="postText.errors?.required">Post is required.</p>
			<p *ngIf="postText.errors?.maxlength">Post is too long. You typed</p>
		</div>
	</div>

	<div class="form-group" [ngClass]="{ 'has-error': profileUserName.touched && profileUserName.invalid }">
		<label for="profileUserName">User Name</label>
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-quote-left" aria-hidden="true"></i>
			</div>
			<input type="text" name="profileUserName" id="profileUserName" class="form-control" maxlength="64" required [(ngModel)]="profile.UserName" #attribution="ngModel" />
		</div>
		<div [hidden]="profileUserName.valid || profileUserName.pristine" class="alert alert-danger" role="alert">
			<p *ngIf="profileUserName.errors?.required">Need profile User Name</p>

		</div>
	</div>
</form>


<hr />
<h1>All Posts</h1>
<table class="table table-bordered table-responsive table-striped table-word-wrap">
	<tr><th>Post ID</th><th>Post Content</th><th>User Name</th></tr>
	<tr *ngFor="let post of posts">
		<td>{{ post.postId }}</td>
		<td>{{ post.postContent }}</td>
		<td>{{ profile.profileUserName }}</td>
		<table class="table table-bordered table-responsive table-striped table-word-wrap">
			<tr><th>Vote ID</th><th>Misquote</th><th>Attribution</th><th>Submitter</th><th>Edit</th></tr>
			<tr *ngFor="let vote of votes">
				<td>{{ misquote.misquoteId }}</td>
				<td>{{ misquote.misquote }}</td>
				<td>{{ misquote.attribution }}</td>
				<td>{{ misquote.submitter }}</td>
				<td><a class="btn btn-warning" (click)="switchMisquote(misquote);"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
			</tr>
		</table>

		<td><a class="btn btn-warning" (click)="switchPost(post);"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
	</tr>
</table>