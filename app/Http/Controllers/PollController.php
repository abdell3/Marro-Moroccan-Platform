<?php

namespace App\Http\Controllers;

use App\Http\Requests\Poll\VotePollRequest;
use App\Models\Poll;
use App\Http\Requests\StorePollRequest;
use App\Http\Requests\UpdatePollRequest;
use App\Services\Interfaces\PollServiceInterface;
use Illuminate\Routing\Controller;

class PollController extends Controller
{
    protected $pollService;

    public function __construct(PollServiceInterface $pollService)
    {
        $this->pollService = $pollService;
        $this->authorizeResource(Poll::class, 'poll');
    }

    
    public function index()
    {
        $polls = $this->pollService->getAllPolls();
        return view('polls.index', compact('polls'));
    }

    public function create()
    {
        return view('polls.create');
    }

    public function store(StorePollRequest $request)
    {
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
        $this->authorize('vote', $poll);
        
        $validated = $request->validated();
        
        $result = $this->pollService->vote($poll->id, $validated['vote_value']);

        if (!$result) {
            return redirect()->back()
                ->with('error', 'Impossible de voter pour ce sondage.');
        }

        return redirect()->back()
            ->with('success', 'Vote enregistré avec succès!');
    }

    public function results(Poll $poll)
    {
        $results = $this->pollService->getPollResults($poll->id);
        return view('polls.results', compact('poll', 'results'));
    }
}
