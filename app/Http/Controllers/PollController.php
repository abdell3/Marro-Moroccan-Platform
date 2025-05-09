<?php

namespace App\Http\Controllers;

use App\Http\Requests\VotePollRequest;
use App\Models\Poll;
use App\Http\Requests\StorePollRequest;
use App\Http\Requests\UpdatePollRequest;
use App\Services\Interfaces\PollServiceInterface;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PollController extends Controller
{
    use AuthorizesRequests;
    protected $pollService;

    public function __construct(PollServiceInterface $pollService)
    {
        $this->pollService = $pollService;
        $this->middleware('auth')->except(['index', 'show', 'results']);
    }

    
    public function index()
    {
        $polls = $this->pollService->getAllPolls();
        return view('polls.index', compact('polls'));
    }

    public function create()
    {
        $this->authorize('create', Poll::class);
        return view('polls.create');
    }

    public function store(StorePollRequest $request)
    {
        $this->authorize('create', Poll::class);
        $validated = $request->validated();

        $poll = $this->pollService->createPoll($validated);

        if (!$poll) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Impossible de créer le sondage.');
        }

        return redirect()->route('posts.show', $validated['post_id'])
            ->with('success', 'Sondage créé avec succès!');
    }

    public function show(Poll $poll)
    {
        $results = $this->pollService->getPollResults($poll->id);
        return view('polls.show', compact('poll', 'results'));
    }

    public function vote(VotePollRequest $request, Poll $poll)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour voter.');
        }
        
        $validated = $request->validated();
        $userId = auth()->id();
        $existingVote = $poll->voters()->where('user_id', $userId)->exists();
        $actionType = $existingVote ? 'modifié' : 'enregistré';
        $result = $this->pollService->vote($poll->id, $validated['vote_value'], $userId);
        if (!$result) {
            return redirect()->back()
                ->with('error', 'Impossible de voter pour ce sondage.');
        }

        return redirect()->back()
            ->with('success', 'Vote ' . $actionType . ' avec succès!');
    }

    public function results(Poll $poll)
    {
        $results = $this->pollService->getPollResults($poll->id);
        return view('polls.results', compact('poll', 'results'));
    }
}
