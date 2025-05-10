<div class="vote-area" data-post-id="{{ $post->id }}" data-vote-state="{{ $userVoteType ?? 'none' }}">
    <form class="hidden" id="upvote-form-{{ $post->id }}" action="{{ route('posts.upvote', $post) }}" method="POST">
        @csrf
    </form>
    <form class="hidden" id="downvote-form-{{ $post->id }}" action="{{ route('posts.downvote', $post) }}" method="POST">
        @csrf
    </form>

    <button type="button" class="vote-button upvote-button {{ ($userVoteType === 'upvote') ? 'upvoted' : '' }}" onclick="submitVoteForm('upvote', {{ $post->id }})">
        <svg class="upvote-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <polygon points="12 4 4 15 20 15" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
    
    <span class="vote-count {{ ($userVoteType === 'upvote') ? 'upvoted' : (($userVoteType === 'downvote') ? 'downvoted' : '') }}">
        {{ $post->like }}
    </span>
    
    <button type="button" class="vote-button downvote-button {{ ($userVoteType === 'downvote') ? 'downvoted' : '' }}" onclick="submitVoteForm('downvote', {{ $post->id }})">
        <svg class="downvote-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <polygon points="12 20 4 9 20 9" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>
</div>
