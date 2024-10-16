<?php

namespace App\Http\Controllers\API\v1;

use App\Filters\v1\ReviewFilter;
use App\Http\Resources\v1\Review\ReviewCollection;
use App\Http\Resources\v1\Review\ReviewResource;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReviewController extends Controller
{
    private ReviewFilter $reviewFilter;

    public function __construct(ReviewFilter $reviewFilter){
        $this->reviewFilter = $reviewFilter;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'userId' => 'numeric|nullable',
                'bookId' => 'numeric|nullable',
                'minRating' => 'numeric|nullable|min:0|max:10',
            ]);
    
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->validator->errors()
            ], 422);
        }

        $this->reviewFilter->setQuery(Review::query());
        $reviews = $this->reviewFilter->filter($request)->paginate();
        return new ReviewCollection($reviews->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReviewRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReviewRequest $request)
    {
        DB::beginTransaction();

        try {
            // Create the review
            $review = Review::create($request->all());

            // Recalculate the average rating and total review count for the book
            $book = $review->book; 
            $averageRating = $book->reviews()->avg('rating');
            $reviewCount = $book->reviews()->count();

            // Update the book's rating and review count
            $book->update([
                'rating' => $averageRating,
                'review_count' => $reviewCount,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Review Created Successfully',
                'data' => new ReviewResource($review),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Failed to create review',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        return new ReviewResource($review);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReviewRequest  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        DB::beginTransaction();

        try {
            // Update the review with the new data
            $review->update($request->all());
    
            // Recalculate the average rating for the book
            $book = $review->book; 
            $averageRating = $book->reviews()->avg('rating'); 
            $reviewCount = $book->reviews()->count(); 
    
            // Update the book's rating and review count
            $book->update([
                'rating' => $averageRating,
                'review_count' => $reviewCount,
            ]);
    
            DB::commit();
    
            return response()->json([
                'message' => 'Review Updated Successfully',
                'data' => new ReviewResource($review),
            ], 200);
            
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();
    
            return response()->json([
                'error' => 'Failed to update the review',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        $user = auth()->user();

        if($user == null || $user->id != $review->user_id) {
            return response()->json([
                'message'=> 'unauthorize',
            ], 401);
        }

        DB::beginTransaction();

        try {
            $review->delete();

            // Recalculate the average rating for the book
            $book = $review->book; 
            $averageRating = $book->reviews()->avg('rating'); 
            $reviewCount = $book->reviews()->count(); 
    
            // Update the book's rating and review count
            $book->update([
                'rating' => $averageRating,
                'review_count' => $reviewCount,
            ]);

            Db::commit();

            return response()->json([
                'message' => 'Review Deleted Successfully',
            ], 200);

        }catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Failed to update the review',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
