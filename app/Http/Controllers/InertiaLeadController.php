<?php

namespace App\Http\Controllers;

use App\Enums\LeadStatus;
use App\Http\Requests\Lead\CreateLeadRequest;
use App\Http\Requests\Lead\UpdateLeadRequest;
use App\Http\Requests\Lead\UpdateStatusRequest;
use App\Http\Requests\Note\CreateNoteRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use App\Models\User;
use App\Services\LeadNoteService;
use App\Services\LeadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InertiaLeadController extends Controller
{
    public function __construct(
        private readonly LeadService     $leadService,
        private readonly LeadNoteService $noteService,
    ) {}

    public function index(Request $request): Response
    {
        $leads = $this->leadService->list(
            $request->user(),
            $request->only(['status', 'search']),
            15
        );

        return Inertia::render('Leads/Index', [
            'leads'      => ['data' => LeadResource::collection($leads)->resolve()],
            'pagination' => [
                'total'        => $leads->total(),
                'per_page'     => $leads->perPage(),
                'current_page' => $leads->currentPage(),
                'last_page'    => $leads->lastPage(),
            ],
            'filters' => $request->only(['status', 'search']),
            'users'   => $request->user()->isAdmin()
                ? User::select('id', 'name')->orderBy('name')->get()
                : [],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Leads/Create', [
            'users'    => User::select('id', 'name')->orderBy('name')->get(),
            'statuses' => LeadStatus::values(),
        ]);
    }

    public function store(CreateLeadRequest $request): RedirectResponse
    {
        $this->leadService->create($request->validated(), $request->user());

        return redirect()
            ->route('web.leads.index')
            ->with('success', 'Lead created successfully.');
    }

    public function show(Request $request, Lead $lead): Response
    {
        $this->authorize('view', $lead);

        $lead = $this->leadService->find($lead->id);

        return Inertia::render('Leads/Show', [
            'lead'     => (new LeadResource($lead))->resolve(),
            'statuses' => LeadStatus::values(),
        ]);
    }

    public function edit(Request $request, Lead $lead): Response
    {
        $this->authorize('update', $lead);

        return Inertia::render('Leads/Edit', [
            'lead'     => (new LeadResource($lead->load(['assignee', 'creator'])))->resolve(),
            'users'    => User::select('id', 'name')->orderBy('name')->get(),
            'statuses' => LeadStatus::values(),
        ]);
    }

    public function update(UpdateLeadRequest $request, Lead $lead): RedirectResponse
    {
        $this->authorize('update', $lead);

        $this->leadService->update($lead, $request->validated());

        return redirect()
            ->route('web.leads.show', $lead)
            ->with('success', 'Lead updated successfully.');
    }

    public function destroy(Request $request, Lead $lead): RedirectResponse
    {
        $this->authorize('delete', $lead);

        $this->leadService->delete($lead);

        return redirect()
            ->route('web.leads.index')
            ->with('success', 'Lead deleted successfully.');
    }

public function updateStatus(UpdateStatusRequest $request, Lead $lead): RedirectResponse
    {
        $this->authorize('updateStatus', $lead);

        $this->leadService->updateStatus(
            $lead,
            LeadStatus::from($request->validated('status')),
            $request->user()
        );

        return back()->with('success', 'Status updated successfully.');
    }

    public function addNote(CreateNoteRequest $request, Lead $lead): RedirectResponse
    {
        $this->authorize('addNote', $lead);

        $this->noteService->addNote($lead, $request->user(), $request->validated('note'));

        return back()->with('success', 'Note added successfully.');
    }
}
