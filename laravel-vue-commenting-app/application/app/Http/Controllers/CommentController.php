<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Comment;
use Exception;

class CommentController extends Controller
{
    public function index() {}

    public function postComment(Request $request) {
        $this->validateComment($request);

        try {
            $comment = new Comment();

            $comment->id_user = auth('sanctum')->user()->id_user;
            $comment->data = $request->data;
            $comment->save();

            $message = "Sucessfully submitted a comment.";
        } catch(Exception $e) {
            $message = $e->getMessage();
        }

        return [
            'message' => $message
        ];
    }

    function validateComment($request) {
        $rules = [
            'data' => ['required', 'max:500']
        ];

        $errors = [
            'data.reqired' => 'Comment is required.',
            'data.max' => 'Comment should be at most 500 length.',
        ];
        
        return $request->validate($rules, $errors);
    }

    public function getAllComments(Request $request) {
        $this->validateOffset($request);

        $comments = Comment::orderBy('created_at', 'DESC')->take($request->offset*4)->get();

        $end = false;
        if ($comments->count() >= Comment::count()) $end = true;

        foreach ($comments as $comment) {
            $user = $comment->user()->first();

            $comment->name = $user->name;
            $comment->surname = $user->surname;
            $comment->email = $user->email;
        }

        return [
            'comments' => $comments,
            'end' => $end
        ];
    }

    function validateOffset($request) {
        $rules = [
            'offset' => ['required', 'integer']
        ];

        $errors = [
            'offset.reqired' => 'Offset is required.',
            'offset.integer' => 'Offset must be an integer.',
        ];
        
        return $request->validate($rules, $errors);
    }

    public function removeSingleComment(Request $request) {
        $this->validateCommentParams($request);

        try {
            Comment::where('id_user', auth('sanctum')->user()->id_user)->where('id_comment', $request->id_comment)->delete();

            $message = "Sucessfully deleted a comment.";
        } catch(Exception $e) {
            $message = $e->getMessage();
        }

        if ($request->page == "index")
            $comments = $this->getAllComments($request)["comments"];
        else if ($request->page == "user")
            $comments = Comment::where('id_user', auth('sanctum')->user()->id_user)->get()->makeHidden(['id_user']);

        return [
            'message' => $message,
            'comments' => $comments
        ];
    }

    public function removeAllComments() {
        try {
            Comment::where('id_user', auth('sanctum')->user()->id_user)->delete();

            $message = "Sucessfully deleted all comments for this user.";
        } catch(Exception $e) {
            $message = $e->getMessage();
        }

        $comments = Comment::where('id_user', auth('sanctum')->user()->id_user)->get()->makeHidden(['id_user']);

        return [
            'message' => $message,
            'comments' => $comments
        ];
    }

    function validateCommentParams($request) {
        $rules = [
            'id_comment' => ['required', 'integer'],
            'page' => ['required']
        ];

        $errorMessages = [
            'id_comment.required' => 'Comment id is required.',
            'id_comment.integer' => 'Comment id must be an integer.',

            'page.required' => 'Page attribute is required'
        ];

        return $request->validate($rules, $errorMessages);
    }

    public function getUserComments() {
        try {
            $comments = Comment::where('id_user', auth('sanctum')->user()->id_user)->get()->makeHidden(['id_user']);
        } catch(Exception $e) {
            $message = $e->getMessage();
        }

        return [
            'comments' => $comments,
            //'mesasge' => $message
        ];
    }
}
