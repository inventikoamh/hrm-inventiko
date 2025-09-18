<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class LeadController extends Controller
{
    /**
     * Store a newly created lead in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'mobile' => 'required|string|max:20',
                'email' => 'required|email|max:255',
                'product_type' => 'required|string|max:255',
                'budget' => 'required|string|max:255',
                'start' => 'required|string|max:255',
                'created_at' => 'nullable|date',
            ]);

            // Process created_at if provided
            $leadData = $validated;
            if (isset($validated['created_at'])) {
                $customDate = \Carbon\Carbon::parse($validated['created_at']);
                $leadData['created_at'] = $customDate;
                $leadData['updated_at'] = $customDate;
            }

            $lead = Lead::create($leadData);

            return response()->json([
                'success' => true,
                'message' => 'Lead created successfully',
                'data' => [
                    'id' => $lead->id,
                    'name' => $lead->name,
                    'mobile' => $lead->mobile,
                    'email' => $lead->email,
                    'product_type' => $lead->product_type,
                    'budget' => $lead->budget,
                    'start' => $lead->start,
                    'created_at' => $lead->created_at->toISOString(),
                    'updated_at' => $lead->updated_at->toISOString(),
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the lead',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of leads.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $search = $request->get('search', '');

            $query = Lead::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('mobile', 'like', '%' . $search . '%')
                      ->orWhere('product_type', 'like', '%' . $search . '%');
                });
            }

            $leads = $query->orderBy('created_at', 'desc')
                          ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Leads retrieved successfully',
                'data' => $leads->items(),
                'pagination' => [
                    'current_page' => $leads->currentPage(),
                    'last_page' => $leads->lastPage(),
                    'per_page' => $leads->perPage(),
                    'total' => $leads->total(),
                    'from' => $leads->firstItem(),
                    'to' => $leads->lastItem(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving leads',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified lead.
     *
     * @param Lead $lead
     * @return JsonResponse
     */
    public function show(Lead $lead): JsonResponse
    {
        try {
            $lead->load('remarks.user');

            return response()->json([
                'success' => true,
                'message' => 'Lead retrieved successfully',
                'data' => [
                    'id' => $lead->id,
                    'name' => $lead->name,
                    'mobile' => $lead->mobile,
                    'email' => $lead->email,
                    'product_type' => $lead->product_type,
                    'budget' => $lead->budget,
                    'start' => $lead->start,
                    'created_at' => $lead->created_at->toISOString(),
                    'updated_at' => $lead->updated_at->toISOString(),
                    'remarks' => $lead->remarks->map(function ($remark) {
                        return [
                            'id' => $remark->id,
                            'remark' => $remark->remark,
                            'user' => [
                                'id' => $remark->user->id,
                                'name' => $remark->user->name,
                                'email' => $remark->user->email,
                            ],
                            'created_at' => $remark->created_at->toISOString(),
                        ];
                    })
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the lead',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Convert a lead to a client.
     *
     * @param Request $request
     * @param Lead $lead
     * @return JsonResponse
     */
    public function convertToClient(Request $request, Lead $lead): JsonResponse
    {
        try {
            // Check if user has permission to convert leads to clients
            if (!auth()->user() || !auth()->user()->can('convert lead to client')) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to convert leads to clients'
                ], 403);
            }

            if ($lead->converted_to_client) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lead has already been converted to a client'
                ], 400);
            }

            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            // Create client from lead data
            $client = Client::create([
                'client_name' => $lead->name,
                'company_name' => $validated['company_name'],
                'description' => $validated['description'] ?? '',
                'email' => $lead->email,
                'mobile' => $lead->mobile,
            ]);

            // Update lead to mark as converted
            $lead->update([
                'converted_to_client' => true,
                'client_id' => $client->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Lead converted to client successfully',
                'data' => [
                    'lead_id' => $lead->id,
                    'client_id' => $client->id,
                    'client_name' => $client->client_name,
                    'company_name' => $client->company_name,
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while converting the lead',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}